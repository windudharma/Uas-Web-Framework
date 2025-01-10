<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Download') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm rounded-lg mt-6">
                <div class="p-6">
                    <div class="space-y-0">
                        @forelse ($histories as $index => $history)
                            <div class="flex items-center p-4 {{ $index % 2 === 0 ? 'bg-gray-100' : 'bg-white' }}">
                                <!-- Gambar -->
                                <div class="flex-shrink-0">
                                    @if ($history->asset->gambar)
                                        <img src="{{ asset('storage/' . $history->asset->gambar) }}" alt="Thumbnail" class="w-24 h-24 rounded-lg object-cover">
                                    @else
                                        <div class="w-24 h-24 bg-gray-200 rounded-lg flex items-center justify-center">
                                            <span class="text-gray-500 text-sm">No Image</span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Informasi -->
                                <div class="ml-4 flex-1">
                                    <h4 class="text-lg font-semibold">{{ $history->asset->nama_aset ?? 'Tidak ada judul' }}</h4>
                                    <p class="text-sm text-gray-500">
                                        @if ($history->asset->kategori)
                                            Tipe Asset {{ $history->asset->jenis_aset }}
                                        @else
                                            <span>Tidak ada kategori</span>
                                        @endif
                                    </p>
                                </div>

                                <!-- Tanggal -->
                                <div class="text-center mx-auto">
                                    <p class="text-sm text-gray-500">
                                        {{ \Carbon\Carbon::parse($history->downloaded_at)->format('d M Y') }}
                                    </p>
                                </div>

                                <!-- Tombol Download -->
                                <div class="ml-4">
                                    @if ($history->asset->file_zip)
                                        <a href="{{ route('dashboard', ['download' => $history->asset->id]) }}" class="px-4 py-2 bg-green-500 text-white rounded-lg text-sm">
                                            Download
                                        </a>
                                    @else
                                        <span class="px-4 py-2 bg-gray-400 text-white rounded-lg text-sm">File Tidak Tersedia</span>
                                    @endif
                                </div>

                            </div>
                        @empty
                            <div class="text-center text-gray-500 py-4">Tidak ada data unduhan.</div>
                        @endforelse
                    </div>
                    <div class="mt-4">
                        {{ $histories->links() }} {{-- Pagination --}}
                    </div>
                </div>
            </div>






        </div>
    </div>
</x-app-layout>
