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
    <h2>Analisis 2023</h2>
    <div class="table-responsive small">
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
    <script>

</script>

@stop
