@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    @include('admin.components.header')
    
    {{-- Main Content --}}
    <div class="flex flex-col lg:flex-row gap-6">
        {{-- Left Column - Stats & Chart (70%) --}}
        <div class="w-full lg:w-[75%] space-y-6">
            {{-- Stats Cards --}}
            @include('admin.dashboard.components.stats-card')

            {{-- Chart Penjualan --}}
            @include('admin.dashboard.components.penjualan-card')

            {{-- Transaction History --}}
            <div class="bg-white rounded-xl p-6 shadow-sm">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold">Transaction History</h2>
                    <button class="px-4 py-2 bg-gray-100 rounded-lg text-sm">Month</button>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="text-left text-gray-500">
                                <th class="pb-4">Menu/Item</th>
                                <th class="pb-4">Amount</th>
                                <th class="pb-4">Status</th>
                                <th class="pb-4">Date</th>
                                <th class="pb-4">Customer</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600">
                            <tr class="border-t">
                                <td class="py-4">Nasi Goreng</td>
                                <td>Rp25.000</td>
                                <td>
                                    <span class="px-2 py-1 bg-green-100 text-green-600 rounded-full text-sm">
                                        Completed
                                    </span>
                                </td>
                                <td>Nov 02, 2023</td>
                                <td>John Doe</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Right Column - Calendar (30%) --}}
        <div class="w-full lg:w-[25%] bg-white rounded-xl p-6 shadow-xl h-fit">
            {{-- Calendar dn Event --}}
            @include('admin.dashboard.components.calendarEvent-card')
        </div>
    </div>
@endsection