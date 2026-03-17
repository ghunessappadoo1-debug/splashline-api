<?php

namespace App\Http\Controllers\API;

use App\Models\FeedingSchedule;
use App\Http\Controllers\Controller;
use App\Http\Resources\FeedingScheduleResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FeedingScheduleController extends Controller
{
    public function index(Request $request)
    {
        $query = FeedingSchedule::with(['exhibit', 'animal']);

        if ($request->has('exhibit_id')) {
            $query->where('exhibit_id', $request->exhibit_id);
        }
        if ($request->has('animal_id')) {
            $query->where('animal_id', $request->animal_id);
        }

        $schedules = $query->paginate(15);
        return FeedingScheduleResource::collection($schedules);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'exhibit_id' => 'nullable|exists:exhibits,id',
            'animal_id' => 'nullable|exists:animals,id',
            'feeding_time' => 'required|date_format:H:i',
            'food_type' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Ensure at least one is provided, but not both
        if (!$request->exhibit_id && !$request->animal_id) {
            return response()->json(['error' => 'Either exhibit_id or animal_id must be provided.'], 422);
        }
        if ($request->exhibit_id && $request->animal_id) {
            return response()->json(['error' => 'Provide either exhibit_id or animal_id, not both.'], 422);
        }

        $schedule = FeedingSchedule::create($request->all());
        return new FeedingScheduleResource($schedule->load(['exhibit', 'animal']));
    }

    public function show(FeedingSchedule $feedingSchedule)
    {
        return new FeedingScheduleResource($feedingSchedule->load(['exhibit', 'animal']));
    }

    public function update(Request $request, FeedingSchedule $feedingSchedule)
    {
        $validator = Validator::make($request->all(), [
            'exhibit_id' => 'nullable|exists:exhibits,id',
            'animal_id' => 'nullable|exists:animals,id',
            'feeding_time' => 'sometimes|required|date_format:H:i',
            'food_type' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if ($request->has('exhibit_id') && $request->has('animal_id') && $request->exhibit_id && $request->animal_id) {
            return response()->json(['error' => 'Provide either exhibit_id or animal_id, not both.'], 422);
        }

        $feedingSchedule->update($request->all());
        return new FeedingScheduleResource($feedingSchedule->load(['exhibit', 'animal']));
    }

    public function destroy(FeedingSchedule $feedingSchedule)
    {
        $feedingSchedule->delete();
        return response()->json(['message' => 'Feeding schedule deleted'], 200);
    }

    // Custom: Get upcoming feeding schedules (today and future)
    public function upcoming()
    {
        $now = now()->format('H:i:s');
        $schedules = FeedingSchedule::whereTime('feeding_time', '>=', $now)
            ->orderBy('feeding_time')
            ->paginate(15);
        return FeedingScheduleResource::collection($schedules);
    }
}