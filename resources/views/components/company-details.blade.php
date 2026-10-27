@props(['dark' => false, 'exclude' => []])

@php
    $companyDetails = collect([
        'company_name' => 'legal_name',
        'company_address' => 'address',
        'company_pib' => 'pib',
        'company_maticni_broj' => 'registration_number',
        'company_sifra_delatnosti' => 'activity_code',
        'company_bank_account' => 'bank_account',
    ])->except($exclude)->map(fn ($label, $key) => [
        'label' => __('ftherm.company.' . $label),
        'value' => setting_value($key),
    ])->filter(fn ($detail) => filled($detail['value']));
@endphp

@if ($companyDetails->isNotEmpty())
    <section {{ $attributes->class(['company-details', 'company-details--dark' => $dark]) }}>
        <h2 class="company-details__heading">{{ __('ftherm.company.title') }}</h2>
        <dl class="company-details__grid">
            @foreach ($companyDetails as $detail)
                <div class="company-details__item">
                    <dt>{{ $detail['label'] }}</dt>
                    <dd>{{ $detail['value'] }}</dd>
                </div>
            @endforeach
        </dl>
    </section>
@endif
