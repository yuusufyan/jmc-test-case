<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      Barang Masuk
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      {{-- Card Container --}}
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">

          <div class="flex justify-between items-center mb-4">
            <h1 class="text-lg font-bold">Daftar Transaksi</h1>
            <a href="{{ route('transaksi.create') }}"
              class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
              + Tambah Transaksi
            </a>
          </div>

          @if (session('success'))
        <div class="mb-4 text-green-500 font-semibold">
        {{ session('success') }}
        </div>
      @endif

          <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-4">
            <table id="transaksiTable" class="table-auto w-full">
              <thead class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-100">
                <tr>
                  <th class="border px-6 py-3">No.</th>
                  <th class="border px-6 py-3">User</th>
                  <th class="border px-6 py-3">Kategori</th>
                  <th class="border px-6 py-3">Sub Kategori</th>
                  <th class="border px-6 py-3">Asal Barang</th>
                  <th class="border px-6 py-3">Nomor Surat</th>
                  <th class="border px-6 py-3">Tanggal</th>
                  <th class="border px-6 py-3">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($transaksis as $trx)
          <tr>
            <td class="border px-4 py-2">{{ $loop->iteration }}</td>
            <td class="border px-4 py-2">{{ $trx->user->name ?? '-' }}</td>
            <td class="border px-4 py-2">{{ $trx->kategori->nama_kategori ?? '-' }}</td>
            <td class="border px-4 py-2">{{ $trx->subKategori->nama_sub_kategori ?? '-' }}</td>
            <td class="border px-4 py-2">{{ $trx->asal_barang }}</td>
            <td class="border px-4 py-2">{{ $trx->nomor_surat ?? '-' }}</td>
            <td class="border px-4 py-2">{{ $trx->created_at->format('d M Y H:i') }}</td>
            <td class="border px-4 py-2">
            <a href="{{ route('transaksi.edit', $trx->id) }}" class="text-blue-400 hover:underline">✏️</a>

            <form action="{{ route('transaksi.destroy', $trx->id) }}" method="POST" class="inline">
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

  @push('scripts')
    <script>
    $(document).ready(function () {
      let table = $('#transaksiTable').DataTable({
      pageLength: 10,
      language: {
        search: "Cari:",
        searchPlaceholder: "Cari transaksi..."
      }
      });

      $('.dataTables_filter').addClass('mb-4').css({ 'display': 'block', 'color': 'white' });
      $('.dataTables_filter input')
      .addClass('p-2 rounded border border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-white');
    });
    </script>
  @endpush
</x-app-layout>