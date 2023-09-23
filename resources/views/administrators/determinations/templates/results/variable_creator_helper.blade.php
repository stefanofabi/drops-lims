@section('js')
<script type="module">
	$('#numberRadioButton').change(function() {
        if(this.checked) 
        {
			$('#placeholderOption').show(1000);
			$('#stepOption').show(1000);
            $('#selectOptions').hide(1000);

			changeInputTypes();
        }
    });

	$('#textRadioButton').change(function() {
        if(this.checked) 
        {
			$('#placeholderOption').show(1000);
			$('#stepOption').hide(1000);
            $('#selectOptions').hide(1000);

			changeInputTypes();
        }
    });

	$('#dateRadioButton').change(function() {
        if(this.checked) 
        {
			$('#placeholderOption').hide(1000);
			$('#stepOption').hide(1000);
            $('#selectOptions').hide(1000);

			changeInputTypes();
        } 
    });

	$('#timeRadioButton').change(function() {
        if(this.checked) 
        {
			$('#placeholderOption').hide(1000);
			$('#stepOption').hide(1000);
            $('#selectOptions').hide(1000);

			changeInputTypes();
        } 
    });

	$('#selectRadioButton').change(function() {
        if(this.checked) 
        {
            $('#selectOptions').show(1000);
			$('#stepOption').hide(1000);
			$('#placeholderOption').hide(1000);

			changeInputTypes();
        } 
    });

	$('#helperId').change(function() {
        $('#helperName').val(this.value);
    });

	$('#helperStep').change(function() {
        $('#helperDefaultValue').attr('step', this.value);
    });

	$(document).ready(function() {
        $('#selectOptions').hide();
    });
</script>

<script type="text/javascript">
	function generateVariableInput()
	{
		let resultHelperValue = "";

		let helperName = $('#helperName').val();
		let helperId = $('#helperId').val();
		let helperWidth = $('#helperWidth').val();
		var helperDefaultValue = $('#helperDefaultValue').val();
		let helperStep = $('#helperStep').val();
		let helperPlaceholder = $('#helperPlaceholder').val();
		let helperRequired = $('#helperRequired').prop('checked');
		let helperReadOnly = $('#helperReadOnly').prop('checked');
		let helperDisabled = $('#helperDisabled').prop('checked');

		let helperOptions = $('#helperOptions').val();
		
		let input_type = $('input[name=inlineRadioInputs]:checked', '#helperForm').val();

		if (input_type != "select") 
		{
			resultHelperValue = '<input type="'+input_type+'"';

			if (helperWidth)
				resultHelperValue += ' style="width: '+helperWidth+'px"';

			if (helperName)
				resultHelperValue += ' name="'+helperName+'"';

			if (helperId)
				resultHelperValue += ' id="'+helperId+'"';

			if (helperDefaultValue)
				resultHelperValue += ' value="'+helperDefaultValue+'"';

			if (input_type == "number" && helperStep)
				resultHelperValue += ' step="'+helperStep+'"';

			if (helperPlaceholder && (input_type != "date" || input_type != "time"))
				resultHelperValue += ' placeholder="'+helperPlaceholder+'"';

			if (helperRequired)
				resultHelperValue += ' required';

			if (helperDefaultValue) 
			{
				if (helperDisabled) 
					resultHelperValue += ' disabled';
				else if (helperReadOnly) 
					resultHelperValue += ' readonly';
			}
			
			resultHelperValue += '>';
		}
		else 
		{
			resultHelperValue = '<select';

			if (helperWidth)
				resultHelperValue += ' style="width: '+helperWidth+'px"';

			if (helperName)
				resultHelperValue += ' name="'+helperName+'"';

			if (helperId)
				resultHelperValue += ' id="'+helperId+'"';

			if (helperRequired)
				resultHelperValue += ' required';

			if (helperDefaultValue) 
			{
				if (helperDisabled) 
					resultHelperValue += ' disabled';
			}

			resultHelperValue += '>';

			let options = helperOptions.split(";");
			console.log(options);
			options.forEach(function(option) {
				let ex = option.split(",");
				let option_key = ex[0];
				let option_val = ex[1];

				resultHelperValue += ' <option value="'+option_val+'"';

				if (option_val === helperDefaultValue)
					resultHelperValue += ' selected';
				
				
				resultHelperValue += '>'+option_key+' </option>';
			});

			resultHelperValue += ' </select>';
		}
	
		$('#resultHelperName').val(helperId);
		$('#resultHelperValue').val(resultHelperValue);

		return false;
	}

	function submitHelperForm() 
	{
		$('#submitHelperButton').click();
	}

	function changeInputTypes() 
	{
		let input_type = $('input[name=inlineRadioInputs]:checked', '#helperForm').val();

		if (input_type != "select") 
		{
			$('#helperDefaultValue').attr('type', input_type);
		} else
		{
			$('#helperDefaultValue').attr('type', 'text');
		} 

		if (input_type != "number") 
		{
			$('#helperDefaultValue').attr('step', '0');
		}
	}

	function copyResultHelper() {
		let resultHelperValue = $('#resultHelperValue').val();
		navigator.clipboard.writeText(resultHelperValue);

		alert("{{ trans('forms.copied_to_clipboard') }}!");
	}
