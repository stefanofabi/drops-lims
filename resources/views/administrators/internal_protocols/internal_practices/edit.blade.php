@extends('administrators/default-template')

@section('title')
{{ trans('practices.edit_practice') }}
@endsection

@section('active_protocols', 'active')

@section('js')
    <script type="module">
        $(document).ready(function () {
            $('#report').find('input').each(function () {
                $(this).addClass("form-control");
            });

            $('#report').find('select').each(function () {
                $(this).addClass("form-select");
            });

            loadResult();
        });
    </script>
    
    <script type="text/javascript">
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
        
        function signPractice() {
            if (! confirm("{{ Lang::get('forms.confirm')}}")) return false;

            let practice_signature_form = $("#practice_signature_form")
            practice_signature_form.submit();
        }
    </script>

    <!-- Practice Javascript code -->
    {!! $practice->determination->javascript !!}
@endsection

@section('menu')
<nav class="navbar">
    <ul class="navbar-nav">
        
        <li class="nav-item">
            <a class="nav-link @if ($practice->internalProtocol->isClosed() || ! auth()->user()->can('sign practices')) disabled @endif" href="#" onclick="return signPractice();"> {{ trans('practices.sign_practice') }} </a>
        </li>

        <form method="post" action="{{ route('administrators/protocols/practices/sign', ['id' => $practice->id]) }}" id="practice_signature_form">
            @csrf
            {{ method_field('PUT') }}
        </form>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('administrators/protocols/practices/index', ['internal_protocol_id' => $practice->internal_protocol_id]) }}"> {{ trans('forms.go_back') }} </a>
        </li>
    </ul>
</nav>
@endsection

@section('content-title')
    <i class="fas fa-file-medical"></i> {{ trans('practices.edit_practice') }}
@endsection

@section('content-message')
<p class="text-justify pe-5">
    {{ trans('practices.practices_edit_message') }}
</p>
@endsection

@section('content')
<div id="messages"></div>


<div class="form-group mt-3 col-md-6">
    <label class="fs-4" for="determination"> {{ trans('determinations.determination') }} </label>
    <input type="text" class="form-control" id="determination" value="{{ $practice->determination->name }}" disabled>
</div>

<div class="form-group mt-3">
    <label class="fs-4" for="determination"> {{ trans('practices.result') }} </label>
</div>

<div class="card mt-3">
    <div class="card-body">
        <form method="post" action="{{ route('administrators/protocols/practices/inform_result', ['id' => $practice->id]) }}" onsubmit="return confirm('{{ Lang::get('forms.confirm') }}')">
            @csrf
            {{ method_field('PUT') }}  

            <div id="report">
                {!! $practice->determination->report !!}
            </div>

            <div class="row row-cols-md-auto mt-4">         
                <div class="col-12">   
                    <input type="submit" class="btn btn-primary @if (! empty($practice->internalProtocol->closed)) disabled @endif" value="{{ trans('forms.save') }}">
                </div>

                <div class="col-12 mt-2">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="stay_on_this_page" value="1" id="stayOnThisPage">
                        <label class="form-check-label" for="stayOnThisPage">
                            {{ trans('forms.stay_on_this_page') }}
                        </label>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection