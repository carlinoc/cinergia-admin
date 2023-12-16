<?php

namespace App\Http\Controllers;

use App\Models\FreeShort;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class FreeShortController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $movies = Movie::all();
        
        return view('freeshort.index', ['movies' => $movies]);
    }

    public function add(Request $request): JsonResponse
    {
        $request->validate([
            'movieId' => 'required'
        ]);

        $rows = FreeShort::all()->where('movieId', $request->movieId)->count();
        
        if($rows>0){
            return response()->json(['status'=>'error', 'message'=>'La película ya está agregada']);    
        }else{
            $freeshort = new FreeShort();
            $freeshort->movieId = $request->movieId; 
            $freeshort->save();
            return response()->json(['status'=>'success']);
        }
    }

    public function remove(Request $request): JsonResponse
    {
        FreeShort::find($request->freeShortId)->delete();
        
        return response()->json(['status'=>'success']);
    }

    public function list(Request $request): JsonResponse
    {
        if ($request->ajax()) {

            $freeshorts = FreeShort::select('freeshorts.id', 'movies.id as movieId', 'movies.name', 'movies.image1')
            ->join('movies', 'movies.id', '=', 'freeshorts.movieId')->get();
             
            return response()->json(['freeshorts' => $freeshorts]);
        } else {
            abort(403);
        }
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
    public function show(FreeShort $freeShort)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FreeShort $freeShort)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FreeShort $freeShort)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FreeShort $freeShort)
    {
        //
    }
}
