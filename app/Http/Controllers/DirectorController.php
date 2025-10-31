<?php

namespace App\Http\Controllers;

use App\Models\Director;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Country;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;

class DirectorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $directors = Director::select('directors.id', 'directors.firstName', 'directors.lastName', 'countries.name as country')
            ->join('countries','countries.id','=','directors.countryId')
            ->get();

        $heads = [
            'ID',
            'Nombre',
            'Apellido',
            'Pais',
            'Opciones'
        ];
        return view('directors.index', ['directors' => $directors, 'heads' => $heads]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $countries = Country::all();
        return view('directors.create', ['countries' => $countries]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'firstName' => 'required',
            'lastName' => 'required',
            'countryId' => 'required'
        ]);

        Director::create($request->all());
        return redirect()->route('directors.index')->with('success', 'Nuevo director creado');
    }

    /**
     * Display the specified resource.
     */
    public function show(Director $director)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Director $director): View
    {
        $countries = Country::all();
        return view('directors.edit', ['director'=>$director, 'countries' => $countries]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Director $director): RedirectResponse
    {
        $director->update($request->all());
        return redirect()->route('directors.index')->with('success', 'Director actualizado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Director $director): RedirectResponse
    {
        $director->delete();
        //todo verify if has movies
        return redirect()->route('directors.index')->with('success', 'Director eliminado');
    }

    public function add(Request $request): JsonResponse
    {
        $request->validate([
            'dname' => 'required',
            'dlastname' => 'required',
            'dcountryId' => 'required'
        ]);

        try {
            if(Director::where('firstName', $request->dname)->where('lastName', $request->dlastname)->exists()){
                return response()->json(['status' => 'alert', 'message' => 'Ya existe un Director con ese nombre']);
            }

            $director = new Director();
            $director->firstName = $request->dname;
            $director->lastName = $request->dlastname;
            $director->countryId = $request->dcountryId;
            $director->save();

            $listDirectors = Director::orderBy('firstName', 'asc')->get();

            return response()->json([
                'status'=>'success',
                'message'=>'Director agregado',
                'director'=>$director,
                'listDirectors'=>$listDirectors
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Error al agregar Director'. $e->getMessage()]);
        }
    }
}
