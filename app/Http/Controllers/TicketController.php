<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Branch;
use App\Models\AccountType;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
            ->paginate(10);

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
    public function store(Request $request){
        try{
            $branchId = 1; 
            $accountTypeId = 4;

            $data = $request->validate([
                'dueDate' => 'required|date',
                'ownership' => 'required|integer',
                'type' => 'required|integer',
                'request' => 'required|integer',
                'requestorName' => 'required|string',
                'client_contactnum' => 'required|string',
                'client_email' => 'required|string',
                'machine_id' => 'required|exists:machines,id',
            ]);

            $branch = Branch::findOrFail($branchId);
            $accountType = AccountType::findOrFail($accountTypeId);

            $latestTicket = Ticket::where('fk_branch', $branchId)
                                ->latest('id')
                                ->first();

            $sequenceNumber = $latestTicket ? (int) substr($latestTicket->ticket_number, -4) + 1 : 1;

            $ticketNumber = strtoupper(substr($branch->branch, 0, 3)) . '-' . 
                            strtoupper($accountType->alias) . '-' . 
                            str_pad($sequenceNumber, 7, '0', STR_PAD_LEFT);

            $ticketData = array_merge($data, [
                'ticket_number' => $ticketNumber,
                'fk_branch' => $branchId,
                'status' => 1,
                'fk_mif' => $data['machine_id'],
            ]);

            Ticket::create($ticketData);

            return redirect()->back()->with('success', 'Ticket created successfully!');
        }catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Branch or Account Type not found.');
        }
        
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
