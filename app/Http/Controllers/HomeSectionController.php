<?php

namespace App\Http\Controllers;

use App\Models\HomeSection;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use App\Models\Movie;
use App\Models\WebSite;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File; 

class HomeSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $sections= Section::all();
        $websites= WebSite::all();

        return view('homesection.index', ['sections' => $sections, 'websites' => $websites]);
    }

    public function list(Request $request): JsonResponse
    {
        if ($request->ajax()) {

            $hsections = HomeSection::select('home_section.id', 'home_section.title', 'websites.title as web', 'sections.name as sectionName', DB::raw('count(home_section_movie.home_section_id) as movies'))
            ->Join('websites','websites.id','=','home_section.websiteId')
            ->Join('sections','sections.id','=','home_section.sectionId')
            ->leftJoin('home_section_movie','home_section_movie.home_section_id','=','home_section.id')
            ->groupBy('home_section.id', 'home_section.title', 'websites.title', 'sections.name')
            ->get();

            return response()->json(['hsections' => $hsections]);
        } else {
            abort(403, 'You do not have permission to view this page ');
        }
    }

    public function add(Request $request): JsonResponse
    {
        $request->validate([
            'websiteId' => 'required',
            'sectionId' => 'required'
        ]);

        try {
            $rows = HomeSection::where('sectionId', $request->sectionId)->where('websiteId', $request->websiteId)->count();
            if($rows > 0) {
                return response()->json(['status'=>'error', 'message'=>'Ya existe una sección para esa web']);    
            }else{
                $hsection = new HomeSection();
                $hsection->websiteId = $request->websiteId;
                $hsection->sectionId = $request->sectionId;
                $hsection->title = $request->title;
                $hsection->save();

                return response()->json(['status' => 'success']);    
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to save the Section.'], 500);
        }
    }

    public function edit(Request $request): JsonResponse 
    {
        
        $path = 'files/sections/';
        
        $homesection = HomeSection::where('id', $request->hsectionId)->first();
        $background = $homesection->background;

        
        if(!is_null($background) && $request->hasFile('background')){
            File::delete($background);
        }else{
            if(is_null($request->title)){
                $background = null;
            }
        }

        if($request->hasFile('background')){
            $filename = time() .'-'. $request->hsectionId . '.jpg';
            $success = $request->file('background')->move($path, $filename);
            if($success) {
                $background = $path . $filename;   
            }
        }

        $affected = HomeSection::where('id', $request->hsectionId)
            ->update(['websiteId' => $request->websiteId, 'sectionId' => $request->sectionId, 'title' => $request->title, 'background' => $background]);

        return response()->json(['status'=>'success', 'message'=>'La sección fue actualizada', 'background'=> $background]);
    }

    public function remove(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'id' => 'required',
            ]);

            $homesection = HomeSection::where('id', $request->id)->first();
            $background = $homesection->background;
            
            if(!is_null($background)){
                File::delete($background);
            }

            HomeSection::findOrFail($request->id)->delete();

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function detail(Request $request): View
    {
        $sections= Section::all();
        $websites= WebSite::all();

        $movies = Movie::all();

        $hsection = HomeSection::select('home_section.id', 'home_section.websiteId', 'home_section.sectionId', 'home_section.title', 'home_section.background', 'sections.name as sectionName', 'sections.maxMovies')
            ->join('sections', 'sections.id', '=', 'home_section.sectionId')
            ->where('home_section.id', $request->id)->first();

        return view('homesection.detail', ['sections' => $sections, 'websites' => $websites, 'hsection' => $hsection, 'movies' => $movies]);
    }

    public function movielist(Request $request): JsonResponse
    {
        if ($request->ajax()) {

            $movies = Movie::select('movies.id', 'movies.name', 'movies.slug')
                ->join('home_section_movie', 'home_section_movie.movie_id', '=', 'movies.id')
                ->where('home_section_movie.home_section_id', $request->hsectionId)
                ->get();
             
            return response()->json(['movies' => $movies]);
        } else {
            abort(403, 'You do not have permission to view this page ');
        }
    }

    public function addMovie(Request $request): JsonResponse
    {
        $request->validate([
            'movieId' => 'required'
        ]);

        $movie = [$request->movieId];

        $maxMovies = HomeSection::select('sections.maxMovies')
        ->join('sections', 'sections.id', '=', 'home_section.sectionId')
        ->where('home_section.id', $request->hsectionId)->first();

        $currentMovies = DB::table('home_section_movie')->where('home_section_id', $request->hsectionId)->count();

        if($currentMovies >= $maxMovies->maxMovies){
            return response()->json(['status'=>'error', 'message'=>'No se puede agregar mas películas']);    
        }

        $rows = DB::table('home_section_movie')->where('home_section_id', $request->hsectionId)->where('movie_id', $request->movieId)->count();
        if($rows>0){
            return response()->json(['status'=>'error', 'message'=>'La película ya está agregada']);    
        }else{
            $homesection = HomeSection::where('id', $request->hsectionId)->first();
            $homesection->movies()->attach($movie);

            return response()->json(['status'=>'success']);
        }
    }

    public function removemovie(Request $request): JsonResponse
    {
        DB::table('home_section_movie')->where('home_section_id', $request->hsectionId)->where('movie_id', $request->movieId)->delete();
        return response()->json(['status'=>'success']);
    }
}
