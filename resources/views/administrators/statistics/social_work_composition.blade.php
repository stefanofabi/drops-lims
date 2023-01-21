@extends('administrators.statistics.index')

@section('js')
@if (isset($social_work_composition))
<script type="module">
  GoogleCharts.load(drawChart);

  function drawChart() 
  {
    const data = GoogleCharts.api.visualization.arrayToDataTable([
      ['Social work', 'Total orders'],
      
      @foreach ($social_work_composition as $social_work)
      ['{{ $social_work->name }}', {{ $social_work->total_orders }}], 	
      @endforeach
    ]);

    var options = {
        title: 'Composition of social works',
    };

    var chart = new GoogleCharts.api.visualization.PieChart(document.getElementById('piechart'));
    chart.draw(data, options);
  }
</script>
@endif
@endsection

@section('content')
<div class="mt-3"> 
    <h2> {{ trans('statistics.social_work_composition') }} </h2> 
    <hr class="col-6">
    <p class="col-9"> {{ trans('statistics.social_work_composition_message') }} </p>
</div>

<form action="{{ route('administrators/statistics/social_work_composition/generate_chart') }}" method="post">
    @csrf

    <input type="submit" class="btn btn-primary mt-3" value="{{ trans('statistics.generate_chart') }}">
</form>

@if (isset($social_work_composition))
<div class="mt-5" id="piechart" style="width: 800px; height: 500px;"></div>
@endif
@endsection

