@extends('layouts.app') {{-- Menggunakan layout utama Anda --}}

@section('title', 'Translator Sumba Kambera')

@section('content')
<div class="pt-16 pb-16 min-h-screen flex items-start justify-center p-4">
    <div id="translator-app" class="w-full max-w-5xl bg-white rounded-xl shadow-2xl overflow-hidden transform transition duration-500 hover:shadow-green-300/50">
        
        <header class="bg-green-700 p-3 rounded-t-xl">
            <!-- BARU: Container Flex untuk Judul dan Tombol -->
            <div class="flex items-center justify-between flex-wrap gap-4"> 
    <h1 class="font-bold text-white flex items-center justify-center gap-2 text-xs sm:text-sm md:text-base">
        <span class="whitespace-nowrap">Penerjemah <span class="kamuskambera">Indonesia</span></span>
        
        <svg class="w-6 h-6 text-green-400 flex-shrink-0 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
        </svg>

        <span class="whitespace-nowrap">Sumba Kambera</span>
    </h1>

    <div class="flex items-center flex-wrap gap-2">
        <button id="add-word-button" class="flex items-center space-x-2 px-4 py-2 bg-green-500 text-white text-sm font-semibold rounded-lg shadow-md hover:bg-green-600 transition duration-200 whitespace-nowrap">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            <span>Tambah Kata</span>
        </button>
        
        <button id="edit-word-button" class="flex items-center space-x-2 px-3 py-2 bg-yellow-500 text-white text-sm font-semibold rounded-lg shadow-md hover:bg-yellow-600 transition duration-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-9-4l9-9m-4 4L19 7m-4-4l-9 9m9 4l-4 4m0 0l-4-4m4 4l-4 4"></path></svg>
            <span>Edit Kata</span>
        </button>

        <button id="delete-word-button" class="flex items-center space-x-2 px-3 py-2 bg-red-500 text-white text-sm font-semibold rounded-lg shadow-md hover:bg-red-600 transition duration-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.86 10.32a2 2 0 01-2 1.68H7.86a2 2 0 01-2-1.68L5 7m4-2V3a1 1 0 011-1h4a1 1 0 011 1v2m-6 0h6m-3 4v6m0-6h.01"></path></svg>
            <span>Hapus Kata</span>
        </button>
    </div>
</div>
            
            <!-- KRITIS: Tambahkan token CSRF untuk keamanan POST request Laravel -->
            <meta name="csrf-token" content="{{ csrf_token() }}">
        </header>

        <main class="p-4">
            
            <!-- --- TATA LETAK SEBELAH MENYEBELAH (SIDE-BY-SIDE) --- -->
            <div class="flex flex-col md:flex-row gap-6 relative">
                
                <!-- Kolom KIRI (Akan diswap) -->
                <div id="left-column" class="flex-1">
				<div class="flex items-center justify-between mb-1">
                    <label for="input-text" id="input-label" class="block text-sm font-semibold text-gray-700 mb-1">
                        Teks Sumber&nbsp;<span class="kamuskambera">( Indonesia )</span>
                    </label>
					<!-- BARU: Tombol Suara Input -->
                        <button id="speak-input-button" title="Bacakan Teks Indonesia" class="text-gray-500 hover:text-green-600 transition duration-150 disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9.383 3.076A1 1 0 0110 4v12a1 1 0 01-1.383.924L4.69 13H2a1 1 0 01-1-1V8a1 1 0 011-1h2.69l4.312-3.924zM16 11a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM16 8a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM13 14a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1z" clip-rule="evenodd"></path></svg>
                        </button>
					</div>
					
					<!-- ini ditambahkan 26/01/2026 sebagai textarea untuk bahasa asing yang akan muncul ketika user memilih bahasa asing-->
					
						<textarea 
							id="input-foreign"
							rows="4" autocomplete="Off"
							placeholder="Type in your language here..."
							class="w-full p-4 border-2 border-blue-400 rounded-lg focus:border-blue-600 focus:ring-blue-600 transition duration-150 text-gray-800 text-base resize-none shadow-inner hidden"
						></textarea>
						
					
					<!----------------------------------------------------------------------------------!>
					
                    <textarea 
                        id="input-text"
                        rows="4" autocomplete="Off"
                        placeholder="Masukkan kata atau kalimat Bahasa Indonesia di sini..."
                        class="notranslate w-full p-4 border-2 border-green-300 rounded-lg focus:border-green-600 focus:ring-green-600 transition duration-150 ease-in-out text-gray-800 text-base resize-none shadow-inner"
                     translate="no"></textarea>
					 
					<!-- ditambhkan 28/01/2026 sebagai penampung inputan user tapi tidak terlihat agar bisa disalin lagi ke textarea foreign-->
					<div id="ghost-inputText" class="sr-only"></div>
					 <!------------------------------------------------------------------------------------------------>
					 
                    <p id="input-status" class="text-sm text-gray-500 mt-1">Maksimal 255 karakter!</p>
                </div>

                <!-- Tombol Tukar Bahasa (Hanya terlihat di desktop) --
                <button id="swap-button" title="Tukar Bahasa" class="absolute z-10 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-12 h-12 bg-gray-200 text-gray-700 rounded-full shadow-lg border-4 border-white hover:bg-green-100 transition duration-150 hidden md:flex items-center justify-center">
                    <svg class="w-6 h-6 transform rotate-90 md:rotate-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                </button> -->
                
                <!-- Kolom KANAN (Akan diswap) -->
                <div id="right-column" class="flex-1">
				<div class="flex items-center justify-between mb-1">
                    <label for="output-text" id="output-label" class="block text-sm font-semibold text-gray-700 mb-1">
                        Hasil Terjemahan ( Sumba Kambera )
                    </label>

					<!-- Tombol Suara Output -->
                        <button id="speak-output-button" title="Bacakan Teks Sumba Kambera" class="text-gray-500 hover:text-green-600 transition duration-150 disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                           <span id="icon-output-status">
								<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
									<path fill-rule="evenodd" d="M9.383 3.076A1 1 0 0110 4v12a1 1 0 01-1.383.924L4.69 13H2a1 1 0 01-1-1V8a1 1 0 011-1h2.69l4.312-3.924zM16 11a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM16 8a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM13 14a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1z" clip-rule="evenodd">
									</path>
								</svg>
							</span>
                        </button>
				</div>
                    <textarea 
                        id="output-text"
                        rows="4" autocomplete="Off"
                        readonly
                        placeholder="Hasil terjemahan akan muncul di sini. Kata yang tidak ditemukan akan ditampilkan lagi."
                        class="w-full p-4 border-2 border-gray-200 bg-gray-50 rounded-lg text-gray-800 text-base cursor-default resize-none shadow-inner"
                     ></textarea>
                </div>
            </div>
            
            <!-- Tombol Terjemahkan (Dinonaktifkan, Diganti Real-time) dan Loading Indicator -->
            
			<div class="flex flex-col items-center justify-center mt-6 space-y-4">
			
				<!-- Loading Indicator -->
                <div id="loading-indicator" class="text-center hidden">
                    <div class="animate-spin inline-block w-6 h-6 border-4 border-green-500 border-t-transparent rounded-full mr-3"></div>
                    <span class="text-green-600 font-medium">Sedang memproses terjemahan...</span>
                </div>
            </div>
            
            <!-- Pesan Notifikasi Global (untuk hasil tambah kata) -->
            <div id="notification-message" class="fixed top-4 left-1/2 transform -translate-x-1/2 p-4 rounded-lg shadow-xl text-white font-medium z-50 transition-all duration-300 hidden opacity-0"></div>

        </main>

        <footer class="p-4 text-center text-sm text-gray-500 border-t border-gray-100 bg-gray-50 rounded-b-xl">
            Penerjemah Sederhana V1.0. Kata yang tidak ditemukan akan dikembalikan dalam format aslinya.
        </footer>
    </div>
