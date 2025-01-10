<div id="formTambah" class="hidden p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-xl font-bold text-gray-800 mb-4">Tambah Asset</h2>

    <form action="{{ route('assets.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- Nama Asset -->
        <div>
            <label for="nama_aset" class="block text-sm font-medium text-gray-700">Nama Asset</label>
            <input type="text" name="nama_aset" id="nama_aset" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
        </div>

        <!-- Jenis Asset -->
        <div>
            <label for="jenis_aset" class="block text-sm font-medium text-gray-700">Jenis Asset</label>
            <select name="jenis_aset" id="jenis_aset" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                <option value="" disabled selected>Pilih Jenis Asset</option>
                <option value="Vector">Vector</option>
                <option value="Image">Image</option>
                <option value="Template">Template</option>
            </select>
        </div>

        <!-- Kategori -->
        <div>
            <label for="kategori" class="block text-sm font-medium text-gray-700">Kategori</label>
            <input type="text" name="kategori" id="kategori" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
        </div>

        <!-- Upload Gambar -->
        <div>
            <label for="gambar" class="block text-sm font-medium text-gray-700">Upload Gambar</label>
            <input type="file" name="gambar" id="gambar" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" required>
        </div>

        <!-- Upload File ZIP -->
        <div>
            <label for="file_zip" class="block text-sm font-medium text-gray-700">Upload File ZIP</label>
            <input type="file" name="file_zip" id="file_zip" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" required>
        </div>

        <!-- Deskripsi -->
        <div>
            <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required></textarea>
        </div>

        <!-- Tombol Simpan dan Batal -->
        <div class="flex justify-end space-x-4">
            <button type="button" id="cancelForm" class="px-6 py-2 bg-red-500 text-white font-semibold rounded-lg shadow-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                Batal
            </button>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Simpan
            </button>
        </div>
    </form>
</div>
