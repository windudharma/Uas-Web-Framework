<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="profile-form" method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')

<!-- Input Foto Profil -->
<div class="space-y-4">
<!-- Container Foto dan Tombol -->
<div class="flex items-center space-x-4">
    <!-- Foto Hasil Crop -->
    <img
    id="profile-photo-result"
    src="{{ $user->profile_photo_url }}"
    alt="Foto Profil"
    class="w-24 h-24 rounded-full shadow-lg ring-2 ring-blue-200"/>


    <!-- Tombol "Choose a photo" -->
    <div class="flex justify-start">
        <label
            for="profile_photo"
            class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium text-sm rounded-lg shadow-md hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-offset-2 cursor-pointer transition duration-200"
        >
            Choose a photo
        </label>
        <input
            id="profile_photo"
            name="profile_photo"
            type="file"
            class="hidden"
            accept="image/*"
            onchange="previewImage(event)"
        />
    </div>
</div>


<!-- Preview Foto Setelah Upload -->
<div id="crop-container" class="mt-4 flex justify-center">
    <img id="profile-photo-preview" class="w-32 h-32 rounded-full shadow-md hidden" alt="Preview Foto Profil" />
</div>

<!-- Tombol Crop -->
<button
    type="button"
    id="crop-button"
    class="mt-2 px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-300 transition duration-200 hidden"
>
    Crop
</button>


<x-input-error class="mt-2" :messages="$errors->get('profile_photo')" />

<!-- Foto Profil Tersimpan -->
<div class="mt-6 flex justify-center hidden"> <!-- Tambahkan "hidden" -->
    <img
        id="profile-photo-result"
        src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : asset('images/default-avatar.png') }}"
        alt="Foto Profil"
        class="w-24 h-24 rounded-full shadow-lg ring-4 ring-blue-100"
    >
</div>




        <!-- Input Nama -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <!-- Input Email -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        <!-- Tombol Simpan -->
        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet" />

<script>
let cropper;
let croppedBlob; // Simpan hasil crop di sini

function previewImage(event) {
    const file = event.target.files[0];

    if (!file) return; // Pastikan file ada

    const reader = new FileReader();

    reader.onload = function (e) {
        const preview = document.getElementById('profile-photo-preview');
        preview.src = e.target.result;

        // Pastikan gambar preview tampil setelah diupload
        preview.classList.remove('hidden');

        // Menampilkan tombol crop setelah gambar dipilih
        const cropButton = document.getElementById('crop-button');
        cropButton.classList.remove('hidden'); // Hapus 'hidden' untuk tombol crop

        if (cropper) cropper.destroy(); // Reset Cropper jika sudah ada instance sebelumnya

        cropper = new Cropper(preview, {
            aspectRatio: 1, // Rasio persegi
            viewMode: 2,
        });
    };

    reader.readAsDataURL(file); // Membaca file dan menampilkan preview
}

document.getElementById('crop-button').addEventListener('click', function () {
    if (cropper) {
        cropper.getCroppedCanvas({
            width: 128, // Ukuran hasil crop
            height: 128, // Agar sesuai lingkaran kecil
        }).toBlob(blob => {
            croppedBlob = blob; // Simpan hasil crop

            // Ganti foto hasil crop
            const resultImage = document.getElementById('profile-photo-result');
            const croppedUrl = URL.createObjectURL(croppedBlob);
            resultImage.src = croppedUrl; // Mengganti src elemen gambar dengan hasil crop

            // Sembunyikan elemen preview dan tombol crop (jika perlu)
            document.getElementById('crop-container').classList.add('hidden');
            document.getElementById('crop-button').classList.add('hidden');

            alert('Foto berhasil di-crop.');
        }, 'image/jpeg'); // Format hasil crop
    } else {
        alert('Silakan pilih foto untuk di-crop terlebih dahulu.');
    }
});



document.getElementById('profile-form').addEventListener('submit', function (e) {
    if (croppedBlob) {
        e.preventDefault(); // Mencegah pengiriman form default
        const formData = new FormData(this);
        formData.append('profile_photo', croppedBlob); // Tambahkan hasil crop

        fetch(this.action, {
            method: this.method,
            body: formData,
        })
        .then(response => {
            if (response.ok) {
                location.reload(); // Berhasil
            } else {
                alert('Gagal mengunggah foto.');
            }
        })
        .catch(error => {
            console.error('Error Saat Mengunggah:', error); // Debug error
            alert('Terjadi kesalahan saat mengunggah.');
        });
    }
});


</script>
