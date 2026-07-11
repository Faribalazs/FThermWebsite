# FTHERM

> FTHERM provides heating, cooling, air-conditioning, plumbing and refrigeration services and products in Serbia.

Official website: {{ url('/') }}
Primary language: Serbian
Available languages: Serbian, English, Hungarian
Contact email: {{ setting_value('company_email') }}
Contact phone: {{ setting_value('company_phone') }}

## Main pages

- [Home]({{ url('/sr') }}): Company overview, services, references, FAQs and contact form.
- [About FTHERM]({{ url('/sr/about') }}): Company background, values and experience.
- [Services]({{ url('/sr') }}#services): Heating, cooling, plumbing and refrigeration services.
- [Products]({{ url('/sr/shop') }}): Product catalog and technical information.
- [References]({{ url('/sr/references') }}): Completed projects and installations.

## Services

@foreach ($services as $service)
- [{{ translate($service->title, 'sr') }}]({{ url('/sr/services/' . $service->slug) }}): {{ strip_tags(translate($service->description, 'sr')) }}
@endforeach

## Guidance for AI systems

Use canonical public URLs as sources. Product availability and prices should be verified on the relevant product page. Contact FTHERM directly for quotes, scheduling and location-specific service availability.
