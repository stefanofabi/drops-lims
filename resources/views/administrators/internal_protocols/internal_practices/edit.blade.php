@extends('administrators/default-template')

@section('title')
{{ trans('practices.edit_practice') }}
@endsection

@section('active_protocols', 'active')

@section('js')
    <script type="text/javascript">

        $(document).ready(function () {
            $('#report').find('input').each(function () {
                $(this).addClass("form-control");
            });

            $('#report').find('select').each(function () {
                $(this).addClass("form-select");
            });

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

                    // If there are default values in the template it does not overwrite them
                    if (response.length) 
                    {
                        var i = 0;  
                        
                        $('#report').find('input, select').each(function () {
                            
                                $(this).val(response[i]);
                                i++;
                            
                        });
                    }
                }
            }).fail(function () {
                $("#messages").html('<div class="alert alert-danger fade show mt-3" role="alert"> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"> </button> <strong> {{ trans("forms.danger") }}! </strong> {{ trans("forms.failed_transaction") }} </div>');
            });
        }

        function updatePractice() {
            if (! confirm("{{ Lang::get('forms.confirm')}}")) return false;

            let submit_practice_update = $("#submit_practice_update")
            submit_practice_update.click();
        }

        @if (empty($practice->internalProtocol->closed))
            @can('sign_practices')
            function signPractice() {
                if (! confirm("{{ Lang::get('forms.confirm')}}")) return false;

                let practice_signature_form = $("#practice_signature_form")
                practice_signature_form.submit();
            }
            @endcan
        @endif
    </script>

    <!-- Practice Javascript code -->
    {!! $practice->determination->javascript !!}
@endsection

@section('menu')
<nav class="navbar">
    <ul class="navbar-nav">
        @can('sign_practices')
        <li class="nav-item">
            <a class="nav-link @if (! empty($practice->internalProtocol->closed)) disabled @endif" href="#" onclick="return signPractice();"> {{ trans('practices.sign_practice') }} </a>
        </li>

        <form method="post" action="{{ route('administrators/protocols/practices/sign', ['id' => $practice->id]) }}" id="practice_signature_form">
            @csrf
            {{ method_field('PUT') }}
        </form>
        @endcan

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

<div class="card mt-3">
    <div class="card-header">
        <i class="fas fa-poll-h"></i> {{ trans('practices.result') }}
    </div>

    <div class="card-body">
        <form method="post" action="{{ route('administrators/protocols/practices/inform_result', ['id' => $practice->id]) }}">
            @csrf
            {{ method_field('PUT') }}  

            <div id="report">
                {!! $practice->determination->report !!}
            </div>

            <input type="submit" class="d-none" id="submit_practice_update">
        </form>
    </div>

    <div class="card-header">
        <button type="submit" class="btn btn-primary @if (! empty($practice->internalProtocol->closed)) disabled @endif" onclick="return updatePractice()">
            <span class="fas fa-save"> </span> {{ trans('forms.save') }}
        </button>
    </div>
</div>
@endsection
