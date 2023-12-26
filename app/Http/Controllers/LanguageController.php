<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class LanguageController extends Controller
{
    public function index(): View
    {
        return view('languages.index');
    }

    public function list(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            $languages = Language::all();
            return response()->json(['languages' => $languages]);
        } else {
            abort(403, 'You do not have permission to view this page ');
        }
    }

    public function add(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        try {
            $language = new Language();
            $language->name = $request->name;
            $language->save();

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to save the Language.'], 500);
        }
    }

    public function edit(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        try {
            $affected = Language::where('id', $request->languageId)
                ->update(['name' => $request->name]);

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to edit the Language.'], 500);
        }
    }

    public function remove(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'languageId' => 'required',
            ]);

            Language::findOrFail($request->languageId)->delete();

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
    public function show(Language $language)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Language $language)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Language $language)
    {
        //
    }
}
