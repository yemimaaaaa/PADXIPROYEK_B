<!DOCTYPE html>
<html lang="en">
<head>
    <title>Profil Member</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white shadow-lg rounded-lg p-8 max-w-md w-full">
        <h2 class="text-2xl font-semibold text-center mb-4">Profil Member</h2>
        <p><strong>Nama:</strong> {{ $member->nama }}</p>
        <p><strong>No. HP:</strong> {{ $member->no_hp }}</p>
        <p><strong>Level Member:</strong> {{ $member->levelmember->tingkatan_level ?? 'Tidak Ada' }}</p>
        <p><strong>Periode Awal:</strong> {{ $member->periode_awal }}</p>
        <p><strong>Periode Akhir:</strong> {{ $member->periode_akhir }}</p>
        <div class="mt-4">
            <a href="/cek-member" class="block text-center bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">Cari Lagi</a>
        </div>
    </div>
</body>
</html>
