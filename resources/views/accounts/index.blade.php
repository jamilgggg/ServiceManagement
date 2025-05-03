<x-app-layout>


<div class="overflow-x-auto p-1">

        {{-- Add Button --}}
        <div x-data="{ createModal: {{ session('error') ? 'true' : 'false' }} }">
            <button 
                @click="createModal = true"
                class="bg-green-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-blue-400 transition duration-200 flex items-center ml-auto"
            >
                Add Account
                <i class="fa fa-user-plus ml-1"></i>
            </button>

            <!-- Create Modal -->
            <form action="{{ route('accounts.addAccounts') }}" method="POST">
                @csrf
                <div x-show="createModal" @click.away="createModal = false" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
                    <div class="bg-white p-6 rounded-lg w-full max-w-4xl h-[80vh] overflow-y-auto" @click.stop>
                        <!-- Modal Header -->
                        <div class="flex justify-between items-center mb-4 border-b pb-2">
                            <h2 class="text-xl font-semibold">Create Account</h2>
                            <button @click.prevent="createModal = false" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
                        </div>

                        <!-- Tab Navigation -->
                        <div x-data="{ tab: 'basic' }">
                            <div class="flex mb-4 border-b">
                                <a :class="{'border-b-2 border-blue-500 text-blue-500': tab === 'basic'}" class="px-4 py-2 text-sm text-gray-700 hover:text-blue-500 cursor-pointer">
                                    Basic Information
                                </a>
                            </div>

                            <!-- Form -->
                            <div x-show="tab === 'basic'">
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="col-span-2 flex flex-col items-center">
                                        <label class="block text-sm font-medium text-gray-700">Profile Picture</label>
                                        <div class="relative w-32 h-32 rounded-full overflow-hidden border mt-2">
                                            <img x-ref="profilePreview" src="{{ asset('images/default.jpg') }}" class="w-full h-full object-cover" alt="Profile Picture">
                                            <input type="file" id="profile_picture" name="profile_picture" class="absolute inset-0 opacity-0 cursor-pointer" @change="
                                                const reader = new FileReader();
                                                reader.onload = (e) => $refs.profilePreview.src = e.target.result;
                                                reader.readAsDataURL($event.target.files[0]);
                                            ">
                                        </div>
                                    </div>
                                    <div>
                                        <label for="empid" class="block text-sm font-medium text-gray-700">Employee ID</label>
                                        <input type="text" id="empid" name="empid" class="mt-1 p-2 w-full border rounded-md" placeholder="Enter EMP ID" value="{{ old('empid') }}">
                                        <x-input-error :messages="session('form_errors.empid')" class="mt-2" />
                                    </div>
                                    <div>
                                        <label for="name" class="block text-sm font-medium text-gray-700">User Full Name</label>
                                        <input type="text" id="name" name="name" class="mt-1 p-2 w-full border rounded-md" placeholder="Enter Name" value="{{ old('name') }}">
                                        <x-input-error :messages="session('form_errors.name')" class="mt-2" />
                                    </div>
                                    <div>
                                        <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                                        <input type="email" id="email" name="email" class="mt-1 p-2 w-full border rounded-md" placeholder="Enter Email Address" value="{{ old('email') }}">
                                        <x-input-error :messages="session('form_errors.email')" class="mt-2" />
                                    </div>
                                    <div x-data="{ show: false }">
                                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                                        <div class="relative">
                                            <input :type="show ? 'text' : 'password'" id="password" name="password" class="mt-1 p-2 w-full border rounded-md pr-10" placeholder="Enter Password">
                                            
                                            <!-- Toggle Button -->
                                            <button type="button" @click="show = !show"
                                                class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-500 text-sm focus:outline-none">
                                                <i :class="show ? 'fa fa-eye-slash' : 'fa fa-eye'"></i>
                                            </button>
                                        </div>
                                        <x-input-error :messages="session('form_errors.password')" class="mt-2" />
                                    </div>
                                    <div>
                                        <label for="user_contactnum" class="block text-sm font-medium text-gray-700">Contact Number</label>
                                        <input type="text" id="user_contactnum" name="user_contactnum" class="mt-1 p-2 w-full border rounded-md" placeholder="Enter Contact Number" value="{{ old('user_contactnum') }}">
                                        <x-input-error :messages="session('form_errors.user_contactnum')" class="mt-2" />
                                    </div>
                                    <div>
                                        <label for="idgender" class="block text-sm font-medium text-gray-700">Gender</label>
                                        <select id="idgender" name="idgender" class="mt-1 p-2 w-full border rounded-md">
                                            <option value="">---</option>
                                            <option value="1" {{ old('idgender') == '1' ? 'selected' : '' }}>MALE</option>
                                            <option value="2" {{ old('idgender') == '2' ? 'selected' : '' }}>FEMALE</option>
                                            <option value="2" {{ old('idgender') == '3' ? 'selected' : '' }}>LGBTQ+</option>
                                        </select>
                                        <x-input-error :messages="session('form_errors.idgender')" class="mt-2" />
                                    </div>
                                    <div>
                                        <label for="idacctype" class="block text-sm font-medium text-gray-700">Account Role</label>
                                        <select id="idacctype" name="idacctype" class="mt-1 p-2 w-full border rounded-md">
                                            <option value="">---</option>
                                            @foreach($accountTypes as $accountType)
                                                <option value="{{ $accountType->id }}" {{ old('idacctype') == $accountType->id ? 'selected' : '' }}>
                                                    {{ $accountType->type }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <x-input-error :messages="session('form_errors.idacctype')" class="mt-2" />
                                    </div>
                                    <div>
                                        <label for="idemailstat" class="block text-sm font-medium text-gray-700">Email Status</label>
                                        <select id="idemailstat" name="idemailstat" class="mt-1 p-2 w-full border rounded-md">
                                            <option value="">---</option>
                                            <option value="1" {{ old('idemailstat') == '1' ? 'selected' : '' }}>ACTIVE</option>
                                            <option value="2" {{ old('idemailstat') == '2' ? 'selected' : '' }}>INACTIVE</option>
                                        </select>
                                        <x-input-error :messages="session('form_errors.idemailstat')" class="mt-2" />
                                    </div>
                                    <!-- Branch Multi-Select -->
                                    <div>
                                        <label for="branches" class="block text-sm font-medium text-gray-700">Branch</label>
                                        <select id="branches" name="branches[]" class="select2 w-full border p-2 rounded-md" multiple>
                                            @foreach($branches as $branch)
                                                <option value="{{ $branch->id }}" @selected(in_array($branch->id, old('branches', [])))>{{ $branch->branch }}</option>
                                            @endforeach
                                        </select>
                                        <x-input-error :messages="session('form_errors.branches')" class="mt-2" />
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
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="min-w-full bg-white shadow rounded-lg overflow-hidden">
            <table class="min-w-full table-auto border-collapse">
                <thead class="border-b-2 border-b-black bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">#</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Account Name</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Type</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Email</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Location</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Account Status</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white-50">
                    @php $rowNumber = $startRow; @endphp
                    @foreach($accounts as $account)
                        <tr class="hover:bg-gray-100 transition duration-150">

                            <td class="px-4 py-3 text-sm font-semibold text-black-700">
                                {{$rowNumber++}}
                            </td>

                            <td class="px-4 py-3 text-sm font-semibold text-black-700">
                                {{ $account->name }}
                            </td>

                            <td class="px-4 py-3 text-sm text-black-600">
                                {{ $account->type }}
                            </td>

                             <td class="px-4 py-3 text-sm text-black-600">
                                {{ $account->email }}
                            </td>

                            <td class="px-4 py-3 text-sm text-black-600">
                                {{-- {{ $account->email }} --}}
                            </td>

                            <td class="px-4 py-3 text-sm font-medium">
                                <span class="px-3 py-1 rounded-full 
                                    {{ $account->idstat == 1 ? 'bg-green-100 text-green-600' :  'bg-red-100 text-red-600' }}">
                                    {{ $account->idstat == 1 ? 'ACTIVE' : 'INACTIVE'}}
                                </span>
                            </td>

                            <!-- Action Button -->
                            <td class="px-4 py-3 text-center">
                                <div class="relative inline-block text-left" x-data="{ open: false }">
                                    <button 
                                        @click="open = !open"
                                        class="bg-green-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-blue-400 transition duration-200 flex items-center"
                                    >
                                        Update
                                        <i class="fas fa-edit ml-2 text-xs"></i>
                                    </button>
                                </div>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="px-4 py-3">
                {{ $accounts->links('pagination::tailwind') }}
            </div>
        </div>

        {{-- Success MODAL --}}
        @if(session('success'))
            <div x-data="{ showSuccessModal: true }">
                <div x-show="showSuccessModal" x-transition class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
                    <div class="bg-white p-6 rounded-lg shadow-lg">
                        <h2 class="text-xl font-bold text-green-600">Success!</h2>
                        <p>{{ session('success') }}</p>
                        <button @click="showSuccessModal = false" class="mt-4 px-4 py-2 bg-blue-600 text-white rounded">OK</button>
                    </div>
                </div>
            </div>
        @endif

    </div>

<script>
    $(document).ready(function() {
        $('#branches').select2({
            placeholder: "Select Branches",
            allowClear: true,
            width: '100%'
        });
    });
</script>

</x-app-layout>