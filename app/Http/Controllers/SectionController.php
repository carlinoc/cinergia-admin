<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('sections.index');
    }

    public function list(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            $sections= Section::all();
            return response()->json(['sections' => $sections]);
        } else {
            abort(403, 'You do not have permission to view this page ');
        }
    }

    public function add(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255'
        ]);

        try {
            $section = new Section();
            $section->name = $request->name;
            $section->slug = $request->slug;
            $section->maxMovies = $request->maxMovies;
            $section->save();

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to save the Language.'], 500);
        }
    }

    public function edit(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255'
        ]);

        try {
            $affected = Section::where('id', $request->sectionId)
                ->update(['name' => $request->name, 'slug' => $request->slug, 'maxMovies' => $request->maxMovies]);

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to edit the Language.'], 500);
        }
    }

    public function remove(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'sectionId' => 'required',
            ]);

            Section::findOrFail($request->sectionId)->delete();

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
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
    public function show(Section $section)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Section $section)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Section $section)
    {
        //
    }
}
