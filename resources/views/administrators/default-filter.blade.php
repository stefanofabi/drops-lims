@extends('default-filter')

@section('home-href')
{{ route('administrators/home') }}
@endsection

@section('navbar_menu')
@include('administrators/navbar_menu')
@endsection