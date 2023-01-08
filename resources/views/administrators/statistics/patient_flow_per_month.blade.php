@extends('administrators.statistics.index')

@section('js')
@if (isset($data))
<script type="module">
  GoogleCharts.load(drawChart);

  function drawChart() 
  {
    const data = GoogleCharts.api.visualization.arrayToDataTable([
      [
        '{{ trans("statistics.months") }}', '{{ trans("patients.patient") }}'],

        @foreach ($data as $month)
        ['{{ $month['value'] }}', {{ $month['total'] }}],
        @endforeach
    ]);

    var options = {
      title: '{{ trans("statistics.patient_flow") }}',
      hAxis: {title: '{{ trans("statistics.months") }}',  titleTextStyle: {color: '#333'}},
      vAxis: {minValue: 0}
    };

    var chart = new GoogleCharts.api.visualization.AreaChart(document.getElementById('chart_div'));
    chart.draw(data, options);
  }
</script>
@endif
@endsection

@section('content')
<form action="{{ route('administrators/statistics/get_patient_flow_per_month') }}" method="post">
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
<div class="mt-3" id="chart_div" style="width: 800px; height: 500px;"></div>
@endif
@endsection

