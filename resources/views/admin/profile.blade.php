@extends('layouts.default.dashboard')
@section('content')
<div class="grid grid-cols-1 px-4 pt-6 xl:grid-cols-3 xl:gap-4 dark:bg-gray-900">
   
    <div class="mb-4 col-span-full xl:mb-2">
        <nav class="flex mb-5" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 text-sm font-medium md:space-x-2">
              <li class="inline-flex items-center">
                <a href="./dashboard" class="inline-flex items-center text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-white">
                  <svg class="w-5 h-5 mr-2.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                  Beranda
                </a>
              </li>
              <li>
                <div class="flex items-center">
                  <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                  <span class="ml-1 text-gray-400 md:ml-2 dark:text-gray-500" aria-current="page">Profile</span>
                </div>
              </li>
            </ol>
        </nav>
        @if(session('errorProfilePhoto'))
        <div class="alert alert-danger flex items-center mb-4 p-4 text-red-800 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800"
        role="alert">
        <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 16 16">
            <path
                d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
        </svg>
        <div>
            {{ session('errorProfilePhoto') }}
        </div>
    </div>
    
        @endif
        @if(session('successProfilePhoto'))
    <div class="alert alert-success flex items-center mb-4 p-4 text-green-800 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800"
        role="alert">
        <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 16 16">
            <path
                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
        </svg>
        <div>
            {{ session('successProfilePhoto') }}
        </div>
    </div>
    @endif
        <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Profile</h1>
    </div>

    <!-- Right Content -->
    <div class="col-span-full xl:col-auto">
        <div class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">

            <div class="items-center sm:flex xl:block 2xl:flex sm:space-x-4 xl:space-x-0 2xl:space-x-4">
           
                <div>
                    <form method="POST" action="{{ route('photoProfile') }}"enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <img id="image-preview" class="mb-4 rounded-lg w-28 h-28 sm:mb-0 xl:mb-4 2xl:mb-0" src="{{ $admin->image == null ? asset('static/images/users/bonnie-green-2x.png') : asset($admin->image) }}" alt="Admin picture">
                        <input type="file" id="image" name="image" class="hidden"accept="image/*" onchange="previewImage()">
                    <h3 class="mb-1 text-xl font-bold text-gray-900 dark:text-white">Foto Profile</h3>
                    <div class="mb-4 text-sm text-gray-500 dark:text-gray-400">
                        JPG, GIF atau PNG. Max size 5 MB
                    </div>
                    <div class="flex items-center space-x-4">
                        <button type="button" onclick="document.getElementById('image').click()" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                            <svg class="w-4 h-4 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.977A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z"></path><path d="M9 13h2v5a1 1 0 11-2 0v-5z"></path></svg>
                            Upload Foto
                        </button>
                        <button type="submit" 
                            class="py-2 px-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                            Simpan Perubahan
                            </button>
                
                    </div>
                </form>
                    <button type="button" 
                    data-modal-target="logout-profile-modal"
                    data-modal-toggle="logout-profile-modal"
                                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-center mt-3  text-gray-900 rounded-lg bg-white border border-gray-200 hover:bg-red-600 hover:text-white dark:bg-gray-800 dark:hover:bg-red-600 dark:text-white">
                        Keluar
                    </button>
                    <div class="fixed left-0 right-0 z-50 items-center justify-center hidden overflow-x-hidden overflow-y-auto top-4 md:inset-0 h-modal sm:h-full"id="logout-profile-modal">
        <div class="relative w-full h-full max-w-md px-4  md:h-auto">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-800">
                <!-- Modal body -->
                <div class="p-6 pt-0 text-center">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <div class="pt-2"></div>
                        <svg class="mt-5 w-16 h-16 mx-auto text-red-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="mt-5 mb-6 text-lg text-gray-500 dark:text-gray-400">Apakah Kamu yakin ingin keluar ? </h3>
                        <button type="submit"
                            class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-base inline-flex items-center px-3 py-2.5 text-center mr-2 dark:focus:ring-red-800">
                            Iya
                        </button>
                        <button type="button"
                            class="text-gray-900 bg-white hover:bg-gray-100 focus:ring-4 focus:ring-primary-300 border border-gray-200 font-medium inline-flex items-center rounded-lg text-base px-3 py-2.5 text-center dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-gray-700"
                            data-modal-toggle="logout-profile-modal"
                            >
                            Tidak
                        </button>
                    </form>
                </div>
            </div>
                </div>
                    </div>
                </div>
            
            </div>
        </div>
    </div>
    <div class="col-span-2">
        @if(session('errorProfile'))
        <div class="alert alert-danger flex items-center mb-4 p-4 text-red-800 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800"
        role="alert">
        <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 16 16">
            <path
                d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
        </svg>
        <div>
            {{ session('errorProfile') }}
        </div>
    </div>

        @endif
        @if(session('success'))
    <div class="alert alert-success flex items-center mb-4 p-4 text-green-800 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800"
        role="alert">
        <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 16 16">
            <path
                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
        </svg>
        <div>
            {{ session('success') }}
        </div>
    </div>
    @endif
        <div class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <h3 class="mb-4 text-xl font-semibold dark:text-white">Informasi Umum</h3>
            <form method="POST" action="{{ route('update') }}">
                @csrf
                @method('put')
                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6 sm:col-span-3">
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama</label>
                        <input type="text" name="name" id="name" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="{{$admin->name }}" required value="{{ old('name',$admin->name) }}">
                    </div>
                    <div class="col-span-6 sm:col-span-3">
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                        <input type="email" name="email" id="email" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="{{$admin->email }}" required value="{{ old('email',$admin->email) }}">
                    </div>
                    <div class="col-span-6 sm:col-full">
                        <button class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800" type="submit">Simpan Perubahan</button>
                    </div>
                </div>
            </form>
        </div>
        @if(session('errorValidator'))
    <div class="alert alert-danger flex items-center mb-4 p-4 text-red-800 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800"
        role="alert">
        <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 16 16">
            <path
                d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
        </svg>
        <div>
            {{ session('errorValidator') }}
        </div>
    </div>
        @endif
        @if(session('successPassword'))
    <div class="alert alert-success flex items-center mb-4 p-4 text-green-800 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800"
        role="alert">
        <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 16 16">
            <path
                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
        </svg>
        <div>
            {{ session('successPassword') }}
        </div>
    </div>
    @endif
        <div class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <h3 class="mb-4 text-xl font-semibold dark:text-white">Informasi Password</h3>
            <form  method="POST" action="{{ route('change-password') }}">
                @csrf
                @method('put')
                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6 sm:col-span-3">
                        <label for="current-password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password Saat Ini</label>
                        <div class="relative">
                            <input minlength="8" name="old_password" id="current-password" type="password" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="••••••••"  required>
                            <button type="button" id="toggleCurrentPassword"
                                    class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <svg id="iconCurrentPassword" class="w-6 h-6 text-gray-800 dark:text-white"
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
                        <label for="passwordProfile" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password baru</label>
                        <div class="relative">
                            <input minlength="8" onkeyup="validatePassword()" name="password" data-popover-target="popover-password" data-popover-placement="bottom" type="password" id="passwordProfile" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="••••••••" required>
                            <button type="button" id="toggleNewPassword" class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <svg id="iconNewPassword" class="w-6 h-6 text-gray-800 dark:text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-width="2" d="M3 12c0 1.2 4.03 6 9 6s9-4.8 9-6c0-1.2-4.03-6-9-6s-9 4.8-9 6Z" />
                                    <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    <path stroke="currentColor" stroke-width="2" d="M1 1l22 22" />
                                </svg>
                            </button>
                        </div>
                    
                        <div data-popover id="popover-password" role="tooltip" class="absolute z-10 inline-block text-sm font-light text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-100 w-72 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">
                            <div class="p-3 space-y-2">
                                <h3 class="font-semibold text-gray-900 dark:text-white">Must have at least 8 characters</h3>
                                <div id="progress-bars" class="grid grid-cols-4 gap-2">
                                    <div class="h-1 bg-gray-200 dark:bg-gray-600"></div>
                                    <div class="h-1 bg-gray-200 dark:bg-gray-600"></div>
                                    <div class="h-1 bg-gray-200 dark:bg-gray-600"></div>
                                    <div class="h-1 bg-gray-200 dark:bg-gray-600"></div>
                                </div>
                                <p>It’s better to have:</p>
                                <ul>
                                    <li id="min-char" class="flex items-center mb-1">
                                        <svg id="icon-min-char" class="w-4 h-4 mr-2 text-gray-300 dark:text-gray-400" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        Upper & lower case letters
                                    </li>
                                    <li id="has-symbol" class="flex items-center mb-1">
                                        <svg id="icon-has-symbol" class="w-4 h-4 mr-2 text-gray-300 dark:text-gray-400" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        A symbol (#$&)
                                    </li>
                                    <li id="long-pass" class="flex items-center">
                                        <svg id="icon-long-pass" class="w-4 h-4 mr-2 text-gray-300 dark:text-gray-400" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        A longer password (min. 12 chars.)
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-span-6 sm:col-span-3">
                        <label for="confirm-password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Konfirmasi password</label>
                        <div class="relative">
                            <input minlength="8" type="password" name="password_confirmation" id="confirm-password" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="••••••••" required>
                            <button type="button" id="toggleConfirmPassword"
                            class="absolute inset-y-0 right-0 flex items-center pr-3">
                            <svg id="iconConfirmPassword" class="w-6 h-6 text-gray-800 dark:text-white"
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
                    <div class="col-span-6 sm:col-full">
                        <button class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800" type="submit">Simpan Perubahan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>

@endsection
<script>
    
    function validatePassword() {
    const password = document.getElementById("passwordProfile").value;
    const minChar = /^(?=.*[a-z])(?=.*[A-Z])/; // Uppercase and lowercase
    const hasSymbol = /[!@#$%^&*(),.?":{}|<>]/; // Check for symbol
    const longPass = password.length >= 12;
    const minPass = password.length >= 8;

    // Initialize requirements
    let requirementsMet = 0;

    // Validate if password has both uppercase and lowercase letters
    


    if (minChar.test(password)) {
        document.getElementById("min-char").classList.add("text-green-500");
        document.getElementById("icon-min-char").classList.remove("text-gray-300");
        document.getElementById("icon-min-char").classList.add("text-green-500");
        requirementsMet++;
    } else {
        document.getElementById("min-char").classList.remove("text-green-500");
        document.getElementById("icon-min-char").classList.remove("text-green-500");
        document.getElementById("icon-min-char").classList.add("text-gray-300");
    }

    // Validate if password has a symbol
    if (hasSymbol.test(password)) {
        document.getElementById("has-symbol").classList.add("text-green-500");
        document.getElementById("icon-has-symbol").classList.remove("text-gray-300");
        document.getElementById("icon-has-symbol").classList.add("text-green-500");
        requirementsMet++;
    } else {
        document.getElementById("has-symbol").classList.remove("text-green-500");
        document.getElementById("icon-has-symbol").classList.remove("text-green-500");
        document.getElementById("icon-has-symbol").classList.add("text-gray-300");
    }

    // Validate if password is long enough (min. 12 characters)
    if (longPass) {
        document.getElementById("long-pass").classList.add("text-green-500");
        document.getElementById("icon-long-pass").classList.remove("text-gray-300");
        document.getElementById("icon-long-pass").classList.add("text-green-500");
        requirementsMet++;
    } else {
        document.getElementById("long-pass").classList.remove("text-green-500");
        document.getElementById("icon-long-pass").classList.remove("text-green-500");
        document.getElementById("icon-long-pass").classList.add("text-gray-300");
    }
    if (minPass) {
     requirementsMet++;
    }

    // Update progress bars based on number of requirements met
    const progressBars = document.querySelectorAll("#progress-bars > div");
    progressBars.forEach((bar, index) => {
        if (index < requirementsMet) {
            bar.classList.remove("bg-gray-200", "dark:bg-gray-600");
            bar.classList.add("bg-green-400");
        } else {
            bar.classList.remove("bg-green-400");
            bar.classList.add("bg-gray-200", "dark:bg-gray-600");
        }
    });
}

    function previewImage() {
        const fileInput = document.getElementById('image');
        const imagePreview = document.getElementById('image-preview');

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