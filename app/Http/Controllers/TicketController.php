<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $tickets = Ticket::query()
            ->select('t.*', 's.name as status_name', 's.color as status_color', 'm.serial_number', 'm.company', 'm.department', 'm.brand', 'm.model')
            ->from('tickets as t')
            ->leftJoin('sp_status as s', 't.status', '=', 's.id')
            ->leftJoin('machines as m', 't.fk_mif', '=', 'm.id')
            ->orderBy('t.created_at', 'desc')
            ->paginate(15);

        return view('tick.index', ['tickets' => $tickets]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        //
    }
}
