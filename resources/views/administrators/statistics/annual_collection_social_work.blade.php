@extends('administrators.statistics.index')

@section('js')
<script type="module">
	$(document).ready(function() 
  {
    	$("#socialWork").val('{{ $social_work ?? '' }}') ;	    
	});

  @if (isset($data))
  GoogleCharts.load(drawChart);

  function drawChart() 
  {
    const data = GoogleCharts.api.visualization.arrayToDataTable([
      ['Months', 'Collection'],

      @foreach ($data as $month)
      ['{{ $month['value'] }}', {{ $month['total'] }}], 	
      @endforeach
    ]);

    var options = {
      chart: {
        title: '{{ trans("statistics.annual_collection_social_work") }}',
        subtitle: '{{ trans("statistics.subtitle_collection_from_month_to_month", ['initial_date' => $initial_date, 'ended_date' => $ended_date ]) }}',
      }
    };

    var chart = new GoogleCharts.api.visualization.ColumnChart(document.getElementById('columnchart_material'));
    chart.draw(data, options);
  }
@endif
</script>
@endsection

@section('content')
<form action="{{ route('administrators/statistics/get_annual_collection_social_work') }}" method="post">
  @csrf

  <div class="col-md-6">
    <div class="form-group mt-2">
      <label for="socialWork"> {{ trans('social_works.social_work') }} </label>
      <select class="form-select" name="social_work" id="socialWork" aria-describedby="socialWorkHelp" required>
        <option value=""> {{ trans('forms.select_option') }}</option>

        @foreach ($social_works as $social_work)
        <option value="{{ $social_work->id }}"> {{ $social_work->name }} </option>
        @endforeach
		  </select>

      <small id="socialWorkHelp" class="form-text text-muted"> The social work to which the amount collected will be counted </small>
    </div>
  </div>

  <div class="col-md-6">
    <div class="form-group mt-2">
      <label for="initialDate"> {{ trans('statistics.initial_date') }} </label>
      <input type="date" class="form-control @error('initial_date') is-invalid @enderror" name="initial_date" id="initialDate" value="{{ $initial_date ?? date('Y-m-d') }}" aria-describedby="initialDateHelp" required>

      <small id="initialDateHelp" class="form-text text-muted"> The date on which the collection begins to be counted </small>
    </div>
  </div>

  <div class="col-md-6">
    <div class="form-group mt-2">
      <label for="endedDate"> {{ trans('statistics.ended_date') }} </label>
      <input type="date" class="form-control @error('ended_date') is-invalid @enderror" name="ended_date" id="endedDate" value="{{ $ended_date ?? date('Y-m-d') }}" aria-describedby="endedDateHelp" required>

      <small id="endedDateHelp" class="form-text text-muted"> The date on which the collection ends </small>
    </div>
  </div>

  <input type="submit" class="btn btn-primary mt-3" value="{{ trans('statistics.generate_graph') }}">
</form>

@if (isset($data))
<div class="mt-3" id="columnchart_material" style="width: 800px; height: 500px;"></div>
@endif
@endsection