<div x-data="{ isOpen: false }">
    {{-- Mobile Toggle Button --}}
    <button 
        class="md:hidden fixed top-4 right-4 z-50 p-2 rounded-md bg-white shadow-lg hover:bg-gray-50 transition-colors"
        @click="isOpen = !isOpen"
    >
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>

    {{-- Desktop Sidebar --}}
    <div class="hidden md:flex w-64 h-full">
        <div class="flex flex-col w-full">
            <div class="flex flex-col flex-grow h-screen overflow-y-auto bg-gradient-to-b from-purple-50 via-white to-purple-50 border-r">
                {{-- Logo --}}
                <div class="flex items-center flex-shrink-0 px-6 py-5">
                    <span class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-purple-600 to-blue-500">Admin Panel</span>
                </div>

                {{-- Menu Items --}}
                <div class="flex-grow flex flex-col px-4">
                    <nav class="flex-1 space-y-2">
                        {{-- Dashboard --}}
                        <a href="{{ route('admin.dashboard') }}" 
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 ease-in-out
                            {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-purple-500 to-blue-500 text-white shadow-lg shadow-purple-200' : 'text-gray-600 hover:bg-purple-50' }}">
                            <svg class="mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            <span>Dashboard</span>
                        </a>

                        {{-- Products --}}
                        <a href="#" 
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 ease-in-out
                            {{ request()->routeIs('admin.products') ? 'bg-gradient-to-r from-purple-500 to-blue-500 text-white shadow-lg shadow-purple-200' : 'text-gray-600 hover:bg-purple-50' }}">
                            <svg class="mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            <span>Products</span>
                        </a>

                        {{-- Categories --}}
                        <a href="#" 
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 ease-in-out
                            {{ request()->routeIs('admin.categories') ? 'bg-gradient-to-r from-purple-500 to-blue-500 text-white shadow-lg shadow-purple-200' : 'text-gray-600 hover:bg-purple-50' }}">
                            <svg class="mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                            <span>Categories</span>
                        </a>

                        {{-- Orders --}}
                        <a href="#" 
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 ease-in-out
                            {{ request()->routeIs('admin.orders') ? 'bg-gradient-to-r from-purple-500 to-blue-500 text-white shadow-lg shadow-purple-200' : 'text-gray-600 hover:bg-purple-50' }}">
                            <svg class="mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            <span>Orders</span>
                        </a>

                        {{-- Users --}}
                        <a href="#" 
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 ease-in-out
                            {{ request()->routeIs('admin.users') ? 'bg-gradient-to-r from-purple-500 to-blue-500 text-white shadow-lg shadow-purple-200' : 'text-gray-600 hover:bg-purple-50' }}">
                            <svg class="mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            <span>Users</span>
                        </a>
                    </nav>
                </div>

                {{-- User Profile & Logout (Desktop) --}}
                <div class="flex-shrink-0 p-4 border-t">
                    <div class="flex items-center justify-between space-x-3 px-4 py-3 rounded-xl hover:bg-purple-50">
                        <div class="flex items-center space-x-3">
                            <img class="h-8 w-8 rounded-full" src="https://ui-avatars.com/api/?name=Admin" alt="Admin">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">
                                    Admin
                                </p>
                                <p class="text-xs text-gray-500 truncate">
                                    admin@example.com
                                </p>
                            </div>
                        </div>
                        <form method="POST" action="{{ route('admin.logout') }}">
                            @csrf
                            <button type="submit" class="p-2 rounded-lg hover:bg-red-50 group">
                                <svg class="w-5 h-5 text-red-500 group-hover:text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Mobile Sidebar --}}
    <div 
        x-show="isOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="-translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="-translate-x-full"
        class="md:hidden fixed inset-0 z-40"
        @click.away="isOpen = false"
    >
        {{-- Backdrop --}}
        <div 
            class="fixed inset-0 bg-gray-800/30 backdrop-blur-sm"
            x-show="isOpen"
            x-transition:enter="transition-opacity ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-in duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="isOpen = false"
        ></div>
        
        {{-- Sidebar Content --}}
        <div class="fixed left-0 w-64 h-full bg-white shadow-lg">
            <div class="flex flex-col h-full">
                <div class="flex flex-col flex-grow h-screen overflow-y-auto bg-gradient-to-b from-purple-50 via-white to-purple-50">
                    {{-- Logo --}}
                    <div class="flex items-center flex-shrink-0 px-6 py-5">
                        <span class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-purple-600 to-blue-500">Admin Panel</span>
                    </div>

                    {{-- Menu Items (sama seperti desktop) --}}
                    <div class="flex-grow flex flex-col px-4">
                        <nav class="flex-1 space-y-2">
                            {{-- Dashboard --}}
                            <a href="{{ route('admin.dashboard') }}" 
                                class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 ease-in-out
                                {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-purple-500 to-blue-500 text-white shadow-lg shadow-purple-200' : 'text-gray-600 hover:bg-purple-50' }}">
                                <svg class="mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                <span>Dashboard</span>
                            </a>

                            {{-- Products --}}
                            <a href="#" 
                                class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 ease-in-out
                                {{ request()->routeIs('admin.products') ? 'bg-gradient-to-r from-purple-500 to-blue-500 text-white shadow-lg shadow-purple-200' : 'text-gray-600 hover:bg-purple-50' }}">
                                <svg class="mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                                <span>Products</span>
                            </a>

                            {{-- Categories --}}
                            <a href="#" 
                                class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 ease-in-out
                                {{ request()->routeIs('admin.categories') ? 'bg-gradient-to-r from-purple-500 to-blue-500 text-white shadow-lg shadow-purple-200' : 'text-gray-600 hover:bg-purple-50' }}">
                                <svg class="mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                                <span>Categories</span>
                            </a>

                            {{-- Orders --}}
                            <a href="#" 
                                class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 ease-in-out
                                {{ request()->routeIs('admin.orders') ? 'bg-gradient-to-r from-purple-500 to-blue-500 text-white shadow-lg shadow-purple-200' : 'text-gray-600 hover:bg-purple-50' }}">
                                <svg class="mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                <span>Orders</span>
                            </a>

                            {{-- Users --}}
                            <a href="#" 
                                class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 ease-in-out
                                {{ request()->routeIs('admin.users') ? 'bg-gradient-to-r from-purple-500 to-blue-500 text-white shadow-lg shadow-purple-200' : 'text-gray-600 hover:bg-purple-50' }}">
                                <svg class="mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                <span>Users</span>
                            </a>
                        </nav>
                    </div>

                    {{-- User Profile & Logout (Mobile) --}}
                    <div class="flex-shrink-0 p-4 border-t">
                        <div class="flex items-center justify-between space-x-3 px-4 py-3 rounded-xl hover:bg-purple-50">
                            <div class="flex items-center space-x-3">
                                <img class="h-8 w-8 rounded-full" src="https://ui-avatars.com/api/?name=Admin" alt="Admin">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">
                                        Admin
                                    </p>
                                    <p class="text-xs text-gray-500 truncate">
                                        admin@example.com
                                    </p>
                                </div>
                            </div>
                            <form method="POST" action="{{ route('admin.logout') }}">
                                @csrf
                                <button type="submit" class="p-2 rounded-lg hover:bg-red-50 group">
                                    <svg class="w-5 h-5 text-red-500 group-hover:text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>