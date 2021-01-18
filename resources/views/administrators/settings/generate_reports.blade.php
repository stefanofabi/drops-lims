@extends('administrators/settings/index')

@section('title')
    {{ trans('settings.generate_reports') }}
@endsection

@section('content-title')
    <i class="fas fa-archive"> </i> {{ trans('settings.generate_reports') }}
@endsection

@section('js')
    <script type="text/javascript">
        function generateReport() {
            var form = document.getElementById('generate_report');
            form.submit();
        }
    </script>

@endsection

@section('content')

    <div class="card">
        <div class="card-header"><h5> {{ trans('settings.protocol_report') }} </h5></div>

        <div class="card-body">
            <form method="post" target="_blank" id="generate_report" action="#">
                @csrf

                <div class="input-group col-md-6 input-form">
                    <div class="input-group-prepend">
                        <span class="input-group-text"> {{ trans('statistics.initial_date') }} </span>
                    </div>

                    <input type="date" class="form-control" name="address" value="{{ date('Y-m-d') }}">
                </div>

                <div class="input-group mt-2 col-md-6 input-form">
                    <div class="input-group-prepend">
                        <span class="input-group-text"> {{ trans('statistics.ended_date') }} </span>
                    </div>

                    <input type="date" class="form-control" name="address" value="{{ date('Y-m-d') }}">
                </div>

            </form>
        </div>

        <div class="card-footer">
            <div class="text-right">
                <button onclick="generateReport();" class="btn btn-primary">
                    <span class="fas fa-file-pdf"></span> {{ trans('settings.generate_report') }}
                </button>
            </div>
        </div>
    </div>



@endsection
