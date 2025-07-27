<!-- Modal Edit Kategori -->
<div id="modalEditKategori" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center hidden z-50">
  <div class="bg-white dark:bg-gray-800 dark:text-white p-6 rounded shadow-lg w-full max-w-md">
    <h2 class="text-xl font-semibold mb-4">Edit Kategori</h2>
    <form id="formEditKategori" method="POST">
      @csrf
      @method('PUT')
      <input type="hidden" name="id" id="edit_id">
      <div class="mb-4">
        <label for="edit_kode_kategori" class="block text-sm font-medium">Kode Kategori</label>
        <input type="text" name="kode_kategori" id="edit_kode_kategori"
          class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded p-2" required>
      </div>
      <div class="mb-4">
        <label for="edit_nama_kategori" class="block text-sm font-medium">Nama Kategori</label>
        <input type="text" name="nama_kategori" id="edit_nama_kategori"
          class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded p-2" required>
      </div>
      <div class="flex justify-end gap-2">
        <button type="button" onclick="document.getElementById('modalEditKategori').classList.add('hidden')"
          class="bg-gray-400 text-white px-4 py-2 rounded">Batal</button>
        <button type="submit"
          class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan</button>
      </div>
    </form>
  </div>
</div>
