<?php

namespace App\Http\Controllers\API;

use App\Models\Exhibit;
use App\Http\Controllers\Controller;
use App\Http\Resources\ExhibitResource;
use App\Http\Resources\AnimalResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExhibitController extends Controller
{
    public function index()
    {
        $exhibits = Exhibit::with('animals')->paginate(15);
        return ExhibitResource::collection($exhibits);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'capacity' => 'nullable|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $exhibit = Exhibit::create($request->all());
        return new ExhibitResource($exhibit->load('animals'));
    }

    public function show(Exhibit $exhibit)
    {
        return new ExhibitResource($exhibit->load(['animals', 'feedingSchedules']));
    }

    public function update(Request $request, Exhibit $exhibit)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'capacity' => 'nullable|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $exhibit->update($request->all());
        return new ExhibitResource($exhibit->load('animals'));
    }

    public function destroy(Exhibit $exhibit)
    {
        $exhibit->delete();
        return response()->json(['message' => 'Exhibit deleted successfully'], 200);
    }

    // Custom: Get all animals in this exhibit
    public function animals(Exhibit $exhibit)
    {
        $animals = $exhibit->animals()->paginate(15);
        return AnimalResource::collection($animals);
    }

    // Custom: Featured exhibit (random)
    public function featured()
    {
        $exhibit = Exhibit::with('animals')->inRandomOrder()->first();
        if (!$exhibit) {
            return response()->json(['error' => 'No exhibits found'], 404);
        }
        return new ExhibitResource($exhibit);
    }
}