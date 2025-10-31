<?php

namespace App\Http\Controllers;

use App\Models\MovieRented;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class MovieRentedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('movierented.index');
    }

    public function list(Request $request): JsonResponse
    {
        if ($request->ajax()) {

            $rented= MovieRented::all();

            return response()->json(['rented' => $rented]);
        } else {
            abort(403, 'You do not have permission to view this page ');
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
    public function show(MovieRented $movieRented)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MovieRented $movieRented)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MovieRented $movieRented)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MovieRented $movieRented)
    {
        //
    }
}
