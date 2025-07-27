<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      Tambah Transaksi Barang
    </h2>
  </x-slot>

  <div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <form action="{{ route('transaksi.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-lg p-6 space-y-6">
          <!-- Operator / User -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label for="operator" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Operator</label>
              <select name="operator" id="operator"
                class="mt-1 block w-full rounded-md text-gray-300 border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm">
                @foreach($users as $user)
          <option value="{{ $user->id }}">{{ $user->name }}</option>
        @endforeach
              </select>
            </div>

            {{-- Kategori & Subkategori --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <label for="kategori_id"
                  class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kategori</label>
                <select name="kategori_id" id="kategori_id"
                  class="mt-1 block w-full rounded-md text-gray-300 border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm">
                  <option value="">-- Pilih Kategori --</option>
                  @foreach($kategoris as $kategori)
            <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
          @endforeach
                </select>
              </div>

              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                  <label for="sub_kategori_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sub
                    Kategori</label>
                  <select name="sub_kategori_id" id="sub_kategori_id"
                    class="mt-1 block w-full text-gray-300 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm"
                    onchange="setBatasHarga()">
                    <option value="">-- Pilih Sub Kategori --</option>
                    @foreach($subKategoris as $subKategori)
            <option value="{{ $subKategori->id }}" data-harga="{{ $subKategori->batas_harga }}">
              {{ $subKategori->nama_sub_kategori }}
            </option>
          @endforeach
                  </select>
                </div>

                {{-- Kolom Batas Harga --}}
                <div>
                  <label for="batas_harga" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Batas
                    Harga</label>
                  <input type="text" id="batas_harga"
                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-gray-300"
                    readonly>
                </div>
              </div>

            </div>

            {{-- Asal & Surat --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <label for="asal_barang" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Asal
                  Barang</label>
                <input type="text" name="asal_barang" id="asal_barang"
                  class="mt-1 block w-full rounded-md text-gray-300 border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm">
              </div>

              <div>
                <label for="nomor_surat" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nomor
                  Surat</label>
                <input type="text" name="nomor_surat" id="nomor_surat"
                  class="mt-1 block w-full rounded-md text-gray-300 border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm">
              </div>
            </div>

            {{-- Lampiran --}}
            <div>
              <label for="lampiran" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Lampiran
                (opsional)</label>
              <input type="file" name="lampiran" id="lampiran"
                class="mt-1 block w-full text-sm text-gray-900 dark:text-gray-200">
            </div>

            {{-- Detail Barang --}}
            <div class="pt-6 border-t border-gray-200 dark:border-gray-600">
              <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Detail Barang</h3>

              <table class="min-w-full border text-sm text-gray-800 dark:text-gray-200">
                <thead class="bg-gray-100 dark:bg-gray-700">
                  <tr>
                    <th class="px-4 py-2">Nama Barang</th>
                    <th class="px-4 py-2">Harga</th>
                    <th class="px-4 py-2">Jumlah</th>
                    <th class="px-4 py-2">Satuan</th>
                    <th class="px-4 py-2">Total</th>
                    <th class="px-4 py-2">Expired</th>
                    <th class="px-4 py-2">Aksi</th>
                  </tr>
                </thead>
                <tbody id="barang-table-body">
                  {{-- Baris barang dinamis akan di-generate via JS --}}
                </tbody>
              </table>

              <button type="button" onclick="addRow()"
                class="mt-4 inline-flex items-center px-3 py-2 bg-blue-600 text-white rounded shadow hover:bg-blue-700">
                + Tambah Barang
              </button>
            </div>

            <div class="flex justify-end">
              <x-primary-button>Simpan Transaksi</x-primary-button>
            </div>
          </div>
      </form>
    </div>
  </div>

  {{-- Template baris barang --}}
  <template id="row-template">
    <tr class="bg-white dark:bg-gray-800 border-t dark:border-gray-600">
      <td class="px-4 py-2">
        <input type="text" name="detail_barang[nama_barang][]"
          class="w-full bg-transparent text-gray-900  border border-gray-300 dark:border-gray-600 rounded">
      </td>
      <td class="px-4 py-2">
        <input type="number" name="detail_barang[harga][]"
          class="w-full bg-transparent text-gray-900  border border-gray-300 dark:border-gray-600 rounded"
          oninput="hitungTotal(this)">
      </td>
      <td class="px-4 py-2">
        <input type="number" name="detail_barang[jumlah][]"
          class="w-full bg-transparent text-gray-900  border border-gray-300 dark:border-gray-600 rounded"
          oninput="hitungTotal(this)">
      </td>
      <td class="px-4 py-2">
        <input type="text" name="detail_barang[satuan][]"
          class="w-full bg-transparent text-gray-900  border border-gray-300 dark:border-gray-600 rounded">
      </td>
      <td class="px-4 py-2">
        <input type="number" name="detail_barang[total][]"
          class="w-full bg-transparent text-gray-900  border border-gray-300 dark:border-gray-600 rounded" readonly>
      </td>
      <td class="px-4 py-2">
        <input type="date" name="detail_barang[tgl_expired][]"
          class="w-full bg-transparent text-gray-900  border border-gray-300 dark:border-gray-600 rounded">
      </td>
      <td class="px-4 py-2 text-center">
        <button type="button" onclick="hapusRow(this)" class="text-red-600 hover:text-red-800">Hapus</button>
      </td>
    </tr>
  </template>



  <script>
    $('#kategori_id').on('change', function () {
      let kategoriId = $(this).val();

      $.ajax({
        url: '/get-subkategori/' + kategoriId,
        method: 'GET',
        success: function (data) {
          let options = '<option value="">-- Pilih Sub Kategori --</option>';
          data.forEach(function (sub) {
            options += `<option value="${sub.id}" data-harga="${sub.batas_harga}">${sub.nama_sub_kategori}</option>`;
          });
          $('#sub_kategori_id').html(options);

          // rebind event onchange ke select baru
          document.querySelector('#sub_kategori_id').addEventListener('change', setBatasHarga);
        }
      });
    });

    function addRow() {
      const template = document.querySelector('#row-template').content.cloneNode(true);
      document.getElementById('barang-table-body').appendChild(template);
    }

    function hapusRow(button) {
      button.closest('tr').remove();
    }

    function hitungTotal(el) {
      const row = el.closest('tr');
      const harga = row.querySelector('[name="detail_barang[harga][]"]').value;
      const jumlah = row.querySelector('[name="detail_barang[jumlah][]"]').value;
      const total = row.querySelector('[name="detail_barang[total][]"]');
      total.value = (parseInt(harga) || 0) * (parseInt(jumlah) || 0);
    }

    function setBatasHarga() {
      const selected = document.querySelector('#sub_kategori_id option:checked');
      const batas = selected.getAttribute('data-harga') || '';
      document.getElementById('batas_harga').value = batas ? parseInt(batas).toLocaleString('id-ID') : '';
    }

    // Tambahan: Validasi harga input saat user isi
    document.addEventListener('input', function (e) {
      if (e.target.name === 'detail_barang[harga][]') {
        const row = e.target.closest('tr');
        const harga = parseInt(e.target.value) || 0;
        const batasHarga = parseInt(document.getElementById('batas_harga').value.replace(/[^\d]/g, ''));

        if (batasHarga && harga > batasHarga) {
          alert('Harga melebihi batas yang diizinkan!');
          e.target.value = batasHarga;
          e.target.focus();
        }

        hitungTotal(e.target); // pastikan total tetap dihitung
      }

      if (e.target.name === "detail_barang[harga][]") {
        let value = e.target.value.replace(/\D/g, "");
        value = new Intl.NumberFormat("id-ID").format(value);
        e.target.value = value;
      }
    });
  </script>
</x-app-layout>