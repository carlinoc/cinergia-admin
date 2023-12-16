<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File; 
use App\Models\Movie;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('package.index');
    }

    public function add(Request $request): JsonResponse
    {
        $request->validate([
            'slogan' => 'required'
        ]);

        $slug = Str::slug($request->slogan);
        $path = 'files/packages/';

        $package = new Package();
        
        if($request->hasFile('background')){
            $filename = $slug . '.jpg';
            $success = $request->file('background')->move($path, $filename);
            if($success){
                $package->background = $path . $filename;    
            }
        }

        $package->slogan = $request->slogan;
        $package->slug = $slug;
        $package->description = $request->description;

        $package->save();

        return response()->json(['status'=>'success']);
    }

    public function edit(Request $request) 
    {
        $slug = Str::slug($request->slogan);
        $path = 'files/packages/';
        $state = 0;

        if($request->state){
            Package::query()->update(['state' => 0]);    
            $state = 1;
        }

        $package = Package::where('id', $request->packageId)->first();
        $background = $package->background;
        $deleteImage = false;

        if(!is_null($background) && $request->hasFile('background')){
            $deleteImage = File::delete($background);
        }

        if($request->hasFile('background')){
            $filename = time() .'-'. $slug . '.jpg';
            $success = $request->file('background')->move($path, $filename);
            if($success) {
                $background = $path . $filename;   
            }
        }

        $affected = Package::where('id', $request->packageId)
            ->update(['slogan' => $request->slogan, 'slug' => $slug, 'description' => $request->description, 'background' => $background, 'state' => $state]);

        return response()->json(['status'=>'success', 'message'=>'El paquete fue actualizado', 'background'=> $background]);
    }

    public function addMovie(Request $request): JsonResponse
    {
        $request->validate([
            'movieId' => 'required'
        ]);
        $movie = [$request->movieId];

        $rows = DB::table('movie_package')->where('package_id', $request->packageId)->where('movie_id', $request->movieId)->count();
        if($rows>0){
            return response()->json(['status'=>'error', 'message'=>'La película ya está agregada']);    
        }else{
            $package = Package::where('id', $request->packageId)->first();
            $package->movies()->attach($movie);

        return response()->json(['status'=>'success']);
        }
    }

    public function list(Request $request): JsonResponse
    {
        if ($request->ajax()) {

            $packages = Package::select('packages.id', 'packages.slogan', 'packages.state', 'packages.slug', DB::raw('count(movie_package.package_id) as movies'))
                ->leftJoin('movie_package', 'movie_package.package_id', '=', 'packages.id')
                ->groupBy('packages.id', 'packages.slogan', 'packages.state', 'packages.slug')
                ->get();
             
            return response()->json(['packages' => $packages]);
        } else {
            abort(403);
        }
    }

    public function movielist(Request $request): JsonResponse
    {
        if ($request->ajax()) {

            $movies = Movie::select('movies.id', 'movies.name', 'movies.slug')
                ->join('movie_package', 'movie_package.movie_id', '=', 'movies.id')
                ->where('movie_package.package_id', $request->packageId)
                ->get();
             
            return response()->json(['movies' => $movies]);
        } else {
            abort(403);
        }
    }

    public function remove(Request $request): JsonResponse
    {
        $package = Package::where('id', $request->packageId)->first();
        if($package->count() > 0){
            if(!is_null($package->background)){
                File::delete(public_path($package->background));
            }

            Package::find($package->id)->delete();      

            return response()->json(['status'=>'success']);
        }else{
            return response()->json(['status'=>'error']);
        }
    }

    public function detail(Request $request): View
    {
        $movies = Movie::all();

        $package = Package::where('id', $request->packageId)->first();

        return view('package.detail', ['movies' => $movies, 'package' => $package]);
    }

    public function removemovie(Request $request): JsonResponse
    {
        DB::table('movie_package')->where('package_id', $request->packageId)->where('movie_id', $request->movieId)->delete();
        return response()->json(['status'=>'success']);
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
    public function show(Package $package)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Package $package)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Package $package)
    {
        //
    }
}
