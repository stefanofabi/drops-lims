@extends('administrators/default-template')

@section('title')
{{ trans('settings.settings') }}
@endsection

@section('menu')
<nav class="navbar">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('administrators/settings/nomenclators/index') }}"> {{ trans('nomenclators.nomenclators') }} </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('administrators/settings/social_works/billing_periods/index') }}"> {{ trans('billing_periods.billing_periods') }} </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('administrators/settings/social_works/index') }}"> {{ trans('social_works.social_works') }} </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('administrators/settings/activity_logs') }}" target="_blank"> {{ trans('settings.activity_logs') }} </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('administrators/settings/system_logs') }}"> {{ trans('settings.system_logs') }} </a>
        </li>
    </ul>
</nav>
@endsection

@section('content-title')
<i class="fas fa-cogs"></i> {{ trans('settings.settings') }}
@endsection

@section('content')

@endsection
