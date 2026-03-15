<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Animal;
use Illuminate\Http\Request;

class AnimalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         return response()->json(Animal::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'species' => 'required|string|max:255',
                'age' => 'required|integer',
                'exhibit_id' => 'required|exists:exhibits,id'
            ]);

            $animal = Animal::create($validated);

            return response()->json($animal, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
            $animal = Animal::findOrFail($id);

            return response()->json($animal);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
            $animal = Animal::findOrFail($id);

            $animal->update($request->all());

            return response()->json($animal);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
            $animal = Animal::findOrFail($id);

            $animal->delete();

            return response()->json([
                'message' => 'Animal deleted successfully'
            ]);
    }
}
