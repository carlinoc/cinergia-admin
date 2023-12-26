<?php

namespace App\Http\Controllers;

use App\Models\AgeRate;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class AgeRateController extends Controller
{
    public function index(): View
    {
        return view('agerates.index');
    }

    public function list(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            $agerates = AgeRate::all();
            return response()->json(['agerates' => $agerates]);
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
            $ageRate = new AgeRate();
            $ageRate->name = $request->name;
            $ageRate->save();

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to save AgeRate.'], 500);
        }
    }

    public function edit(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        try {
            $affected = AgeRate::where('id', $request->ageRateId)
                ->update(['name' => $request->name]);

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to edit the AgeRate.'], 500);
        }
    }

    public function remove(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'ageRateId' => 'required',
            ]);

            AgeRate::findOrFail($request->ageRateId)->delete();

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
    public function show(AgeRate $ageRate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AgeRate $ageRate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AgeRate $ageRate)
    {
        //
    }
}
