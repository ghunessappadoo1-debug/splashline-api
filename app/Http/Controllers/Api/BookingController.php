<?php

namespace App\Http\Controllers\API;

use App\Models\Booking;
use App\Models\Ticket;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookingResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['visitor', 'ticket']);

        if ($request->has('visit_date')) {
            $query->whereDate('visit_date', $request->visit_date);
        }
        if ($request->has('visitor_id')) {
            $query->where('visitor_id', $request->visitor_id);
        }
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $bookings = $query->paginate(15);
        return BookingResource::collection($bookings);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'visitor_id' => 'required|exists:visitors,id',
            'ticket_id' => 'required|exists:tickets,id',
            'visit_date' => 'required|date|after_or_equal:today',
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $ticket = Ticket::find($request->ticket_id);
        $totalPrice = $ticket->price * $request->quantity;

        $booking = Booking::create([
            'visitor_id' => $request->visitor_id,
            'ticket_id' => $request->ticket_id,
            'visit_date' => $request->visit_date,
            'quantity' => $request->quantity,
            'total_price' => $totalPrice,
            'status' => 'confirmed',
        ]);

        return new BookingResource($booking->load(['visitor', 'ticket']));
    }

    public function show(Booking $booking)
    {
        return new BookingResource($booking->load(['visitor', 'ticket']));
    }

    public function update(Request $request, Booking $booking)
    {
        $validator = Validator::make($request->all(), [
            'visit_date' => 'sometimes|required|date|after_or_equal:today',
            'quantity' => 'sometimes|required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if ($request->has('quantity') && $request->quantity != $booking->quantity) {
            $booking->total_price = $booking->ticket->price * $request->quantity;
        }

        $booking->update($request->only(['visit_date', 'quantity', 'total_price']));
        return new BookingResource($booking->load(['visitor', 'ticket']));
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();
        return response()->json(['message' => 'Booking deleted successfully'], 200);
    }

    // Custom: Cancel a booking (PATCH)
    public function cancel(Booking $booking)
    {
        if ($booking->status === 'cancelled') {
            return response()->json(['error' => 'Booking already cancelled'], 400);
        }
        $booking->update(['status' => 'cancelled']);
        return new BookingResource($booking->load(['visitor', 'ticket']));
    }
}