<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Str;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $genres = Genre::all();

        $heads = [
            'ID',
            'Género',
            'Slug',
            'Opciones'
        ];
        return view('genres.index', ['genres' => $genres, 'heads' => $heads]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('genres.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required'
        ]);

        $slug = Str::slug($request->name);
        $request->merge(['slug' => $slug]);

        Genre::create($request->all());
        return redirect()->route('genres.index')->with('success', 'Nuevo género creado');
    }

    /**
     * Display the specified resource.
     */
    public function show(Genre $genre)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Genre $genre): View
    {
        return view('genres.edit', ['genre'=>$genre]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Genre $genre): RedirectResponse
    {
        $request->validate([
            'name' => 'required'
        ]);

        $slug = Str::slug($request->name);
        $request->merge(['slug' => $slug]);

        $genre->update($request->all());
        return redirect()->route('genres.index')->with('success', 'Género Actualizado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Genre $genre): RedirectResponse
    {
        $genre->delete();
        return redirect()->route('genres.index')->with('success', 'Género eliminado');
    }
}
