@extends('administrators.settings.index')

@section('title')
{{ trans('settings.generate_reports') }}
@endsection

@section('js')
    <script type="text/javascript">
        function send(submit_button_id) {
            let submitButton = $('#'+submit_button_id);
            submitButton.click();
        }
    </script>

@endsection

@section('content-title')
<i class="fas fa-archive"> </i> {{ trans('settings.generate_reports') }}
@endsection

@section('content-message')
<p class="text-justify pe-5">
    {{ trans('pdf.generate_reports_message') }} 
</p>
@endsection

@section('content')
<div class="row">
    <div class="col-xl-6">    
        @include('administrators.settings.generate_reports.protocols_report')
    </div>

    <div class="col-xl-6">  
        @include('administrators.settings.generate_reports.patients_flow')
    </div>
</div>

<div class="row">
    <div class="col-xl-6">  
        @include('administrators.settings.generate_reports.debt_social_works')
    </div>
</div>
@endsection
