{{-- Sidebar --}}
<div class="hidden md:flex md:flex-shrink-0">
    <div class="flex flex-col w-64">
        <div class="flex flex-col flex-grow h-screen overflow-y-auto bg-gradient-to-b from-purple-50 via-white to-purple-50 border-r backdrop-blur-sm">
            <div class="flex items-center flex-shrink-0 px-6 py-5">
                <span class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-purple-600 to-blue-500">Admin Panel</span>
            </div>
            <div class="flex-grow flex flex-col px-4">
                <nav class="flex-1 space-y-2">
                    {{-- Dashboard --}}
                    <a href="#" 
                        class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 ease-in-out
                        bg-gradient-to-r from-purple-500 to-blue-500 text-white shadow-lg shadow-purple-200">
                        <svg class="mr-3 h-5 w-5 text-white" 
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Dashboard
                    </a>

                    {{-- Kategori --}}
                    <a href="#" 
                        class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 ease-in-out
                        text-gray-600 hover:bg-white hover:shadow-md hover:text-purple-600">
                        <svg class="mr-3 h-5 w-5 text-gray-500 group-hover:text-purple-500"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                        Manajemen Kategori
                    </a>

                    {{-- Produk --}}
                    <div class="space-y-1">
                        <a href="#" 
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 ease-in-out
                            text-gray-600 hover:bg-white hover:shadow-md hover:text-purple-600">
                            <svg class="mr-3 h-5 w-5 text-gray-500 group-hover:text-purple-500"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                            Manajemen Produk
                        </a>
                        
                    </div>

                    {{-- Laporan --}}
                    <div class="space-y-1">
                        <a href="#" 
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 ease-in-out
                            text-gray-600 hover:bg-white hover:shadow-md hover:text-purple-600">
                            <svg class="mr-3 h-5 w-5 text-gray-500 group-hover:text-purple-500"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Laporan
                        </a>
                        
                    </div>
                </nav>

                {{-- Logout Button --}}
                <div class="mt-auto pb-6">
                    <form action="#" method="POST">
                        @csrf
                        <button type="submit" 
                            class="w-full group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 ease-in-out
                            text-red-500 hover:bg-red-50 hover:text-red-600">
                            <svg class="mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>