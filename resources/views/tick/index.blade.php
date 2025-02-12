<x-layout>

    {{-- PLUS MODAL --}}
    <div x-data="{ open: false, createModal: false }">
            <div class="fixed top-4 right-4 z-50" @click.away="open = false">
                <button 
                        @click="open = !open" 
                        class="bg-black text-white p-3 rounded-full shadow-lg hover:bg-gray-600 focus:outline-none transform transition-all duration-300 ease-in-out flex items-center justify-center"
                    >
                        <i class="fas fa-plus text-xl"></i>
                </button>
                <div x-show="open" x-transition class="absolute mt-4 right-0 space-y-3">
                    <!-- Create Request button -->
                    <button 
                        @click="createModal = true,open = false"
                        class="bg-gray-700 text-white p-4 rounded-lg shadow-md hover:bg-gray-600 focus:outline-none transform transition-all duration-200 ease-in-out flex items-center space-x-3 w-56 border border-gray-600"
                    >
                        <i class="fas fa-plus-circle text-xl"></i>
                        <span class="text-sm">Create Request</span>
                    </button>

                    <!-- Search button -->
                    <button 
                        @click="open = false"
                        class="bg-gray-700 text-white p-4 rounded-lg shadow-md hover:bg-gray-600 focus:outline-none transform transition-all duration-200 ease-in-out flex items-center space-x-3 w-56 border border-gray-600"
                    >
                        <i class="fas fa-search text-xl"></i>
                        <span class="text-sm">Search</span>
                    </button>

                    <!-- Export to Excel button -->
                    <button 
                        @click="open = false"
                        class="bg-gray-700 text-white p-4 rounded-lg shadow-md hover:bg-gray-600 focus:outline-none transform transition-all duration-200 ease-in-out flex items-center space-x-3 w-56 border border-gray-600"
                    >
                        <i class="fas fa-file-excel text-xl"></i>
                        <span class="text-sm">Export to Excel</span>
                    </button>
                </div>
            </div>

    
            <!-- Modal -->
            <form action="{{ route('tick.store') }}" method="POST">
            @csrf
                <div x-show="createModal" @click.away="createModal = false" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
                <div class="bg-white p-6 rounded-lg w-full max-w-4xl h-[80vh] overflow-y-auto" @click.stop>
                    <!-- Modal Header -->
                    <div class="flex justify-between items-center mb-4 border-b pb-2">
                        <h2 class="text-xl font-semibold">Create Request</h2>
                        <button @click.prevent="createModal = false" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
                    </div>

                    <!-- Tab Navigation -->
                    <div x-data="{ tab: 'basic' }">
                        <div class="flex mb-4 border-b">
                            <a @click.prevent="tab = 'basic'" :class="{'border-b-2 border-blue-500 text-blue-500': tab === 'basic'}" class="px-4 py-2 text-sm text-gray-700 hover:text-blue-500 cursor-pointer">
                                Basic Information
                            </a>
                            <a @click.prevent="tab = 'printer'" :class="{'border-b-2 border-blue-500 text-blue-500': tab === 'printer'}" class="px-4 py-2 text-sm text-gray-700 hover:text-blue-500 cursor-pointer">
                                Printer Details
                            </a>
                        </div>

                        <!-- Form -->
                        <form>
                            <!-- Basic Information Tab -->
                            <div x-show="tab === 'basic'">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="dueDate" class="block text-sm font-medium text-gray-700">Due Date</label>
                                        <input type="date" name = 'dueDate' id="dueDate" class="mt-1 p-2 w-full border rounded-md">
                                    </div>
                                    <div>
                                        <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
                                        <select id="type" name = 'type' class="mt-1 p-2 w-full border rounded-md">
                                            <option>---</option>
                                            <option value="1">PRINTER</option>
                                            <option value="2">TONER</option>
                                            <option value="3">LAPTOP</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="ownership" class="block text-sm font-medium text-gray-700">Ownership</label>
                                        <select id="ownership" name="ownership" class="mt-1 p-2 w-full border rounded-md">
                                            <option>---</option>
                                            <option value="1">DELSAN OWNED</option>
                                            <option value="2">OTHERS</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="request" class="block text-sm font-medium text-gray-700">Request</label>
                                        <select id="request" name="request"  class="mt-1 p-2 w-full border rounded-md">
                                            <option>---</option>
                                            <option value="1">CHAT</option>
                                            <option value="2">TELEPHONE</option>
                                            <option value="3">EMAIL</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="requestorName" class="block text-sm font-medium text-gray-700">Requestor's Name</label>
                                        <input type="text" id="requestorName" name= "requestorName" class="mt-1 p-2 w-full border rounded-md" placeholder="Requestor's Name">
                                    </div>
                                    <div>
                                        <label for="contactNumber" class="block text-sm font-medium text-gray-700">Contact Number</label>
                                        <input type="text" id="client_contactnum" name= "client_contactnum" class="mt-1 p-2 w-full border rounded-md" placeholder="Contact Number">
                                    </div>
                                    <div>
                                        <label for="contactNumber" class="block text-sm font-medium text-gray-700">Client Email</label>
                                        <input type="email" id="client_email" name= "client_email" class="mt-1 p-2 w-full border rounded-md" placeholder="Client Email">
                                    </div>
                                </div>
                            </div>

                            <!-- Printer Details Tab -->
                            <div x-show="tab === 'printer'">
                                <div x-data="searchMachines()" x-init="initSearch()">
                                        <div class="relative">
                                            <label for="serialNumber" class="block text-sm font-medium text-gray-700">Serial Number</label>
                                            <input type="text" id="serialNumber" x-model="searchQuery"
                                                @input.debounce.300ms="fetchMachines"
                                                @focus="showDropdown = true"
                                                @blur="setTimeout(() => showDropdown = false, 200)"
                                                class="mt-1 p-2 w-full border rounded-md" placeholder="Serial Number">

                                            <!-- Dropdown Suggestions -->
                                            <ul x-show="showDropdown && results.length" class="absolute w-full bg-white border rounded-md shadow-md z-10">
                                                <template x-for="machine in results" :key="machine.id">
                                                    <li @click="selectMachine(machine)"
                                                        class="p-2 cursor-pointer hover:bg-gray-200">
                                                        <span x-text="machine.serial_number"></span>
                                                    </li>
                                                </template>
                                            </ul>
                                        </div>

                                        <div class="grid grid-cols-2 gap-4 mt-2">
                                            <div>
                                                <label for="company" class="block text-sm font-medium text-gray-700">Company</label>
                                                <input type="text" id="company" x-model="selectedMachine.company"
                                                    class="mt-1 p-2 w-full border rounded-md" placeholder="Company">
                                            </div>
                                            <div>
                                                <label for="department" class="block text-sm font-medium text-gray-700">Department</label>
                                                <textarea id="department" x-model="selectedMachine.department"
                                                        class="mt-1 p-2 w-full border rounded-md" placeholder="Department"></textarea>
                                            </div>
                                            <div>
                                                <label for="printerBrand" class="block text-sm font-medium text-gray-700">Printer Brand</label>
                                                <input type="text" id="printerBrand" x-model="selectedMachine.brand"
                                                    class="mt-1 p-2 w-full border rounded-md" placeholder="Printer Brand">
                                            </div>
                                            <div>
                                                <label for="printerModel" class="block text-sm font-medium text-gray-700">Printer Model</label>
                                                <input type="text" id="printerModel" x-model="selectedMachine.model"
                                                    class="mt-1 p-2 w-full border rounded-md" placeholder="Printer Model">
                                            </div>
                                        </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex justify-between items-center mt-4">
                                    <button @click="createModal = false" type="button" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">
                                        Close
                                    </button>
                                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">
                                        Save
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
                </div>
            </form>
            

    </div>

    <!-- Ticketing System Table -->
    <div class="overflow-x-auto p-3">
        <div class="min-w-full bg-white shadow rounded-lg overflow-hidden">
            <table class="min-w-full table-auto border-collapse">
                <thead class="border-b-2 border-b-black bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Ticket Number</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Priority</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Company</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Technician</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider">Aging</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider">Last Updated</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white-50">
                    @foreach($tickets as $ticket)
                        <tr class="hover:bg-gray-100 transition duration-150">
                            <!-- Ticket Number -->
                            <td class="px-4 py-3 text-sm font-semibold text-black-700">
                                {{ $ticket->ticket_number }}
                            </td>

                            <!-- Status -->
                            <td class="px-4 py-3 text-sm">
                                <span class="px-3 py-1 rounded-full 
                                    {{ $ticket->status_color == 1 ? 'bg-green-100 text-green-600' : ($ticket->status_color == 2 ? 'bg-yellow-100 text-yellow-600' : 'bg-red-100 text-red-600') }}">
                                    {{ $ticket->status_name }}
                                </span>
                            </td>

                            <!-- Priority Level -->
                            <td class="px-4 py-3 text-sm font-medium">
                                <span class="px-3 py-1 rounded-full 
                                    {{ $ticket->priority == 1 ? 'bg-green-100 text-green-600' : ($ticket->priority == 2 ? 'bg-yellow-100 text-yellow-600' : 'bg-red-100 text-red-600') }}">
                                    {{ $ticket->priority == 1 ? 'LOW' : ($ticket->priority == 2 ? 'MEDIUM' : 'HIGH') }}
                                </span>
                            </td>

                            <!-- Company -->
                            <td class="px-4 py-3 text-sm text-black-600">
                                {{ $ticket->company }}
                            </td>

                            <!-- Technician Assigned -->
                            <td class="px-4 py-3 text-sm text-black-600">
                                @if($ticket->technician)
                                    {{ $ticket->technician }}
                                @else
                                    <span class="text-xs text-gray-400">Unassigned</span>
                                @endif
                            </td>

                            <!-- Aging -->
                            <td class="px-4 py-3 text-center">
                                <div class="rounded-full bg-orange-500 text-white font-bold w-7 h-7 flex items-center justify-center mx-auto">
                                    {{ $ticket->aging }}
                                </div>
                            </td>

                            <!-- Last Updated -->
                            <td class="px-4 py-3 text-sm text-center">
                                <div class="flex items-center space-x-2 justify-center">
                                    <span class="bg-gray-100 px-3 py-1 rounded-md text-xs font-medium flex items-center">
                                        <i class="fa fa-calendar text-green-600 mr-1"></i> {{ \Carbon\Carbon::parse($ticket->updated_at)->format('d M, Y') }}
                                    </span>
                                    <span class="bg-gray-100 px-3 py-1 rounded-md text-xs font-medium flex items-center">
                                        <i class="fa fa-clock text-blue-600 mr-1"></i> {{ \Carbon\Carbon::parse($ticket->updated_at)->format('h:i A') }}
                                    </span>
                                </div>
                            </td>

                            <!-- Action Button -->
                            <td class="px-4 py-3 text-center">
                                <div class="relative inline-block text-left" x-data="{ open: false }">
                                    <button 
                                        @click="open = !open"
                                        class="bg-green-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-blue-400 transition duration-200 flex items-center"
                                    >
                                        Action
                                        <i class="fas fa-caret-down ml-2 text-xs"></i>
                                    </button>

                                    <!-- Dropdown Menu -->
                                    <div 
                                        x-show="open" 
                                        @click.away="open = false" 
                                        class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10"
                                        x-cloak
                                    >
                                        <ul class="text-sm">
                                            <li class="w-full px-4 py-2 text-gray-700 hover:bg-gray-100 text-left flex items-center"> 
                                                <i class="fa fa-sync-alt mr-2"></i> UPDATE REQUEST
                                            </li>
                                            <li class="w-full px-4 py-2 text-gray-700 hover:bg-gray-100 text-left flex items-center"> 
                                                <i class="fa fa-wrench mr-2"></i> PARTS REQUEST LOGS
                                            </li>
                                            <li class="w-full px-4 py-2 text-gray-700 hover:bg-gray-100 text-left flex items-center"> 
                                                <i class="fa fa-info-circle mr-2"></i> STATUS LOGS
                                            </li>
                                            <li class="w-full px-4 py-2 text-gray-700 hover:bg-gray-100 text-left flex items-center"> 
                                                <i class="fa fa-file-alt mr-2"></i> PAGE COUNT LOGS
                                            </li>
                                            <li class="w-full px-4 py-2 text-gray-700 hover:bg-gray-100 text-left flex items-center"> 
                                                <i class="fa fa-history mr-2"></i> PM HISTORY
                                            </li>
                                            <li class="w-full px-4 py-2 text-gray-700 hover:bg-gray-100 text-left flex items-center"> 
                                                <i class="fa fa-cogs mr-2"></i> SERVICE HISTORY
                                            </li>
                                            <li class="w-full px-4 py-2 text-gray-700 hover:bg-gray-100 text-left flex items-center"> 
                                                <i class="fa fa-comments mr-2"></i> DIRECT CHAT
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="px-4 py-3">
                {{ $tickets->links('pagination::tailwind') }}
            </div>
        </div>
    </div>

    <script>
        function searchMachines() {
            return {
                searchQuery: '',
                results: [],
                showDropdown: false,
                selectedMachine: { company: '', department: '', brand: '', model: '' },

                async fetchMachines() {
                    if (this.searchQuery.length < 2) {
                        this.results = [];
                        return;
                    }

                    const response = await fetch(`/tick/machines/search?q=${this.searchQuery}`);
                    this.results = await response.json();
                },

                selectMachine(machine) {
                    this.searchQuery = machine.serial_number;
                    this.selectedMachine = {
                        company: machine.company,
                        department: machine.department,
                        brand: machine.brand,
                        model: machine.model
                    };
                    this.showDropdown = false;
                },

                initSearch() {
                    this.results = [];
                    this.selectedMachine = { company: '', department: '', brand: '', model: '' };
                }
            };
        }
    </script>

    
</x-layout>
