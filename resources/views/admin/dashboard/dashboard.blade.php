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
            @include('admin.dashboard.components.transaksi-card')
        </div>

        {{-- Right Column - Calendar (30%) --}}
        <div class="w-full lg:w-[25%] bg-white rounded-xl p-6 shadow-xl h-fit">
            {{-- Calendar dn Event --}}
            @include('admin.dashboard.components.calendarEvent-card')
        </div>
    </div>
@endsection