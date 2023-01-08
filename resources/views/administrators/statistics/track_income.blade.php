@extends('administrators.statistics.index')

@section('js')
@if (isset($data))
<script type="module">
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
        title: '{{ trans("statistics.track_income") }}',
        subtitle: '{{ trans("statistics.subtitle_collection_from_month_to_month", ['initial_date' => $initial_date, 'ended_date' => $ended_date ]) }}',
      }
    };

    var chart = new GoogleCharts.api.visualization.ColumnChart(document.getElementById('columnchart_material'));
    chart.draw(data, options);
  }
</script>
@endif
@endsection

@section('content')
<form action="{{ route('administrators/statistics/get_track_income') }}" method="post">
  @csrf

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

  <input type="submit" class="btn btn-primary mt-3" value="{{ trans('statistics.generate_summary') }}">
</form>

@if (isset($data))
<div class="mt-3" id="columnchart_material" style="width: 800px; height: 500px;"></div>
@endif
@endsection

