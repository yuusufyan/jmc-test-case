<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      Master Data Kategori
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      {{-- Card Container --}}
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">

          <div class="flex justify-between items-center mb-4">
            <h1 class="text-lg font-bold">Daftar Kategori</h1>
            <button onclick="document.getElementById('modalKategori').classList.remove('hidden')"
              class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
              + Tambah Kategori
            </button>
          </div>

          <div class="overflow-x-auto">
            <table id="kategoriTable" class="display w-full text-base text-left">
              <thead class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-100">
                <tr>
                  <th class="border px-6 py-3">No.</th>
                  <th class="border px-6 py-3">Kode</th>
                  <th class="border px-6 py-3">Nama Kategori</th>
                  <th class="border px-6 py-3">Dibuat Oleh</th>
                  <th class="border px-6 py-3">Terakhir Diedit</th>
                  <th class="border px-6 py-3">Dibuat Tanggal</th>
                  <th class="border px-6 py-3">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($kategoris as $kategori)
          <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
            <td class="border px-6 py-4">{{ $loop->iteration }}</td>
            <td class="border px-6 py-4">{{ $kategori->kode_kategori }}</td>
            <td class="border px-6 py-4">{{ $kategori->nama_kategori }}</td>
            <td class="border px-6 py-4">{{ optional($kategori->creator)->name ?? '-' }}</td>
            <td class="border px-6 py-4">{{ optional($kategori->updater)->name ?? '-' }}</td>
            <td class="border px-6 py-4">{{ $kategori->created_at->format('d M Y H:i') }}</td>
            <td class="whitespace-nowrap border px-6 py-4">
            <a href="#" onclick='openEditModal(@json($kategori))' class="text-blue-400 hover:underline">✏️</a>
            <form action="{{ route('kategori.destroy', $kategori->id) }}" method="POST" class="inline">
              @csrf @method('DELETE')
              <button type="submit" onclick="return confirm('Yakin hapus?')"
              class="text-red-400 hover:underline ml-2">🗑️</button>
            </form>
            </td>
          </tr>
        @endforeach
              </tbody>
            </table>

            <!-- <div class="mt-4">
              <label for="customFilter" class="block text-sm font-medium mb-1 dark:text-white">Filter Nama
                Kategori:</label>
              <input type="text" id="customFilter"
                class="w-full max-w-sm p-2 rounded border border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-white"
                placeholder="Tulis nama kategori...">
            </div> -->
          </div>

        </div>
      </div>
    </div>
  </div>

  <!-- Modal Tambah -->
  @include('kategori.partials.modal-create')
  <!-- Modal Edit -->
  @include('kategori.partials.modal-edit')

</x-app-layout>

<script>
  window.openEditModal = function (kategori) {
    console.log("👉 Dapet kategori:", kategori);
    $('#edit_id').val(kategori.id);
    $('#edit_kode_kategori').val(kategori.kode_kategori);
    $('#edit_nama_kategori').val(kategori.nama_kategori);
    $('#formEditKategori').attr('action', `/kategori/${kategori.id}`);
    document.getElementById('modalEditKategori').classList.remove('hidden');
  }

  $(document).ready(function () {
    let table = $('#kategoriTable').DataTable({
      pageLength: 10,
      language: {
        search: "Cari:",
        searchPlaceholder: "Cari kategori..."
      }
    });

    // Styling bawaan DataTable
    $('.dataTables_filter').addClass('mb-4').css({ 'display': 'block', 'color': 'white' });
    $('.dataTables_filter input')
      .addClass('p-2 rounded border border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-white');

    // 🧠 Filter tambahan berdasarkan nama kategori
    $('#customFilter').on('keyup', function () {
      table.column(2).search(this.value).draw(); // kolom ke-2 (index 2) = nama kategori
    });
  });
</script>