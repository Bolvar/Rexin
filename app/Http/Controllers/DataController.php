<?php

namespace App\Http\Controllers;

use App\Models\data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('welcome');
    }

    public function analisis(){
        $results = DB::table('data as d1')
        ->select(
            'd1.nombre_sujeba',
            DB::raw('SUM(CASE WHEN MONTH(fecha) = 1 THEN d1.totpes ELSE 0 END) as enero'),
            DB::raw('SUM(CASE WHEN MONTH(fecha) = 2 THEN d1.totpes ELSE 0 END) as febrero'),
            DB::raw('SUM(CASE WHEN MONTH(fecha) = 3 THEN d1.totpes ELSE 0 END) as marzo'),
            DB::raw('SUM(CASE WHEN MONTH(fecha) = 4 THEN d1.totpes ELSE 0 END) as abril'),
            DB::raw('SUM(CASE WHEN MONTH(fecha) = 5 THEN d1.totpes ELSE 0 END) as mayo'),
            DB::raw('SUM(CASE WHEN MONTH(fecha) = 6 THEN d1.totpes ELSE 0 END) as junio'),
            DB::raw('SUM(CASE WHEN MONTH(fecha) = 7 THEN d1.totpes ELSE 0 END) as julio'),
            DB::raw('SUM(CASE WHEN MONTH(fecha) = 8 THEN d1.totpes ELSE 0 END) as agosto'),
            DB::raw('SUM(CASE WHEN MONTH(fecha) = 9 THEN d1.totpes ELSE 0 END) as septiembre'),
            DB::raw('SUM(CASE WHEN MONTH(fecha) = 10 THEN d1.totpes ELSE 0 END) as octubre'),
            DB::raw('SUM(CASE WHEN MONTH(fecha) = 11 THEN d1.totpes ELSE 0 END) as noviembre'),
            DB::raw('SUM(CASE WHEN MONTH(fecha) = 12 THEN d1.totpes ELSE 0 END) as diciembre'),
            DB::raw('SUM(d1.totpes) as total')
        )
        ->where('d1.anopro', '=', 2023)
        ->groupBy('d1.sujeba')
        ->orderBy('total', 'desc')
        ->get();
        return view('analisis', ['data' => $results]);

    }
    public function comparacion(){
        $datos = DB::table('data')
        ->select(
            'nombre_sujeba',
            'sujeba',
            DB::raw("SUM(CASE WHEN YEAR(fecha) = 2022 THEN totpes ELSE 0 END) as 'data1'"),
            DB::raw("SUM(CASE WHEN YEAR(fecha) = 2023 THEN totpes ELSE 0 END) as 'data2'")
        )
        ->whereYear('fecha', '>=', 2022)
        ->groupBy('nombre_sujeba', 'sujeba')
        ->orderBy('nombre_sujeba')
        ->orderBy('sujeba')
        ->get();

        return view('comparacion', ['data' => $datos]);

    }
    public function getComparacion(){
        $datos = DB::table('data')
        ->select(
            'nombre_sujeba',
            DB::raw("SUM(CASE WHEN YEAR(fecha) = 2022 THEN totpes ELSE 0 END) as 'data1'"),
            DB::raw("SUM(CASE WHEN YEAR(fecha) = 2023 THEN totpes ELSE 0 END) as 'data2'")
        )
        ->whereYear('fecha', '>=', 2022)
        ->groupBy('nombre_sujeba')
        ->orderBy('nombre_sujeba')
        ->get();

        foreach ($datos as $key => $value) {
            $value->data1 = intval($value->data1);
            $value->data2 = intval($value->data2);
        }
        $media = $datos->avg('data2');
        $empresasSuperiores = $datos->filter(function ($item) use ($media) {
            return $item->data2 > $media;
        });
        return response()->json($empresasSuperiores->values());

    }
    public function getKM()
    {
        $resultados = DB::table('data')
        ->select(
            DB::raw('YEAR(fecha) as Año'),
            DB::raw('MONTH(fecha) as Mes'),
            DB::raw('TIMESTAMP(CONCAT(YEAR(NOW()),"-", MONTH(fecha),"-01")) AS date'),
            DB::raw('TIMESTAMP(CONCAT(YEAR(fecha),"-", MONTH(fecha),"-01")) AS original'),
            DB::raw('SUM(totpes) as value')
        )
        ->where('umd', '=', 'KM')
        ->groupBy(DB::raw('YEAR(fecha)'), DB::raw('MONTH(fecha)'))
        ->orderBy('Año', 'asc')
        ->get();

        return response()->json($resultados->groupBy('Año'));
    }
    public function getMC()
    {
        $resultados = DB::table('data')
        ->select(
            DB::raw('YEAR(fecha) as Año'),
            DB::raw('MONTH(fecha) as Mes'),
            DB::raw('TIMESTAMP(CONCAT(YEAR(NOW()),"-", MONTH(fecha),"-01")) AS date'),
            DB::raw('TIMESTAMP(CONCAT(YEAR(fecha),"-", MONTH(fecha),"-01")) AS original'),
            DB::raw('SUM(totpes) as value')
        )
        ->where('umd', '=', 'M3')
        ->groupBy(DB::raw('YEAR(fecha)'), DB::raw('MONTH(fecha)'))
        ->orderBy('Año', 'asc')
        ->get();
        return response()->json($resultados->groupBy('Año'));
    }
    public function getPastThree()
    {
        $anioEspecifico = 2023; // Reemplazar con el año deseado

        $resultados = DB::table('data')
            ->select(
                'nombre_sujeba as empresa',
                DB::raw('SUM(totpes) as total')
            )
            ->whereYear('fecha', $anioEspecifico)
            ->groupBy('nombre_sujeba')
            ->get();

        // Calcular la media
        foreach ($resultados as $key => $value) {
            $value->total = intval($value->total);
        }
        $media = $resultados->avg('total');

        // Filtrar por empresas con total superior a la media
        $empresasSuperiores = $resultados->filter(function ($item) use ($media) {
            return $item->total > $media;
        });

        return response()->json($empresasSuperiores->values());
    }
}