</div>

<!-- Modal 1: Tambah Kata Baru -->
<div id="add-word-modal" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center p-4 z-40 hidden transition-opacity duration-300 opacity-0">
    <div class="bg-white rounded-xl shadow-3xl w-full max-w-md transform transition-all duration-300 scale-95" role="dialog" aria-modal="true" aria-labelledby="modal-title">
        <div class="p-6">
            <h3 id="modal-title" class="text-2xl font-bold text-gray-800 mb-4 border-b pb-2">Tambah Kata Baru ke Kamus</h3>
            <form id="add-word-form" class="space-y-4">
                
                <div>
                    <label for="new-id-word" class="block text-sm font-medium text-gray-700">Kata Bahasa Indonesia (Contoh: buah)</label>
                    <input type="text" id="new-id-word" required autocomplete="Off" name="new-id-word"
                        class="mt-1 block w-full p-3 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500 text-gray-800 lowercase"
                        placeholder="HARUS HURUF KECIL"
                    >
                    <p id="error-id-word" class="text-red-500 text-xs mt-1"></p>
                </div>

                <div>
                    <label for="new-sbk-word" class="block text-sm font-medium text-gray-700">Kata Sumba Kambera (Contoh: wua)</label>
                    <input type="text" id="new-sbk-word" required autocomplete="Off"
                        class="mt-1 block w-full p-3 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500 text-gray-800 lowercase"
                        placeholder="HARUS HURUF KECIL"
                    >
                    <p id="error-sbk-word" class="text-red-500 text-xs mt-1"></p>
                </div>

                <div class="flex justify-end space-x-3 pt-4">
                    <button type="button" data-modal-target="add-word-modal" class="close-modal px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition duration-150">
                        Batal
                    </button>
                    <button type="submit" id="save-word-button"
                        class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 transition duration-150 disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        Simpan Kata
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal 2: Edit Kata Baru (NEW) -->
<div id="edit-word-modal" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center p-4 z-40 hidden transition-opacity duration-300 opacity-0">
    <div class="bg-white rounded-xl shadow-3xl w-full max-w-lg transform transition-all duration-300 scale-95" role="dialog" aria-modal="true" aria-labelledby="modal-title-edit">
        <div class="p-6">
            <h3 id="modal-title-edit" class="text-2xl font-bold text-gray-800 mb-4 border-b pb-2">Edit Kata Kamus</h3>
            <form id="edit-word-form" class="space-y-4">

                <!-- Input Pencarian & Pilihan Bahasa -->
                <div class="p-4 bg-gray-50 rounded-lg border">
                    <label for="edit-search-word" class="block text-sm font-medium text-gray-700 mb-2">Cari Kata yang Ingin Diedit</label>
                    <div class="flex gap-2 mb-4">
                        <input type="text" id="edit-search-word" 
                            class="flex-1 p-3 border border-gray-300 rounded-lg focus:ring-yellow-500 focus:border-yellow-500 text-gray-800 lowercase"
                            placeholder="Ketik kata (misal: rumah, atau uma)"
                            autocomplete="off"
                        >
                        <div id="loading-edit-search" class="text-yellow-600 flex items-center hidden">
                            <div class="animate-spin w-5 h-5 border-2 border-yellow-500 border-t-transparent rounded-full"></div>
                        </div>
                    </div>

                    <div class="flex space-x-4">
                        <label class="inline-flex items-center text-sm font-medium text-gray-700">
                            <input type="radio" name="edit_language_mode" value="id" checked id="edit-mode-id" class="form-radio text-yellow-600 w-4 h-4">
                            <span class="ml-2">Cari dalam **Indonesia**</span>
                        </label>
                        <label class="inline-flex items-center text-sm font-medium text-gray-700">
                            <input type="radio" name="edit_language_mode" value="sbk" id="edit-mode-sbk" class="form-radio text-yellow-600 w-4 h-4">
                            <span class="ml-2">Cari dalam **Sumba Kambera**</span>
                        </label>
                    </div>
                </div>
                
                <p id="edit-status-message" class="text-sm font-medium"></p>
				<input type="hidden" id="edit_unique_id">
                <input type="hidden" id="edit-original-id">
                <input type="hidden" id="edit-original-sbk">

                <!-- Input Kata Indonesia -->
                <div>
                    <label for="edit-id-word" class="block text-sm font-medium text-gray-700">Kata Bahasa Indonesia</label>
                    <input type="text" id="edit-id-word" required disabled autocomplete="Off"
                        class="mt-1 block w-full p-3 border border-gray-300 bg-gray-100 rounded-lg focus:ring-yellow-500 focus:border-yellow-500 text-gray-800 lowercase"
                        placeholder="Kata Indonesia"
                    >
                </div>

                <!-- Input Kata Sumba Kambera -->
                <div>
                    <label for="edit-sbk-word" class="block text-sm font-medium text-gray-700">Kata Sumba Kambera</label>
                    <input type="text" id="edit-sbk-word" required disabled autocomplete="Off"
                        class="mt-1 block w-full p-3 border border-gray-300 bg-gray-100 rounded-lg focus:ring-yellow-500 focus:border-yellow-500 text-gray-800 lowercase"
                        placeholder="Kata Sumba Kambera"
                    >
                </div>

                <div class="flex justify-end space-x-3 pt-4">
                    <button type="button" data-modal-target="edit-word-modal" class="close-modal px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition duration-150">Batal</button>
                    <button type="submit" id="update-word-button" disabled
                        class="px-4 py-2 text-sm font-medium text-white bg-yellow-600 rounded-lg hover:bg-yellow-700 transition duration-150 disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal 3: Hapus Kata (NEW) -->
