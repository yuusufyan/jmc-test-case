<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      Master Data Sub Kategori
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      {{-- Card Container --}}
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">

          <div class="flex justify-between items-center mb-4">
            <h1 class="text-lg font-bold">Daftar Sub Kategori</h1>
            <button onclick="document.getElementById('modalSubKategori').classList.remove('hidden')"
              class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
              + Tambah Sub Kategori
            </button>
          </div>

          <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-4">
            <table id="subKategoriTable" class="table-auto w-full">
              <thead class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-100">
                <tr>
                  <th class="border px-6 py-3">No.</th>
                  <th class="border px-6 py-3">Nama Sub Kategori</th>
                  <th class="border px-6 py-3">Kategori</th>
                  <th class="border px-6 py-3">Batas Harga</th>
                  <th class="border px-6 py-3">Dibuat Oleh</th>
                  <th class="border px-6 py-3">Terakhir Diedit</th>
                  <th class="border px-6 py-3">Dibuat Tanggal</th>
                  <th class="border px-6 py-3">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($subKategoris as $subKategori)
          <tr>
            <td class="border px-4 py-2">{{ $loop->iteration }}</td>
            <td class="border px-4 py-2">{{ $subKategori->nama_sub_kategori }}</td>
            <td class="border px-4 py-2">{{ $subKategori->kategori->nama_kategori }}</td>
            <td class="border px-4 py-2">{{ number_format($subKategori->batas_harga, 0, ',', '.') }}</td>
            <td class="border px-6 py-4">{{ optional($subKategori->creator)->name ?? '-' }}</td>
            <td class="border px-6 py-4">{{ optional($subKategori->updater)->name ?? '-' }}</td>
            <td class="border px-6 py-4">{{ $subKategori->created_at->format('d M Y H:i') }}</td>
            <td class="border px-4 py-2">
            <a href="#" onclick='openEditModal(@json($subKategori))'
              class="text-blue-400 hover:underline">✏️</a>

            <form action="{{ route('sub-kategori.destroy', $subKategori->id) }}" method="POST" class="inline">
              @csrf @method('DELETE')
              <button type="submit" onclick="return confirm('Yakin hapus?')"
              class="text-red-400 hover:underline ml-2">🗑️</button>
            </form>
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

  <!-- Modal Tambah -->
  @include('sub-kategori.partials.modal-create')
  <!-- Modal Tambah -->
  @include('sub-kategori.partials.modal-edit')
</x-app-layout>

<script>
  window.openEditModal = function (subKategori) {
    console.log("👉 Dapet sub kategori:", subKategori);
    $('#edit_sub_id').val(subKategori.id);
    $('#edit_nama_sub_kategori').val(subKategori.nama_sub_kategori);
    $('#edit_kategori_id').val(subKategori.kategori_id);

    let formatted = new Intl.NumberFormat("id-ID").format(subKategori.batas_harga);
    $('#edit_batas_harga').val(formatted);

    $('#formEditSubKategori').attr('action', `/sub-kategori/${subKategori.id}`);
    document.getElementById('modalEditSubKategori').classList.remove('hidden');
  }

  $(document).ready(function () {
    let table = $('#subKategoriTable').DataTable({
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

  document.addEventListener("input", function (e) {
    if (e.target.name === "batas_harga") {
      let value = e.target.value.replace(/\D/g, "");
      value = new Intl.NumberFormat("id-ID").format(value);
      e.target.value = value;
    }
  });
</script>

<!-- @push('scripts')
  <script>
    $(document).ready(function () {
    $('#subKategoriTable').DataTable();
    });
  </script>
@endpush -->