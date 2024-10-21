<!-- Export Modal -->
<div id="export-jadwal_pelajaran-modal" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full h-full p-4 overflow-x-hidden overflow-y-auto bg-gray-900 bg-opacity-75">
    <div class="relative w-full max-w-md mx-auto bg-white rounded-lg shadow dark:bg-gray-700">
        <div class="p-6 text-center">
            <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Pilih Format Export</h3>
            <a href="{{ route('admin.jadwal_pelajaran.export', ['type' => 'excel']) }}"
               class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-center text-white bg-green-500 rounded-lg hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800">
                Export to Excel
            </a>
            <a href="{{ route('admin.jadwal_pelajaran.export', ['type' => 'pdf']) }}"
               class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-center text-white bg-red-500 rounded-lg hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800">
                Export to PDF
            </a>
        </div>
    </div>
</div>

<script>
    function toggleExportModal() {
        const modal = document.getElementById('export-jadwal_pelajaran-modal');
        modal.classList.toggle('hidden');
    }
</script>
