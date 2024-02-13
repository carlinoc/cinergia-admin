<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use App\Models\Movie;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('clients.index');
    }

    public function list(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            //$clients= Client::all();

            $clients = Client::select('clients.id', 'clients.name', 'clients.email', 'clients.active', DB::raw('count(client_movie.client_id) as movies'))
            ->leftJoin('client_movie','client_movie.client_id','=','clients.id')
            ->groupBy('clients.id', 'clients.name', 'clients.email', 'clients.active')
            ->get();

            return response()->json(['clients' => $clients]);
        } else {
            abort(403, 'You do not have permission to view this page ');
        }
    }

    public function add(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255'
        ]);

        try {
            $active = 0;
            if($request->active) $active = 1;

            $section = new Client();
            $section->name = $request->name;
            $section->email = $request->email;
            $section->active = $active;
            $section->save();

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to save the Client.'], 500);
        }
    }

    public function remove(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'clientId' => 'required',
            ]);

            Client::findOrFail($request->clientId)->delete();

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function detail(Request $request): View
    {
        $movies = Movie::all();

        $client = Client::where('id', $request->clientId)->first();

        return view('clients.detail', ['movies' => $movies, 'client' => $client]);
    }

    public function edit(Request $request) 
    {
        $active = 0;
        if($request->active) $active = 1;

        Client::where('id', $request->clientId)->update(['active' => $active]);

        return response()->json(['status'=>'success', 'message'=>'El cliente fue actualizado']);
    }

    public function addMovie(Request $request): JsonResponse
    {
        $request->validate([
            'movieId' => 'required'
        ]);
        $movie = [$request->movieId];
        $transactionId = time();
        $date_start = Carbon::now();
        $date_end = Carbon::now()->addHours(72);

        $rows = DB::table('client_movie')->where('client_id', $request->clientId)->where('movie_id', $request->movieId)->count();
        if($rows>0){
            return response()->json(['status'=>'error', 'message'=>'La película ya está agregada']);    
        }else{
            $client = Client::where('id', $request->clientId)->first();
            $client->movies()->attach($movie, ['transactionId' => $transactionId, 'date_start' => $date_start, 'date_end' => $date_end]);

            return response()->json(['status'=>'success']);
        }
    }

    public function movielist(Request $request): JsonResponse
    {
        if ($request->ajax()) {

            $movies = Movie::select('movies.id', 'movies.name', 'movies.slug', 'movies.payment_type', 'client_movie.transactionId', 'client_movie.amount', 'client_movie.date_start', 'client_movie.date_end')
                ->join('client_movie', 'client_movie.movie_id', '=', 'movies.id')
                ->where('client_movie.client_id', $request->clientId)
                ->get();
             
            return response()->json(['movies' => $movies]);
        } else {
            abort(403);
        }
    }

    public function removemovie(Request $request): JsonResponse
    {
        DB::table('client_movie')->where('client_id', $request->clientId)->where('movie_id', $request->movieId)->delete();
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
    public function show(client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, client $client)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(client $client)
    {
        //
    }
}
