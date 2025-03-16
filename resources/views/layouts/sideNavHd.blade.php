<aside x-show="sidebarOpen" x-transition
    class="bg-gray-800 w-60 p-4 text-white space-y-2 hidden lg:block">
    <a href="{{ route('dashboard') }}" class="flex items-center py-2.5 px-4 rounded-lg hover:bg-gray-700">
        <i class="fas fa-home mr-2"></i> Home
    </a>
    <a href="#" class="flex items-center py-2.5 px-4 rounded-lg hover:bg-gray-700">
        <i class="fas fa-ticket-alt mr-2"></i> Tickets
    </a>
    <a href="#" class="flex items-center py-2.5 px-4 rounded-lg hover:bg-gray-700">
        <i class="fas fa-chart-line mr-2"></i> Monitoring
    </a>
    <a href="#" class="flex items-center py-2.5 px-4 rounded-lg hover:bg-gray-700">
        <i class="fas fa-arrow-left mr-2"></i> Back
    </a>
</aside>