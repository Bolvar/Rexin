@extends('layout')

{{-- Page title --}}
@section('title')
Administracion Usuarios
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
<!--page level css -->
<!--end of page level css-->
<style>
  .table tr th
        {
            border-top:0;
        }
        table.dataTable
        {
            border-collapse: collapse !important;
        }

    </style>
@stop

{{-- Page content --}}
@section('content')
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <h2>Comparacion 2022-2023</h2>
    <div class="table-responsive small">
        <div id="chartdiv"></div>
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th scope="col">RUT</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">2022</th>
                    <th scope="col">2023</th>
                    <th scope="col">Diferencia</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $linea)
                <tr>
                    <td>{{$linea->sujeba}}</td>
                    <td>{{$linea->nombre_sujeba}}</td>
                    <td>{{number_format($linea->data1,0,",",".")}}</td>
                    <td>{{number_format($linea->data2,0,",",".")}}</td>
                    <td>{{number_format((intval($linea->data2)-intval($linea->data1)),0,",",".")}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</main>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
    <script>

$(document).ready(function () {
        $.ajax({
            async: false,
            method: "GET",
            url: "{{ url('/api/comparacion') }}",
            dataType: "json"
        })
            .done((data) => {
                addChart("chartdiv", data);
            })



            })


            function addChart(div, datos){


var root = am5.Root.new(div);

// Set themes
// https://www.amcharts.com/docs/v5/concepts/themes/
root.setThemes([
  am5themes_Animated.new(root)
]);

// Create chart
// https://www.amcharts.com/docs/v5/charts/xy-chart/
var chart = root.container.children.push(am5xy.XYChart.new(root, {
  panX: true,
  panY: false,
  wheelX: "panX",
  wheelY: "zoomX",
  paddingLeft: 0,
  layout: root.verticalLayout
}));

var data = datos;
/*
[{
  "country": "USA",
  "year2004": 3.5,
  "year2005": 4.2
}];*/

// Create axes
// https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
var xRenderer = am5xy.AxisRendererX.new(root, {
  minGridDistance: 70,
  minorGridEnabled: true
});

var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
  categoryField: "nombre_sujeba",
  renderer: xRenderer,
  tooltip: am5.Tooltip.new(root, {
    themeTags: ["axis"],
    animationDuration: 200
  })
}));

xRenderer.grid.template.setAll({
  location: 1
})
xRenderer.labels.template.setAll({
  rotation: -35,
  centerY: am5.p50,
  centerX: am5.p100,
  paddingRight: 15
});

xAxis.data.setAll(data);

var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
  min: 0,
  renderer: am5xy.AxisRendererY.new(root, {
    strokeOpacity: 0.1
  })
}));

// Add series
// https://www.amcharts.com/docs/v5/charts/xy-chart/series/

var series0 = chart.series.push(am5xy.ColumnSeries.new(root, {
  name: "2022",
  xAxis: xAxis,
  yAxis: yAxis,
  valueYField: "data1",
  categoryXField: "nombre_sujeba",
  clustered: false,
  tooltip: am5.Tooltip.new(root, {
    labelText: "2022: {valueY}"
  })
}));

series0.columns.template.setAll({
  width: am5.percent(80),
  tooltipY: 0,
  strokeOpacity: 0
});


series0.data.setAll(data);


var series1 = chart.series.push(am5xy.ColumnSeries.new(root, {
  name: "2023",
  xAxis: xAxis,
  yAxis: yAxis,
  valueYField: "data2",
  categoryXField: "nombre_sujeba",
  clustered: false,
  tooltip: am5.Tooltip.new(root, {
    labelText: "2023: {valueY}"
  })
}));

series1.columns.template.setAll({
  width: am5.percent(50),
  tooltipY: 0,
  strokeOpacity: 0
});

series1.data.setAll(data);

var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {}));


// Make stuff animate on load
// https://www.amcharts.com/docs/v5/concepts/animations/
chart.appear(1000, 100);
series0.appear();
series1.appear();

            }
</script>

@stop
