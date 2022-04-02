@extends('administrators/default-template')

@section('title')
{{ trans('home.dashboard') }}
@endsection

@section('content-title')
{{ trans('home.dashboard') }}
@endsection

@section('content-message')
{{ trans('home.dashboard_message') }}
@endsection

@section('content')
<div class="ms-2 me-2">
    <div class="row">
        <div class="col-md bg-success ms-1 me-1 mt-3 rounded p-4">
            <div class="d-inline-block fs-1">
                <span class="fas fa-clock" ></span> 
            </div>  

            <div class="d-inline-block fs-1 ms-2">
                {{ $pending_protocols->count() }}
            </div> 
            
            <br />
            <span class="fs-6"> {{ trans('home.pending_protocols') }} </span>
        </div>

        <div class="col-md bg-danger ms-1 me-1 mt-3 rounded p-4">
            <div class="d-inline-block fs-1">
                <span class="fas fa-signature" ></span> 
            </div>  

            <div class="d-inline-block fs-1 ms-2">
                {{ $practices_not_signed->count() }}
            </div>  

            <br />
            <span class="fs-6"> {{ trans('home.practices_not_signed') }} </span>
        </div>

        <div class="col-md bg-warning ms-1 me-1 mt-3 rounded p-4">
            <div class="d-inline-block fs-1">
                <span class="fas fa-dollar-sign" ></span> 
            </div>  

            <div class="d-inline-block fs-1 ms-2">
                @if ($debt_social_works >= 1000000000 || $debt_social_works <= -1000000000)
                {{ number_format($debt_social_works/1000000000, 2, '.', '.') }}B
                @elseif ($debt_social_works >= 1000000 || $debt_social_works <= -1000000)
                {{ number_format($debt_social_works/1000000, 2, '.', '.') }}M
                @elseif ($debt_social_works >= 1000 || $debt_social_works <= -1000)
                {{ number_format($debt_social_works/1000, 2, '.', '.') }}K
                @else
                {{ number_format($debt_social_works, 0, ',', '.') }}
                @endif
            </div>  

            <br />
            <span class="fs-6"> {{ trans('home.debt_social_works') }} </span>
        </div>
    </div>
</div>
@endsection