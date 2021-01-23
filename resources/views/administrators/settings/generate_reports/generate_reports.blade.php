@extends('administrators.settings.index')

@section('title')
    {{ trans('settings.generate_reports') }}
@endsection

@section('content-title')
    <i class="fas fa-archive"> </i> {{ trans('settings.generate_reports') }}
@endsection

@section('js')
    <script type="text/javascript">
        function send(submit_button_id) {
            let submitButton = $('#'+submit_button_id);
            submitButton.click();
        }
    </script>

@endsection

@section('content')

    @include('administrators.settings.generate_reports.protocols_report')

    @include('administrators.settings.generate_reports.patients_flow')

    @include('administrators.settings.generate_reports.debt_social_works')

@endsection
