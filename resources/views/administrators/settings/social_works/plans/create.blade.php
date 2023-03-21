@extends('administrators/settings/index')

@section('js')
<script type="module">
    $(document).ready(function () 
    {
        // Select a nomenclator from list
        $("#nomenclator").val("{{ old('nomenclator_id') }}");
    });
</script>
@endsection

@section('title')
{{ trans('plans.create_plan') }}
@endsection

@section('menu')
<nav class="navbar">
	<ul class="navbar-nav">
        <li class="nav-item">
			<a class="nav-link" href="{{ route('administrators/settings/social_works/plans/index', ['social_work_id' => $social_work->id]) }}"> {{ trans('forms.go_back')}} </a>
		</li>
	</ul>
</nav>
@endsection

@section('content-title')
<i class="fas fa-plus"> </i> {{ trans('plans.create_plan') }}
@endsection

@section('content-message')
<p class="text-justify pe-5">
    {{ trans('plans.plans_create_message') }}  
</p>
@endsection

@section('content')

<form method="post" action="{{ route('administrators/settings/social_works/plans/store') }}">
    @csrf

    <input type="hidden" name="social_work_id" value="{{ $social_work->id }}">

    <div class="row">
        <div class="col-md-6">
            <div class="form-group mt-2">
                <label for="social_work"> {{ trans('social_works.social_work') }} </label>
                <input type="text" class="form-control" id="social_work" value="{{ $social_work->name }}" aria-describedby="socialWorkHelp" disabled>
                                
                <small id="socialWorkHelp" class="form-text text-muted"> {{ trans('plans.social_work_help') }} </small>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group mt-2">
                <label for="nomenclator"> {{ trans('nomenclators.nomenclator') }} </label>
                <select class="form-select" name="nomenclator_id" id="nomenclator" aria-describedby="nomenclatorHelp">
                    <option value=""> {{ trans('forms.select_option') }}</option>
                    @foreach ($nomenclators as $nomenclator)
                    <option value="{{ $nomenclator->id }}"> {{ $nomenclator->name }}</option>
                    @endforeach
                </select>           

                <small id="nomenclatorHelp" class="form-text text-muted"> {{ trans('plans.nomenclator_help') }} </small>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group mt-2">
                <label for="name"> {{ trans('social_works.name') }} </label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name') }}" aria-describedby="nameHelp" required>
                            
                <small id="nameHelp" class="form-text text-muted"> {{ trans('plans.name_help') }} </small>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group mt-2">
                <label for="nbu_price"> {{ trans('plans.nbu_price') }} </label>
                <input type="number" step="0.01" class="form-control @error('nbu_price') is-invalid @enderror" name="nbu_price" id="nbu_price" value="{{ old('nbu_price') }}" aria-describedby="nbuPriceHelp" required>          

                <small id="nbuPriceHelp" class="form-text text-muted"> {{ trans('plans.nbu_price_help') }} </small>
            </div> 
        </div>
    </div>

    <input type="submit" class="btn btn-lg btn-primary mt-3" value="{{ trans('forms.save') }}">
</form>
@endsection