<!DOCTYPE html>
<html lang="en">
<head>
    <title>Cek Member</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white shadow-lg rounded-lg p-8 max-w-md w-full">
        <h2 class="text-2xl font-semibold text-center mb-4">Cek Profil Member</h2>
        <form action="{{ route('public.member.cekmember') }}" method="GET">
            <div class="mb-4">
                <label for="query" class="block text-gray-700 font-medium mb-2">Masukkan Nama atau No. HP:</label>
                <input type="text" name="query" id="query" class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Nama atau No. HP" required>
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition">Cari</button>
        </form>
    </div>
</body>
</html>
