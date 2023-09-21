@extends('administrators/default-template')

@section('css')
<style>
.getBig:hover {
      transform: scale(1.02);
      opacity: 0.95;
      box-shadow: 0px 3px 10px -2px black;
}
</style>
@endsection

@section('title')
{{ trans('home.dashboard') }}
@endsection

@section('content-title')
<i class="fa-solid fa-gauge"></i> {{ trans('home.dashboard') }}
@endsection

@section('content-message')
{{ trans('home.dashboard_message') }}
@endsection

@section('content')
<div class="ms-2 me-2">
    <div class="row">
        <div class="col-md bg-success ms-1 me-1 mt-3 rounded p-4 getBig">
            <div class="d-inline-block fs-1">
                <span class="fas fa-clock" ></span> 
            </div>  
            
            <div class="d-inline-block fs-1 ms-2">
                {{ $pending_protocols->count() }}
            </div> 
            
            <br />
            <span class="fs-6"> {{ trans('home.pending_protocols') }} </span>
        </div>

        <div class="col-md bg-danger ms-1 me-1 mt-3 rounded p-4 getBig">
            <div class="d-inline-block fs-1">
                <span class="fas fa-signature" ></span> 
            </div>  

            <div class="d-inline-block fs-1 ms-2">
                {{ $practices_not_signed->count() }}
            </div>  

            <br />
            <span class="fs-6"> {{ trans('home.practices_not_signed') }} </span>
        </div>

        <div class="col-md bg-warning ms-1 me-1 mt-3 rounded p-4 getBig">
            <div class="d-inline-block fs-1">
                <span class="fas fa-dollar-sign" ></span> 
            </div>  

            <div class="d-inline-block fs-1 ms-2">
                @if ($debt_social_works >= 1000000000 || $debt_social_works <= -1000000000)
                {{ number_format($debt_social_works/1000000000, Drops::getSystemParameterValueByKey('DECIMALS'), Drops::getSystemParameterValueByKey('DECIMAL_SEPARATOR'), Drops::getSystemParameterValueByKey('THOUSANDS_SEPARATOR')) }}B
                @elseif ($debt_social_works >= 1000000 || $debt_social_works <= -1000000)
                {{ number_format($debt_social_works/1000000, Drops::getSystemParameterValueByKey('DECIMALS'), Drops::getSystemParameterValueByKey('DECIMAL_SEPARATOR'), Drops::getSystemParameterValueByKey('THOUSANDS_SEPARATOR')) }}M
                @elseif ($debt_social_works >= 1000 || $debt_social_works <= -1000)
                {{ number_format($debt_social_works/1000, Drops::getSystemParameterValueByKey('DECIMALS'), Drops::getSystemParameterValueByKey('DECIMAL_SEPARATOR'), Drops::getSystemParameterValueByKey('THOUSANDS_SEPARATOR')) }}K
                @else
                {{ number_format($debt_social_works, Drops::getSystemParameterValueByKey('DECIMALS'), Drops::getSystemParameterValueByKey('DECIMAL_SEPARATOR'), Drops::getSystemParameterValueByKey('THOUSANDS_SEPARATOR')) }}
                @endif
            </div>  

            <br />
            <span class="fs-6"> {{ trans('home.debt_social_works') }} 
        </div>
    </div>

    <div class="row">
        <div class="col-md bg-secondary rounded fs-2 p-4 ms-1 me-1 mt-3 getBig">
            <i class="fa-solid fa-chart-simple"></i>

            {{ trans('statistics.statistics') }}
            
            <a href="@if (auth()->user()->can('view statistics')) {{ route('administrators/statistics/index') }} @else # @endif" class="text-dark"> 
                <i class="fa-solid fa-arrow-right float-end mt-2"></i> 
            </a>
        </div>

        <div class="col-md bg-secondary rounded fs-2 p-4 ms-1 me-1 mt-3 getBig">
            <i class="fa-solid fa-file-pdf"></i>

            {{ trans('summaries.summaries') }}
            
            <a href="@if (auth()->user()->can('generate summaries')) {{ route('administrators/summaries/index') }} @else # @endif" class="text-dark"> 
                <i class="fa-solid fa-arrow-right float-end mt-2"></i> 
            </a>
        </div>
    </div>
</div>


@endsection