@extends('administrators.statistics.index')

@section('js')
@if (isset($sex_composition))
@php $sexs = array("F" => 'Femenino', "M" => 'Masculino') @endphp

<script type="module">
  GoogleCharts.load(drawChart);

  function drawChart() 
  {
    const data = GoogleCharts.api.visualization.arrayToDataTable([
      ['Sex', 'Total patients'],
      
      @foreach ($sex_composition as $sex)
      ['{{ $sexs[$sex->sex] }}', {{ $sex->total_patients }}], 	
      @endforeach
    ]);

    var options = {
        title: 'Composition of sex',
    };

    var chart = new GoogleCharts.api.visualization.PieChart(document.getElementById('piechart'));
    chart.draw(data, options);
  }
</script>
@endif
@endsection

@section('content')
<div class="mt-3"> 
    <h2> {{ trans('statistics.sex_composition') }} </h2> 
    <hr class="col-6">
    <p class="col-9"> {{ trans('statistics.sex_composition_message') }} </p>
</div>

<form action="{{ route('administrators/statistics/sex_composition/generate_chart') }}" method="post">
    @csrf

    <input type="submit" class="btn btn-primary mt-3" value="{{ trans('statistics.generate_chart') }}">
</form>

@if (isset($sex_composition))
<div class="mt-5" id="piechart" style="width: 800px; height: 500px;"></div>
@endif
@endsection

