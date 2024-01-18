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

        $report = DB::table('data')
            ->selectRaw('nombre_sujeba,sujeba,SUM(totpes) as total')
            ->groupBy('sujeba')
            ->get();

            $mc = DB::table('data as d1')
            ->select(
                'd1.nombre_sujeba',
                DB::raw('SUM(CASE WHEN d1.mespro = 1 THEN d1.numero ELSE 0 END) as enero'),
                DB::raw('SUM(CASE WHEN d1.mespro = 2 THEN d1.numero ELSE 0 END) as febrero'),
                DB::raw('SUM(CASE WHEN d1.mespro = 3 THEN d1.numero ELSE 0 END) as marzo'),
                DB::raw('SUM(CASE WHEN d1.mespro = 4 THEN d1.numero ELSE 0 END) as abril'),
                DB::raw('SUM(CASE WHEN d1.mespro = 5 THEN d1.numero ELSE 0 END) as mayo'),
                DB::raw('SUM(CASE WHEN d1.mespro = 6 THEN d1.numero ELSE 0 END) as junio'),
                DB::raw('SUM(CASE WHEN d1.mespro = 7 THEN d1.numero ELSE 0 END) as julio'),
                DB::raw('SUM(CASE WHEN d1.mespro = 8 THEN d1.numero ELSE 0 END) as agosto'),
                DB::raw('SUM(CASE WHEN d1.mespro = 9 THEN d1.numero ELSE 0 END) as septiembre'),
                DB::raw('SUM(CASE WHEN d1.mespro = 10 THEN d1.numero ELSE 0 END) as octubre'),
                DB::raw('SUM(CASE WHEN d1.mespro = 11 THEN d1.numero ELSE 0 END) as noviembre'),
                DB::raw('SUM(CASE WHEN d1.mespro = 12 THEN d1.numero ELSE 0 END) as diciembre'),
                DB::raw('SUM(d1.numero) as total')
            )
            ->where('d1.umd', '=', "M3")
            ->where('d1.anopro', '=', 2023)
            ->groupBy('d1.sujeba')
            ->orderBy('total', 'desc')
            ->get();


            $km = DB::table('data as d1')
            ->select(
                'd1.nombre_sujeba',
                DB::raw('SUM(CASE WHEN d1.mespro = 1 THEN d1.numero ELSE 0 END) as enero'),
                DB::raw('SUM(CASE WHEN d1.mespro = 2 THEN d1.numero ELSE 0 END) as febrero'),
                DB::raw('SUM(CASE WHEN d1.mespro = 3 THEN d1.numero ELSE 0 END) as marzo'),
                DB::raw('SUM(CASE WHEN d1.mespro = 4 THEN d1.numero ELSE 0 END) as abril'),
                DB::raw('SUM(CASE WHEN d1.mespro = 5 THEN d1.numero ELSE 0 END) as mayo'),
                DB::raw('SUM(CASE WHEN d1.mespro = 6 THEN d1.numero ELSE 0 END) as junio'),
                DB::raw('SUM(CASE WHEN d1.mespro = 7 THEN d1.numero ELSE 0 END) as julio'),
                DB::raw('SUM(CASE WHEN d1.mespro = 8 THEN d1.numero ELSE 0 END) as agosto'),
                DB::raw('SUM(CASE WHEN d1.mespro = 9 THEN d1.numero ELSE 0 END) as septiembre'),
                DB::raw('SUM(CASE WHEN d1.mespro = 10 THEN d1.numero ELSE 0 END) as octubre'),
                DB::raw('SUM(CASE WHEN d1.mespro = 11 THEN d1.numero ELSE 0 END) as noviembre'),
                DB::raw('SUM(CASE WHEN d1.mespro = 12 THEN d1.numero ELSE 0 END) as diciembre'),
                DB::raw('SUM(d1.numero) as total')
            )
            ->where('d1.umd', '=', "KM")
            ->where('d1.anopro', '=', 2023)
            ->groupBy('d1.sujeba')
            ->orderBy('total', 'desc')
            ->get();

        $results = DB::table('data as d1')
            ->select(
                'd1.nombre_sujeba',
                DB::raw('SUM(CASE WHEN d1.mespro = 1 THEN d1.totpes ELSE 0 END) as enero'),
                DB::raw('SUM(CASE WHEN d1.mespro = 2 THEN d1.totpes ELSE 0 END) as febrero'),
                DB::raw('SUM(CASE WHEN d1.mespro = 3 THEN d1.totpes ELSE 0 END) as marzo'),
                DB::raw('SUM(CASE WHEN d1.mespro = 4 THEN d1.totpes ELSE 0 END) as abril'),
                DB::raw('SUM(CASE WHEN d1.mespro = 5 THEN d1.totpes ELSE 0 END) as mayo'),
                DB::raw('SUM(CASE WHEN d1.mespro = 6 THEN d1.totpes ELSE 0 END) as junio'),
                DB::raw('SUM(CASE WHEN d1.mespro = 7 THEN d1.totpes ELSE 0 END) as julio'),
                DB::raw('SUM(CASE WHEN d1.mespro = 8 THEN d1.totpes ELSE 0 END) as agosto'),
                DB::raw('SUM(CASE WHEN d1.mespro = 9 THEN d1.totpes ELSE 0 END) as septiembre'),
                DB::raw('SUM(CASE WHEN d1.mespro = 10 THEN d1.totpes ELSE 0 END) as octubre'),
                DB::raw('SUM(CASE WHEN d1.mespro = 11 THEN d1.totpes ELSE 0 END) as noviembre'),
                DB::raw('SUM(CASE WHEN d1.mespro = 12 THEN d1.totpes ELSE 0 END) as diciembre'),
                DB::raw('SUM(d1.totpes) as total')
            )
            ->where('d1.anopro', '=', 2023)
            ->groupBy('d1.sujeba')
            ->orderBy('total', 'desc')

            ->get();

        return view('welcome', ['data' => $km]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
