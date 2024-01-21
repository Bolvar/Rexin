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
    public function getKM()
    {
        $resultados = DB::table('data')
        ->select(DB::raw('TIMESTAMP(CONCAT(YEAR(fecha),"-", MONTH(fecha),"-01")) AS date, UNIX_TIMESTAMP(TIMESTAMP(CONCAT(YEAR(fecha),"-", MONTH(fecha),"-01"))) as time, SUM(NUMERO) AS value'))
            ->where('umd', '=', "KM")
            ->groupBy(DB::raw('MONTH(fecha)'))
            ->get();
        return response()->json($resultados);
    }
    public function getMC()
    {
        $resultados = DB::table('data')
        ->select(DB::raw('TIMESTAMP(CONCAT(YEAR(fecha),"-", MONTH(fecha),"-01")) AS date, UNIX_TIMESTAMP(TIMESTAMP(CONCAT(YEAR(fecha),"-", MONTH(fecha),"-01"))) as time, SUM(NUMERO) AS value'))
        ->where('umd', '=', "M3")
            ->groupBy(DB::raw('MONTH(fecha)'))
            ->get();
        return response()->json($resultados);
    }
}
