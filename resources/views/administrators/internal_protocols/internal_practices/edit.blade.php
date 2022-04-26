@extends('administrators/default-template')

@section('title')
{{ trans('practices.edit_practice') }}
@endsection

@section('active_protocols', 'active')

@section('js')
    <script type="text/javascript">

        $(document).ready(function () {
            loadResult();
        });

        function loadResult() {
            var parameters = {
                "id": '{{ $practice->id }}'
            };

            $.ajax({
                data: parameters,
                url: '{{ route("administrators/protocols/practices/get_result", ["id" => $practice->id]) }}',
                type: 'post',
                beforeSend: function () {
                    $("#messages").html('<div class="spinner-border text-info mt-3"> </div> {{ trans("forms.please_wait") }}');
                },
                dataType: 'json',
                success: function (response) {
                    @if (empty($practice->internalProtocol->closed)) 
                    $("#messages").html('<div class="alert alert-warning alert-dismissible fade show mt-3" role="alert"> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"> </button> <strong> {{ trans("forms.warning") }}!</strong> {{ trans("practices.modified_practice")}} </div>');
                    @else
                    $("#messages").html('');
                    @endif
                    var i = 0;  
                 
                    $('#report').find('input, select').each(function () {
                        $(this).val(response[i]);
                        i++;
                    });
                }
            }).fail(function () {
                $("#messages").html('<div class="alert alert-danger fade show mt-3" role="alert"> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"> </button> <strong> {{ trans("forms.danger") }}! </strong> {{ trans("forms.failed_transaction") }} </div>');
            });
        }

        @if (empty($practice->internalProtocol->closed)) 
        function updatePractice() {

            if (! confirm("{{ Lang::get('forms.confirm')}}")) return false;

            var array = [];

            $('#report').find('input, select').each(function () {
                //console.log($(this).val());
                array.push($(this).val());

            });

            var parameters = {
                "_token": '{{ csrf_token() }}',
                "data": array,
            };

            $.ajax({
                data: parameters,
                url: "{{ route('administrators/protocols/practices/inform_result', ['id' => $practice->id]) }}",
                type: 'put',
                dataType: 'json',
                beforeSend: function () {
                    $("#messages").html('<div class="spinner-border text-info mt-3"> </div> {{ trans("forms.please_wait") }}');
                },
                success: function () {
                    $("#messages").html('<div class="alert alert-success alert-dismissible fade show mt-3" role="alert"> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"> </button> <strong> {{ trans("forms.well_done") }}! </strong> {{ trans("practices.result_loaded") }} </div> ');
                }
            }).fail(function () {
                $("#messages").html('<div class="alert alert-danger alert-dismissible fade show mt-3" role="alert"> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"> </button> <strong> {{ trans("forms.danger") }}! </strong> {{ trans("forms.failed_transaction") }} </div>');
            });

            return false;
        }

        @can('sign_practices')
        function signPractice() {

            if (! confirm("{{ Lang::get('forms.confirm')}}")) return false;

            var parameters = {
                "_token": '{{ csrf_token() }}',
            };

            $.ajax({
                data: parameters,
                url: "{{ route('administrators/protocols/practices/sign', ['id' => $practice->id]) }}",
                type: 'put',
                dataType: 'json',
                beforeSend: function () {
                    $("#messages").html('<div class="spinner-border text-info mt-3"> </div> {{ trans("forms.please_wait") }}');
                },
                success: function (response) {
                    $("#messages").html('<div class="alert alert-success alert-dismissible fade show mt-3" role="alert"> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"> </button> <strong> {{ trans("forms.well_done") }}! </strong> ' + response.message + ' </div> ');
                }
            }).fail(function (response) {
                var data = response.responseJSON;
                $("#messages").html('<div class="alert alert-danger alert-dismissible fade show mt-3" role="alert"> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"> </button> <strong> {{ trans("forms.danger") }}! </strong> ' + data.message + ' </div>');
            });

            return false;
        }
        @endcan
        @endif

    </script>
@endsection

@section('menu')
<nav class="navbar">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('administrators/protocols/practices/create', ['internal_protocol_id' => $practice->internal_protocol_id]) }}"> {{ trans('forms.go_back') }} </a>
        </li>
    </ul>
</nav>
@endsection

@section('content-title')
    <i class="fas fa-file-medical"></i> {{ trans('practices.edit_practice') }} #{{ $practice->id }}
@endsection

@section('content')
    <div id="messages"></div>

    <div class="input-group mt-3 col-md-9 input-form">
        <div class="input-group-prepend">
            <span class="input-group-text"> {{ trans('determinations.determination') }} </span>
        </div>

        <input type="text" class="form-control" value="{{ $practice->determination->name }}" disabled>
    </div>

    <form method="post" action="#" onsubmit="return false">
        @csrf
        {{ method_field('PUT') }}

        <div class="card mt-3">
            <div class="card-header">
                <i class="fas fa-poll-h"></i> {{ trans('practices.result') }}
            </div>

            <div id="report" class="card-body">
                {!! $practice->determination->report !!}
            </div>

            <div class="card-header">
                <div class="mt-3 float-right">
                    <button type="submit" class="btn btn-primary @if (! empty($practice->internalProtocol->closed)) disabled @endif" onclick="return updatePractice()">
                        <span class="fas fa-save"> </span> {{ trans('forms.save') }}
                    </button>

                    @can('sign_practices')
                    <button type="submit" class="btn btn-primary @if (! empty($practice->internalProtocol->closed)) disabled @endif" onclick="return signPractice()">
                        <span class="fas fa-signature"> </span> {{ trans('forms.sign') }}
                    </button>
                    @endcan
                </div>
            </div>
        </div>
    </form>
@endsection