<div id="delete-word-modal" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center p-4 z-40 hidden transition-opacity duration-300 opacity-0">
    <div class="bg-white rounded-xl shadow-3xl w-full max-w-sm transform transition-all duration-300 scale-95" role="dialog" aria-modal="true" aria-labelledby="modal-title-delete">
        <div class="p-6">
            <h3 id="modal-title-delete" class="text-2xl font-bold text-gray-800 mb-4 border-b pb-2">Hapus Kata dari Kamus</h3>
            <form id="delete-word-form" class="space-y-4">
                
                <!-- Input Pencarian Hapus & Pilihan Bahasa -->
                <div class="p-4 bg-gray-50 rounded-lg border">
                    <label for="delete-search-word" class="block text-sm font-medium text-gray-700 mb-2">Kata yang akan Dihapus</label>
                    <input type="text" id="delete-search-word"  name="delete-search-word"
                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500 text-gray-800 lowercase"
                        placeholder="Ketik kata untuk mencari"
                        autocomplete="off"
                    >
                    <div class="flex space-x-4 mt-2">
                        <label class="inline-flex items-center text-sm font-medium text-gray-700">
                            <input type="radio" name="delete_language_mode" value="id" checked id="delete-mode-id" class="form-radio text-red-600 w-4 h-4">
                            <span class="ml-2">Cari dalam **Indonesia**</span>
                        </label>
                        <label class="inline-flex items-center text-sm font-medium text-gray-700">
                            <input type="radio" name="delete_language_mode" value="sbk" id="delete-mode-sbk" class="form-radio text-red-600 w-4 h-4">
                            <span class="ml-2">Cari dalam **Sumba Kambera**</span>
                        </label>
                    </div>
                </div>

                <p id="delete-confirmation-text" class="text-lg font-semibold text-gray-800 mt-4 p-2 bg-red-50 rounded-lg">
                    Cari kata di atas untuk konfirmasi penghapusan.
                </p>

                <div class="flex justify-end space-x-3 pt-4">
                    <button type="button" data-modal-target="delete-word-modal" class="close-modal px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition duration-150">Batal</button>
                    <button type="submit" id="confirm-delete-button" disabled
                        class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 transition duration-150 disabled:opacity-50 disabled:cursor-not-allowed"
                        data-id-word=""
                    >
                        Konfirmasi Hapus
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>




