@extends('administrators.statistics.index')

@section('js')
@parent
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
@endsection

@section('graphs')
  <div class="mt-3" id="chart_div" style="height: 500px;"></div>
@endsection

