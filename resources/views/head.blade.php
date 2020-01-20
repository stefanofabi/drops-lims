<title> @yield('title') - SrLab</title>

<!-- JQuery -->
<script src="{{ asset('lib/jquery/jquery.min.js') }}"></script>

<!-- Bootstrap - need JQuery -->
<link rel="stylesheet" href="{{ asset('lib/bootstrap/css/bootstrap.min.css') }}">
<script src="{{ asset('lib/bootstrap/js/bootstrap.min.js') }}"></script>

<!-- Icons -->
<link href="{{ asset('lib/fontawesome/css/fontawesome.css') }}" rel="stylesheet">
<link href="{{ asset('lib/fontawesome/css/brands.css') }}" rel="stylesheet">
<link href="{{ asset('lib/fontawesome/css/solid.css') }}" rel="stylesheet">

<!-- JQuery UI & AutoComplete -->
<link rel="stylesheet" href="{{ asset('lib/jquery-ui/jquery-ui.css') }}">
<script src="{{ asset('lib/jquery-ui/jquery-ui.js') }}"></script>

<!-- Styles -->
<link rel="stylesheet" href="{{ asset('css/default.css') }}">


<!-- Description that will be taken into account by web search engines  -->
<meta name="description" content="Sistema de resultados online pensado para nuestros derivadores y médicos que nos confian a sus pacientes"/>

<!-- Keywords for better web positioning -->
<meta name="keywords" content="laboratorio, resultados, derivadores, medicos, online, pacientes, salud"/>


<!-- Page authors -->
<meta name="author" content="Stefano Fabi, CEO & Founder SrDev" />

<!-- Copyright -->
<meta name="copyright" content="SrDev" />

<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> 

<!-- Used by ajax -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<script type="text/javascript">
	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});
</script>