<!-- Export Modal -->
<div id="export-jadwal_pelajaran-modal" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full h-full p-4 overflow-x-hidden overflow-y-auto bg-gray-900 bg-opacity-75 ">
    <div class="relative w-full max-w-md mx-auto bg-white rounded-lg shadow dark:bg-gray-700"> <!-- Prevent click event from bubbling up -->
        <div class="p-6 text-center">
            <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Pilih Format Export</h3>

            <p class="mb-4 text-sm text-gray-600 dark:text-gray-300">
                Pilih salah satu format untuk mengekspor jadwal pelajaran Anda.
            </p>

            <div class="flex justify-center space-x-4 mb-4"> <!-- Flex container for buttons -->
                <a href="{{ route('admin.jadwal_pelajaran.export', ['type' => 'excel']) }}"
                   class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-green-500 rounded-lg hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800">
                    Export to Excel
                </a>
                <a href="{{ route('admin.jadwal_pelajaran.export', ['type' => 'pdf']) }}"
                   class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-red-500 rounded-lg hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800">
                    Export to PDF
                </a>
            </div>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">Unduh jadwal sebagai file Excel untuk memudahkan pengeditan dan manipulasi data, lalu mengeksportnya kembali ke dalam website.</p>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">Unduh jadwal sebagai file PDF, cocok untuk dicetak dan dibagikan.</p>

            <!-- Close Button -->
            <button data-modal-toggle="export-jadwal_pelajaran-modal" class="mt-4 inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-gray-400 rounded-lg hover:bg-gray-500 focus:ring-4 focus:outline-none focus:ring-gray-300 dark:focus:ring-gray-800">
                Close
            </button>
        </div>
    </div>
</div>
