<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Checkout Paket</title>
  <!-- Memanggil CSS Bootstrap -->
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
  />
  <!-- (Opsional) Memanggil Bootstrap Icons untuk ikon yang lebih menarik -->
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"
  />
</head>
<body>

<!-- Bagian Utama -->
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <!-- Judul Halaman -->
      <h1 class="text-center mb-4">Checkout Paket</h1>

      <!-- Kartu Paket -->
      <div class="card shadow">
        <div class="card-header bg-primary text-white text-center">
          <h2 class="mb-0">Paket Premium</h2>
        </div>
        <div class="card-body">
          <h5 class="text-center mb-3">Fitur yang Anda Dapatkan</h5>
          <ul class="list-group list-group-flush mb-3">
            <li class="list-group-item d-flex align-items-center">
              <i class="bi bi-check-circle-fill text-success me-2"></i>
              Akses Semua Konten
            </li>
            <li class="list-group-item d-flex align-items-center">
              <i class="bi bi-check-circle-fill text-success me-2"></i>
              10 Download / Hari
            </li>
            <li class="list-group-item d-flex align-items-center">
              <i class="bi bi-check-circle-fill text-success me-2"></i>
              Masa Aktif 30 Hari
            </li>
          </ul>

          <!-- Total Harga -->
          <div class="text-center mb-4">
            <h4 class="fw-bold">Total Harga: Rp 100.000</h4>
          </div>

          <!-- Tombol Checkout -->
          <div class="d-grid">
            <button class="btn btn-success btn-lg">
              <i class="bi bi-credit-card-fill me-1"></i>
              Checkout Sekarang
            </button>
          </div>
        </div>
      </div>
      <!-- Akhir Kartu Paket -->

    </div>
  </div>
</div>

<!-- Memanggil JS Bootstrap (opsional) -->
<script
  src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
></script>

</body>
</html>
