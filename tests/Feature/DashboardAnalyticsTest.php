<?php

namespace Tests\Feature;

use App\Models\Inquiry;
use App\Models\PageView;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardAnalyticsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config(['analytics.timezone' => 'Europe/Belgrade', 'app.timezone' => 'UTC']);
        CarbonImmutable::setTestNow(CarbonImmutable::parse('2026-10-27 11:00:00', 'UTC'));
        $this->actingAs(User::factory()->create(['is_admin' => true, 'role' => 'admin']), 'admin');
    }

    protected function tearDown(): void
    {
        CarbonImmutable::setTestNow();

        parent::tearDown();
    }

    public function test_totals_chart_and_breakdowns_share_local_day_boundaries_and_exclude_future_data(): void
    {
        $this->pageView('2026-08-28 21:59:59', 'outside');
        $this->pageView('2026-08-28 22:00:00', 'previous');
        $this->pageView('2026-09-27 10:00:00', 'previous');
        $this->pageView('2026-09-27 10:00:01', 'after-previous-comparison');
        $this->pageView('2026-09-27 22:00:00', 'earlier');
        $this->pageView('2026-10-13 22:00:00', 'historical');
        $this->pageView('2026-10-20 10:00:00', 'historical');
        $this->pageView('2026-10-20 10:00:01', 'historical');
        $this->pageView('2026-10-20 22:00:00', 'recent');
        // Belgrade's October 25 has 25 hours, including both occurrences of 02:30.
        $this->pageView('2026-10-24 22:00:00', 'recent');
        $this->pageView('2026-10-25 00:30:00', 'recent');
        $this->pageView('2026-10-25 01:30:00', 'recent');
        $this->pageView('2026-10-26 22:59:59', 'recent');
        $this->pageView('2026-10-26 23:00:00', 'today');
        $this->pageView('2026-10-27 11:00:00', 'today');
        $this->pageView('2026-10-27 11:00:01', 'future');
        $this->pageView('2026-10-28 09:00:00', 'future');

        $this->inquiry('2026-09-27 21:59:59');
        $this->inquiry('2026-09-27 22:00:00');
        $this->inquiry('2026-10-27 11:00:00')->delete();
        $this->inquiry('2026-10-27 11:00:01');

        $response = $this->get(route('admin.dashboard'))->assertOk();
        $analytics = $response->viewData('analytics');

        $this->assertSame(2, $analytics['today']);
        $this->assertSame(7, $analytics['seven_days']);
        $this->assertSame(11, $analytics['thirty_days']);
        $this->assertSame(4, $analytics['unique_thirty_days']);
        $this->assertSame([1, 0, 0, 0, 3, 1, 2], $analytics['trend']->pluck('total')->all());
        $this->assertSame(['21.10.', '22.10.', '23.10.', '24.10.', '25.10.', '26.10.', '27.10.'], $analytics['trend']->pluck('date')->all());
        $this->assertEquals(250, $analytics['weekly_growth']);
        $this->assertEquals(450, $analytics['growth']);
        $this->assertEquals(50, $analytics['conversion']);
        foreach (['popular_pages', 'devices', 'languages', 'sources'] as $breakdown) {
            $this->assertEquals(11, $analytics[$breakdown]->sum('total'), $breakdown);
        }
        $response->assertSee('+250,0% / 7 dana')
            ->assertSee('+450,0%')
            ->assertSee('Pregledi / 7 dana')
            ->assertSee('Posetioci / 30 dana (procena)')
            ->assertSee('Europe/Belgrade')
            ->assertSee('height: 0px', false)
            ->assertDontSee('Podaci bez botova');
    }

    public function test_growth_is_unavailable_without_a_nonzero_baseline(): void
    {
        $this->pageView('2026-10-27 10:00:00', 'new');

        $response = $this->get(route('admin.dashboard'))->assertOk();
        $analytics = $response->viewData('analytics');

        $this->assertNull($analytics['growth']);
        $this->assertNull($analytics['weekly_growth']);
        $response->assertSee('Nema pregleda u prethodnom periodu za poređenje.')
            ->assertDontSee('+100,0%');
    }

    public function test_empty_analytics_does_not_invent_a_conversion_rate(): void
    {
        $response = $this->get(route('admin.dashboard'))->assertOk();
        $analytics = $response->viewData('analytics');

        $this->assertSame(0, $analytics['today']);
        $this->assertSame(0, $analytics['seven_days']);
        $this->assertSame(0, $analytics['thirty_days']);
        $this->assertNull($analytics['growth']);
        $this->assertNull($analytics['weekly_growth']);
        $this->assertNull($analytics['conversion']);
        $this->assertSame([0, 0, 0, 0, 0, 0, 0], $analytics['trend']->pluck('total')->all());
    }

    public function test_growth_can_show_a_complete_decline(): void
    {
        $this->pageView('2026-09-01 10:00:00', 'previous-month');

        $analytics = $this->get(route('admin.dashboard'))->assertOk()->viewData('analytics');

        $this->assertEquals(-100, $analytics['growth']);
    }

    private function pageView(string $at, string $visitor): void
    {
        PageView::create([
            'path' => '/sr', 'route_name' => 'home', 'locale' => 'sr',
            'visitor_hash' => hash('sha256', $visitor), 'device' => 'desktop', 'viewed_at' => $at,
        ]);
    }

    private function inquiry(string $at): Inquiry
    {
        $inquiry = new Inquiry(['name' => 'Test visitor', 'phone' => '123456789', 'message' => 'Test inquiry']);
        $inquiry->created_at = $at;
        $inquiry->save();

        return $inquiry;
    }
}
