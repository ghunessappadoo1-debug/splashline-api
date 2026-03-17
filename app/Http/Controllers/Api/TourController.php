<?php

namespace App\Http\Controllers\API;

use App\Models\Tour;
use App\Http\Controllers\Controller;
use App\Http\Resources\TourResource;
use App\Http\Resources\TourRegistrationResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TourController extends Controller
{
    public function index()
    {
        $tours = Tour::with('registrations.visitor')->paginate(15);
        return TourResource::collection($tours);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'max_participants' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $tour = Tour::create($request->all());
        return new TourResource($tour);
    }

    public function show(Tour $tour)
    {
        return new TourResource($tour->load('registrations.visitor'));
    }

    public function update(Request $request, Tour $tour)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'sometimes|required|date',
            'end_time' => 'sometimes|required|date|after:start_time',
            'max_participants' => 'sometimes|required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $tour->update($request->all());
        return new TourResource($tour);
    }

    public function destroy(Tour $tour)
    {
        $tour->delete();
        return response()->json(['message' => 'Tour deleted'], 200);
    }

    // Custom: Register a visitor for a tour
    public function register(Request $request, Tour $tour)
    {
        $validator = Validator::make($request->all(), [
            'visitor_id' => 'required|exists:visitors,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Check if already registered
        $exists = $tour->registrations()->where('visitor_id', $request->visitor_id)->exists();
        if ($exists) {
            return response()->json(['error' => 'Visitor already registered for this tour'], 400);
        }

        // Check capacity
        if ($tour->registrations()->count() >= $tour->max_participants) {
            return response()->json(['error' => 'Tour is full'], 400);
        }

        $registration = $tour->registrations()->create([
            'visitor_id' => $request->visitor_id,
        ]);

        return new TourRegistrationResource($registration->load('visitor'));
    }

    // Custom: List upcoming tours
    public function upcoming()
    {
        $tours = Tour::where('start_time', '>', now())
                     ->with('registrations')
                     ->orderBy('start_time')
                     ->paginate(15);
        return TourResource::collection($tours);
    }
}