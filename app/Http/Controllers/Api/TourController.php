<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use Illuminate\Http\Request;

class TourController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Tour::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'schedule_time' => 'required|date',
                'max_capacity' => 'required|integer'
            ]);

            $tour = Tour::create($validated);

            return response()->json($tour, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
            $tour = Tour::findOrFail($id);

            return response()->json($tour);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
            $tour = Tour::findOrFail($id);

            $tour->update($request->all());

            return response()->json($tour);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
            $tour = Tour::findOrFail($id);

            $tour->delete();

            return response()->json([
                'message' => 'Tour deleted successfully'
            ]);
    }
}
