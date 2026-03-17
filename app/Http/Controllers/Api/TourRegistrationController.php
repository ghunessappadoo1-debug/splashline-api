<?php

namespace App\Http\Controllers\API;

use App\Models\TourRegistration;
use App\Http\Controllers\Controller;
use App\Http\Resources\TourRegistrationResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TourRegistrationController extends Controller
{
    public function index(Request $request)
    {
        $query = TourRegistration::with(['tour', 'visitor']);

        if ($request->has('tour_id')) {
            $query->where('tour_id', $request->tour_id);
        }

        $registrations = $query->paginate(15);
        return TourRegistrationResource::collection($registrations);
    }

    public function store(Request $request)
    {
        // Usually registration is handled via TourController::register, but we keep for completeness
        $validator = Validator::make($request->all(), [
            'tour_id' => 'required|exists:tours,id',
            'visitor_id' => 'required|exists:visitors,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Check capacity
        $tour = Tour::find($request->tour_id);
        if ($tour->registrations()->count() >= $tour->max_participants) {
            return response()->json(['error' => 'Tour is full'], 400);
        }

        $registration = TourRegistration::create($request->all());
        return new TourRegistrationResource($registration->load(['tour', 'visitor']));
    }

    public function show(TourRegistration $tourRegistration)
    {
        return new TourRegistrationResource($tourRegistration->load(['tour', 'visitor']));
    }

    public function destroy(TourRegistration $tourRegistration)
    {
        $tourRegistration->delete();
        return response()->json(['message' => 'Registration cancelled'], 200);
    }
}