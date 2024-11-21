<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-roboto">
    <div class="container mx-auto mt-8">
        <h2 class="text-2xl font-bold mb-4 text-center">Daftar Member</h2>
        <table class="table-auto w-full border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="px-4 py-2">Nama</th>
                    <th class="px-4 py-2">No HP</th>
                    <th class="px-4 py-2">Periode Awal</th>
                    <th class="px-4 py-2">Periode Akhir</th>
                    <th class="px-4 py-2">Level Member</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($members as $member)
                    <tr>
                        <td class="border px-4 py-2">{{ $member->nama }}</td>
                        <td class="border px-4 py-2">{{ $member->no_hp }}</td>
                        <td class="border px-4 py-2">{{ $member->periode_awal }}</td>
                        <td class="border px-4 py-2">{{ $member->periode_akhir }}</td>
                        <td class="border px-4 py-2">{{ $member->level->tingkatan_level ?? 'N/A' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
