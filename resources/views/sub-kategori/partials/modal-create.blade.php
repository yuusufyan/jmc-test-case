<!-- Modal Tambah Sub Kategori -->
<div id="modalSubKategori" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center hidden z-50">
  <div class="bg-white dark:bg-gray-800 dark:text-white p-6 rounded shadow-lg w-full max-w-md">
    <h2 class="text-xl font-semibold mb-4">Tambah Sub Kategori</h2>
    <form action="{{ route('sub-kategori.store') }}" method="POST">
      @csrf

      <div class="mb-4">
        <label for="kategori_id" class="block text-sm font-medium">Kategori</label>
        <select name="kategori_id" id="kategori_id" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded p-2" required>
          @foreach($kategoriList as $kategori)
            <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
          @endforeach
        </select>
      </div>

      <div class="mb-4">
        <label for="nama_sub_kategori" class="block text-sm font-medium">Nama Sub Kategori</label>
        <input type="text" name="nama_sub_kategori" id="nama_sub_kategori"
          class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded p-2" maxlength="100" required>
      </div>

      <div class="mb-4">
        <label for="batas_harga" class="block text-sm font-medium">Batas Harga</label>
        <input type="text" name="batas_harga" id="batas_harga"
          class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded p-2" required>
      </div>

      <div class="flex justify-end gap-2">
        <button type="button" onclick="document.getElementById('modalSubKategori').classList.add('hidden')"
          class="bg-gray-400 text-white px-4 py-2 rounded">Batal</button>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan</button>
      </div>
    </form>
  </div>
</div>
