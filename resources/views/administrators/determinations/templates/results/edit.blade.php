@extends('administrators/default-template')

@section('title')
{{ trans('templates.edit_result_template') }}
@endsection

@section('active_determinations', 'active')

@section('js')
<script type="module">
    tinymce.init({
        selector: 'textarea#template', // Replace this CSS selector to match the placeholder element for TinyMCE
        plugins: 'code table lists wordcount searchreplace quickbars preview link fullscreen emoticons charmap advlist',
        toolbar: 'undo redo | formatselect| bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | table | code | fullscreen',
    });
</script>
@append

@section('menu')
<nav class="navbar">
    <ul class="navbar-nav">
		<li class="nav-item">
            <a class="nav-link" data-bs-toggle="modal" data-bs-target="#exampleModal"> {{ trans('templates.open_variable_creator_helper') }} </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('administrators/determinations/edit', ['id' => $determination->id]) }}"> {{ trans('forms.go_back') }} </a>
        </li>
    </ul>
</nav>
@endsection

@section('content-title')
<i class="fas fa-edit"></i> {{ trans('templates.edit_result_template') }}
@endsection

@section('content-message')
<p class="text-justify pe-5">
	{{ trans('templates.templates_edit_message') }}
</p>
@endsection

@section('content')
@if (sizeof($errors) == 0)
	<div id="securityMessage" class="alert alert-warning fade show mt-3">
		{{ trans('templates.edit_template_notice') }}
	</div>
@endif

<form method="post" action="{{ route('administrators/determinations/templates/results/update', ['id' => $determination->id]) }}">
    @csrf
    {{ method_field('PUT') }}

	<div class="row">
		<a class="text-decoration-none text-dark text-center" data-bs-toggle="collapse" href="#collapseVariables" role="button" aria-expanded="false" aria-controls="collapseVariables">
			{{ trans('templates.view_template_variables') }} ⬇️
		</a>
	</div>

	<div class="collapse" id="collapseVariables">
		<div class="table-responsive">
			<table class="table mt-3">
				<thead>
					<tr>
						<th scope="col" style="width: 30%"> {{ trans('templates.variable_identifier') }} </th>
						<th scope="col">  {{ trans('templates.variable_value') }} </th>
					</tr>
				</thead>

				<tbody>
					@if (! is_null($determination->template_variables))
						@foreach ($determination->template_variables as $var_name => $var_value)
						<tr>
							<td>
								<input type="text" class="form-control" name="variable_names[]" value="{{ $var_name }}" pattern="^[a-zA-Z0-9_]+$">
							</td>

							<td>
								<input type="text" class="form-control" name="variable_values[]" value="{{ $var_value }}">
							</td>
						</tr>
						@endforeach
					@endif

					<tr>
						<td>
							<input type="text" class="form-control" name="variable_names[]" pattern="^[a-zA-Z0-9_]+$" placeholder="{{ trans('templates.add_new_identifier') }}">
						</td>
						
						<td>
							<input type="text" class="form-control" name="variable_values[]" placeholder="{{ trans('templates.add_new_value') }}">
						</td>
					</tr>
				</tbody>
			</table>
		</div>

		<div> 
			<h4> {{ trans('templates.considerations') }} </h4>
			<div class="row">
				<ol class="list-group  list-group-flush list-group-numbered">
					<li class="list-group-item  bg-light"> {{ trans('templates.how_create_template_variables') }} </li>
					<li class="list-group-item  bg-light"> {{ trans('templates.match_identifier_and_name_consideration') }} </li>
					<li class="list-group-item  bg-light"> {{ trans('templates.enclose_variable_consideration') }} </li>
					<li class="list-group-item  bg-light"> {{ trans('templates.any_questions_consideration') }} </li>
				</ol>
			</div>
			
		</div>
	</div>

	<div class="form-group mt-4">
		<h3> <label for="javascript"> {{ trans('templates.javascript') }} </label> </h3>
		<textarea maxlength="1000" class="form-control" rows="10" name="javascript" id="javascript" aria-describedby="javascriptHelp" placeholder='<script> $(document).ready(function() {  your code }); </script>'>{{ old('javascript') ?? $determination->javascript }}</textarea>
		
		<small id="javascriptHelp" class="form-text text-muted"> {{ trans('templates.javascript_help') }} </small>
	</div>

	<div class="form-group mt-4">
		<h3> <label for="template"> {{ trans('templates.template') }} </label> </h3>
		<textarea maxlength="2000" class="form-control" rows="20" name="template" id="template" aria-describedby="templateHelp" placeholder='<p> <b> Determination name </b> </p> <p> <input type="number" name="result[]"> </p>'>{{ old('template') ?? $determination->template }}</textarea>
		
		<small id="templateHelp" class="form-text text-muted"> {{ trans('templates.template_help') }} <br> {{ trans('templates.invisible_table_structure_consideration') }} </small>
	</div>

	<input type="submit" class="btn btn-lg btn-primary mt-3" value="{{ trans('forms.save') }}">
</form>

@include('administrators.determinations.templates.results.variable_creator_helper')
@endsection
