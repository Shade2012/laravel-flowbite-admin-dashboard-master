@foreach ($users as $user)
    <!-- Edit User Modal -->
    <div class="fixed left-0 right-0 z-50 items-center justify-center hidden overflow-x-hidden overflow-y-auto top-4 md:inset-0 h-modal sm:h-full"
        id="edit-user-modal{{ $user->id }}">
        <div class="relative w-full h-full max-w-2xl px-4 md:h-auto">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-800">
                <!-- Modal header -->
                <div class="flex items-start justify-between p-5 border-b rounded-t dark:border-gray-700">
                    <h3 class="text-xl font-semibold dark:text-white">
                        Edit user
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-700 dark:hover:text-white"
                        data-modal-toggle="edit-user-modal{{ $user->id }}">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-6 space-y-6">
                    <form action="{{ route('admin.user.update', $user->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6 sm:col-span-3">
                                <label for="image"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Gambar</label>
                                <div class="flex items-start space-x-4">
                                    <div class="mb-4">
                                        <img id="image-preview{{ $user->id }}" class="w-32 h-32 rounded-full object-cover" src="{{ is_string($user->image) && !empty($user->image) ? url($user->image) : asset('images/poto_profil.jpg') }}" alt="User Image">
                                    </div>
                                    <button type="button"
                                        onclick="document.getElementById('image{{ $user->id }}').click()"
                                        class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-4 py-2 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                                        Unggah Gambar
                                    </button>
                                    <input type="file" id="image{{ $user->id }}" name="image" class="hidden"
                                        accept="image/*" onchange="previewImage({{ $user->id }})">
                                </div>
                                <div>
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Unggah gambar profil (JPG,
                                        PNG, atau GIF). Maks ukuran 2 MB.</p>
                                </div>
                            </div>
                            <div class="col-span-6 sm:col-span-3">
                                <label for="name"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                    id="name"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Your Name">
                            </div>
                            <div class="col-span-6 sm:col-span-3">
                                <label for="email"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                    id="email"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="example@gmail.com">
                            </div>
                            <div class="col-span-6 sm:col-span-3">
                                <label for="password"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                                <div class="relative">
                                    <input type="password" name="password" id="password" placeholder="••••••••"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                        required>
                                </div>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Jika Anda ingin mempertahankan
                                    kata sandi saat ini, silakan biarkan kolom ini kosong.</p>
                            </div>
                            <div class="col-span-6 sm:col-span-3">
                                <label for="role"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Peran</label>
                                <select name="role" id="role"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                    <option value="Siswa" {{ $user->role == 'Siswa' ? 'selected' : '' }}>Siswa
                                    </option>
                                    <option value="Guru" {{ $user->role == 'Guru' ? 'selected' : '' }}>Guru</option>
                                    <option value="Admin" {{ $user->role == 'Admin' ? 'selected' : '' }}>Admin
                                    </option>
                                </select>
                            </div>
                        </div>
                </div>
                <!-- Modal footer -->
                <div class="items-center p-6 border-t border-gray-200 rounded-b dark:border-gray-700">
                    <button
                        class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"
                        type="submit">Simpan Semua</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

<script>
    function previewImage(userId) {
        const fileInput = document.getElementById('image' + userId);
        const imagePreview = document.getElementById('image-preview' + userId);

        const file = fileInput.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                imagePreview.src = event.target.result;
            };
            reader.readAsDataURL(file);
        }
    }
</script>
