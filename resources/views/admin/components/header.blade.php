{{-- Header Component --}}
<div class="flex flex-col md:flex-row md:items-center justify-between px-4 md:px-8 py-5 space-y-4 md:space-y-0">
    {{-- Left side - Greeting --}}
    <div>
        <h1 class="text-xl md:text-2xl font-semibold text-gray-800">Good Evening Team!</h1>
        <p class="text-sm text-gray-500 mt-1 hidden md:block">Have an in-depth look at all the metrics within your dashboard.</p>
    </div>

    {{-- Right side - Search & Profile --}}
    <div class="flex items-center space-x-2 md:space-x-4">
        {{-- Search Bar --}}
        <div class="relative flex-1 md:flex-none">
            <input type="text" placeholder="Search..." class="w-full md:w-auto pl-10 pr-4 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
            <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>

        {{-- Notifications --}}
        <button class="relative p-2 text-gray-400 hover:text-gray-500 focus:outline-none">
            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
            <span class="absolute top-0 right-0 h-2 w-2 rounded-full bg-red-500"></span>
        </button>

        {{-- Profile Button --}}
        <button class="flex items-center space-x-2 focus:outline-none">
            <img src="https://ui-avatars.com/api/?name=Jhonlosan" alt="Profile" class="w-8 h-8 rounded-full">
            <span class="text-sm font-medium text-gray-700 hidden md:block">Umam</span>
            <svg class="w-4 h-4 text-gray-400 hidden md:block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>
    </div>
</div>