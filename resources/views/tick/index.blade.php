<x-layout>
    <!-- Ticketing System Table -->
    <div class="overflow-x-auto p-3">
        <div class="min-w-full bg-white shadow rounded-lg overflow-hidden">
            <table class="min-w-full table-auto border-collapse">
                <thead class="border-b-2 border-b-black">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold uppercase">Ticket Number</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold uppercase">Status</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold uppercase">Priority Level</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold uppercase">Company</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold uppercase">Department</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold uppercase">Brand-Model</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold uppercase">Serial Number</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold uppercase">Acknowledged By</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold uppercase"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white-50">
                    @foreach($tickets as $ticket)
                        <tr class="hover:bg-gray-100 transition duration-150">
                            <!-- Ticket Number -->
                            <td class="px-6 py-4 text-sm font-semibold text-black-700">
                                {{ $ticket->ticket_number }}
                            </td>

                            <!-- Status -->
                            <td class="px-6 py-4 text-sm">
                                @if($ticket->status_color == 1)
                                    <span class="px-3 py-1 rounded-full bg-green-100 text-green-600">{{ $ticket->status_name }}</span>
                                @elseif($ticket->status_color == 2)
                                    <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-600">{{ $ticket->status_name }}</span>
                                @else
                                    <span class="px-3 py-1 rounded-full bg-red-100 text-red-600">{{ $ticket->status_name }}</span>
                                @endif
                            </td>

                            <!-- Priority Level -->
                            <td class="px-6 py-4 text-sm font-medium">
                                @if($ticket->priority == 1)
                                    <span class="px-3 py-1 rounded-full bg-green-100 text-green-600">LOW</span>
                                @elseif($ticket->priority == 2)
                                    <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-600">MEDIUM</span>
                                @else
                                    <span class="px-3 py-1 rounded-full bg-red-100 text-red-600">HIGH</span>
                                @endif
                            </td>

                            <!-- Company -->
                            <td class="px-6 py-4 text-sm text-black-600">
                                {{ $ticket->company }}
                            </td>

                            <!-- Department -->
                            <td class="px-6 py-4 text-sm text-black-600">
                                {{ $ticket->department }}
                            </td>

                            <!-- Brand-Model -->
                            <td class="px-6 py-4 text-sm text-black-600">
                                {{ $ticket->brand }} - {{ $ticket->model }}
                            </td>

                            <!-- Serial Number -->
                            <td class="px-6 py-4 text-sm text-black-600">
                                {{ $ticket->serial_number }}
                            </td>

                            <!-- Acknowledged By -->
                            <td class="px-6 py-4 text-sm text-black-600">
                                @if($ticket->acknowledgedby)
                                    {{ $ticket->acknowledgedby }}
                                    <br>
                                    <span class="text-xs text-black-500">
                                        {{ \Carbon\Carbon::parse($ticket->acknowledgedby_datetime)->format('d M, Y') }}
                                    </span>
                                @else
                                    <span class="text-xs text-gray-400">Not yet acknowledged</span>
                                @endif
                            </td>

                            {{-- action button --}}
                            <td class="pr-3" x-data="{ open: false }">
                                <div class="relative inline-block text-left" x-on:click.away="open = false">
                                    <button 
                                        @click="open = true"
                                        class="bg-green-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-blue-400 transition duration-200 flex items-center"
                                    >
                                        Action
                                        <i class="fas fa-caret-down ml-2 text-xs"></i> <!-- Small caret down icon -->
                                    </button>

                                    <!-- Dropdown Menu -->
                                    <div 
                                        x-show="open" 
                                        class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10"
                                        x-cloak
                                    >
                                        <ul class="text-sm">
                                            <li class="block w-full px-4 py-2 text-gray-700 hover:bg-gray-100 text-left flex items-center"> 
                                                <i class="fa fa-sync-alt mr-2"></i> <!-- UPDATE REQUEST -->
                                                UPDATE REQUEST
                                            </li>
                                            <li class="block w-full px-4 py-2 text-gray-700 hover:bg-gray-100 text-left flex items-center"> 
                                                <i class="fa fa-wrench mr-2"></i> <!-- PARTS REQUEST LOGS -->
                                                PARTS REQUEST LOGS
                                            </li>
                                            <li class="block w-full px-4 py-2 text-gray-700 hover:bg-gray-100 text-left flex items-center"> 
                                                <i class="fa fa-info-circle mr-2"></i> <!-- STATUS LOGS -->
                                                STATUS LOGS
                                            </li>
                                            <li class="block w-full px-4 py-2 text-gray-700 hover:bg-gray-100 text-left flex items-center"> 
                                                <i class="fa fa-file-alt mr-2"></i> <!-- PAGE COUNT LOGS -->
                                                PAGE COUNT LOGS
                                            </li>
                                            <li class="block w-full px-4 py-2 text-gray-700 hover:bg-gray-100 text-left flex items-center"> 
                                                <i class="fa fa-history mr-2"></i> <!-- PM HISTORY -->
                                                PM HISTORY
                                            </li>
                                            <li class="block w-full px-4 py-2 text-gray-700 hover:bg-gray-100 text-left flex items-center"> 
                                                <i class="fa fa-cogs mr-2"></i> <!-- SERVICE HISTORY -->
                                                SERVICE HISTORY
                                            </li>
                                            <li class="block w-full px-4 py-2 text-gray-700 hover:bg-gray-100 text-left flex items-center"> 
                                                <i class="fa fa-comments mr-2"></i> <!-- DIRECT CHAT -->
                                                DIRECT CHAT
                                            </li>
                                        </ul>

                                    </div>
                                </div>
                            </td>




                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- <div class="px-6 py-4">
                {{ $tickets->links() }}
            </div> --}}

            <div class="px-6 py-4">
                {{ $tickets->links('pagination::tailwind') }}
            </div>
        </div>
    </div>
</x-layout>
