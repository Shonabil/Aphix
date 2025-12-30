{{-- Ganti seluruh file dengan kode ini --}}

{{-- PUSH STYLE: CSS untuk membuat area crop bulat --}}
@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
    <style>
        /* Kunci agar tampilan crop preview menjadi bulat */
        .cropper-view-box,
        .cropper-face {
            border-radius: 50%;
        }
    </style>
@endpush

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10"
     x-data="{ activeTab: 'profile' }">

    {{-- HEADER: BANNER & INFO --}}
    <div class="bg-white dark:bg-gray-900 rounded-[2.5rem] shadow-2xl overflow-hidden mb-10 border border-gray-100 dark:border-gray-800">

        {{-- Cover Gradient --}}
        <div class="h-64 bg-gradient-to-r from-[#051D6B] via-blue-900 to-orange-500 relative">
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
        </div>

        {{-- Profile Info Wrapper --}}
        <div class="px-10 pb-10 relative">
            {{-- Flex container untuk Avatar & Nama --}}
            <div class="flex flex-col md:flex-row items-center md:items-end -mt-20 mb-8 gap-8">

                {{-- Avatar Utama --}}
                {{-- PERBAIKAN: Pastikan container ini proporsional (misal w-40 h-40) --}}
                <div class="relative group w-40 h-40 shrink-0">
                    <div class="absolute inset-0 bg-white rounded-full blur-xl opacity-50"></div>

                    {{-- ID 'main-avatar-preview' untuk update gambar via JS --}}
                    {{-- PERBAIKAN: Gunakan aspect-square, w-full, h-full, rounded-full, object-cover --}}
                    <img id="main-avatar-preview"
                        src="{{ $user->profile_photo_path
                        ? asset('storage/' . $user->profile_photo_path)
                        : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=051D6B&color=fff&size=256' }}"
                        alt="{{ $user->name }}"
                        class="w-full h-full rounded-full object-cover aspect-square border-[6px] border-white dark:border-gray-900 shadow-2xl relative z-10 bg-white" />

                    <div class="absolute bottom-3 right-3 z-20 w-7 h-7 rounded-full border-[5px] border-white dark:border-gray-900 {{ $user->hasVerifiedEmail() ? 'bg-green-500' : 'bg-orange-500' }}"></div>
                </div>

                {{-- Name & Email --}}
                <div class="text-center md:text-left flex-1 space-y-1">
                    <h1 class="text-4xl font-black text-gray-900 dark:text-white tracking-tight">{{ $user->name }}</h1>
                    <p class="text-gray-500 font-medium text-lg flex items-center justify-center md:justify-start gap-2">
                        <i class="fa-regular fa-envelope text-orange-500"></i> {{ $user->email }}
                    </p>
                </div>

                {{-- Tabs Navigation --}}
                <div class="flex bg-gray-100 dark:bg-gray-800 p-1.5 rounded-2xl gap-2 shadow-inner">
                    <button @click="activeTab = 'profile'" :class="{ 'bg-white shadow-md text-[#051D6B] scale-105': activeTab === 'profile', 'text-gray-500 hover:text-gray-700': activeTab !== 'profile' }" class="px-8 py-3 rounded-xl text-sm font-bold transition-all flex items-center gap-2.5">
                        <i class="fa-solid fa-user-pen text-lg"></i> <span class="hidden sm:inline">Profile</span>
                    </button>
                    <button @click="activeTab = 'security'" :class="{ 'bg-white shadow-md text-orange-600 scale-105': activeTab === 'security', 'text-gray-500 hover:text-gray-700': activeTab !== 'security' }" class="px-8 py-3 rounded-xl text-sm font-bold transition-all flex items-center gap-2.5">
                        <i class="fa-solid fa-shield-halved text-lg"></i> <span class="hidden sm:inline">Security</span>
                    </button>
                    <button @click="activeTab = 'danger'" :class="{ 'bg-white shadow-md text-red-600 scale-105': activeTab === 'danger', 'text-gray-500 hover:text-gray-700': activeTab !== 'danger' }" class="px-8 py-3 rounded-xl text-sm font-bold transition-all flex items-center gap-2.5">
                        <i class="fa-solid fa-triangle-exclamation text-lg"></i> <span class="hidden sm:inline">Danger</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- CONTENT AREA --}}
    <div class="relative min-h-[500px]">

        {{-- TAB 1: EDIT PROFILE (CLEAN VERSION) --}}
        <div x-show="activeTab === 'profile'"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="bg-white dark:bg-gray-900 rounded-[2.5rem] shadow-xl border border-gray-100 dark:border-gray-800 p-10 lg:p-12">

            <div class="w-full">
                <header class="mb-10 pb-6 border-b border-gray-100 dark:border-gray-800">
                    <h2 class="text-2xl font-bold text-[#051D6B] dark:text-white flex items-center gap-3">
                        <span class="bg-blue-100 text-blue-700 p-2 rounded-lg"><i class="fa-regular fa-id-card"></i></span>
                        Informasi Pribadi
                    </h2>
                </header>

                <form id="send-verification" method="post" action="{{ route('verification.send') }}">@csrf</form>

                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-8" id="profileForm">
                    @csrf @method('PATCH')

                    {{-- AREA UPLOAD FOTO (HANYA KOTAK UPLOAD) --}}
                    <div x-data="photoUploader()">
                        <x-input-label for="photo" value="Ganti Foto Profil" class="text-gray-700 dark:text-gray-300 font-bold text-sm uppercase tracking-wide mb-3" />

                        {{-- HANYA ADA KOTAK UPLOAD --}}
                        <div class="w-full">
                            <label for="photo" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-3xl cursor-pointer bg-gray-50 dark:bg-gray-800 hover:bg-orange-50 hover:border-orange-300 transition-all group relative overflow-hidden">

                                <div class="flex flex-col items-center justify-center pt-5 pb-6 z-10">
                                    <div class="bg-white dark:bg-gray-700 p-3 rounded-full shadow-sm mb-2 group-hover:scale-110 transition-transform">
                                        <i class="fa-solid fa-camera text-2xl text-gray-400 group-hover:text-orange-500 transition-colors"></i>
                                    </div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 font-medium group-hover:text-orange-600">
                                        Klik untuk ganti foto profil header
                                    </p>
                                    <p class="text-xs text-gray-400 mt-1">JPG/PNG Max 2MB</p>
                                </div>

                                {{-- Input File Asli (Hidden) --}}
                                <input id="photo" name="photo" type="file" class="hidden" accept="image/*" @change="fileChosen">
                            </label>
                        </div>

                        {{-- MODAL CROPPER --}}
                        <div x-show="isCropping" style="display: none;"
                             class="fixed inset-0 z-[9999] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                <div class="fixed inset-0 bg-gray-900/90 transition-opacity" aria-hidden="true"></div>
                                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                                <div class="inline-block align-bottom bg-[#0f172a] rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-700">
                                    <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                        <h3 class="text-lg leading-6 font-medium text-white mb-4">Sesuaikan Lingkaran</h3>
                                        <div class="relative w-full h-96 bg-black rounded-lg overflow-hidden">
                                            <img id="crop-image" class="max-w-full block" src="">
                                        </div>
                                    </div>
                                    <div class="bg-gray-800 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                                        <button type="button" @click="saveCrop" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-6 py-2 bg-orange-600 text-base font-medium text-white hover:bg-orange-700 sm:ml-3 sm:w-auto sm:text-sm">Potong & Simpan</button>
                                        <button type="button" @click="cancelCrop" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-600 shadow-sm px-4 py-2 bg-transparent text-base font-medium text-gray-300 hover:text-white hover:bg-gray-700 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Batal</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('photo')" class="mt-2 text-red-500" />
                    </div>

                    {{-- Nama & Email --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <x-input-label for="name" value="Nama Lengkap" class="text-gray-700 dark:text-gray-300 font-bold text-sm uppercase tracking-wide mb-2" />
                            <x-text-input id="name" name="name" type="text" class="mt-2 block w-full rounded-2xl bg-gray-50 border-gray-200 focus:ring-[#051D6B] px-5 py-4 text-lg" :value="old('name', $user->name)" required />
                        </div>
                        <div>
                            <x-input-label for="email" value="Email" class="text-gray-700 dark:text-gray-300 font-bold text-sm uppercase tracking-wide mb-2" />
                            <x-text-input id="email" name="email" type="email" class="mt-2 block w-full rounded-2xl bg-gray-50 border-gray-200 focus:ring-[#051D6B] px-5 py-4 text-lg" :value="old('email', $user->email)" required />
                        </div>
                    </div>

                    <div class="pt-6 border-t border-gray-100 dark:border-gray-800 flex items-center gap-6">
                        <button type="submit" class="bg-[#051D6B] hover:bg-blue-900 text-white px-10 py-4 rounded-2xl font-bold text-lg shadow-xl shadow-blue-900/20 hover:-translate-y-1 transition-all">Simpan Profil</button>
                        @if (session('status') === 'profile-updated')
                            <span x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-green-600 text-lg font-bold flex items-center gap-2"><i class="fa-solid fa-circle-check text-xl"></i> Tersimpan</span>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        {{-- TAB 2: SECURITY (PASSWORD) --}}
        <div x-show="activeTab === 'security'"
             x-cloak
             style="display: none;"
             class="bg-white dark:bg-gray-900 rounded-[2.5rem] shadow-xl border border-gray-100 dark:border-gray-800 p-10 lg:p-12">

            <div class="w-full">
                <header class="mb-10 pb-6 border-b border-gray-100">
                    <h2 class="text-2xl font-bold text-orange-600 flex items-center gap-3">
                        <span class="bg-orange-100 text-orange-600 p-2 rounded-lg"><i class="fa-solid fa-lock"></i></span>
                        Keamanan Akun
                    </h2>
                </header>

                <form method="post" action="{{ route('password.update') }}" class="space-y-8">
                    @csrf @method('put')
                    <div>
                        <x-input-label for="current_password" value="Password Saat Ini" class="text-gray-700 font-bold text-sm uppercase tracking-wide mb-2" />
                        <x-text-input id="current_password" name="current_password" type="password" class="px-5 py-4 block w-full rounded-2xl bg-gray-50 border-gray-200 focus:ring-orange-500 focus:border-orange-500 text-lg" />
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <x-input-label for="password" value="Password Baru" class="text-gray-700 font-bold text-sm uppercase tracking-wide mb-2" />
                            <x-text-input id="password" name="password" type="password" class="px-5 py-4 block w-full rounded-2xl bg-gray-50 border-gray-200 focus:ring-orange-500 focus:border-orange-500 text-lg" />
                        </div>
                        <div>
                            <x-input-label for="password_confirmation" value="Konfirmasi Password" class="text-gray-700 font-bold text-sm uppercase tracking-wide mb-2" />
                            <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="px-5 py-4 block w-full rounded-2xl bg-gray-50 border-gray-200 focus:ring-orange-500 focus:border-orange-500 text-lg" />
                        </div>
                    </div>
                    <div class="pt-6 border-t border-gray-100 flex items-center gap-6">
                        <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-10 py-4 rounded-2xl font-bold text-lg shadow-xl shadow-orange-500/20 hover:-translate-y-1 transition-all">Update Password</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- TAB 3: DANGER ZONE --}}
        <div x-show="activeTab === 'danger'"
             x-cloak
             style="display: none;"
             class="bg-red-50 rounded-[2.5rem] shadow-inner border border-red-100 p-10 lg:p-12">

            <div class="flex flex-col md:flex-row gap-10 items-start">
                <div class="bg-white p-6 rounded-3xl shadow-sm text-red-500 text-5xl">
                    <i class="fa-solid fa-skull-crossbones"></i>
                </div>
                <div class="flex-1">
                    <h2 class="text-2xl font-bold text-red-700">Hapus Akun Permanen</h2>
                    <p class="text-base text-red-600/80 mt-3 mb-8 leading-relaxed max-w-2xl">
                        Tindakan ini tidak dapat dibatalkan. Setelah akun Anda dihapus, semua sumber daya dan data yang terkait akan dihapus secara permanen.
                    </p>
                    <button x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')" class="bg-red-600 hover:bg-red-700 text-white px-8 py-4 rounded-2xl font-bold text-lg shadow-xl shadow-red-600/20 hover:-translate-y-1 transition-all flex items-center gap-3">
                        <i class="fa-solid fa-trash"></i> Ya, Hapus Akun Saya
                    </button>
                </div>
            </div>
            <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
                <form method="post" action="{{ route('profile.destroy') }}" class="p-8">
                    @csrf @method('delete')
                    <h2 class="text-xl font-bold text-gray-900">{{ __('Are you sure you want to delete your account?') }}</h2>
                    <p class="mt-2 text-sm text-gray-600">{{ __('Please enter your password to confirm you would like to permanently delete your account.') }}</p>
                    <div class="mt-6">
                        <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />
                        <x-text-input id="password" name="password" type="password" class="mt-1 block w-full rounded-xl px-5 py-3 border-gray-300 focus:border-red-500 focus:ring-red-500" placeholder="{{ __('Password') }}" />
                        <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                    </div>
                    <div class="mt-8 flex justify-end gap-4">
                        <x-secondary-button x-on:click="$dispatch('close')" class="px-6 py-3 rounded-xl">{{ __('Cancel') }}</x-secondary-button>
                        <x-danger-button class="ml-3 px-6 py-3 rounded-xl">{{ __('Delete Account') }}</x-danger-button>
                    </div>
                </form>
            </x-modal>
        </div>

    </div>
</div>

{{-- PUSH SCRIPT: JS Cropper JS --}}
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script>
    function photoUploader() {
        return {
            isCropping: false,
            cropper: null,
            originalFile: null,

            fileChosen(event) {
                this.originalFile = event.target.files[0];

                if (this.originalFile) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        const image = document.getElementById('crop-image');
                        image.src = e.target.result;
                        this.isCropping = true;

                        // Init Cropper
                        this.$nextTick(() => {
                            if (this.cropper) {
                                this.cropper.destroy();
                            }
                            // PERBAIKAN: aspectRatio: 1 dan viewMode: 1 penting untuk crop bulat
                            this.cropper = new Cropper(image, {
                                aspectRatio: 1,
                                viewMode: 1,
                                dragMode: 'move',
                                guides: false,
                                background: false,
                                autoCropArea: 0.8,
                            });
                        });
                    };
                    reader.readAsDataURL(this.originalFile);
                }
            },

            saveCrop() {
                if (!this.cropper) return;

                this.cropper.getCroppedCanvas({
                    width: 300,
                    height: 300
                }).toBlob((blob) => {
                    const previewUrl = URL.createObjectURL(blob);

                    // UPDATE AVATAR BESAR DI HEADER
                    const headerAvatar = document.getElementById('main-avatar-preview');
                    if(headerAvatar) headerAvatar.src = previewUrl;

                    // GANTI INPUT FILE DENGAN HASIL CROP
                    const file = new File([blob], this.originalFile.name, { type: 'image/jpeg', lastModified: new Date().getTime() });
                    const container = new DataTransfer();
                    container.items.add(file);
                    document.getElementById('photo').files = container.files;

                    this.isCropping = false;
                }, 'image/jpeg', 0.9);
            },

            cancelCrop() {
                this.isCropping = false;
                document.getElementById('photo').value = ''; // Reset input
            }
        }
    }
</script>
@endpush
