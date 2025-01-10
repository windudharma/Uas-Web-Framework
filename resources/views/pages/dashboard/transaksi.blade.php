<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Laporan Transaksi Membership') }}
            </h2>
            <!-- Tombol Download PDF -->
            <a id="download-pdf"
                href="{{ route('transaksi.export-pdf') }}"
                target="_blank"
                class="px-4 py-2 bg-red-500 text-white rounded-lg text-sm font-semibold shadow-md hover:bg-red-600 transition">
                Download PDF
            </a>
        </div>
    </x-slot>

    <div class="container mx-auto py-10">
        <!-- Kontainer Filter -->
        <div class="bg-white shadow-lg rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-6">Filter Data</h3>

            <!-- Filter Section -->
            <div class="flex items-center justify-between mb-6">
                <!-- Search Input dan Tombol PDF -->
                <div class="flex items-center gap-4 w-1/2">
                    <!-- Search Input -->
                    <div class="w-2/3">
                        <label for="search" class="sr-only">Pencarian</label>
                        <input type="text" id="search" placeholder="Cari..."
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 px-4 py-2 text-sm">
                    </div>

                </div>

                <!-- Dropdown Tahun dan Bulan -->
                <div class="flex items-center gap-4">
                    <!-- Dropdown Tahun -->
                    <div>
                        <label for="year_filter" class="sr-only">Tahun</label>
                        <select id="year_filter"
                            class="rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 px-3 py-2 text-sm">
                            <option value="">Pilih Tahun</option>
                            @for ($year = now()->year; $year >= now()->year - 10; $year--)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endfor
                        </select>
                    </div>

                    <!-- Dropdown Bulan -->
                    <div id="month_filter_wrapper" class="hidden">
                        <label for="month_filter" class="sr-only">Bulan</label>
                        <select id="month_filter"
                            class="rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 px-3 py-2 text-sm">
                            <option value="">Pilih Bulan</option>
                            @for ($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}">{{ \Carbon\Carbon::create()->month($i)->format('F') }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kontainer Tabel Transaksi -->
        <div id="transaction-table" class="mt-8 bg-white shadow-lg rounded-lg overflow-hidden">
            @include('pages.dashboard.partials.transaction_table', ['transactions' => $transactions])
        </div>

        </div>
    </div>

    <script>
        const yearFilter = document.getElementById('year_filter');
        const monthFilterWrapper = document.getElementById('month_filter_wrapper');
        const monthFilter = document.getElementById('month_filter');
        const downloadPdf = document.getElementById('download-pdf');

        yearFilter.addEventListener('change', function () {
            if (this.value) {
                monthFilterWrapper.classList.remove('hidden'); // Show month filter
                fetchTransactions(); // Fetch yearly data
            } else {
                monthFilterWrapper.classList.add('hidden'); // Hide month filter
            }
        });

        monthFilter.addEventListener('change', function () {
            fetchTransactions(); // Fetch monthly data
        });

        document.getElementById('search').addEventListener('input', fetchTransactions);

        function fetchTransactions() {
            const search = document.getElementById('search').value;
            const year_filter = yearFilter.value;
            const month_filter = monthFilter.value;

            const params = new URLSearchParams({
                search: search,
                year_filter: year_filter,
                month_filter: month_filter,
            });

            // Update the Download PDF link dynamically
            const pdfUrl = `{{ route('transaksi.export-pdf') }}?${params.toString()}`;
            downloadPdf.href = pdfUrl;

            fetch(`{{ route('transaksi') }}?${params.toString()}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
            })
                .then(response => response.json())
                .then(data => {
                    // Periksa jika data HTML kosong
                    if (data.html.trim() === '') {
                        document.getElementById('transaction-table').innerHTML = '<div class="p-6 text-center text-gray-500">Tidak ada data ditemukan.</div>';
                    } else {
                        document.getElementById('transaction-table').innerHTML = data.html;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('transaction-table').innerHTML = '<div class="p-6 text-center text-gray-500">Gagal memuat data.</div>';
                });
        }
    </script>
</x-app-layout>
