<aside x-show="sidebarOpen" x-transition
    class="bg-gray-800 w-60 p-4 text-white space-y-2 hidden lg:block">
    <a href="{{ route('dashboard') }}" class="flex items-center py-2.5 px-4 rounded-lg hover:bg-gray-700">
        <i class="fas fa-columns mr-2"></i> Dashboard
    </a>
    <a href="#" class="flex items-center py-2.5 px-4 rounded-lg hover:bg-gray-700">
        <i class="fas fa-user mr-2"></i> Accounts
    </a>
    <a href="#" class="flex items-center py-2.5 px-4 rounded-lg hover:bg-gray-700">
        <i class="fas fa-chart-bar mr-2"></i> Overall Reports
    </a>
    <a href="#" class="flex items-center py-2.5 px-4 rounded-lg hover:bg-gray-700">
        <i class="fas fa-arrow-left mr-2"></i> Back
    </a>
</aside>