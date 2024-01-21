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
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
        <div class="btn-toolbar mb-2 mb-md-0">

        </div>
    </div>
    <h4>Traslado Mts.3</h4>
    <div class="table-responsive small">
        <div id="chartdiv"></div>
    </div>
    <h4>Kilometros Recorridos</h4>
    <div class="table-responsive small">
        <div id="chartdiv2"></div>
    </div>
</main>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
<script src="bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.2/dist/chart.umd.js"
    integrity="sha384-eI7PSr3L1XLISH8JdDII5YN/njoSsxfbrkCTnJrzXt+ENP5MOVBxD+l6sEG4zoLp" crossorigin="anonymous">
    </script>
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
<script>
    $(document).ready(function () {
        $.ajax({
            async: false,
            method: "GET",
            url: "{{ url('/api/m3') }}",
            dataType: "json"
        })
            .done((data) => {

                var datos = [];
                $.each(data, function (index, value) {
                    fecha = new Date(value.date);
                    am5.time.add(fecha, "month", 1);

                    datos.push({
                        date: fecha.getTime(),
                        value: parseInt(value.value)
                    });
                });
                addChart("chartdiv", datos);
            })
        $.ajax({
            async: false,
            method: "GET",
            url: "{{ url('/api/km') }}",
            dataType: "json"
        })
            .done((data) => {

                var datos = [];
                $.each(data, function (index, value) {
                    fecha = new Date(value.date);
                    am5.time.add(fecha, "month", 1);

                    datos.push({
                        date: fecha.getTime(),
                        value: parseInt(value.value)
                    });
                });
                addChart("chartdiv2", datos);
            })
    })



    function addChart(divID, data) {
        var root = am5.Root.new(divID);

        const myTheme = am5.Theme.new(root);

        myTheme.rule("AxisLabel", ["minor"]).setAll({
            dy: 1
        });

        myTheme.rule("Grid", ["x"]).setAll({
            strokeOpacity: 0.05
        });

        myTheme.rule("Grid", ["x", "minor"]).setAll({
            strokeOpacity: 0.05
        });

        root.setThemes([
            am5themes_Animated.new(root),
            myTheme
        ]);

        var chart = root.container.children.push(am5xy.XYChart.new(root, {
            panX: true,
            panY: true,
            wheelX: "panX",
            wheelY: "zoomX",
            maxTooltipDistance: 0,
            pinchZoomX: true
        }));

        var xAxis = chart.xAxes.push(am5xy.DateAxis.new(root, {
            maxDeviation: 0.2,
            baseInterval: {
                timeUnit: "month",
                count: 1
            },
            renderer: am5xy.AxisRendererX.new(root, {
                minorGridEnabled: true
            }),
            tooltip: am5.Tooltip.new(root, {})
        }));

        var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
            renderer: am5xy.AxisRendererY.new(root, {})
        }));

        var series = chart.series.push(am5xy.LineSeries.new(root, {
            name: "2023",
            xAxis: xAxis,
            yAxis: yAxis,
            valueYField: "value",
            valueXField: "date",
            legendValueText: "{valueY}",
            tooltip: am5.Tooltip.new(root, {
                pointerOrientation: "horizontal",
                labelText: "{valueY}"
            })
        }));

        series.data.setAll(data);

        series.appear();

        var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {
            behavior: "none"
        }));
        cursor.lineY.set("visible", false);

        var legend = chart.rightAxesContainer.children.push(am5.Legend.new(root, {
            width: 200,
            paddingLeft: 15,
            height: am5.percent(100)
        }));

        legend.itemContainers.template.events.on("pointerover", function (e) {
            var itemContainer = e.target;

            var series = itemContainer.dataItem.dataContext;

            chart.series.each(function (chartSeries) {
                if (chartSeries != series) {
                    chartSeries.strokes.template.setAll({
                        strokeOpacity: 0.15,
                        stroke: am5.color(0x000000)
                    });
                } else {
                    chartSeries.strokes.template.setAll({
                        strokeWidth: 3
                    });
                }
            })
        })

        legend.itemContainers.template.events.on("pointerout", function (e) {
            var itemContainer = e.target;
            var series = itemContainer.dataItem.dataContext;

            chart.series.each(function (chartSeries) {
                chartSeries.strokes.template.setAll({
                    strokeOpacity: 1,
                    strokeWidth: 1,
                    stroke: chartSeries.get("fill")
                });
            });
        })

        legend.itemContainers.template.set("width", am5.p100);
        legend.valueLabels.template.setAll({
            width: am5.p100,
            textAlign: "right"
        });

        legend.data.setAll(chart.series.values);

        chart.appear(1000, 100);
    }
</script>
@stop
