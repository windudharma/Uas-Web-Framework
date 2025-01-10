// Ambil semua gambar yang dapat diklik
const clickableImages = document.querySelectorAll(".clickable-image");

// Menyimpan URL asli
let previousUrl = window.location.href;

// Fungsi untuk membuka modal dengan gambar yang diklik
clickableImages.forEach(image => {
    image.addEventListener("click", function() {
        const modalId = image.getAttribute("data-target"); // Ambil ID modal dari data-target
        const modal = document.querySelector(modalId); // Cari modal berdasarkan ID yang dinamis
        const modalImage = modal.querySelector(".main-image");

        const imageUrl = image.src;
        const imageAlt = image.alt;
        const assetId = image.getAttribute("data-id");
        const assetName = image.getAttribute("data-nama"); // Nama aset yang sudah di-`slug`

        // Set gambar modal dan deskripsi
        modalImage.src = imageUrl;
        modalImage.alt = imageAlt;

        // Tampilkan modal
        modal.style.display = "flex";

        // Ubah URL di browser tanpa memuat ulang halaman
        const newUrl = `/aset/${assetId}/${assetName}`;
        window.history.pushState({
            path: newUrl
        }, "", newUrl);
    });
});


// Fungsi untuk menutup modal
const closeBtns = document.querySelectorAll(".close-btn");
closeBtns.forEach(btn => {
    btn.addEventListener("click", function() {
        const modal = btn.closest(".modal");
        modal.style.display = "none";

        // Kembalikan URL ke kondisi semula setelah menutup modal
        window.history.pushState({
            path: previousUrl
        }, "", previousUrl);
    });
});

// Fungsi untuk menutup modal jika klik di luar area modal
window.addEventListener("click", function(event) {
    if (event.target.classList.contains("modal")) {
        const modal = event.target;
        modal.style.display = "none";

        // Kembalikan URL ke kondisi semula setelah menutup modal
        window.history.pushState({
            path: previousUrl
        }, "", previousUrl);
    }
});





document.addEventListener('DOMContentLoaded', function() {
    // Ambil semua gambar pada halaman yang ingin dihitung warna dominannya
    const images = document.querySelectorAll('.image-with-dominant-color');

    // Fungsi untuk mendapatkan warna dominan
    function getDominantColor(img) {
        const canvas = document.createElement('canvas');
        const context = canvas.getContext('2d');

        canvas.width = img.width;
        canvas.height = img.height;
        context.drawImage(img, 0, 0, canvas.width, canvas.height);

        const imageData = context.getImageData(0, 0, canvas.width, canvas.height);
        const pixels = imageData.data;

        let colorCount = {};
        let dominantColor = [0, 0, 0];
        let maxCount = 0;

        for (let i = 0; i < pixels.length; i += 4) {
            const r = pixels[i];
            const g = pixels[i + 1];
            const b = pixels[i + 2];
            const color = `${r},${g},${b}`;

            colorCount[color] = (colorCount[color] || 0) + 1;
            if (colorCount[color] > maxCount) {
                maxCount = colorCount[color];
                dominantColor = [r, g, b];
            }
        }

        return `rgb(${dominantColor[0]}, ${dominantColor[1]}, ${dominantColor[2]})`;
    }

    // Hitung warna dominan untuk setiap gambar yang ada di halaman
    images.forEach(image => {
        const tempImg = new Image();
        tempImg.crossOrigin = 'Anonymous'; // Tambahkan untuk gambar eksternal
        tempImg.src = image.src;
        tempImg.onload = () => {
            const dominantColor = getDominantColor(tempImg);
            image.style.backgroundColor = dominantColor; // Set warna latar belakang gambar
        };
    });
});






document.getElementById('download-form').addEventListener('submit', function (e) {
e.preventDefault();

const isLoggedIn = "{{ auth()->check() }}"; // Periksa apakah pengguna login
const messageDiv = document.getElementById('message');

if (!isLoggedIn) {
messageDiv.style.display = 'block';
messageDiv.textContent = 'Anda harus login terlebih dahulu untuk mengunduh file.';
return;
}

this.submit(); // Lanjutkan form jika pengguna sudah login
});

