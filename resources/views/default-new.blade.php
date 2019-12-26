<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        @include('head')

        @include('navbar')

        @section('js')
        @show

        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>

    <body>
    	<div class="row">
	    	<div class="col-md-3 menu float-left">
				@section('menu')
				@show
	    	</div>

	    	<div class="col-md-9">
	    		@section('content')
	    		@show
	    	</div>
	    </div>
    </body>
</html>