<div x-show="filterMode"  x-cloak class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
    <div class="bg-white rounded shadow-lg w-full max-w-2xl p-6 relative">
        <div class="flex justify-between items-center mb-4 border-b pb-2">
            <h2 class="text-xl font-semibold" x-text="modalTitle"></h2>
        </div>

       <form method="POST" x-bind:action="FilterAction" enctype="multipart/form-data">
        {{ $slot }}
            <div class="flex justify-end space-x-2 mt-6">
                <button type="button" @click="filterMode = false" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">
                    Close
                </button>
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                    Apply
                </button>
            </div> 
        </form>
    </div>
    
</div>