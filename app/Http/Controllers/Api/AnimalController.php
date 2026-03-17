<?php

namespace App\Http\Controllers\API;

use App\Models\Animal;
use App\Http\Controllers\Controller;
use App\Http\Resources\AnimalResource;
use App\Http\Resources\FeedingScheduleResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AnimalController extends Controller
{
    public function index(Request $request)
    {
        $query = Animal::with('exhibit');

        if ($request->has('species')) {
            $query->where('species', 'like', '%' . $request->species . '%');
        }
        if ($request->has('exhibit_id')) {
            $query->where('exhibit_id', $request->exhibit_id);
        }

        $animals = $query->paginate(15);
        return AnimalResource::collection($animals);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'species' => 'required|string|max:255',
            'age' => 'nullable|integer|min:0',
            'fun_fact' => 'nullable|string',
            'exhibit_id' => 'required|exists:exhibits,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $animal = Animal::create($request->all());
        return new AnimalResource($animal->load('exhibit'));
    }

    public function show(Animal $animal)
    {
        return new AnimalResource($animal->load(['exhibit', 'feedingSchedules']));
    }

    public function update(Request $request, Animal $animal)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'species' => 'sometimes|required|string|max:255',
            'age' => 'nullable|integer|min:0',
            'fun_fact' => 'nullable|string',
            'exhibit_id' => 'sometimes|required|exists:exhibits,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $animal->update($request->all());
        return new AnimalResource($animal->load('exhibit'));
    }

    public function destroy(Animal $animal)
    {
        $animal->delete();
        return response()->json(['message' => 'Animal deleted successfully'], 200);
    }

    // Custom: Get feeding schedule for this animal
    public function feedingSchedule(Animal $animal)
    {
        $schedules = $animal->feedingSchedules()->paginate(15);
        return FeedingScheduleResource::collection($schedules);
    }
}