<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Exhibit;
use Illuminate\Http\Request;

class ExhibitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
            $exhibits = Exhibit::all();

            return response()->json($exhibits);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

         $exhibit = Exhibit::create($validated);

         return response()->json($exhibit, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
            $exhibit = Exhibit::findOrFail($id);

            return response()->json($exhibit);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
            $exhibit = Exhibit::findOrFail($id);

            $validated = $request->validate([
                'name' => 'sometimes|string|max:255',
                'type' => 'sometimes|string|max:255',
                'description' => 'nullable|string'
            ]);

            $exhibit->update($validated);

            return response()->json($exhibit);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
            $exhibit = Exhibit::findOrFail($id);

            $exhibit->delete();

            return response()->json([
                'message' => 'Exhibit deleted successfully'
            ]);
    }
}
