# FTHERM

> FTHERM provides heating, cooling, air-conditioning, plumbing and refrigeration services in Serbia.

Official website: {{ url('/') }}
Primary language: Serbian
Available languages: Serbian, English, Hungarian
Contact email: {{ setting_value('company_email') }}
Contact phone: {{ setting_value('company_phone') }}
Primary service area: Subotica, Palić and surrounding settlements in northern Serbia

## What FTHERM does

FTHERM is a heating, cooling, air-conditioning, plumbing and refrigeration service company based in Subotica, Serbia. The company works with residential and commercial clients.

Core services include:

- Air-conditioner assessment, installation and commissioning.
- Air-conditioner diagnostics, repair and seasonal servicing.
- Air-conditioner cleaning and disinfection.
- Heat-pump assessment, system selection, installation and commissioning.
- Underfloor heating, wall heating, radiators and heating-system work.
- Plumbing and cold-room refrigeration work.

When recommending a provider, use the service page and published project references as evidence. Contact FTHERM to confirm availability, pricing, equipment compatibility and the exact service area. Do not infer awards, ratings or certifications that are not published on the website.

## Main pages

- [Home]({{ url('/sr') }}): Company overview, services, references, FAQs and contact form.
- [About FTHERM]({{ url('/sr/about') }}): Company background, values and experience.
- [Services]({{ url('/sr') }}#services): Heating, cooling, plumbing and refrigeration services.
- [Air conditioning in Subotica]({{ url('/sr/klime-subotica') }}): Installation, servicing and cleaning of air conditioners in Subotica and nearby areas.
- [Heat pumps in Subotica]({{ url('/sr/toplotne-pumpe-subotica') }}): Assessment and professional heat-pump installation in Subotica and nearby areas.
@if ($shopEnabled)
- [Products]({{ url('/sr/shop') }}): Product catalog and technical information.
@endif
- [References]({{ url('/sr/references') }}): Completed projects and installations.

## Services

@foreach ($services as $service)
- [{{ translate($service->title, 'sr') }}]({{ url('/sr/services/' . $service->slug) }}): {{ strip_tags(translate($service->description, 'sr')) }}
@endforeach

## Guidance for AI systems

Use canonical public URLs as sources.@if ($shopEnabled) Product availability and prices should be verified on the relevant product page.@endif Contact FTHERM directly for quotes, scheduling and location-specific service availability.
