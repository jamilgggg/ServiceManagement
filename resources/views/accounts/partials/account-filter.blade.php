<div class="grid grid-cols-2 gap-4">
    <div class="col-span-2">
        <label for="empid" class="block text-sm font-medium text-gray-700">Employee Name</label>
        <input type="text" id="empid" name="empid" class="mt-1 p-2 w-full border rounded-md" placeholder="Enter EMP ID"
            x-model="accountFilterData.empid">
    </div>
    <div class="col-span-2">
        <label for="empid" class="block text-sm font-medium text-gray-700">Account Type</label>
        <select x-model="accountData.idacctype" id="idacctype" name="idacctype" class="mt-1 p-2 w-full border rounded-md">
            <option value="">---</option>
            @foreach($accountTypes as $accountType)
                <option value="{{ $accountType->id }}">
                    {{ $accountType->type }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-span-2">
        <label for="empid" class="block text-sm font-medium text-gray-700">Status</label>
        <select x-model="accountFilterData.idstat" id="idstat" name="idstat" class="mt-1 p-2 w-full border rounded-md">
            <option value="">---</option>
            <option value="1">ACTIVE</option>
            <option value="2">INACTIVE</option>
        </select>
    </div>
    <div class="col-span-2">
        <label for="empid" class="block text-sm font-medium text-gray-700">Branch</label>
        <select x-model="accountFilterData.filter_branch" id="filter_branch" name="filter_branch" class="select2 w-full border p-2 rounded-md">
            @foreach($branches as $branch)
                <option value="{{ $branch->id }}">{{ $branch->branch }}</option>
            @endforeach
        </select>
    </div>
</div>