<script>


    document.addEventListener('DOMContentLoaded', () => {
		
        // --- Elemen Utama ---
        const inputTextarea = document.getElementById('input-text');
        const outputTextarea = document.getElementById('output-text');
		const sourceLangName = document.querySelectorAll('.kamuskambera');
		
		const targetLangName = document.getElementById('target-lang-name');
		const speakInputButton = document.getElementById('speak-input-button');
		const speakOutputButton = document.getElementById('speak-output-button');
		let isAutoReadEnabled = true; // Defaultnya baca text output aktif, 31 jan 2026
	
        const loadingIndicator = document.getElementById('loading-indicator');
        const loadingText = loadingIndicator.querySelector('span'); // Span di dalam loading indicator
        const notificationMessage = document.getElementById('notification-message');
        
		// --- Elemen Tambahan 26 jan 2026 (Untuk Bahasa Asing) ---
		const inputForeign = document.getElementById('input-foreign'); // Pastikan ID ini ada di HTML Anda
		const ghost = document.getElementById('ghost-inputText');
		const kodebahasa = localStorage.getItem('user_lang') || 'id-ID';
		window.switchkodebahasa = kodebahasa;
		window.namabahasa = "Indonesia";
		
		// Objek Web Speech API
		const synthesis = window.speechSynthesis;
		const isTTSAvailable = 'speechSynthesis' in window;
		let idVoice; // <-- PERBAIKAN 1: Deklarasi idVoice di scope ini
		
        // Elemen Label
        const inputLabel = document.getElementById('input-label');
        const outputLabel = document.getElementById('output-label');
        
        // Tombol Tukar
        //const swapButton = document.getElementById('swap-button');

        // Mendapatkan token CSRF dari meta tag
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        // --- ENDPOINT API ---
        const translateApiUrl = '/api/translate'; 
        const addWordApiUrl = '/api/dictionary/add'; 
        const searchWordApiUrl = '/api/dictionary/search'; // NEW
        const updateWordApiUrl = '/api/dictionary/update'; // NEW: Akan diikuti ID
        const deleteWordApiUrl = '/api/dictionary/delete'; // NEW: Akan diikuti ID
        
        // *** VARIABEL STATUS TERJEMAHAN ***
        let isIdToSbkMode = true;

        // --- Elemen Modal Add Word ---
        const addWordButton = document.getElementById('add-word-button');
        const modal = document.getElementById('add-word-modal');
        const addWordForm = document.getElementById('add-word-form');
        const saveWordButton = document.getElementById('save-word-button');
        const idWordInput = document.getElementById('new-id-word');
        const sbkWordInput = document.getElementById('new-sbk-word');

        // --- Elemen Modal Edit Word (NEW) ---
        const editWordButton = document.getElementById('edit-word-button');
        const editModal = document.getElementById('edit-word-modal');
        const editSearchInput = document.getElementById('edit-search-word');
        const editModeRadios = document.querySelectorAll('input[name="edit_language_mode"]');
        const editIdWordInput = document.getElementById('edit-id-word');
        const editSbkWordInput = document.getElementById('edit-sbk-word');
        const updateWordButton = document.getElementById('update-word-button');
        const editOriginalId = document.getElementById('edit-original-id');
        const editOriginalSbk = document.getElementById('edit-original-sbk');
        const editStatusMessage = document.getElementById('edit-status-message');
        const loadingEditSearch = document.getElementById('loading-edit-search');
        const editWordForm = document.getElementById('edit-word-form'); // Pastikan elemen form ada
		const editUniqueId = document.getElementById('edit_unique_id'); // <-- NEW: Field tersembunyi untuk ID unik database

        // --- Elemen Modal Delete Word (NEW) ---
        const deleteWordButton = document.getElementById('delete-word-button');
        const deleteModal = document.getElementById('delete-word-modal');
        const deleteSearchInput = document.getElementById('delete-search-word');
        const deleteModeRadios = document.querySelectorAll('input[name="delete_language_mode"]');
        const deleteConfirmationText = document.getElementById('delete-confirmation-text');
        const confirmDeleteButton = document.getElementById('confirm-delete-button');
        const deleteWordForm = document.getElementById('delete-word-form'); // Pastikan elemen form ada

        // Fungsi utility
        const delay = (ms) => new Promise(resolve => setTimeout(resolve, ms));
		
		// --- FUNGSI DEBOUNCE ---
        const debounce = (func, wait) => {
            let timeout;
            return function(...args) {
                const context = this;
                clearTimeout(timeout);
                timeout = setTimeout(() => func.apply(context, args), wait);
            };
        };

        function showNotification(message, isSuccess = true) {
            notificationMessage.textContent = message;
            notificationMessage.classList.remove('hidden', 'bg-red-500', 'bg-green-500');
            notificationMessage.classList.add(isSuccess ? 'bg-green-500' : 'bg-red-500');

            setTimeout(() => {
                notificationMessage.classList.add('opacity-0');
                setTimeout(() => notificationMessage.classList.add('hidden'), 300);
            }, 3000);
            notificationMessage.classList.remove('opacity-0');
        }
        
        // --- LOGIKA UTAMA: FETCH DENGAN EXPONENTIAL BACKOFF ---
        async function fetchWithBackoff(url, options, maxRetries = 5) {
            for (let attempt = 0; attempt < maxRetries; attempt++) {
                try {
                    const response = await fetch(url, options);
                    if (!response.ok) {
                        const contentType = response.headers.get("content-type");
                        if (contentType && contentType.indexOf("application/json") === -1 && response.status !== 204) {
                            const errorText = await response.text();
                            console.error("Non-JSON Response from Server:", errorText);
                            // Ini mungkin error page Laravel, return response untuk handle di luar
                            return response;
                        }
                        
                        if (response.status >= 500 && attempt < maxRetries - 1) {
                            throw new Error(`Server error! status: ${response.status}`);
                        } else {
                            return response;
                        }
                    }
                    return response;
                } catch (error) {
                    if (attempt < maxRetries - 1) {
                        const waitTime = Math.pow(2, attempt) * 1000 + Math.random() * 500;
                        await delay(waitTime);
                    } else {
                        throw new Error(`Gagal terhubung ke API setelah ${maxRetries} kali coba. Pesan: ${error.message}`);
                    }
                }
            }
        }
		
		// --- LOGIKA MORFOLOGI KAMBERA (CLIENT-SIDE) ---
        function applyKamberaMorphology(sbkText) {
            if (!sbkText) return "";

            const words = sbkText.toLowerCase().split(/\s+/).filter(word => word.length > 0);
            const resultWords = [];

            for (let i = 0; i < words.length; i++) {
                const currentWord = words[i];

                if (currentWord === 'mbuhang') { // Aturan 1: buhang (mau)
                    resultWords.push(currentWord);

                    if (i + 1 < words.length) {
                        const nextWord = words[i + 1];
                        // Asumsi kata berikutnya adalah kata kerja, tambahkan prefiks 'pa-'
                        const prefixedWord = `pa-${nextWord}`;
                        resultWords.push(prefixedWord);
                        i++; // Loncat satu indeks karena kata kerja sudah diproses
                    }
                } else {
                    resultWords.push(currentWord);
                }
            }

            return resultWords.join(' ');
        }
        // ----------------------------------------------------

		
       // --- FUNGSI UTAMA: MENGIRIM TERJEMAHAN ---
	   
	   //Jadi, ketika fungsi sedang berjalan, kita "mengunci" pintu masuknya.
	   //Jika ada input baru masuk saat proses belum selesai, input tersebut akan diabaikan atau ditolak sampai proses sebelumnya masuk ke blok finally
	   let isTranslating = false; // Ini adalah "kuncinya", 3 peb 2026
	   
	   
        async function performTranslation() {
			if (isTranslating) return; // Jika ya, abaikan input baru
			
            const textToTranslate = inputTextarea.value.trim();
			
			// Update ghost text yang tersebunyi
			if(window.switchkodebahasa === 'id-ID') {
				syncToGhost(inputTextarea.value);
			}
						
            // 1. Cek Teks Kosong
            if (textToTranslate === "") {
                outputTextarea.value = "";
                loadingIndicator.classList.add('hidden');
                return;
            }

			// MULAI PROSES - KUNCI AKTIF
			isTranslating = true;
			
            // 2. Tampilkan Loading
			//loadingText.textContent = 'Sedang memproses terjemahan...';
            loadingIndicator.classList.remove('hidden');
            
            const requestOptions = {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken, 
                },
                body: JSON.stringify({ 
                    text: textToTranslate,
                    mode: isIdToSbkMode ? 'id_to_sbk' : 'sbk_to_id'
                })
            };

            try {
                const response = await fetchWithBackoff(translateApiUrl, requestOptions);
                const data = await response.json();
                
                if (data.status === 'success' && data.translation) {
                    const translatedText = data.translation;
                    
                    // APLIKASIKAN MORFOLOGI HANYA JIKA MODE ID -> SBK
                    const finalOutput = isIdToSbkMode 
                        ? applyKamberaMorphology(translatedText) 
                        : translatedText;

                    outputTextarea.value = finalOutput;
					
					// Pengecekan setting speaker dengan jeda (delay), dimonaktifkan dulu karena kadang bermasalah di HP, 27 Feb 2026
					/*if (isAutoReadEnabled && finalOutput) {
						// Batalkan suara sebelumnya agar tidak tumpang tindih (opsional tapi bagus)
						//window.speechSynthesis.cancel(); 
						
						setTimeout(() => {
							// Pastikan setelah delay, user belum menghapus teksnya
							if (outputTextarea.value.trim() !== "") {
								speakText(finalOutput, 'speak-output-button');
							}
						}, 500); // Jeda 0.5 detik
					} */
					
					// --- PICU TOMBOL SUARA, baca text setelah ketik ---, 31 jan 2026
					/*const btnSuara = document.getElementById('speak-output-button'); 
					if (btnSuara) {
						// Delay (100ms) agar teks terisi sempurna dulu di textarea
						setTimeout(() => {
							btnSuara.click();
						}, 100);
					}*/
					// -----------------------------------
					
                } else if (data.message) {
                    outputTextarea.value = `Error: ${data.message}`;
                } else {
                    outputTextarea.value = "Terjemahan tidak ditemukan atau terjadi masalah server.";
                }

            } catch (error) {
                console.error('Fetch error:', error);
                outputTextarea.value = `Gagal terhubung ke server penerjemahan. (${error.message})`;
            } finally {
				// PROSES SELESAI - BUKA KUNCI
				isTranslating = false;
				
                loadingIndicator.classList.add('hidden');
				// PERBAIKAN 2: Panggil setButtonState setelah output terisi
				setButtonState(false);
            }
			
			
        }
        
        // Buat versi debounced dari fungsi terjemahan, menunggu 500ms
        const debouncedTranslate = debounce(performTranslation, 500);
        
		// --- FUNGSI BARU: Update State Tombol Suara ---
		function handleInputChange() {
			setButtonState(false); // Update status tombol input secara instan
			debouncedTranslate(); // Lanjutkan dengan terjemahan
		}
		
		
/////////////Translator bahasa asing ke indonesia sehingga kamus kambera tetap bekerja //////////////
		// 1. Definisikan Cache di scope global
		const translationCache = {};

		// 2. Fungsi untuk mendeteksi bahasa dari label tombol navigasi
		function getActiveLanguage(bahasabaru) {
			
			//if (!bahasabaru) return 'id-ID';
			
			//const currentLangText = bahasabaru.innerText.trim();
			
			// 1. Cari objek bahasa di dalam array 'languages' yang namanya cocok dengan label
			const foundLang = languages.find(lang => lang.name === bahasabaru);

			// 2. Ambil kodenya jika ketemu, jika tidak (seperti Sumba Kambera) default ke 'id-ID'
			window.switchkodebahasa = foundLang ? foundLang.code : 'id-ID';
		
			// 3. Return kodenya agar bisa digunakan oleh fungsi lain
			return window.switchkodebahasa;
		}

		// 3. Pasang Event Listener pada container navigasi
		// Ambil elemen-elemen kunci
		const mobileToggle = document.getElementById('mobile-menu-toggle');
		const deskMenuContainer = document.getElementById('language-list-desk-menu');
		const mobMenuContainer = document.getElementById('language-list-mob');
		
		//deteksi mode (Cek apakah hamburger sedang muncul/display tidak none)
		const isMobileMode = window.getComputedStyle(mobileToggle).display !== 'none';

		let gantibahasa;
		let labelId;

		if (isMobileMode) {
			// JALUR MOBILE
			gantibahasa = mobMenuContainer;
			labelId = 'button-label-mob';
			console.log("Mode Mobile Aktif");
		} else {
			// JALUR DESKTOP
			gantibahasa = deskMenuContainer;
			labelId = 'button-label-desk';
			console.log("Mode Desktop Aktif");
		}
		
		if (gantibahasa || kodebahasa != 'id-ID') { 
			gantibahasa.addEventListener('click', function(e) { 
				
				const labelElement = document.getElementById(labelId);
				if (!labelElement) return;

				const bahasabaru = labelElement.innerText.trim();
				
				//jika bahasa yang sama diklik, batalkan proses transalasi
				if(bahasabaru === window.namabahasa){
					return;
				}
				
				//simpan bahasa BARU
				window.namabahasa = bahasabaru;
				
				// Gunakan setTimeout 0 agar script berjalan SETELAH 
				// script internal navigasi Anda selesai mengubah teks label tombol
				setTimeout(() => {
					const currentLang = getActiveLanguage(bahasabaru); 
					applyLanguageUI(currentLang); //ubah UI
					idVoice = getDynamicVoice(currentLang); //ubah suara
				}, 50);
			});
			
			//jika tidak ada penggantian bahasa dari navigasi, maka ini berati
			//hanya loading halaman awal sehingga kode bahasa tersimpan di browser yang digunakan
			applyLanguageUI(kodebahasa);
		}

		// 4. Fungsi penyesuaian UI
		function applyLanguageUI(kode) {
			if (kode !== 'id-ID') { 
				inputForeign.classList.remove('hidden');
				inputTextarea.classList.add('hidden');
				
					
				// Buat pengamat (Observer) untuk mendeteksi saat teks ghost berubah
				const observer = new MutationObserver((mutations) => {
					mutations.forEach((mutation) => {
						const teksBaru = ghost.innerText.trim();
						if (teksBaru !== "") { 
							// 1. Salin teks yang SUDAH diterjemahkan ke inputForeign
							inputForeign.value = teksBaru;
							
							// 2. Berhenti mengamati jika sudah dapat hasilnya
							observer.disconnect(); 
							
						}
					});
				});

				// Mulai mengamati perubahan teks di dalam ghost
				observer.observe(ghost, { characterData: true, childList: true, subtree: true });
			
					
			} else {
				inputForeign.classList.add('hidden');
				inputTextarea.classList.remove('hidden');
				
			}
			
			sourceLangName.forEach(el => {
				el.textContent = '( '+window.namabahasa+' )';
			});
			
			//baca otomatis
			//if(outputTextarea.value !== ""){
			//	speakText(outputTextarea.value, 'speak-output-button');
			//}
		}

		// 5. Listener Input (Biarkan satu saja, tidak perlu diubah-ubah)
		inputForeign.addEventListener('input', debounce(async function() {
		const textToTranslate = inputForeign.value.trim();
		
		//update text inputan ke html ghost
		syncToGhost(inputForeign.value);
		
		if (textToTranslate.length < 2) return;

		if (translationCache[textToTranslate]) {
			inputTextarea.value = translationCache[textToTranslate];
			handleInputChange();
			return;
		}

		try {
			const response = await fetch("{{ route('bridge.translate') }}", {
				method: 'POST',
				headers: {
					'Content-Type': 'application/json',
					'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
				},
				body: JSON.stringify({ text: textToTranslate })
			});

			const data = await response.json();
			if (data.status === 'success') {
				translationCache[textToTranslate] = data.translated;
				inputTextarea.value = data.translated;
				
				handleInputChange();
			}
		} catch (error) {
			console.error('Bridge Error:', error);
		}
	}, 350));
	
	function syncToGhost(text) { //div tersembunyi yang menyimpan content dari inputtext sehingga tetap bisa digunakan meskipun bahasa diganti
		if (ghost) {
			ghost.innerText = text;
		}
	}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////		
		
		
		
        // --- Event Listener Real-Time ---
        inputTextarea.addEventListener('input', handleInputChange); // <-- PERBAIKAN 3: Memanggil fungsi baru

        // --- Logika Swap Bahasa ---
        /*function swapLanguages() {
            isIdToSbkMode = !isIdToSbkMode;
            
            const tempValue = inputTextarea.value;
            inputTextarea.value = outputTextarea.value;
            outputTextarea.value = tempValue;

            if (isIdToSbkMode) {
                inputLabel.textContent = 'Teks Sumber (Indonesia)';
                outputLabel.textContent = 'Hasil Terjemahan (Sumba Kambera)';
                inputTextarea.placeholder = "Masukkan kata atau kalimat Bahasa Indonesia di sini...";
            } else {
                inputLabel.textContent = 'Teks Sumber (Sumba Kambera)';
                outputLabel.textContent = 'Hasil Terjemahan (Indonesia)';
                inputTextarea.placeholder = "Masukkan kata atau kalimat Sumba Kambera di sini...";
            }
            
            inputTextarea.focus();
            debouncedTranslate(); // Panggil terjemahan setelah swap
        }

        swapButton.addEventListener('click', swapLanguages);
        
        if (inputTextarea.value.trim() !== "") {
            debouncedTranslate();
        } */

        // --- FUNGSI MODAL REUSABLE ---
        const showModal = (modalEl) => {
            modalEl.classList.remove('hidden');
            setTimeout(() => modalEl.classList.remove('opacity-0'), 10);
        };

        const hideModal = (modalEl) => {
            modalEl.classList.add('opacity-0');
            setTimeout(() => {
                modalEl.classList.add('hidden');
                // Cleanup forms and status
                if (modalEl === modal) {
                    addWordForm.reset();
                    document.getElementById('error-id-word').textContent = '';
                    document.getElementById('error-sbk-word').textContent = '';
                } else if (modalEl === editModal) {
                    editWordForm.reset();
                    editStatusMessage.textContent = '';
                    updateWordButton.disabled = true;
                    editIdWordInput.disabled = true;
                    editSbkWordInput.disabled = true;
                    editStatusMessage.classList.remove('text-red-500', 'text-green-600', 'text-yellow-600');
                    loadingEditSearch.classList.add('hidden');
                } else if (modalEl === deleteModal) {
                    deleteWordForm.reset();
                    deleteConfirmationText.innerHTML = 'Cari kata di atas untuk konfirmasi penghapusan.';
                    confirmDeleteButton.disabled = true;
                    confirmDeleteButton.dataset.idWord = '';
                    deleteConfirmationText.classList.remove('bg-red-100', 'bg-yellow-100');
                    deleteConfirmationText.classList.add('bg-red-50');
                }
            }, 300);
        };

        // --- Event Listeners untuk Tombol Modal ---
        addWordButton.addEventListener('click', () => showModal(modal));
        editWordButton.addEventListener('click', () => showModal(editModal));
        deleteWordButton.addEventListener('click', () => showModal(deleteModal));

        // Event listeners untuk tombol 'Batal' dan klik overlay
        document.querySelectorAll('.close-modal').forEach(button => {
            button.addEventListener('click', () => {
                const modalTargetId = button.dataset.modalTarget;
                const modalEl = document.getElementById(modalTargetId);
                if (modalEl) hideModal(modalEl);
            });
        });

        [modal, editModal, deleteModal].forEach(m => {
            m.addEventListener('click', (e) => {
                if (e.target === m) {
                    hideModal(m);
                }
            });
        });
        
        // --- LOGIKA TAMBAH KATA (DILENGKAPI) ---
        addWordForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            document.getElementById('error-id-word').textContent = '';
            document.getElementById('error-sbk-word').textContent = '';

            const idWord = idWordInput.value.trim().toLowerCase();
            const sbkWord = sbkWordInput.value.trim().toLowerCase();

            if (!idWord || !sbkWord) {
                showNotification("Harap isi kedua kolom kata.", false);
                return;
            }

            saveWordButton.disabled = true;
            
            const requestOptions = {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({ id_word: idWord, sbk_word: sbkWord })
            };

            try {
                const response = await fetchWithBackoff(addWordApiUrl, requestOptions);
                const data = await response.json();

                if (data.status === 'success') {
                    showNotification(`Kata "${data.word}" berhasil disimpan!`, true);
                    hideModal(modal);
                    debouncedTranslate(); 
                } else if (data.status === 'validation_error') {
                    if (data.errors.id_word) {
                        document.getElementById('error-id-word').textContent = data.errors.id_word[0];
                    }
                    // MELENGKAPI: Penanganan error sbk_word
                    if (data.errors.sbk_word) {
                        document.getElementById('error-sbk-word').textContent = data.errors.sbk_word[0];
                    }
                    showNotification("Gagal menyimpan. Ada kesalahan validasi.", false);
                } else {
                    showNotification(data.message || "Gagal menyimpan kata baru.", false);
                }
            } catch (error) {
                console.error('Add Word error:', error);
                showNotification(`Gagal koneksi ke server: ${error.message}`, false);
            } finally {
                saveWordButton.disabled = false;
            }
        });

        // --- FUNGSI PENCARIAN REUSABLE UNTUK EDIT/HAPUS ---
        const searchDictionary = async (word, mode, targetModal) => {
            const isEditMode = targetModal === 'edit';

            // Elemen Status & Loading
            const statusEl = isEditMode ? editStatusMessage : deleteConfirmationText;
            const loadingEl = isEditMode ? loadingEditSearch : null;
            const actionButton = isEditMode ? updateWordButton : confirmDeleteButton;
            
            // Reset UI
            statusEl.textContent = isEditMode ? '' : 'Cari kata di atas untuk konfirmasi penghapusan.';
            statusEl.classList.remove('text-red-500', 'text-green-600', 'text-yellow-600');
            statusEl.classList.add(isEditMode ? 'text-sm' : 'text-lg');
            actionButton.disabled = true;
            if (!isEditMode) confirmDeleteButton.dataset.idWord = '';

            if (word.length < 2) {
                if (loadingEl) loadingEl.classList.add('hidden');
                return;
            }

            if (loadingEl) loadingEl.classList.remove('hidden');

            try {
                const url = `${searchWordApiUrl}?word=${encodeURIComponent(word.toLowerCase())}&mode=${mode}`;
                const response = await fetchWithBackoff(url, { method: 'GET' });
                const data = await response.json();

                if (data.status === 'success' && data.word_pair) {
                    const pair = data.word_pair;
                    
					 // Simpan ID unik ke field tersembunyi
                        editUniqueId.value = pair.id; // <-- PENTING: Menyimpan ID
                    if (isEditMode) {
						
						
                        // Populate Edit Form
                        editIdWordInput.value = pair.id_word;
                        editSbkWordInput.value = pair.sbk_word;
                        editOriginalId.value = pair.id_word;
                        editOriginalSbk.value = pair.sbk_word;
                        editIdWordInput.disabled = false;
                        editSbkWordInput.disabled = false;
                        updateWordButton.disabled = false;
                        statusEl.textContent = `Kata ditemukan: ${pair.id_word} ↔ ${pair.sbk_word}. Siap diedit.`;
                        statusEl.classList.add('text-green-600', 'font-medium');
                    } else {
                        // Populate Delete Confirmation
                        statusEl.innerHTML = `**Konfirmasi Hapus:** Anda akan menghapus pasangan kata **"${pair.id_word}"** (ID) ↔ **"${pair.sbk_word}"** (SBK). Tindakan ini tidak dapat dibatalkan.`;
                        confirmDeleteButton.disabled = false;
                        confirmDeleteButton.dataset.idWord = pair.id; // Store the key for deletion
						confirmDeleteButton.dataset.idWord = pair.id_word; // Menyimpan kata untuk notifikasi
                        statusEl.classList.remove('bg-red-50');
                        statusEl.classList.add('bg-red-100');
                    }
                } else {
                    statusEl.textContent = `Kata "${word}" tidak ditemukan. Cek kembali mode bahasa.`;
                    statusEl.classList.add('text-red-500');
                    if (!isEditMode) {
                         statusEl.classList.remove('bg-red-100');
                         statusEl.classList.add('bg-red-50');
                    }
                }
            } catch (error) {
                console.error('Search error:', error);
                statusEl.textContent = 'Gagal mencari kata karena masalah koneksi.';
                statusEl.classList.add('text-red-500');
            } finally {
                if (loadingEl) loadingEl.classList.add('hidden');
            }
        };

        // Debounce untuk Search (Edit)
        const debouncedEditSearch = debounce(() => {
            const word = editSearchInput.value.trim();
            const mode = document.querySelector('input[name="edit_language_mode"]:checked').value;
            searchDictionary(word, mode, 'edit');
        }, 500);

        // Debounce untuk Search (Delete)
        const debouncedDeleteSearch = debounce(() => {
            const word = deleteSearchInput.value.trim();
            const mode = document.querySelector('input[name="delete_language_mode"]:checked').value;
            searchDictionary(word, mode, 'delete');
        }, 500);

        // Event Listeners untuk Pencarian Edit
        editSearchInput.addEventListener('input', debouncedEditSearch);
        editModeRadios.forEach(radio => radio.addEventListener('change', debouncedEditSearch));

        // Event Listeners untuk Pencarian Delete
        deleteSearchInput.addEventListener('input', debouncedDeleteSearch);
        deleteModeRadios.forEach(radio => radio.addEventListener('change', debouncedDeleteSearch));

        // --- LOGIKA SUBMIT EDIT KATA ---
        const updateWord = async (e) => {
            e.preventDefault();

			// --- PERUBAHAN KRUSIAL DI SINI ---
            const uniqueId = editUniqueId.value; // <-- Ambil ID unik dari field tersembunyi
            // --- END PERUBAHAN KRUSIAL ---

            const originalId = editOriginalId.value; // Original ID Word (hanya untuk validasi duplikasi di backend)
            const newIdWord = editIdWordInput.value.trim().toLowerCase();
            const newSbkWord = editSbkWordInput.value.trim().toLowerCase();

            if (!originalId || !newIdWord || !newSbkWord) {
                showNotification('Data kata tidak lengkap.', false);
                editStatusMessage.textContent = 'Data tidak lengkap. Harap cari ulang kata.';
                editStatusMessage.classList.add('text-red-500');
                return;
            }

            updateWordButton.disabled = true;
            editStatusMessage.textContent = 'Menyimpan perubahan...';
            editStatusMessage.classList.remove('text-red-500', 'text-green-600');
            editStatusMessage.classList.add('text-yellow-600');


            const requestOptions = {
                method: 'PUT', // Menggunakan method PUT untuk update
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({
                    original_id_word: originalId, // Masih dikirim untuk pengecekan validasi unik (walaupun tidak mutlak diperlukan jika Anda tidak mengirim 'id' di body)
                    id_word: newIdWord,
                    sbk_word: newSbkWord
                })
            };

            try {
                // Menggunakan originalId sebagai identifikasi di URL
				 // --- PERUBAHAN KRUSIAL DI SINI: Menggunakan ID unik di URL ---
                const response = await fetchWithBackoff(`${updateWordApiUrl}/${uniqueId}`, requestOptions);
                const data = await response.json();

                if (data.status === 'success') {
                    showNotification(`Kata "${originalId}" berhasil diperbarui.`, true);
					
                    hideModal(editModal);
                    debouncedTranslate();
                } else {
                    const errorMsg = data.message || 'Gagal menyimpan perubahan kata. Cek input Anda.';
                    editStatusMessage.textContent = errorMsg;
                    editStatusMessage.classList.remove('text-yellow-600');
                    editStatusMessage.classList.add('text-red-500');
                    showNotification(`Gagal memperbarui: ${errorMsg}`, false);
                }
            } catch (error) {
                console.error('Update error:', error);
                editStatusMessage.textContent = `Gagal koneksi ke server: ${error.message}`;
                editStatusMessage.classList.remove('text-yellow-600');
                editStatusMessage.classList.add('text-red-500');
                showNotification('Gagal koneksi ke server saat memperbarui kata.', false);
            } finally {
                updateWordButton.disabled = false;
            }
        };
        editWordForm.addEventListener('submit', updateWord);

        // --- LOGIKA SUBMIT HAPUS KATA ---
        const deleteWord = async (e) => {
            e.preventDefault();
			
			// --- PERUBAHAN KRUSIAL DI SINI ---
            const uniqueId = editUniqueId.value; // <-- Ambil ID unik dari field tersembunyi
            // --- END PERUBAHAN KRUSIAL ---

            const idWordToDelete = confirmDeleteButton.dataset.idWord; 

            if (!idWordToDelete) {
                showNotification('Kata yang akan dihapus tidak valid. Silakan cari kata terlebih dahulu.', false);
                return;
            }

            confirmDeleteButton.disabled = true;
            deleteConfirmationText.innerHTML = `Sedang menghapus kata **"${idWordToDelete}"**...`;
            deleteConfirmationText.classList.remove('bg-red-100');
            deleteConfirmationText.classList.add('bg-yellow-100');

            const requestOptions = {
                method: 'DELETE', // Menggunakan method DELETE
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json'
                },
            };

            try {
                // Menggunakan idWordToDelete sebagai identifikasi di URL
                const response = await fetchWithBackoff(`${deleteWordApiUrl}/${uniqueId}`, requestOptions);
                
                if (response.ok || response.status === 204) {
                    showNotification(`Kata "${idWordToDelete}" berhasil dihapus.`, true);
                    hideModal(deleteModal);
                    debouncedTranslate();
                } else {
                    const errorData = await response.json();
                    const errorMsg = errorData.message || 'Error server saat menghapus kata.';
                    showNotification(`Gagal menghapus: ${errorMsg}`, false);
                    deleteConfirmationText.innerHTML = `**Gagal Hapus:** ${errorMsg}`;
                    deleteConfirmationText.classList.remove('bg-yellow-100');
                    deleteConfirmationText.classList.add('bg-red-100');
                }
            } catch (error) {
                console.error('Delete error:', error);
                showNotification(`Gagal koneksi ke server: ${error.message}`, false);
            } finally {
                confirmDeleteButton.disabled = false;
            }
        }
        deleteWordForm.addEventListener('submit', deleteWord);


