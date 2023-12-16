<?php

namespace App\Http\Controllers;

use App\Models\AgeRate;
use App\Models\Caption;
use App\Models\Category;
use App\Models\Director;
use App\Models\Featured;
use App\Models\FreeShort;
use App\Models\Genre;
use App\Models\Language;
use App\Models\Movie;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $movies = Movie::select('movies.id', 'movies.name', 'movies.image1', 'categories.name as category')
            ->join('categories','categories.id','=','movies.categoryId')
            ->get();

        $heads = [
            'ID',
            'Movie',
            'Categoria',
            'Image',
            'Opciones'
        ];
        return view('movies.index', ['heads' => $heads, 'movies' => $movies]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $categories = Category::all();
        $languages = Language::all();
        $agerates = AgeRate::all();
        $genres = Genre::all();
        $directors = Director::all();
        
        return view('movies.create', ['categories' => $categories, 'languages' => $languages, 'agerates' => $agerates, 'genres' => $genres, 'directors' => $directors]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $slug = Str::slug($request->name);
        $path = 'files/movies/'.$slug.'/';

        $captions = array();
        $genres = $request->genres;

        $movie = new Movie();

        $fileCaptionES = '';
        $successFileES = false;
        if($request->hasFile('captionES')){
            $fileCaptionES = time() .'-'. $slug . '_es.srt';
            $successFileES = $request->file('captionES')->move($path, $fileCaptionES);
            if($successFileES){
                array_push($captions, 1);        
            }
        }

        $fileCaptionEN = '';
        $successFileEN = false;
        if($request->hasFile('captionEN')){
            $fileCaptionEN = time() .'-'. $slug . '_en.srt';
            $successFileEN = $request->file('captionEN')->move($path, $fileCaptionEN);
            if($successFileEN){
                array_push($captions, 2);        
            }
        }

        if($request->hasFile('image1')){
            $filename3 = time() .'-'. $slug . '_1.jpg';
            $success3 = $request->file('image1')->move($path, $filename3);
            if($success3){
                $movie->image1 = $path . $filename3;    
            }
        }

        if($request->hasFile('image2')){
            $filename4 = time() .'-'. $slug . '_2.jpg';
            $success4 = $request->file('image2')->move($path, $filename4);
            if($success4){
                $movie->image2 = $path . $filename4;    
            }
        }

        if($request->hasFile('image3')){
            $filename5 = time() .'-'. $slug . '_3.jpg';
            $success5 = $request->file('image3')->move($path, $filename5);
            if($success5){
                $movie->image3 = $path . $filename5;    
            }
        }

        $releaseYear = Carbon::parse($request->releaseYear);
        $movie->categoryId = $request->categoryId;
        $movie->languageId = $request->languageId;
        $movie->directorId = $request->directorId;
        $movie->ageRateId = $request->ageRateId;
        $movie->name = $request->name;
        $movie->slug = $slug;
        $movie->description = $request->description;
        $movie->whySee = $request->whySee;
        $movie->movieLength = $request->movieLength;
        $movie->price = $request->price;
        $movie->trailer = $request->trailer;
        $movie->urlId = $request->urlId;
        $movie->releaseYear = $releaseYear;

        $movie->save();

        $movie->genres()->attach($genres);

        $movie->captions()->attach($captions);

        if($successFileES){
            $affected = DB::table('caption_movie')->where('caption_id', 1)->where('movie_id', $movie->id)
                ->update(['file' => $path . $fileCaptionES]);
        }
        if($successFileEN){
            $affected = DB::table('caption_movie')->where('caption_id', 2)->where('movie_id', $movie->id)
                ->update(['file' => $path . $fileCaptionEN]);
        }

        return redirect()->route('movies.index')->with('success', 'Nueva película creada');
    }

    /**
     * Display the specified resource.
     */
    public function show(Movie $movie)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Movie $movie): View
    {
        $categories = Category::all();
        $languages = Language::all();
        $agerates = AgeRate::all();
        $genres = Genre::all();
        $directors = Director::all();

        $mGenres = Genre::select('genre_movie.genre_id', 'genres.name')
            ->join('genre_movie','genre_movie.genre_id','=','genres.id')
            ->where('genre_movie.movie_id', $movie->id)
            ->get();

        $captions = Caption::select('captions.id', 'caption_movie.file')
            ->join('caption_movie', 'caption_movie.caption_id', '=', 'captions.id')
            ->where('caption_movie.movie_id', $movie->id)
            ->orderBy('caption_movie.movie_id')
            ->get();
        
        return view('movies.edit', ['movie'=>$movie, 'categories' => $categories, 'languages' => $languages, 'agerates' => $agerates, 'genres' => $genres, 'directors' => $directors, 'mgenres' => $mGenres, 'captions' => $captions]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Movie $movie)
    {
        //dd($request);
        $movieId = $movie->id;
        $slug = Str::slug($request->name);
        $path = 'files/movies/'.$slug.'/';

        $captions = array();
        $genres = $request->genres;

        $releaseYear = Carbon::parse($request->releaseYear);

        $movie = Movie::find($movieId);      
        
        if($request->hasFile('image1')){
            if(!is_null($movie->image1)){
                $deleteImage = File::delete($movie->image1);
            }
            $filename1 = time() .'-'. $slug . '_1.jpg';
            $success1 = $request->file('image1')->move($path, $filename1);
            if($success1){
                $movie->image1 = $path . $filename1;    
            }
        }

        if($request->hasFile('image2')){
            if(!is_null($movie->image2)){
                $deleteImage = File::delete($movie->image2);
            }
            $filename2 = time() .'-'. $slug . '_2.jpg';
            $success2 = $request->file('image2')->move($path, $filename2);
            if($success2){
                $movie->image2 = $path . $filename2;    
            }
        }

        if($request->hasFile('image3')){
            if(!is_null($movie->image3)){
                $deleteImage = File::delete($movie->image3);
            }
            $filename3 = time() .'-'. $slug . '_3.jpg';
            $success3 = $request->file('image3')->move($path, $filename3);
            if($success3){
                $movie->image3 = $path . $filename3;    
            }
        }

        $fileCaptionES = '';
        $captionES = null;
        if($request->hasFile('captionES')){
            $fileCaptionES = time() .'-'. $slug . '_es.srt';
            $success = $request->file('captionES')->move($path, $fileCaptionES);

            $captionES = DB::table('caption_movie')->where('caption_id', 1)->where('movie_id', $movieId)->first();
            if(!is_null($captionES)){
                $deleteFile = File::delete($captionES->file);
            }
        }

        $fileCaptionEN = '';
        $captionEN = null;
        if($request->hasFile('captionEN')){
            $fileCaptionEN = time() .'-'. $slug . '_en.srt';
            $success = $request->file('captionEN')->move($path, $fileCaptionEN);
            
            $captionEN = DB::table('caption_movie')->where('caption_id', 2)->where('movie_id', $movieId)->first();
            if(!is_null($captionEN)){
                $deleteFile = File::delete($captionEN->file);
            }
        }
        
        $movie->categoryId = $request->categoryId;
        $movie->languageId = $request->languageId;
        $movie->directorId = $request->directorId;
        $movie->ageRateId = $request->ageRateId;
        $movie->name = $request->name;
        $movie->slug = $slug;
        $movie->description = $request->description;
        $movie->whySee = $request->whySee;
        $movie->movieLength = $request->movieLength;
        $movie->price = $request->price;
        $movie->trailer = $request->trailer;
        $movie->urlId = $request->urlId;
        $movie->releaseYear = $releaseYear;

        $movie->update();

        $movie->genres()->sync($genres);

        if(is_null($captionES) && $request->hasFile('captionES')){
            $data = array('caption_id'=>1, 'movie_id'=>$movieId, 'file'=>$path . $fileCaptionES);
            $affected = DB::table('caption_movie')->insert($data);
        }elseif($request->hasFile('captionES')){
            $affected = DB::table('caption_movie')->where('caption_id', 1)->where('movie_id', $movieId)
                ->update(['file' => $path . $fileCaptionES]);
        }

        if(is_null($captionEN) && $request->hasFile('captionEN')){
            $data = array('caption_id'=>2, 'movie_id'=>$movieId, 'file'=>$path . $fileCaptionEN);
            $affected = DB::table('caption_movie')->insert($data);
        }elseif($request->hasFile('captionEN')){
            $affected = DB::table('caption_movie')->where('caption_id', 2)->where('movie_id', $movieId)
                ->update(['file' => $path . $fileCaptionEN]);
        }

        return redirect()->route('movies.index')->with('success', 'Película actualizada');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movie $movie)
    {
        FreeShort::where('movieId', $movie->id)->delete();
        Featured::where('movieId', $movie->id)->delete();
        
        $path = 'files/movies/'.$movie->slug;
        
        try {
            $this->deleteDir($path);
        } catch (Exception $e) {
        }
        
        $movie->delete();
        
        return redirect()->route('movies.index')->with('success', 'Pelicula eliminada');
    }

    public static function getGenreSelected($genreId, $mgenres){
        foreach ($mgenres as $genre) {
            if($genre->genre_id == $genreId) {
               return "selected";
            }
        }
        return "";
    }

    public static function getImage($image){
        if(is_null($image)){
            return "images/movie-default.jpg";
        }
        return $image;
    }

    public static function getCaption($captions, $value){
        if(count($captions) > 0){
            if(isset($captions[$value])){
                return $captions[$value]->file;
            }else{
                return "#";        
            }
        }
        return "#";
    }

    public static function deleteDir($dirPath) {
        if (! is_dir($dirPath)) {
            throw new InvalidArgumentException("$dirPath must be a directory");
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::deleteDir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirPath);
    }
}
