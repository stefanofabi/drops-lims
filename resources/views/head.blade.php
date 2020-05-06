<title> @yield('title') - SrLab</title>

<!-- Laravel mix -->
<script src="{{ asset('js/app.js') }}"></script>
<link type="text/css" rel="stylesheet" href="{{ asset('css/app.css') }}">

<!-- Icons -->
<link href="{{ asset('fontawesome/css/fontawesome.css') }}" rel="stylesheet">
<link href="{{ asset('fontawesome/css/solid.css') }}" rel="stylesheet">

<!-- Description that will be taken into account by web search engines  -->
<meta name="description" content="Sistema de resultados online pensado para nuestros derivadores y médicos que nos confian a sus pacientes"/>

<!-- Keywords for better web positioning -->
<meta name="keywords" content="laboratory, results, shunts, prescribers, online, patients, health"/>


<!-- Page authors -->
<meta name="author" content="Stefano Fabi" />

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