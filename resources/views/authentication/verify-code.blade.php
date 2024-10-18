@extends('layouts.default.baseof')

@section('main')
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <main class="bg-gray-50 dark:bg-gray-900 min-h-screen flex flex-col">
        <div class="container mx-auto px-4">
            <div class="flex flex-col items-center justify-center px-6 pt-8 mx-auto md:h-screen pt:mt-0 dark:bg-gray-900">
                <a href="{{ url('/') }}"
                    class="flex items-center justify-center mb-8 text-2xl font-semibold lg:mb-10 dark:text-white">
                    <img src="{{ asset('static/images/logo.svg') }}" class="mr-4 h-11" alt="FlowBite Logo">
                    <span>SekolahKu</span>
                </a>

                @if (session('success'))
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
                @elseif(session('failed'))
                    <div class="alert alert-danger flex items-center mb-4 p-4 text-red-800 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800"
                        role="alert">
                        <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 16 16">
                            <path
                                d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                        </svg>
                        <div>
                            {{ session('failed') }}
                        </div>
                    </div>
                @endif

                <div class="w-auto p-6 space-y-8 bg-white rounded-lg shadow sm:p-8 dark:bg-gray-800">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                        Verifikasi OTP Anda
                    </h2>
                    <form class="mt-8 space-y-6" action="{{ route('verify-code-add') }}" method="POST" id="otp-form">
                        @csrf
                        <div class="flex space-x-2">
                            @for ($i = 0; $i < 6; $i++)
                                <input type="text" name="otp[]" maxlength="1" pattern="\d"
                                    class="w-12 h-12 text-center border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    oninput="this.value=this.value.replace(/[^0-9]/g,'');"
                                    onkeyup="moveToNext(this, {{ $i }})" required>
                            @endfor
                        </div>
                        <button type="submit"
                            class="w-full px-5 py-3 text-base font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 sm:w-auto dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Verifikasi
                            OTP</button>
                    </form>

                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500 dark:text-gray-400">Tidak menerima kode?
                            <form action="{{ route('resend-otp') }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="text-blue-600 hover:underline focus:outline-none">Kirim Ulang Kode OTP</button>
                            </form>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        function moveToNext(input, index) {
            // If input is filled and is a number, move to the next input
            if (input.value.length === 1) {
                // Move to next input if it's not the last one
                if (index < 5) {
                    document.getElementsByName('otp[]')[index + 1].focus();
                }
            }
            // If backspace is pressed, move to the previous input
            if (input.value.length === 0 && index > 0) {
                document.getElementsByName('otp[]')[index - 1].focus();
            }
        }
    </script>
@endsection
