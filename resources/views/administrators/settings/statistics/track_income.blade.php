@extends('administrators/settings/statistics/index')

@section('js')
@parent

 <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">

      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
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

        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>
@endsection

@section('graphs')
	<div class="mt-3" id="columnchart_material" style="width: 800px; height: 500px;"></div>
@endsection

