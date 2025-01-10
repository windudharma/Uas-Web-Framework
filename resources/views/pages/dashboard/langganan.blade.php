<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Membership') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Kontainer Detail Membership -->
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <!-- Header -->
                <div class="p-6 bg-gradient-to-r from-purple-500 via-indigo-500 to-blue-500 text-white relative">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold">Langganan Membership</h3>
                            <p class="text-sm mt-1">Detail paket langganan Anda.</p>
                        </div>
                        <div class="flex space-x-3">
                            <!-- Tombol Upgrade Paket jika ada langganan aktif -->
                            @if ($activeMembership)
                                <a href="/#price"
                                    class="px-4 py-2 bg-orange-600 text-white text-sm font-semibold rounded-lg hover:bg-orange-700 transition shadow-md">
                                    Upgrade Paket
                                </a>
                                <!-- Tombol Perpanjangan jika ada langganan aktif -->
                                <a href="{{ route('membership.checkout', $activeMembership->membership_id) }}"
                                    class="px-4 py-2 bg-yellow-500 text-white text-sm font-semibold rounded-lg hover:bg-yellow-600 transition shadow-md">
                                    Perpanjangan
                                </a>
                            @else
                                <!-- Tombol Berlangganan Sekarang jika tidak ada langganan aktif -->
                                <a href="/#price"
                                    class="px-4 py-2 bg-orange-600 text-white text-sm font-semibold rounded-lg hover:bg-orange-700 transition shadow-md">
                                    Berlangganan Sekarang
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Cek apakah ada langganan aktif -->
                @if ($activeMembership)
                    <!-- Konten -->
                    <div class="p-6 space-y-6">
                        <!-- Detail Membership -->
                        <div class="flex items-center">
                            <div
                                class="w-16 h-16 bg-gradient-to-r from-green-400 to-green-600 text-white flex items-center justify-center rounded-lg shadow-md">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c1.656 0 3-1.344 3-3s-1.344-3-3-3-3 1.344-3 3 1.344 3 3 3zM15 14H9l-1.5 5H16.5l-1.5-5z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-semibold text-gray-800">
                                    {{ $activeMembership->membership->name ?? 'Belum Ada Membership' }}</h4>
                                <p class="text-sm text-gray-500">Nikmati akses penuh tanpa batas!</p>
                            </div>
                        </div>

                        <!-- Aktif Hingga -->
                        <div class="flex items-center">
                            <div
                                class="w-16 h-16 bg-gradient-to-r from-blue-400 to-blue-600 text-white flex items-center justify-center rounded-lg shadow-md">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 4a9 9 0 0118 0v10a9 9 0 01-18 0V7z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-semibold text-gray-800">Aktif Hingga</h4>
                                <p class="text-sm text-gray-500">
                                    {{ $activeMembership->end_date ? $activeMembership->end_date->format('d M Y') : '-' }}
                                </p>
                            </div>
                        </div>

                        <!-- Batas Download Harian -->
                        <div class="flex items-center">
                            <div
                                class="w-16 h-16 bg-gradient-to-r from-red-400 to-red-600 text-white flex items-center justify-center rounded-lg shadow-md">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l6 6 6-6m-6-6v12" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-semibold text-gray-800">Batas Download Harian</h4>
                                <p class="text-sm text-gray-500">{{ $activeMembership->downloads_today ?? 0 }} dari
                                    {{ $activeMembership->membership->daily_limit ?? 0 }} unduhan tersedia</p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="p-6 text-center">
                        <p class="text-lg font-semibold text-gray-800">Saat ini, Anda tidak memiliki langganan yang aktif.</p>
                    </div>
                @endif
            </div>

            <!-- Kontainer Riwayat Transaksi -->
            <div class="bg-white shadow-lg rounded-lg overflow-hidden mt-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Riwayat Transaksi Anda</h3>
                    @if (!empty($transactions) && $transactions->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full table-auto border-collapse border border-gray-300">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th
                                            class="px-4 py-2 border border-gray-300 text-center text-sm font-bold text-gray-700 whitespace-nowrap">
                                            Paket</th>
                                        <th
                                            class="px-4 py-2 border border-gray-300 text-center text-sm font-bold text-gray-700 whitespace-nowrap">
                                            Jenis Transaksi</th>
                                        <th
                                            class="px-4 py-2 border border-gray-300 text-center text-sm font-bold text-gray-700 whitespace-nowrap">
                                            Waktu</th>
                                        <th
                                            class="px-4 py-2 border border-gray-300 text-center text-sm font-bold text-gray-700 whitespace-nowrap">
                                            Harga</th>
                                        <th
                                            class="px-4 py-2 border border-gray-300 text-center text-sm font-bold text-gray-700 whitespace-nowrap">
                                            Durasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transactions as $transaction)
                                        <tr class="{{ $loop->even ? 'bg-gray-50' : 'bg-white' }}">
                                            <td
                                                class="px-4 py-2 border border-gray-300 text-center text-sm text-gray-600 whitespace-nowrap">
                                                {{ $transaction->membership->name }}</td>
                                            <td
                                                class="px-4 py-2 border border-gray-300 text-center text-sm text-gray-600 whitespace-nowrap">
                                                {{ ucfirst($transaction->transaction_type) }}</td>
                                            <td
                                                class="px-4 py-2 border border-gray-300 text-center text-sm text-gray-600 whitespace-nowrap">
                                                {{ $transaction->created_at->format('d M Y H:i') }}</td>
                                            <td
                                                class="px-4 py-2 border border-gray-300 text-center text-sm text-gray-600 whitespace-nowrap">
                                                Rp {{ number_format($transaction->amount_paid, 0, ',', '.') }}</td>
                                            <td
                                                class="px-4 py-2 border border-gray-300 text-center text-sm text-gray-600 whitespace-nowrap">
                                                {{ $transaction->start_date->format('d M Y') }} -
                                                {{ $transaction->end_date->format('d M Y') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $transactions->links() }} {{-- Pagination --}}
                        </div>
                    @else
                        <p class="text-gray-500">Belum ada transaksi.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
