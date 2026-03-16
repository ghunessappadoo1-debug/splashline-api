<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Booking::with(['visitor','ticket'])->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
            $validated = $request->validate([
                'visitor_id' => 'required|exists:visitors,id',
                'ticket_id' => 'required|exists:tickets,id',
                'quantity' => 'required|integer|min:1'
            ]);

            $ticket = \App\Models\Ticket::find($validated['ticket_id']);

            $validated['total_price'] = $ticket->price * $validated['quantity'];

            $booking = Booking::create($validated);

            return response()->json($booking,201);
            }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
            $booking = Booking::with(['visitor','ticket'])->findOrFail($id);

            return response()->json($booking);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
            $booking = Booking::findOrFail($id);

            $booking->update($request->all());

            return response()->json($booking);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
            $booking = Booking::findOrFail($id);

            $booking->delete();

            return response()->json([
                'message' => 'Booking deleted successfully'
            ]);
    }
}
