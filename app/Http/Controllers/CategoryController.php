<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $categories = Category::all();

        $heads = [
            'ID',
            'Categoria',
            'Slug',
            'Opciones'
        ];
        return view('categories.index', ['categories' => $categories, 'heads' => $heads]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('categories.create');
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

        Category::create($request->all());
        return redirect()->route('categories.index')->with('success', 'Nueva categoría creada');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category): View
    {
        return view('categories.edit', ['category'=>$category]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category): RedirectResponse
    {
        $request->validate([
            'name' => 'required'
        ]);

        $slug = Str::slug($request->name);
        $request->merge(['slug' => $slug]);
        
        $category->update($request->all());
        return redirect()->route('categories.index')->with('success', 'Categoría actualizada');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Categoría eliminada');
    }
}
