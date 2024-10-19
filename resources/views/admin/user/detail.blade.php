@foreach ($users as $user)
    <!-- Detail User Modal -->
    <div class="fixed left-0 right-0 z-50 items-center justify-center hidden overflow-x-hidden overflow-y-auto top-4 md:inset-0 h-modal sm:h-full"
        id="detail-user-modal{{ $user->id }}">
        <div class="relative w-full h-full max-w-2xl px-4 md:h-auto">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-800">
                <!-- Modal header -->
                <div class="flex items-start justify-between p-5 border-b rounded-t dark:border-gray-700">
                    <h3 class="text-xl font-semibold dark:text-white">
                        Detail User
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-700 dark:hover:text-white"
                        data-modal-toggle="detail-user-modal{{ $user->id }}">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6 sm:col-span-3">
                            <label for="name"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Gambar</label>
                            <div>
                                <img  class="w-32 h-32 rounded-full object-cover" src="{{ is_string($user->image) && !empty($user->image) ? url($user->image) : asset('images/poto_profil.jpg') }}" alt="User Image">
                        
                            </div>
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <label for="name"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama</label>
                            <input disabled="true" type="text" value="{{ old('name', $user->name) }}" name="name"
                                id="name"
                                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                placeholder="Your Name">
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <label for="email"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                            <input disabled="true" type="email" value="{{ old('email', $user->email) }}"
                                name="email" id="email"
                                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                placeholder="example@gmail.com">
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <label for="password"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                            <div class="relative">
                                <input disabled="true" type="password" value="{{ old('password', $user->password) }}"
                                    name="password" id="password{{ $user->id }}"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 pr-10 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="••••••••">
                                <button type="button" id="togglePassword{{ $user->id }}"
                                    class="absolute inset-y-0 right-0 flex items-center pr-3 focus:outline-none">
                                    <svg id="iconPassword{{ $user->id }}" class="w-6 h-6 text-gray-800 dark:text-white"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-width="2"
                                            d="M3 12c0 1.2 4.03 6 9 6s9-4.8 9-6c0-1.2-4.03-6-9-6s-9 4.8-9 6Z" />
                                        <path stroke="currentColor" stroke-width="2"
                                            d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        <path stroke="currentColor" stroke-width="2" d="M1 1l22 22" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <label for="role"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Peran</label>
                            <input disabled="true" type="text" value="{{ old('role', $user->role) }}" name="role"
                                id="role"
                                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                placeholder="Siswa">
                        </div>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="items-center p-6 border-t border-gray-200 rounded-b dark:border-gray-700">
                    <button type="button" data-modal-toggle="detail-user-modal{{ $user->id }}"
                        class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                        Kembali
                    </button>
                </div>
            </div>
        </div>
    </div>
@endforeach

<script>
    @foreach ($users as $user)
        const togglePassword{{ $user->id }} = document.getElementById('togglePassword{{ $user->id }}');
        const passwordInput{{ $user->id }} = document.getElementById('password{{ $user->id }}');
        const iconPassword{{ $user->id }} = document.getElementById('iconPassword{{ $user->id }}');

        togglePassword{{ $user->id }}.addEventListener('click', () => {
            // Toggle the type attribute
            const type = passwordInput{{ $user->id }}.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput{{ $user->id }}.setAttribute('type', type);

            // Toggle the eye icon
            iconPassword{{ $user->id }}.innerHTML = type === 'password' ? `
                <path stroke="currentColor" stroke-width="2" d="M3 12c0 1.2 4.03 6 9 6s9-4.8 9-6c0-1.2-4.03-6-9-6s-9 4.8-9 6Z"/>
                <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                <path stroke="currentColor" stroke-width="2" d="M1 1l22 22" />
            ` : `
                <path stroke="currentColor" stroke-width="2" d="M3 12c0 1.2 4.03 6 9 6s9-4.8 9-6c0-1.2-4.03-6-9-6s-9 4.8-9 6Z"/>
                <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
            `;
        });
    @endforeach
</script>

