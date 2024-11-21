<html>
  <head>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Allerta&display=swap" rel="stylesheet" />
    <style>
      body {
        font-family: 'Allerta', sans-serif;
      }
    </style>
  </head>
  <body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white p-10 rounded-xl shadow-2xl w-full max-w-2xl">
      <!-- Bagian Pegawai -->
      <div class="flex items-center justify-between mb-6">
        <div class="text-lg font-small text-gray-600">
          <span>Pengelola: </span>
          <span class="font-small text-blue-400">{{ auth()->user()->nama }}</span>
        </div>
        <div class="bg-blue-100 text-blue-500 px-2 py-2 rounded-lg text-sm">
          ID Pegawai: {{ auth()->user()->id_pegawai }}
        </div>
      </div>

      <h1 class="text-4xl font-semibold text-center text-gray-800 mb-6">Tambah Data Stok</h1>
      <!-- Form mulai di sini -->
      <form action="{{ route('stok.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
          <!-- ID Stok -->
          {{-- <div class="flex flex-col">
            <label class="font-medium text-gray-700 mb-2">ID Stok:</label>
            <input 
              class="border border-gray-300 rounded-lg py-3 px-4 focus:outline-none focus:ring-2 focus:ring-blue-500" 
              type="text" 
              name="id_stok" 
              placeholder="Masukkan ID Stok" 
              required />
          </div> --}}

          <!-- Nama Stok -->
          <div class="flex flex-col">
            <label class="font-medium text-gray-700 mb-2">Nama Stok:</label>
            <input 
              class="border border-gray-300 rounded-lg py-3 px-4 focus:outline-none focus:ring-2 focus:ring-blue-500" 
              type="text" 
              name="nama_stok" 
              placeholder="Masukkan Nama Stok" 
              required />
          </div>

          <!-- Jenis Stok -->
          <div class="flex flex-col">
            <label for="jenis_Stok" class="font-medium text-gray-700 mb-2">Jenis Stok:</label>
            <select 
              name="jenis_stok" 
              id="jenis_stok" 
              class="border border-gray-300 rounded-lg py-3 px-4 focus:outline-none focus:ring-2 focus:ring-blue-500" 
              required>
              <option value="biji kopi">Biji Kopi</option>
              <option value="bahan pokok">Bahan Pokok</option>
              <option value="bahan campuran">Bahan Campuran</option>
              <option value="snack">Snack</option>
              <option value="minuman">Minuman</option>
            </select>
          </div>

          <!-- Tanggal Masuk -->
          <div class="flex flex-col">
            <label class="font-medium text-gray-700 mb-2">Tanggal Masuk Stok:</label>
            <input 
                class="border border-gray-300 rounded-lg py-3 px-4 focus:outline-none focus:ring-2 focus:ring-green-500 bg-green-50" 
                type="date" 
                name="tanggal_masuk_stok" 
                required />
          </div>
      
          <!-- Detail Stok -->
          <div class="flex flex-col lg:col-span-2">
            <label class="font-medium text-gray-700 mb-2">Detail Stok:</label>
            <textarea 
              class="border border-gray-300 rounded-lg py-3 px-4 focus:outline-none focus:ring-2 focus:ring-blue-500 h-32" 
              name="detail_stok" 
              placeholder="Masukkan Detail Stok"></textarea>
          </div>

          <!-- Foto Stok -->
            <div class="flex flex-col lg:col-span-2">
              <label class="font-medium text-gray-700 mb-2">Foto Stok:</label>
              <input 
                  class="border border-gray-300 rounded-lg py-3 px-4 focus:outline-none focus:ring-2 focus:ring-purple-500" 
                  type="file" 
                  name="foto_stok" 
                  required />
              @error('foto_stok')
                  <span class="text-red-500 text-sm mt-2">{{ $message }}</span>
              @enderror
            </div>

          <!-- Hidden Field for ID Pegawai -->
          <input type="hidden" name="id_pegawai" value="{{ auth()->user()->id_pegawai }}" />
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-between mt-8">
          <!-- Tombol Simpan -->
          <button 
            type="submit" 
            class="bg-blue-600 hover:bg-blue-700 text-white py-3 px-8 rounded-lg shadow-md transition duration-300 focus:outline-none focus:ring-2 focus:ring-blue-400">
            Simpan
          </button>

          <!-- Tombol Batal -->
          <a 
            href="/stok" 
            class="bg-gray-300 hover:bg-gray-400 text-gray-800 py-3 px-8 rounded-lg shadow-md transition duration-300 focus:outline-none focus:ring-2 focus:ring-gray-200">
            Batal
          </a>
        </div>
      </form>
    </div>
  </body>
</html>