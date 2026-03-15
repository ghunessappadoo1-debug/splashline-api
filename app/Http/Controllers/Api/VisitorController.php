<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Visitor;
use Illuminate\Http\Request;

class VisitorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Visitor::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email',
                'phone' => 'nullable|string'
            ]);

            $visitor = Visitor::create($validated);

            return response()->json($visitor, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json(Visitor::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
            $visitor = Visitor::findOrFail($id);

            $visitor->update($request->all());

            return response()->json($visitor);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
            $visitor = Visitor::findOrFail($id);

            $visitor->delete();

            return response()->json([
                'message' => 'Visitor deleted successfully'
            ]);
    }
}
