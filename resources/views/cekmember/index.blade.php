<!DOCTYPE html>
<html>
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex">
        <!-- Sidebar -->
        <div class="bg-blue-500 w-1/4 h-screen flex flex-col items-center justify-center shadow-lg">
            <div class="text-center text-white">
                <h1 class="text-4xl font-extrabold mb-2 tracking-wider">Basado</h1>
                <h2 class="text-xl font-light">Food & Drink</h2>
            </div>
        </div>
        <!-- Main Content -->
        <div class="w-3/4 p-8">
            <!-- Search and Back Button -->
            <div class="flex justify-between items-center mb-8">
                <form action="{{ route('member.search') }}" method="GET" class="relative w-2/3">
                    <input 
                        type="text" 
                        name="search" 
                        placeholder="Masukkan Nama atau Nomor HP Member..." 
                        value="{{ request('search') }}" 
                        class="w-full pl-12 pr-4 py-3 rounded-full bg-gray-200 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400"
                    >
                    <i class="fas fa-search absolute left-4 top-3.5 text-gray-500"></i>
                </form>
                <a href="{{ url('/') }}" class="text-blue-500 hover:text-blue-700 text-lg font-semibold transition duration-300">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
            <!-- Title -->
            <h1 class="text-3xl font-bold text-center mb-8 text-gray-700 tracking-wider">Hi, Welcome Back!</h1>

            <!-- Members Data -->
            @if(request('search'))
                @if($members->isNotEmpty())
                    @foreach($members as $member)
                        <div class="bg-white p-6 rounded-lg shadow-md mb-6 hover:shadow-lg transition-shadow duration-300">
                            <h2 class="text-2xl font-bold mb-2 text-blue-600">{{ $member->nama }}</h2>
                            <p class="text-gray-600 mb-4"><i class="fas fa-phone-alt"></i> Nomor HP: {{ $member->no_hp }}</p>
                            <div class="bg-blue-100 p-4 rounded-lg flex items-center">
                                <div class="bg-gray-300 p-4 rounded-lg mr-4">
                                    <i class="fas fa-user text-gray-700 text-3xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-800">Level: {{ $member->levelmember->tingkatan_level ?? 'Unknown' }}</h3>
                                    <p class="text-gray-700">Poin: <span class="text-blue-600 font-semibold">{{ $member->total_poin ?? 0 }}</span></p>
                                    <p class="text-gray-700">Periode: <span class="font-medium">{{ $member->periode_awal }}</span> - <span class="font-medium">{{ $member->periode_akhir }}</span></p>
                                </div>
                                <i class="fas fa-star text-yellow-500 text-3xl ml-auto"></i>
                            </div>
                        </div>
                    @endforeach
                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $members->links() }}
                    </div>
                @else
                    <p class="text-center text-gray-500 text-lg">Tidak ada data member ditemukan.</p>
                @endif
            @else
                <p class="text-center text-gray-500 text-lg">Silakan masukkan nama atau nomor HP untuk mencari member.</p>
            @endif
        </div>
    </div>
</body>
</html>
