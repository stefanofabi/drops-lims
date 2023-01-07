@extends('administrators/settings/statistics/index')

@section('js')
@parent

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
@endsection

@section('graphs')
	<div class="mt-3" id="columnchart_material" style="width: 800px; height: 500px;"></div>
@endsection

