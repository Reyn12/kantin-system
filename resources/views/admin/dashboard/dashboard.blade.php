@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('header', 'Dashboard')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <h2 class="text-xl font-semibold mb-4">Welcome to Admin Dashboard</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-blue-100 p-4 rounded-lg">
            <h3 class="font-semibold">Total Products</h3>
            <p class="text-2xl">0</p>
        </div>
        <div class="bg-green-100 p-4 rounded-lg">
            <h3 class="font-semibold">Total Categories</h3>
            <p class="text-2xl">0</p>
        </div>
        <div class="bg-yellow-100 p-4 rounded-lg">
            <h3 class="font-semibold">Total Orders</h3>
            <p class="text-2xl">0</p>
        </div>
    </div>
</div>
@endsection