</script>
@append

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
    	<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-5" id="exampleModalLabel"> {{ trans('templates.variable_creator_helper') }} </h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>

			<div class="modal-body">
				<form action="#" id="helperForm" onsubmit="return generateVariableInput()">
				<h5> {{ trans('templates.select_input_type') }} </h5>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" name="inlineRadioInputs" id="numberRadioButton" value="number" checked>
					<label class="form-check-label" for="numberRadioButton"> {{ trans('templates.number') }} </label>
				</div>
				
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" name="inlineRadioInputs" id="textRadioButton" value="text">
					<label class="form-check-label" for="textRadioButton"> {{ trans('templates.text') }} </label>
				</div>

				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" name="inlineRadioInputs" id="dateRadioButton" value="date">
					<label class="form-check-label" for="dateRadioButton"> {{ trans('templates.date') }} </label>
				</div>

				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" name="inlineRadioInputs" id="timeRadioButton" value="time">
					<label class="form-check-label" for="timeRadioButton"> {{ trans('templates.time') }} </label>
				</div>
				
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" name="inlineRadioInputs" id="selectRadioButton" value="select">
					<label class="form-check-label" for="selectRadioButton"> {{ trans('templates.select') }} </label>
				</div>

				<h5 class="mt-3"> {{ trans('templates.identifier') }} </h5>
				<input type="text" class="form-control" id="helperId"  pattern="^[a-zA-Z0-9_]+$" required>

				<h5 class="mt-3"> {{ trans('templates.name') }} </h5>
				<input type="text" class="form-control" id="helperName" required disabled>

				<h5 class="mt-3"> {{ trans('templates.width_in_pixels') }} </h5>
				<input type="number" class="form-control" id="helperWidth">

				<h5 class="mt-3"> {{ trans('templates.default_value') }} </h5>
				<input type="number" class="form-control" id="helperDefaultValue" step="0.01">

				<div id="stepOption">
					<h5 class="mt-3"> {{ trans('templates.step') }} </h5>
					<input type="number" class="form-control" id="helperStep" step="0.01" min="0">
				</div>

				<div id="selectOptions">
					<h5 class="mt-3"> {{ trans('templates.options_to_select') }} </h5>
					<input type="text" class="form-control" id="helperOptions">
					<label class="mt-1"> {{ trans('templates.how_create_options') }} </label>
				</div>

				<div id="placeholderOption">
					<h5 class="mt-3"> {{ trans('templates.placeholder') }} </h5>
					<input type="text" class="form-control" id="helperPlaceholder">
				</div>

				<h5 class="mt-3"> {{ trans('templates.attributes') }} </h5>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="checkbox" id="helperRequired" value="required">
					<label class="form-check-label" for="inlineCheckbox1"> {{ trans('templates.required') }} </label>
				</div>

				<div class="form-check form-check-inline">
					<input class="form-check-input" type="checkbox" id="helperReadOnly" value="readonly">
					<label class="form-check-label" for="inlineCheckbox2"> {{ trans('templates.read_only') }} </label>
				</div>

				<div class="form-check form-check-inline">
					<input class="form-check-input" type="checkbox" id="helperDisabled" value="disabled">
					<label class="form-check-label" for="inlineCheckbox3"> {{ trans('templates.disabled') }} </label>
				</div>

				<h4 class="mt-4"> {{ trans('templates.helper_result') }} </h4>
				<input type="text" class="form-control" id="resultHelperName" placeholder="{{ trans('templates.your_variable_name') }}" pattern="^\$\{[a-zA-Z0-9_]+\}$" readonly>
				<textarea class="form-control mt-3" id="resultHelperValue" placeholder="{{ trans('templates.your_variable_value') }}" disabled></textarea>
				<a class="float-end" onclick="copyResultHelper()"> <i class="fa-solid fa-copy"></i> </a>

				<input type="submit" class="d-none" id="submitHelperButton">
				</form>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-primary" onclick="submitHelperForm()"> {{ trans('templates.generate_input') }} </button>
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> {{ trans('forms.close') }} </button>
			</div>
    	</div>
  	</div>
</div>