<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Aset') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <!-- Header -->
                <div
                    class="p-6 bg-gradient-to-r from-gray-700 via-gray-800 to-gray-900 text-white flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold">Riwayat Aset</h3>
                        <p class="text-sm mt-1">Lihat detail aset yang telah ditambahkan.</p>
                    </div>
                    <form action="{{ route('assets.index') }}" method="GET" class="flex items-center gap-4 w-1/2 p-4 rounded-lg shadow-md">
                        <!-- Search Input -->
                        <div class="w-2/3 relative">
                            <label for="search" class="sr-only">Pencarian</label>
                            <input type="text" id="search" name="search" placeholder="Cari berdasarkan kode, nama, jenis, atau kategori"
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 px-4 py-2 text-sm text-gray-900 bg-white placeholder-gray-500"
                                value="{{ request('search') }}" style="selection:bg-blue-500; selection:text-white;">
                        </div>

                        <!-- Submit Button -->
                        <button type="submit"
                            class="w-1/3 px-4 py-2 text-white bg-blue-500 rounded-lg shadow-sm hover:bg-blue-600 focus:ring-2 focus:ring-blue-500 focus:outline-none text-sm">
                            Cari
                        </button>
                    </form>




                    <div>
                        <button id="toggleForm"
                            class="px-6 py-2 bg-green-500 text-white rounded-lg text-sm font-semibold shadow-md hover:bg-green-600 transition">
                            Tambah Aset
                        </button>
                    </div>
                </div>
                <!-- Alert Messages -->
                @if (session('success'))
                    <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="p-4 mb-4 bg-red-100 text-red-700 rounded-md">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif


                <!-- Include Daftar Aset -->
                @include('pages.dashboard.asset.index')

                <!-- Include Form Tambah Aset -->
                @include('pages.dashboard.asset.create')


            </div>
        </div>
    </div>

    <script>
        const toggleFormButton = document.getElementById('toggleForm');
        const cancelFormButton = document.getElementById('cancelForm');
        const formTambah = document.getElementById('formTambah');
        const kontenDaftarAset = document.getElementById('kontenDaftarAset');

        toggleFormButton.addEventListener('click', () => {
            formTambah.classList.remove('hidden'); // Tampilkan form tambah
            kontenDaftarAset.classList.add('hidden'); // Sembunyikan daftar konten
        });

        cancelFormButton.addEventListener('click', () => {
            formTambah.classList.add('hidden'); // Sembunyikan form tambah
            kontenDaftarAset.classList.remove('hidden'); // Tampilkan daftar konten
        });
    </script>



    <script>
        // Fungsi untuk membuka modal dan mengisi data aset
        function openEditModal(asset) {
            const modalEdit = document.getElementById('modalEdit');
            const formEdit = document.getElementById('formEdit');

            // Menampilkan modal
            modalEdit.classList.remove('hidden');

            // Mengisi data form dengan data dari objek asset
            formEdit.action = `/assets/${asset.id}`; // Pastikan rute ini sesuai
            document.getElementById('edit_kode').value = asset.kode;
            document.getElementById('edit_nama_aset').value = asset.nama_aset;
            document.getElementById('edit_jenis_aset').value = asset.jenis_aset; // Pastikan nilai ini sesuai dengan data
            document.getElementById('edit_kategori').value = asset.kategori;
            document.getElementById('edit_deskripsi').value = asset.deskripsi;
            document.getElementById('edit_is_aktif').value = asset.is_aktif ? '1' : '0';
        }


        // Fungsi untuk menutup modal
        const cancelEdit = document.getElementById('cancelEdit');
        cancelEdit.addEventListener('click', () => {
            const modalEdit = document.getElementById('modalEdit');
            modalEdit.classList.add('hidden'); // Menyembunyikan modal
        });

        // Menutup modal jika klik di luar modal
        window.addEventListener('click', (e) => {
            const modalEdit = document.getElementById('modalEdit');
            if (e.target === modalEdit) {
                modalEdit.classList.add('hidden'); // Menyembunyikan modal
            }
        });
    </script>


</x-app-layout>
