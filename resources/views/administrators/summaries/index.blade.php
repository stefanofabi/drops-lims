@extends('administrators.default-template')

@section('title')
{{ trans('summaries.summaries') }}
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
<i class="fas fa-archive"> </i> {{ trans('summaries.summaries') }}
@endsection

@section('content-message')
<p class="text-justify pe-5">
    {{ trans('pdf.generate_reports_message') }} 
</p>
@endsection

@section('content')
<div class="row">
    <div class="col-xl-6">    
        @include('administrators.summaries.protocols_summary')
    </div>

    <div class="col-xl-6">  
        @include('administrators.summaries.patients_flow')
    </div>

    <div class="col-xl-6">  
        @include('administrators.summaries.debt_social_works')
    </div>
</div>
@endsection
