@section('messages')
    @if(Session::has('success'))
        <div class="alert alert-success">
        	<p> <strong> {{ trans('forms.successful_transaction') }} </strong> </p>
            <ul>
                @foreach (Session::get('success') as $message)
                    <li>{{ $message }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
           <p> <strong> {{ trans('errors.error_processing_transaction') }} </strong> </p>

            <ul>
                @foreach ($errors->all() as $error)
                    <li> {{ $error }} </li>
                @endforeach
            </ul>
        </div>
    @endif
@endsection