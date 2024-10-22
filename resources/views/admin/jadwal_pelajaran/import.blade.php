<!-- Import Modal -->
<div id="import-jadwal_pelajaran-modal" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full h-full p-4 overflow-x-hidden overflow-y-auto bg-gray-900 bg-opacity-75">
    <div class="relative w-full max-w-lg mx-auto bg-white rounded-lg shadow-lg dark:bg-gray-800">
        <div class="p-8 text-center">
            <h3 class="mb-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">Import Jadwal Pelajaran</h3>

            <form action="{{ route('admin.jadwal_pelajaran.import', ['type' => 'csv']) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="file" accept=".xls,.xlsx,.csv" class="mb-4 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-600 dark:border-gray-700 dark:text-white" required>
                <p class="mb-4 text-sm text-gray-500 dark:text-gray-400">Upload a CSV or Excel file. Max size: 2MB.</p>
                <button type="submit" class="inline-flex items-center justify-center px-6 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-800 transition duration-150 ease-in-out">
                    Import
                </button>
            </form>

            <!-- Close Button -->
            <button data-modal-toggle="import-jadwal_pelajaran-modal" class="mt-6 inline-flex items-center justify-center px-6 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 focus:ring-4 focus:ring-gray-300 dark:bg-gray-600 dark:text-gray-300 dark:hover:bg-gray-500 transition duration-150 ease-in-out">
                Close
            </button>
        </div>
    </div>
</div>
