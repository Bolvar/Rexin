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
    .table tr th {
        border-top: 0;
    }

    table.dataTable {
        border-collapse: collapse !important;
    }
</style>
@stop

{{-- Page content --}}
@section('content')
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <h2>Analisis 2023</h2>
    <div class="table-responsive small">
        <div id="chartdiv"></div>
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col">Enero</th>
                    <th scope="col">Febrero</th>
                    <th scope="col">Marzo</th>
                    <th scope="col">Abril</th>
                    <th scope="col">Mayo</th>
                    <th scope="col">Junio</th>
                    <th scope="col">Julio</th>
                    <th scope="col">Agosto</th>
                    <th scope="col">Septiembre</th>
                    <th scope="col">Octubre</th>
                    <th scope="col">Noviembre</th>
                    <th scope="col">Diciembre</th>
                    <th scope="col">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $linea)
                <tr>
                    <td>{{$linea->nombre_sujeba}}</td>
                    <td>{{number_format($linea->enero,0,",",".")}}</td>
                    <td>{{number_format($linea->febrero,0,",",".")}}</td>
                    <td>{{number_format($linea->marzo,0,",",".")}}</td>
                    <td>{{number_format($linea->abril,0,",",".")}}</td>
                    <td>{{number_format($linea->mayo,0,",",".")}}</td>
                    <td>{{number_format($linea->junio,0,",",".")}}</td>
                    <td>{{number_format($linea->julio,0,",",".")}}</td>
                    <td>{{number_format($linea->agosto,0,",",".")}}</td>
                    <td>{{number_format($linea->septiembre,0,",",".")}}</td>
                    <td>{{number_format($linea->octubre,0,",",".")}}</td>
                    <td>{{number_format($linea->noviembre,0,",",".")}}</td>
                    <td>{{number_format($linea->diciembre,0,",",".")}}</td>
                    <td>{{number_format($linea->total,0,",",".")}}</td>

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
            url: "{{ url('/api/pastThree') }}",
            dataType: "json"
        })
            .done((data) => {
                addChart("chartdiv", data);
            })



            })


            function addChart(div, datos){

// Create root element
// https://www.amcharts.com/docs/v5/getting-started/#Root_element
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
  panY: true,
  wheelX: "panX",
  wheelY: "zoomX",
  pinchZoomX: true,
  paddingLeft:0,
  paddingRight:1
}));

// Add cursor
// https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {}));
cursor.lineY.set("visible", false);


// Create axes
// https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
var xRenderer = am5xy.AxisRendererX.new(root, {
  minGridDistance: 30,
  minorGridEnabled: true
});

xRenderer.labels.template.setAll({
  rotation: -35,
  centerY: am5.p50,
  centerX: am5.p100,
  paddingRight: 15
});

xRenderer.grid.template.setAll({
  location: 1
})

var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
  maxDeviation: 0.3,
  categoryField: "empresa",
  renderer: xRenderer,
  tooltip: am5.Tooltip.new(root, {})
}));

var yRenderer = am5xy.AxisRendererY.new(root, {
  strokeOpacity: 0.1
})

var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
  maxDeviation: 0.3,
  renderer: yRenderer
}));

// Create series
// https://www.amcharts.com/docs/v5/charts/xy-chart/series/
var series = chart.series.push(am5xy.ColumnSeries.new(root, {
  name: "Series 1",
  xAxis: xAxis,
  yAxis: yAxis,
  valueYField: "total",
  sequencedInterpolation: true,
  categoryXField: "empresa",
  tooltip: am5.Tooltip.new(root, {
    labelText: "{valueY}"
  })
}));

series.columns.template.setAll({ cornerRadiusTL: 5, cornerRadiusTR: 5, strokeOpacity: 0 });
series.columns.template.adapters.add("fill", function (fill, target) {
  return chart.get("colors").getIndex(series.columns.indexOf(target));
});

series.columns.template.adapters.add("stroke", function (stroke, target) {
  return chart.get("colors").getIndex(series.columns.indexOf(target));
});


// Set data
var data = datos;

xAxis.data.setAll(data);
series.data.setAll(data);

// Make stuff animate on load
// https://www.amcharts.com/docs/v5/concepts/animations/
series.appear(1000);
chart.appear(1000, 100);
             }
</script>

@stop