// =======================================================
		// --- WEB SPEECH API (TEXT-TO-SPEECH) IMPLEMENTATION ---
		// =======================================================
		
		
		/**
			 * Mencari suara berdasarkan kode bahasa yang aktif (misal: 'ja-JP', 'fr-FR', 'id-ID')
			 * @param {string} langCode - Kode bahasa target
			 * @returns {SpeechSynthesisVoice | null}
			 */
			const getDynamicVoice = (langCode) => { 
			if (!synthesis) return null;
			const voices = synthesis.getVoices();

			// 1. Prioritas Utama: Cari suara Google untuk bahasa tersebut (karena lebih stabil)
			let selectedVoice = voices.find(v => v.lang.startsWith(langCode.split('-')[0]) && v.name.includes('Google'));

			// 2. Cari yang benar-benar pas (Exact Match)
			if (!selectedVoice) {
				selectedVoice = voices.find(voice => voice.lang === langCode);
			}

			// 3. Cari yang depannya sama (Partial Match)
			if (!selectedVoice) {
				const shortCode = langCode.split('-')[0];
				selectedVoice = voices.find(voice => voice.lang.startsWith(shortCode));
			}

			// 4. JANGAN gunakan 'id' sebagai fallback untuk teks non-id
			// Biarkan browser yang menentukan voice default-nya sendiri
			return selectedVoice || null; 
		};
		
		function setButtonState(disabled) { 
			if (!isTTSAvailable) { 
				speakInputButton.disabled = true;
				speakOutputButton.disabled = true;
			} else { 
				speakInputButton.disabled = disabled || inputTextarea.value.trim() === "";
				speakOutputButton.disabled = disabled || outputTextarea.value.trim() === "";
			}
		}

		function setupTTS() { 
			if (!isTTSAvailable) {
				console.warn("Web Speech API (TTS) tidak didukung di browser ini.");
				showNotification("Fitur Baca Teks tidak didukung di browser Anda.", false);
				setButtonState(true);
				return;
			}
			
			idVoice = getDynamicVoice(window.switchkodebahasa);
			

			if (!idVoice && synthesis.onvoiceschanged === null) {
				// Jika suara belum dimuat, pasang event listener
				synthesis.onvoiceschanged = () => {
					idVoice = getDynamicVoice(window.switchkodebahasa);
					if (idVoice) {
						console.log("Suara TTS Indonesia berhasil dimuat.");
						setButtonState(false);
						synthesis.onvoiceschanged = null; // Hapus listener setelah sukses
					}
				};
			} else if (idVoice) {
				// Jika suara sudah dimuat
				setButtonState(false);
			} else {
				// Jika suara tidak ditemukan meskipun API tersedia (jarang terjadi)
				console.warn("Suara Indonesia (id-ID) tidak ditemukan. Fitur baca dinonaktifkan.");
				setButtonState(true);
			}
		}
		
		
		// Variabel untuk menyimpan ikon (agar rapi)
		const SVG_SPEAKER = `<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M9.383 3.076A1 1 0 0110 4v12a1 1 0 01-1.383.924L4.69 13H2a1 1 0 01-1-1V8a1 1 0 011-1h2.69l4.312-3.924zM16 11a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM16 8a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM13 14a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1z" clip-rule="evenodd"></path></svg>`;
		const SVG_STOP = `<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8 7a1 1 0 00-1 1v4a1 1 0 001 1h4a1 1 0 001-1V8a1 1 0 00-1-1H8z" clip-rule="evenodd"></path></svg>`;
		
		// Ikon Speaker Coret (Off)
		const SVG_SPEAKER_OFF = `<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M9.383 3.076A1 1 0 0110 4v12a1 1 0 01-1.383.924L4.69 13H2a1 1 0 01-1-1V8a1 1 0 011-1h2.69l4.312-3.924zM16 11a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM16 8a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM13 14a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1z"></path><path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A5.014 5.014 0 0016 11V10a1 1 0 10-2 0v1c0 .41-.06.807-.174 1.179l-11.119-11.12z" clip-rule="evenodd"></path></svg>`;
		
		function speakText(text, buttonId, isManual = false) {
			
			// Panggil fungsi pencari suara lagi
			idVoice = getDynamicVoice(window.switchkodebahasa);
			
			const btn = document.getElementById(buttonId);
			const iconContainer = btn.querySelector('span') || btn;

			if (window.speechSynthesis.speaking) {
				// JIKA USER KLIK MANUAL -> BARU BOLEH BERHENTI (CANCEL)
				if (isManual) { 
					window.speechSynthesis.cancel();
					resetIconStatus();
					return;
				} 
				// JIKA OTOMATIS (DARI KETIKAN) -> JANGAN CANCEL, BIARKAN SELESAI
				else { 
					return; 
				}
			}

			if (!text.trim()) return;

			const utterance = new SpeechSynthesisUtterance(text);

			// 1. Tentukan Bahasa & Suara secara bersamaan
			if (buttonId === "speak-output-button") {
				// KHUSUS OUTPUT (SUMBA): Paksa ke Indonesia
				utterance.lang = 'id-ID';
				
				// Cari suara Indonesia asli agar tidak menggunakan suara asing yang tersimpan di idVoice
				const indoVoice = synthesis.getVoices().find(v => v.lang.startsWith('id'));
				if (indoVoice) utterance.voice = indoVoice;
			} else {
				// UNTUK INPUT: Gunakan suara dinamis yang sudah dipilih
				utterance.lang = idVoice ? idVoice.lang : (window.switchkodebahasa || 'id-ID');
				utterance.voice = idVoice; // Gunakan objek suara yang sudah ditemukan
			}

			// 2. Opsional: Sesuaikan kecepatan agar lebih enak didengar
			utterance.rate = 0.9; // Sedikit lebih lambat agar artikulasi jelas

			utterance.onstart = () => {
				// Hanya ubah jadi ikon STOP (kotak) jika suara sedang jalan
				iconContainer.innerHTML = SVG_STOP;
				btn.classList.add('text-red-600');
			};

			// Fungsi helper untuk meriset ikon ke status yang benar (Speaker atau Speaker Coret)
			const resetIconStatus = () => {
				iconContainer.innerHTML = isAutoReadEnabled ? SVG_SPEAKER : SVG_SPEAKER_OFF;
				btn.classList.remove('text-red-600');
			};

			utterance.onend = resetIconStatus;
			utterance.onerror = resetIconStatus;

			window.speechSynthesis.speak(utterance);
		}
		
		// Fungsi tambahan untuk mereset semua ikon ke Play, 31 jan 2026
		function resetAllSpeakButtons() {
			[speakInputButton, speakOutputButton].forEach(btn => {
				const container = btn.querySelector('span') || btn;
				container.innerHTML = iconSpeaker;
				btn.classList.remove('text-red-600');
			});
		}
		
		
		function toggleAutoRead() {
			isAutoReadEnabled = !isAutoReadEnabled;
			const btn = document.getElementById('speak-output-button');
			const container = document.getElementById('icon-output-status');

			if (isAutoReadEnabled) {
				container.innerHTML = SVG_SPEAKER;
				btn.classList.remove('text-gray-400');
				btn.classList.add('text-gray-500');
			} else {
				container.innerHTML = SVG_SPEAKER_OFF;
				btn.classList.remove('text-gray-500');
				btn.classList.add('text-gray-400');
				window.speechSynthesis.cancel(); // Matikan suara jika sedang bunyi
			}
		}
		
		
		// Event Listener untuk tombol suara Input, 2 peb 2026
		speakInputButton.addEventListener('click', () => {

			let textToRead;

			// Jika kode BUKAN Indonesia, ambil dari inputForeign
			if (window.switchkodebahasa !== 'id-ID') {
				textToRead = inputForeign.value;
			} else {
				textToRead = inputTextarea.value;
			}

			speakText(textToRead, 'speak-input-button');
		});

		speakOutputButton.addEventListener('click', () => {
			// 1. Jalankan fungsi tukar ikon & status, dinonaktifkan karena belum bagus di HP, 27 Feb 2026
			//toggleAutoRead();
			
			// 2. Jika setelah diklik statusnya jadi AKTIF, maka bacakan teksnya
			// Jika statusnya JADI MATI, maka suara akan berhenti (karena speechSSynthesis.cancel ada di dalam toggle)
			if (isAutoReadEnabled && outputTextarea.value.trim() !== "") { 
				speakText(outputTextarea.value, 'speak-output-button', true);// isManual = true
			}
		});
		
		// Inisialisasi TTS saat DOM siap
		setupTTS();
		
		
		

   });
	
	
	/**
	Gunakan tiga lapis pertahanan ini secara bersamaan untuk hasil yang paling stabil:

	Debounce: Menunggu user selesai ngetik.

	isTranslating: Menjamin hanya satu proses API yang jalan dalam satu waktu.

	isManual: Menjamin suara tidak mati kecuali diminta oleh user lewat klik.

	Dengan kombinasi ini, aplikasi Anda bakal terasa sekelas aplikasi profesional seperti Google Translate atau DeepL.
	*/	
</script>
@endsection