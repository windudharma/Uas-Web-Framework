               <!-- Modal Dinamis berdasarkan ID aset -->
               <div id="imageModal{{ $asset->id }}" class="modal">
                   <div class="modal-content">
                       <span class="close-btn">&times;</span>
                       <div class="card-popup">
                           <div class="image-container">
                               <img src="{{ asset('storage/' . $asset->gambar) }}" alt="{{ $asset->nama_aset }}"
                                   class="main-image image-with-dominant-color">

                                   <form id="download-form" action="{{ route('assets.download') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $asset->id }}">

                                    <!-- Menampilkan Notifikasi Error -->
                                    @if (session('error'))
                                        <div class="alert alert-danger mt-2">
                                            {{ session('error') }}
                                        </div>
                                    @endif

                                    <button type="submit" class="download-btn">Unduh</button>
                                </form>
                           </div>

                           <div class="info-section">
                            <div class="profile-pic">
                                <img src="{{ $asset->uploader->profile_photo_url ?? asset('storage/uploads/images/default-avatar.jpg') }}" alt="Avatar Pengunggah" class="rounded-circle" />
                            </div>
                               <div class="uploader-info">
                                   <span class="uploader-label">Pengunggah</span>
                                   <span class="uploader-name">{{ $asset->uploader->name ?? 'Tidak diketahui' }}</span>
                                </div>
                           </div>

                           <div class="description py-2">
                               <span class="uploader-name">{{ $asset->nama_aset }}</span>
                               <br>
                               {{ $asset->deskripsi }}
                           </div>

                           <div class="uploader-info">
                               <span class="uploader-name">Tag terkait</span>
                           </div>
                           <div class="tags">
                               @foreach (explode(',', $asset->kategori) as $kategori)
                                   <button class="btn btn-outline-secondary">{{ trim($kategori) }}</button>
                               @endforeach
                           </div>
                       </div>
                   </div>
               </div>
