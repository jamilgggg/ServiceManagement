<x-app-layout>


<div 
    x-data='accountModal(
    {{ session("error") ? "true" : "false" }},"{{ session("mode", "") }}",{!! json_encode(old()) !!},
    {!! json_encode(session("updateValues", [])) !!})' class="overflow-x-auto p-1">
    <button @click="openAdd()" type="button" 
        class="bg-green-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-blue-400 transition duration-200 flex items-center ml-auto"
    >
        Add Account
        <i class="fa fa-user-plus ml-1"></i>
    </button>
        <x-account-modal>
            @include('accounts.partials.form-fields', ['account' => null])
        </x-account-modal>

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
                                        @click='openEdit(@json($account))'
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
    window.sessionFormErrors = @json(session('form_errors', []));

    $(document).ready(function() {
        $('#branches').select2({
            placeholder: "Select Branches",
            allowClear: true,
            width: '100%'
        });
    });

    function accountModal(showOnError = false, mode = '', oldValues = {}, updateValues = {})  {
        return {
            show: showOnError,
            modalTitle: '',
            submitLabel: '',
            accountData: {},
            mode: mode,
            previousMode: null, 
            formAction: '',
            formMethod: '',
            formActionTemplate: '{{ route('accounts.updateAccounts', ['user' => '__ID__']) }}',
            updateValues,
            errors : {},

            init() {
                this.errors = window.sessionFormErrors || {};
                if (this.show) {
                    this.setMode(this.mode);
                }
            },

            setMode(mode) {
                this.previousMode = this.mode; 
                this.mode = mode;
                if (mode === 'edit') {
                    this.accountData = this.updateValues;
                    this.modalTitle = 'Update Account';
                    this.submitLabel = 'Update';
                    this.formAction = this.formActionTemplate.replace('__ID__', this.accountData.id);
                    this.formMethod = 'PUT';
                } else {
                    this.accountData = (this.previousMode != 'edit') ? oldValues : {};
                    const hasOldBranches = oldValues && Array.isArray(oldValues.branches) && oldValues.branches.length > 0;
                    if (!(this.previousMode !== 'edit' && hasOldBranches)) {
                        $("#branches").val([]).trigger("change");
                    }
                    this.modalTitle = 'Create Account';
                    this.submitLabel = 'Save';
                    this.formAction = '{{ route('accounts.addAccounts') }}';
                    this.formMethod = 'POST';
                }
            },

            openAdd() {
                this.clearErrors();
                this.setMode('create');
                this.show = true;
            },

            openEdit(account) {
                this.clearErrors();
                $("#branches").val(account.branches).trigger("change");
                this.updateValues = account;
                this.setMode('edit');
                this.show = true;
            },

            clearErrors() {
                this.errors = {};
            },
        }
    }

</script>

</x-app-layout>