<div class="grid grid-cols-2 gap-4">

    <!-- Profile Picture -->
    <div class="col-span-2 flex flex-col items-center">
        <label class="block text-sm font-medium text-gray-700">Profile Picture</label>
        <div class="relative w-32 h-32 rounded-full overflow-hidden border mt-2">
            <img x-ref="profilePreview" 
                 src="{{ $account && $account->profile_picture ? asset('storage/' . $account->profile_picture) : asset('images/default.jpg') }}" 
                 class="w-full h-full object-cover" alt="Profile Picture">
            <input type="file" name="profile_picture" class="absolute inset-0 opacity-0 cursor-pointer"
                @change="
                    const reader = new FileReader();
                    reader.onload = (e) => $refs.profilePreview.src = e.target.result;
                    reader.readAsDataURL($event.target.files[0]);
                ">
        </div>
    </div>

    <!-- Employee ID -->
    <div>
        <label for="empid" class="block text-sm font-medium text-gray-700">Employee ID</label>
        <input type="text" id="empid" name="empid" class="mt-1 p-2 w-full border rounded-md" placeholder="Enter EMP ID"
            x-bind:value="mode === 'edit' ? accountData.empid ?? '' : '{{ old('empid') }}'">
        <x-input-error :messages="session('form_errors.empid')" class="mt-2" />
    </div>

    <!-- Name -->
    <div>
        <label for="name" class="block text-sm font-medium text-gray-700">User Full Name</label>
        <input type="text" name="name" id="name" class="mt-1 p-2 w-full border rounded-md" placeholder="Enter Name"
            x-bind:value="mode === 'edit' ? accountData.name ?? '' : '{{ old('name') }}'">
        <x-input-error :messages="session('form_errors.name')" class="mt-2" />
    </div>

    <!-- Email -->
    <div>
        <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
        <input type="email" id="email" name="email" class="mt-1 p-2 w-full border rounded-md" placeholder="Enter Email Address"
            x-bind:value="mode === 'edit' ? accountData.email ?? '' : '{{ old('email') }}'">
        <x-input-error :messages="session('form_errors.email')" class="mt-2" />
    </div>

    <!-- Password -->
    <div x-data="{ show: false }">
        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
        <div class="relative">
            <input :type="show ? 'text' : 'password'" id="password" name="password" class="mt-1 p-2 w-full border rounded-md pr-10"
                placeholder="Enter Password">
            <button type="button" @click="show = !show"
                class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-500 text-sm focus:outline-none">
                <i :class="show ? 'fa fa-eye-slash' : 'fa fa-eye'"></i>
            </button>
        </div>
        <x-input-error :messages="session('form_errors.password')" class="mt-2" />
    </div>

    <!-- Contact Number -->
    <div>
        <label for="user_contactnum" class="block text-sm font-medium text-gray-700">Contact Number</label>
        <input type="text" id="user_contactnum" name="user_contactnum" class="mt-1 p-2 w-full border rounded-md"
            placeholder="Enter Contact Number" x-bind:value="mode === 'edit' ? accountData.user_contactnum ?? '' : '{{ old('user_contactnum') }}'">
        <x-input-error :messages="session('form_errors.user_contactnum')" class="mt-2" />
    </div>

    <!-- Gender -->
    <div>
        <label for="idgender" class="block text-sm font-medium text-gray-700">Gender</label>
        <select x-model="accountData.idgender" id="idgender" name="idgender" class="mt-1 p-2 w-full border rounded-md">
            <option value="">---</option>
            <option value="1">MALE</option>
            <option value="2">FEMALE</option>
            <option value="3">LGBTQ+</option>
        </select>
        <x-input-error :messages="session('form_errors.idgender')" class="mt-2" />
    </div>

    <!-- Account Role -->
    <div>
        <label for="idacctype" class="block text-sm font-medium text-gray-700">Account Role</label>
        <select x-model="accountData.idacctype" id="idacctype" name="idacctype" class="mt-1 p-2 w-full border rounded-md">
            <option value="">---</option>
            @foreach($accountTypes as $accountType)
                <option value="{{ $accountType->id }}">
                    {{ $accountType->type }}
                </option>
            @endforeach
        </select>
        <x-input-error :messages="session('form_errors.idacctype')" class="mt-2" />
    </div>

    <!-- Email Status -->
    <div>
        <label for="idemailstat" class="block text-sm font-medium text-gray-700">Email Status</label>
        <select x-model="accountData.idemailstat" id="idemailstat" name="idemailstat" class="mt-1 p-2 w-full border rounded-md">
            <option value="">---</option>
            <option value="1">ACTIVE</option>
            <option value="2">INACTIVE</option>
        </select>
        <x-input-error :messages="session('form_errors.idemailstat')" class="mt-2" />
    </div>

    <!-- Branch Multi-Select -->
    <div>
        <label for="branches" class="block text-sm font-medium text-gray-700">Branch</label>
        <select x-model="accountData.branches" id="branches" name="branches[]" class="select2 w-full border p-2 rounded-md" multiple>
            @foreach($branches as $branch)
                <option value="{{ $branch->id }}">
                    {{ $branch->branch }}
                </option>
            @endforeach
        </select>
        <x-input-error :messages="session('form_errors.branches')" class="mt-2" />
    </div>
</div>
