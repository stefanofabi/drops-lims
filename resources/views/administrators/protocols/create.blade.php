@extends('administrators/default-template')

@section('title')
    {{ trans('protocols.create_protocol') }}
@endsection

@section('active_protocols', 'active')

@section('menu-title')
    {{ trans('forms.menu') }}
@endsection

@section('menu')
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link" href="#"> <img src="{{ asset('images/drop.png') }}" width="25" height="25"> {{ trans('forms.no_options') }} </a>
        </li>
    </ul>
@endsection

@section('content-title')
    <i class="fas fa-file-medical"></i> {{ trans('protocols.create_protocol') }}
@endsection


@section('content')
    <p> Select a type of protocol to create </p>

    <a href="{{ route('administrators/protocols/our/create') }}" class="btn btn-info" title="{{ trans('protocols.destroy_protocol') }}"> Our Protocol</i> </a>
    <a href="" class="btn btn-info" title="{{ trans('protocols.destroy_protocol') }}"> Derived Protocol</i> </a>			
@endsection