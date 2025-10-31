<?php

namespace App\Http\Controllers;

use App\Models\Featured;
use App\Models\Movie;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FeaturedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $movies = Movie::all();
        
        return view('featured.index', ['movies' => $movies]);
    }

    public function add(Request $request): JsonResponse
    {
        $request->validate([
            'movieId' => 'required'
        ]);

        $rows = Featured::all()->where('movieId', $request->movieId)->count();
        
        if($rows>0){
            return response()->json(['status'=>'error', 'message'=>'La película ya está agregada']);    
        }else{
            $featured = new Featured();
            $featured->movieId = $request->movieId; 
            $featured->save();
            return response()->json(['status'=>'success']);
        }
    }

    public function remove(Request $request): JsonResponse
    {
        Featured::find($request->featuredId)->delete();
        
        return response()->json(['status'=>'success']);
    }

    public function list(Request $request): JsonResponse
    {
        if ($request->ajax()) {

            $featureds = Featured::select('featureds.id', 'movies.id as movieId', 'movies.name', 'movies.image1')
            ->join('movies', 'movies.id', '=', 'featureds.movieId')->get();
             
            return response()->json(['featureds' => $featureds]);
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
    public function show(Featured $featured)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Featured $featured)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Featured $featured)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Featured $featured)
    {
        //
    }
}
