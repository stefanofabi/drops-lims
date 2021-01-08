<title> @yield('title') - SrLab</title>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

<meta name="viewport" content="width=device-width, user-scalable=no">

<!-- Laravel mix -->
<script src="{{ asset('js/app.js') }}"></script>
<link type="text/css" rel="stylesheet" href="{{ asset('css/app.css') }}">

<!-- Description that will be taken into account by web search engines  -->
<meta name="description" content="Online results system designed for our shunts and doctors who trust us with their patients"/>

<!-- Keywords for better web positioning -->
<meta name="keywords" content="laboratory, results, shunts, prescribers, online, patients, health"/>

<!-- Page authors -->
<meta name="author" content="Stefano Fabi" />

<!-- Copyright -->
<meta name="copyright" content="SrLab" />

<!-- Used by ajax -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
