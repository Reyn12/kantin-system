@extends('kasir.layouts.app')

@section('title', 'Dashboard')

@section('content')
    @include('kasir.components.header')
    
    {{-- Main Content --}}
    <div class="flex flex-col lg:flex-row gap-6">
        <div class="w-full lg:w-[75%] space-y-6">
            {{-- Transaction History --}}
            @include('kasir.dashboard.components.unpaid-transaction')
        </div>

        {{-- Right Column - Calendar (30%) --}}
        <div class="w-full lg:w-[25%] bg-white rounded-xl p-6 shadow-xl h-fit">
            {{-- Calendar dn Event --}}
            @include('admin.dashboard.components.calendarEvent-card')
        </div>
    </div>
@endsection