<!DOCTYPE html>
<html lang="en">       
@extends('layout.sidebar')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Poin Member</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">
    <!-- Wrapper -->
    <div class="flex flex-col md:flex-row min-h-screen">
        <!-- Main Content -->
        <div class="flex-1 w-full">
            <div class="container mx-auto py-8 px-4">
                <!-- Header -->
                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white p-6 rounded-lg shadow-lg mb-6">
                    <h1 class="text-4xl font-bold">Daftar Poin Member</h1>
                    <p class="mt-2 text-sm font-light">Pantau poin dari setiap member di sistem dan kelola status mereka.</p>
                </div>

                <!-- Success Message -->
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Table -->
                <div class="bg-white shadow-md rounded-lg overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto border-collapse">
                            <thead class="bg-gradient-to-r from-gray-200 to-gray-300 text-gray-800 text-sm uppercase font-semibold">
                                <tr>
                                    <th class="py-4 px-6 text-left border-b">ID Member</th>
                                    <th class="py-4 px-6 text-left border-b">Nama</th>
                                    <th class="py-4 px-6 text-center border-b">Total Poin</th>
                                    <th class="py-4 px-6 text-center border-b">Status</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700">
                                @foreach ($members as $member)
                                <tr class="hover:bg-gray-50 transition duration-300 ease-in-out border-b">
                                    <!-- ID Member -->
                                    <td class="py-4 px-6 font-medium">{{ $member->id_member }}</td>
                            
                                    <!-- Nama -->
                                    <td class="py-4 px-6">
                                        <div class="flex items-center">
                                            <div class="bg-blue-500 text-white rounded-full h-10 w-10 flex items-center justify-center mr-4 shadow-md">
                                                {{ substr($member->nama, 0, 1) }}
                                            </div>
                                            <span class="font-semibold text-lg">{{ $member->nama }}</span>
                                        </div>
                                    </td>
                            
                                    <!-- Total Poin -->
                                    <td class="py-4 px-6 text-center">
                                        <span class="bg-green-100 text-green-700 py-1 px-3 rounded-full text-sm font-semibold shadow-sm">
                                            {{ $member->poins_sum_total_poin ?? 0 }} Poin
                                        </span>
                                    </td>                                 
                            
                                    <!-- Status -->
                                    <td class="py-4 px-6 text-center">
                                        @if (($member->poins_sum_total_poin ?? 0) >= 1000)
                                            <span class="bg-gradient-to-r from-green-400 to-green-600 text-white py-1 px-3 rounded-full text-sm font-medium shadow-md">VIP</span>
                                        @elseif (($member->poins_sum_total_poin ?? 0) >= 500)
                                            <span class="bg-gradient-to-r from-yellow-400 to-yellow-600 text-white py-1 px-3 rounded-full text-sm font-medium shadow-md">Gold</span>
                                        @else
                                            <span class="bg-gradient-to-r from-gray-300 to-gray-400 text-gray-800 py-1 px-3 rounded-full text-sm font-medium shadow-md">Regular</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>                            
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
