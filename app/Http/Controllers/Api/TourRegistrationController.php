<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TourRegistration;
use Illuminate\Http\Request;

class TourRegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(
            TourRegistration::with(['visitor','tour'])->get()
        );

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
            $validated = $request->validate([
                'visitor_id' => 'required|exists:visitors,id',
                'tour_id' => 'required|exists:tours,id'
            ]);

            $registration = TourRegistration::create($validated);

            return response()->json($registration,201);
            }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
            $registration = TourRegistration::with(['visitor','tour'])->findOrFail($id);

            return response()->json($registration);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
            $registration = TourRegistration::findOrFail($id);

            $registration->update($request->all());

            return response()->json($registration);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
            $registration = TourRegistration::findOrFail($id);

            $registration->delete();

            return response()->json([
                'message' => 'Registration deleted successfully'
            ]);
    }
}
