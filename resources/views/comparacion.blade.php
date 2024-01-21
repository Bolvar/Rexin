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
    <script>

</script>

@stop
