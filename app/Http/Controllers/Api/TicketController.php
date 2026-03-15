<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Ticket::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
            $validated = $request->validate([
                'ticket_type' => 'required|string|max:255',
                'price' => 'required|numeric'
            ]);

            $ticket = Ticket::create($validated);

            return response()->json($ticket, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json(Ticket::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
            $ticket = Ticket::findOrFail($id);

            $ticket->update($request->all());

            return response()->json($ticket);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
            $ticket = Ticket::findOrFail($id);

            $ticket->delete();

            return response()->json([
                'message' => 'Ticket deleted successfully'
            ]);
    }
}
