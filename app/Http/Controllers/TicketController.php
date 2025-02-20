<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Branch;
use App\Models\AccountType;
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
            ->from('sp_ticket as t')
            ->leftJoin('sp_status as s', 't.status', '=', 's.id')
            ->leftJoin('machines as m', 't.fk_mif', '=', 'm.id')
            ->orderBy('t.created_at', 'desc')
            ->paginate(15);

        return view('tick.index', ['tickets' => $tickets]);
    }

    public function searchMachines(Request $request)
    {
        $search = $request->query('q');

        if (!$search) {
            return response()->json([]);
        }

        $machines = \DB::table('machines')
            ->where('serial_number', 'LIKE', "%{$search}%")
            ->limit(5)
            ->get(['id', 'serial_number', 'company', 'department', 'brand', 'model']);

        return response()->json($machines);
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
        $brTest = 1;
        $accTest = 4;

        $data = $request->validate([
            'dueDate' => ['required', 'date'],
            'ownership' => ['required', 'integer'],
            'type' => ['required', 'integer'],
            'request' => ['required', 'integer'],
            'requestorName' => ['required', 'string'],
            'client_contactnum' => ['required', 'string'],
            'client_email' => ['required', 'string'],
        ]);

        $branch = Branch::find($brTest);
        $acttype = AccountType::find($accTest);

        $latestTicket = Ticket::where('fk_branch', $brTest)
        ->latest('id')
        ->first();

        $sequenceNumber = $latestTicket ? (int) substr($latestTicket->ticket_number, -4) + 1 : 1;
        $ticketNumber = strtoupper(substr($branch->branch, 0, 3)) . '-' . 
        strtoupper($acttype->alias) . '-' . str_pad($sequenceNumber, 7, '0', STR_PAD_LEFT);

        $data['ticket_number'] = $ticketNumber;
        $data['fk_branch'] = $brTest;
        $data['status'] = 1;

        Ticket::create($data);

        return redirect()->back()->with('success', 'Ticket created successfully!');
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
