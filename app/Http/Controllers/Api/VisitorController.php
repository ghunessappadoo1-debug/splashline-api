<?php

namespace App\Http\Controllers\API;

use App\Models\Visitor;
use App\Http\Controllers\Controller;
use App\Http\Resources\VisitorResource;
use App\Http\Resources\BookingResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VisitorController extends Controller
{
    public function index()
    {
        $visitors = Visitor::with('bookings.ticket')->paginate(15);
        return VisitorResource::collection($visitors);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:visitors,email',
            'phone' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $visitor = Visitor::create($request->all());
        return new VisitorResource($visitor->load('bookings'));
    }

    public function show(Visitor $visitor)
    {
        return new VisitorResource($visitor->load(['bookings.ticket', 'tourRegistrations.tour']));
    }

    public function update(Request $request, Visitor $visitor)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:visitors,email,' . $visitor->id,
            'phone' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $visitor->update($request->all());
        return new VisitorResource($visitor->load('bookings'));
    }

    public function destroy(Visitor $visitor)
    {
        $visitor->delete();
        return response()->json(['message' => 'Visitor deleted successfully'], 200);
    }

    // Custom: Get all bookings of a visitor
    public function bookings(Visitor $visitor)
    {
        $bookings = $visitor->bookings()->with('ticket')->paginate(15);
        return BookingResource::collection($bookings);
    }
}