<div id="kontenDaftarAset" class="p-6 space-y-4">
    @forelse ($assets as $index => $asset)
        <div class="flex items-center p-4 rounded-lg shadow-sm {{ $index % 2 === 0 ? 'bg-gray-50' : 'bg-white' }}">
            <!-- Gambar -->
            <div class="flex-shrink-0 w-24 h-24">
                @if ($asset->gambar)
                    <img src="{{ asset('storage/' . $asset->gambar) }}" alt="Thumbnail"
                        class="w-full h-full rounded-lg object-cover">
                @else
                    <div class="w-full h-full bg-gray-200 rounded-lg flex items-center justify-center">
                        <span class="text-gray-500 text-sm">No Image</span>
                    </div>
                @endif
            </div>

            <!-- Informasi -->
            <div class="ml-4 flex-1">
                <h4 class="text-lg font-semibold text-gray-800">{{ $asset->nama_aset ?? 'Tidak ada nama aset' }}</h4>
                <p class="text-sm text-gray-600 mt-1">
                    {{ $asset->deskripsi ?? 'Tidak ada deskripsi' }}
                </p>
                <p class="text-sm text-gray-500 mt-1">
                    Jenis: <span class="font-medium text-gray-700">{{ $asset->jenis_aset ?? 'Tidak ada jenis' }}</span>
                </p>
            </div>

            <div class="text-left mx-auto">
                @if ($asset->is_aktif == 1)
                    <!-- Tombol Hijau untuk Aktif -->
                    <button class="px-4 py-2 bg-green-500 text-white rounded-lg text-sm font-semibold hover:bg-green-600">
                        Aktif
                    </button>
                @else
                    <!-- Tombol Merah untuk Nonaktif -->
                    <button class="px-4 py-2 bg-red-500 text-white rounded-lg text-sm font-semibold hover:bg-red-600">
                        Nonaktif
                    </button>
                @endif
            </div>


            <!-- Aksi -->
            <div class="ml-4 flex space-x-2">
                <a href="javascript:void(0)" onclick="openEditModal({{ $asset }})"
                class="px-4 py-2 bg-blue-500 text-white rounded-lg text-sm shadow-md hover:bg-blue-600">
                 Edit
             </a>

            </div>
        </div>
    @empty
        <div class="text-center text-gray-500 py-4">
            Tidak ada data aset.
        </div>
    @endforelse
    <!-- Pagination -->
    <div class="mt-4 px-6">
        {{ $assets->links() }}
    </div>
</div>

<!-- Modal Edit Aset -->
<div id="modalEdit" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white w-full max-w-lg rounded-lg shadow-md p-6">
        <h2 class="text-xl font-bold mb-4 text-gray-800">Edit Asset</h2>

        <form id="formEdit" action="#" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Kode Asset -->
            <div>
                <label for="edit_kode" class="block text-sm font-medium text-gray-700">Kode Asset</label>
                <input type="text" name="kode" id="edit_kode" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
            </div>

            <!-- Nama Asset -->
            <div>
                <label for="edit_nama_aset" class="block text-sm font-medium text-gray-700">Nama Asset</label>
                <input type="text" name="nama_aset" id="edit_nama_aset" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
            </div>

            <!-- Jenis Asset -->
            <div>
                <label for="edit_jenis_aset" class="block text-sm font-medium text-gray-700">Jenis Asset</label>
                <select name="jenis_aset" id="edit_jenis_aset" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    <option value="" disabled>Pilih Jenis Asset</option>
                    <option value="Vector">Vector</option>
                    <option value="Image">Image</option>
                    <option value="Template">Template</option>
                </select>
            </div>

            <!-- Kategori -->
            <div>
                <label for="edit_kategori" class="block text-sm font-medium text-gray-700">Kategori</label>
                <input type="text" name="kategori" id="edit_kategori" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
            </div>

            <!-- Upload Gambar -->
            <div>
                <label for="edit_gambar" class="block text-sm font-medium text-gray-700">Upload Gambar</label>
                <input type="file" name="gambar" id="edit_gambar" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            </div>

            <!-- Upload File ZIP -->
            <div>
                <label for="edit_file_zip" class="block text-sm font-medium text-gray-700">Upload File ZIP</label>
                <input type="file" name="file_zip" id="edit_file_zip" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            </div>

            <!-- Deskripsi -->
            <div>
                <label for="edit_deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea name="deskripsi" id="edit_deskripsi" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" required></textarea>
            </div>

            <!-- Status Aktif -->
            <div>
                <label for="edit_is_aktif" class="block text-sm font-medium text-gray-700">Status Aktif</label>
                <select name="is_aktif" id="edit_is_aktif" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    <option value="1">Aktif</option>
                    <option value="0">Nonaktif</option>
                </select>
            </div>

            <!-- Tombol Simpan dan Batal -->
            <div class="flex justify-end space-x-4">
                <button type="button" id="cancelEdit" class="px-6 py-2 bg-red-500 text-white font-semibold rounded-lg hover:bg-red-600 focus:outline-none">Batal</button>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 focus:outline-none">Simpan</button>
            </div>
        </form>
    </div>
</div>

