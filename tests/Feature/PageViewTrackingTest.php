<?php

namespace Tests\Feature;

use App\Http\Middleware\TrackPageView;
use App\Models\PageView;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class PageViewTrackingTest extends TestCase
{
    use RefreshDatabase;

    private const BROWSER = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36';

    public function test_page_views_and_estimated_visitors_are_distinct_metrics(): void
    {
        $this->get('/sr', ['User-Agent' => self::BROWSER])->assertOk();
        $this->get('/sr/about', ['User-Agent' => self::BROWSER])->assertOk();
        $this->get('/sr', ['User-Agent' => self::BROWSER])->assertOk();

        $this->assertDatabaseCount('page_views', 3);
        $this->assertSame(1, PageView::distinct()->count('visitor_hash'));
    }

    #[DataProvider('automatedUserAgents')]
    public function test_recognizable_automation_is_not_counted(string $userAgent): void
    {
        $this->get('/sr', ['User-Agent' => $userAgent])->assertOk();

        $this->assertDatabaseCount('page_views', 0);
    }

    public static function automatedUserAgents(): array
    {
        return [
            'missing' => [''],
            'whitespace' => ['   '],
            'search crawler' => ['Mozilla/5.0 (compatible; Googlebot/2.1)'],
            'curl' => ['curl/8.10.1'],
            'wget' => ['Wget/1.21.4'],
            'python' => ['python-requests/2.32.3'],
            'headless browser' => ['Mozilla/5.0 HeadlessChrome/131.0.0.0 Safari/537.36'],
            'site audit' => [self::BROWSER.' Chrome-Lighthouse'],
            'monitor' => ['Pingdom.com_bot_version_1.4'],
            'go client' => ['Go-http-client/1.1'],
            'node client' => ['node-fetch'],
            'preview' => ['facebookexternalhit/1.1'],
        ];
    }

    #[DataProvider('staffGuards')]
    public function test_staff_browsing_is_not_counted(string $guard): void
    {
        $this->actingAs(User::factory()->create(['role' => $guard, 'is_admin' => $guard === 'admin']), $guard);
        $this->get('/sr', ['User-Agent' => self::BROWSER])->assertOk();

        $this->assertDatabaseCount('page_views', 0);
    }

    public static function staffGuards(): array
    {
        return [['admin'], ['worker']];
    }

    #[DataProvider('backgroundHeaders')]
    public function test_background_requests_are_not_counted(string $header, string $value): void
    {
        $this->get('/sr', ['User-Agent' => self::BROWSER, $header => $value])->assertOk();

        $this->assertDatabaseCount('page_views', 0);
    }

    public static function backgroundHeaders(): array
    {
        return [
            ['Purpose', 'prefetch'],
            ['Sec-Purpose', 'prefetch;prerender'],
            ['X-Purpose', 'preview'],
            ['X-Moz', 'prefetch'],
            ['X-Requested-With', 'XMLHttpRequest'],
        ];
    }

    #[DataProvider('nonPageResponses')]
    public function test_only_successful_html_gets_for_public_pages_are_counted(string $method, string $routeName, int $status, string $contentType): void
    {
        $request = Request::create('/sr', $method, server: ['HTTP_USER_AGENT' => self::BROWSER]);
        $route = (new Route([$method], '/sr', fn () => null))->name($routeName);
        $request->setRouteResolver(fn () => $route);
        $response = new Response('Test', $status, ['Content-Type' => $contentType]);

        $this->assertSame($response, (new TrackPageView)->handle($request, fn () => $response));
        $this->assertDatabaseCount('page_views', 0);
    }

    public static function nonPageResponses(): array
    {
        return [
            ['HEAD', 'home', 200, 'text/html'],
            ['POST', 'home', 200, 'text/html'],
            ['GET', 'admin.dashboard', 200, 'text/html'],
            ['GET', 'home', 302, 'text/html'],
            ['GET', 'home', 404, 'text/html'],
            ['GET', 'home', 500, 'text/html'],
            ['GET', 'home', 200, 'application/json'],
        ];
    }
}
