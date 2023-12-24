@extends('administrators/default-template')

@section('title')
{{ trans('settings.settings') }}
@endsection

@section('content-message')
<p class="text-justify pe-5">
    {{ trans('settings.settings_content_index_message') }}
</p>
@endsection

@section('menu')
<nav class="navbar">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('administrators/settings/nomenclators/index') }}"> {{ trans('nomenclators.nomenclators') }} </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('administrators/settings/billing_periods/index') }}"> {{ trans('billing_periods.billing_periods') }} </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('administrators/settings/social_works/index') }}"> {{ trans('social_works.social_works') }} </a>
        </li>
    </ul>
</nav>
@endsection

@section('content-title')
<i class="fas fa-cogs"></i> {{ trans('settings.settings') }}
@endsection

@section('content')
<div class="row">
    <div class="col-md-6 mt-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title"> {{ trans('settings.system_parameters') }} </h5>
                <p class="card-text"> {{ trans('settings.system_parameters_message') }} </p>
                <a href="{{ route('administrators/settings/system_parameters/edit', ['category' => 'General']) }}" class="btn btn-primary @cannot('manage system parameters') disabled @endcannot"> {{ trans('settings.edit_parameters') }} </a>
            </div>
        </div>
    </div>

    <div class="col-md-6 mt-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title"> {{ trans('settings.roles_permissions') }} </h5>
                <p class="card-text"> {{ trans('settings.roles_permissions_message') }} </p>
                <a href="{{ route('administrators/settings/roles/index') }}" class="btn btn-danger @cannot('manage roles') disabled @endcannot"> ⚠️ {{ trans('settings.go_be_careful') }} </a>
            </div>
        </div>
    </div>

    <div class="col-md-6 mt-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title"> {{ trans('settings.user_management') }} </h5>
                <p class="card-text"> {{ trans('settings.user_management_message') }} </p>
                <a href="{{ route('administrators/settings/users/index') }}" class="btn btn-primary @cannot('manage users') disabled @endcannot"> {{ trans('settings.show_all_users') }} </a>
            </div>
        </div>
    </div>
</div>
@endsection
