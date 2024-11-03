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
        <div class="bg-blue-400 w-1/4 h-screen flex items-center justify-center">
            <div class="text-center text-cream">
                <h1 class="text-4xl font-bold">Basado</h1>
                <h2 class="text-2xl">food&drink</h2>
            </div>
        </div>
        <!-- Main Content -->
        <div class="w-3/4 p-8">
            <div class="flex justify-between items-center mb-8">
                <div class="relative">
                    <input type="text" placeholder="Cek Member" class="pl-10 pr-4 py-2 rounded-full bg-gray-200 text-gray-700 focus:outline-none">
                    <i class="fas fa-search absolute left-3 top-2.5 text-gray-500"></i>
                </div>
                <a href="#" class="text-black text-lg">Kembali</a>
            </div>
            <h1 class="text-2xl font-bold text-center mb-8">HI, WELCOME BACK</h1>
            <div class="bg-white p-8 rounded-lg shadow-md">
                <h2 class="text-xl font-bold mb-2">Nama Member</h2>
                <p class="text-gray-600 mb-4">Nomor Hp Member</p>
                <div class="bg-blue-300 p-4 rounded-lg flex items-center">
                    <div class="bg-gray-200 p-4 rounded-lg mr-4">
                        <i class="fas fa-user text-gray-500 text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold">Level Member</h3>
                        <p class="text-gray-600">Poin</p>
                        <p class="text-gray-600">Periode Awal sampai Periode Akhir</p>
                    </div>
                    <i class="fas fa-star text-yellow-500 text-2xl ml-auto"></i>
                </div>
            </div>
        </div>
    </div>
</body>
</html>