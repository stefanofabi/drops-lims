@extends('administrators/default-template')

@section('title')
{{ trans('templates.edit_worksheet_template') }}
@endsection

@section('active_determinations', 'active')

@section('js')
<script type="module">
    tinymce.init({
        selector: 'textarea#worksheet_template', // Replace this CSS selector to match the placeholder element for TinyMCE
        plugins: 'code table lists wordcount searchreplace quickbars preview link fullscreen emoticons charmap advlist',
        toolbar: 'undo redo | formatselect| bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | table | code | fullscreen',
    });
</script>
@append

@section('menu')
<nav class="navbar">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('administrators/determinations/edit', ['id' => $determination->id]) }}"> {{ trans('forms.go_back') }} </a>
        </li>
    </ul>
</nav>
@endsection

@section('content-title')
<i class="fas fa-edit"></i> {{ trans('templates.edit_worksheet_template') }}
@endsection

@section('content-message')
<p class="text-justify pe-5">
	{{ trans('templates.templates_edit_message') }}
</p>
@endsection

@section('content')
<form method="post" action="{{ route('administrators/determinations/templates/worksheets/update', ['id' => $determination->id]) }}">
    @csrf
    {{ method_field('PUT') }}

	<div class="form-group mt-4">
		<h3> <label for="worksheet_template"> {{ trans('templates.template') }} </label> </h3>
		<textarea maxlength="2000" class="form-control" rows="20" name="worksheet_template" id="worksheet_template" aria-describedby="worksheetTemplateHelp" placeholder='<p> <b> Determination name </b> </p>'>{{ old('worksheet_template') ?? $determination->worksheet_template }}</textarea>
		
		<small id="worksheetTemplateHelp" class="form-text text-muted"> {{ trans('templates.template_help') }} </small>
	</div>

	<input type="submit" class="btn btn-lg btn-primary mt-3" value="{{ trans('forms.save') }}">
</form>
@endsection
