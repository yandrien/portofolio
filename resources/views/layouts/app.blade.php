<!DOCTYPE html>
<html lang="id" class="lang-loading">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<!-- Tag meta (digunakan sebagai fallback) -agar warna browser selaras dengan web -->
    <meta name="theme-color" content="#e9f9ed">
    
	<!--icon title -->
	<link rel="icon" type="image/ico" href="{{ asset('favicon.ico') }}">
	<!--untuk perangkat apple-->
	<link rel="apple-touch-icon" href="{{ asset('favicon.ico') }}">
	
    <title>@yield('title', 'Portofolio')</title>
	<!--jika tidak ada internet panggil halaman offline -->
	@include('offline-check')
	
    <!-- Tailwind CSS CDN untuk styling modern 
    <script src="https://cdn.tailwindcss.com"></script>-->
	@vite(['resources/css/app.css', 'resources/js/app.js'])
	
    <!-- Font Awesome untuk ikon media sosial -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Pengaturan font Inter -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');
		
		/*
		SHIELDING LOGIC: Menyembunyikan body selama proses translasi
		CSS ini akan menyembunyikan seluruh isi body selama class lang-loading masih menempel di atas.
		Saya menggunakan visibility: hidden agar browser tetap bisa menghitung tata letak (layout) tanpa menampilkannya */
		html.lang-loading body { visibility: hidden; opacity: 0; }
		
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0fdf4; /* Warna latar belakang hijau sangat muda */
			
			/* Mengatur zoom menjadi 75%
        zoom: 0.75;
        /* Untuk Firefox (Firefox tidak mendukung 'zoom', maka gunakan scale) */
        -moz-transform: scale(0.75);
        -moz-transform-origin: 0 0; */
        
        }
        
        /* Definisi keyframes untuk animasi soft blur */
        @keyframes soft-blur-animate {
            0% { filter: blur(4px); }
            50% { filter: blur(0px); }
            100% { filter: blur(4px); }
        }

        /* Menerapkan animasi pada elemen gambar di hero section */
        .hero-image-animate {
            animation: soft-blur-animate 10s ease-in-out infinite;
        }

        /* Definisi keyframes untuk animasi detak halus pada seluruh hero section */
        @keyframes pulse-subtle {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.01); }
        }

        /* Menerapkan animasi pulse pada hero section */
        .hero-section-pulse {
            animation: pulse-subtle 4s ease-in-out infinite;
        }

        /* Definisi keyframes untuk efek fade-in */
        @keyframes fade-in {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* Kelas untuk transisi fade-in */
        .fade-in {
            animation: fade-in 1s ease-in-out;
        }
		
		.text-outline {
            color: green; /* Warna teks utama */
            text-shadow:
                -1px -1px 0 #fff,
                1px -1px 0 #fff,
                -1px 1px 0 #fff,
                1px 1px 0 #fff;
        }
		
		.text-outline-black {
            text-shadow: 
                -1px -1px 0 #000,
                 1px -1px 0 #000,
                -1px 1px 0 #000,
                 1px 1px 0 #000;
        }
		
		/****jaga content dari efek google translate*******/
		/* Mengunci agar link navigasi Anda tetap bersih */
    [data-key^="nav_"] font,
    [data-key^="nav_"]:hover font {
        background-color: transparent !important;
        background: none !important;
        box-shadow: none !important;
        color: inherit !important; /* Menjamin warna text-green-300 Anda yang menang */
    }

    /* Mencegah highlight pada link yang sedang aktif/dihover */
    .goog-text-highlight {
        background: none !important;
        box-shadow: none !important;
    }
	
	/* Custom scrollbar untuk dropdown bahasa agar tipis dan keren */
	.custom-scrollbar::-webkit-scrollbar {
		width: 4px;
	}
	.custom-scrollbar::-webkit-scrollbar-track {
		background: transparent;
	}
	.custom-scrollbar::-webkit-scrollbar-thumb {
		background: #4b5563; /* Warna abu-abu gelap */
		border-radius: 10px;
	}
	.custom-scrollbar::-webkit-scrollbar-thumb:hover {
		background: #15803d; /* Warna hijau saat hover */
	}

	/*sembunyikan scrollbar menu di mobile*/
	/* Sembunyikan scrollbar untuk Chrome, Safari dan Opera */
	.no-scrollbar::-webkit-scrollbar {
		display: none;
	}

	/* Sembunyikan scrollbar untuk IE, Edge dan Firefox */
	.no-scrollbar {
		-ms-overflow-style: none;  /* IE and Edge */
		scrollbar-width: none;  /* Firefox */
	}
    </style>
	 <!-- BAGIAN KRUSIAL: Meneruskan variabel .env ke Global Window Object -->
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<script>
		window.LaravelEnv = {
			baseUrl: "{{ url('/') }}",
			csrfToken: "{{ csrf_token() }}"
		};
	</script>
</head>
<body>

<!-- HEADER: Berisi logo dan navigasi utama -->
<header id="header" class="fixed top-0 left-0 w-full bg-transparent z-50 transition-transform duration-300 ease-in-out">
    <div class="w-full px-4 sm:px-8 flex justify-between items-center h-16">
		
			<!-- Grup Logo atau Foto Profil -->
		<div class="flex items-center">
			
			@guest
				<!-- Tampilkan Logo hanya jika pengguna BELUM login -->
				<img src="{{ asset('images/ylaw-logon.webp') }}" alt="AT Logo" class="h-6 w-auto md:h-8 md:w-auto">
			@endguest

			@auth
				<!-- Tampilkan Foto Profil atau Inisial jika SUDAH login -->
				<div id="useraktif" class="flex items-center">
					@if(Auth::user()->avatar)
						<img src="{{ Auth::user()->avatar }}" 
							 alt="Profil" 
							 class="w-8 h-8 md:w-10 md:h-10 rounded-full border-2 border-white shadow-sm object-cover">
					@else
						<!-- Jika foto tidak ada, tampilkan lingkaran dengan huruf awal nama -->
						<div class="w-8 h-8 md:w-10 md:h-10 rounded-full bg-green-900 flex items-center justify-center text-white font-bold text-sm md:text-base shadow-sm border-2 border-white">
							{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
						</div>
					@endif
					
				</div>
			@endauth

		</div>
					
			<!-- Menu Mobile yang Tersembunyi -->
		
			
			<div id="mobile-menu" class="mobile-menu no-scrollbar hidden w-[62.5%] max-w-xs rounded-bl-[50px] fixed top-0 right-0 bg-black bg-opacity-90 shadow-lg py-4 transition-all duration-300 ease-in-out max-h-screen overflow-y-auto">

				<div class="px-8 py-2 border-b border-gray-700">
					<div class="relative w-full">
						<button id="dropdown-toggle-mob" name="language_selector_mob"
								class="language-button flex justify-start items-center px-0 py-1 bg-transparent text-white hover:text-green-600 font-normal transition duration-300 w-full text-left">
							<svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
							</svg>
							<span id="button-label-mob" class="hover:underline">Indonesia</span>
							<svg class="w-4 h-4 ml-2" fill="currentColor" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" /></svg>
						</button>

						<div id="language-dropdown-mob" 
							 class="absolute left-0 mt-2 w-full bg-gray-800 border border-gray-700 rounded-lg shadow-xl z-50 opacity-0 transform scale-95 transition ease-out duration-200 pointer-events-none origin-top-left max-h-[70vh] overflow-y-auto custom-scrollbar">
							<div id="language-list-mob" class="p-2 space-y-1"></div>
						</div>
					</div>
				</div>

				<a href="{{ route('home') }}" class="flex items-center px-8 py-3 text-white hover:text-green-600 font-normal transition duration-300 border-b border-gray-700">
					<svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
					</svg>
					<span data-key="nav_home">Beranda</span>
				</a>

				<a href="{{ route('profile') }}" class="flex items-center px-8 py-3 text-white hover:text-green-600 font-normal transition duration-300 border-b border-gray-700">
					<svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
					</svg>
					Profil
				</a>

				<div class="relative w-full border-b border-gray-700">
					<button id="selectproduct" name="product_menu" class="flex items-center px-8 py-3 text-white hover:text-green-600 font-normal transition duration-300 w-full text-left">
						<svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
						</svg>
						Aplikasi
					</button>
					<div class="px-12 pb-3 text-white">
						<a href="{{ route('translator.index')}}" class="flex items-center py-1 hover:text-green-600 transition duration-300">
							<span class="mr-2 text-green-500">•</span> Translator Sumba
						</a>
						<a href="https://toko.yandrien.my.id" target="blank" class="flex items-center py-1 hover:text-green-600 transition duration-300">
							<span class="mr-2 text-green-500">•</span> iSales
						</a>
					</div>
				</div>

				<a href="#" id="mcontact-link" class="flex items-center px-8 py-3 text-white hover:text-green-600 font-normal transition duration-300 border-b border-gray-700">
					<svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
					</svg>
					Kontak
				</a>

				<a href="#" id="mlogin-link" class="flex items-center px-8 py-3 text-white hover:text-green-600 font-normal transition duration-300">
					<svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
					</svg>
					<span id="moutin">Login</span>
				</a>
			</div>
		
		<!-- Hamburger Menu untuk Mobile -->
			<button id="mobile-menu-toggle" class="md:hidden text-white focus:outline-none">
				<svg class="w-8 h-8 block" style="filter: drop-shadow(0 0 1px #15803d);" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
					<path style="filter: drop-shadow(0 0 1px #15803d);" id="menu-icon-path" class="transition-all duration-300 ease-in-out" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
				</svg>
			</button>	
		
		
		<nav class="hidden md:flex items-center space-x-4 md:space-x-8 bg-black opacity-75 py-2 px-4 rounded-[10px]">
			<a data-key="nav_home" href="{{ route('home') }}" class="text-white hover:text-green-300 font-semibold transition duration-300 text-sm transform hover:scale-105">Beranda</a>
			<a data-key="nav_profile" href="{{ route('profile') }}" class="text-white hover:text-green-300 font-semibold transition-all duration-300 text-sm transform hover:scale-105">Profil</a>
			<div class="relative inline-block group">
			<button id="mselectproduct" class="text-white hover:text-green-300 font-semibold transition duration-300 flex items-center focus:outline-none text-sm transform hover:scale-105">
				<span data-key="nav_products">Aplikasi</span>
				<svg class="ml-1 w-3 h-3 text-gray-500 group-hover:text-green-300 transition duration-300 transform hover:scale-105" fill="currentColor" viewBox="0 0 20 20">
				<path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
				</svg>
			</button>
			<div class="absolute hidden group-hover:block bg-black shadow-lg rounded-md w-48 py-2 text-white font-semibold z-50">
			<a href="{{ route('translator.index') }}" class="block px-4 py-2 hover:text-green-300 transition duration-300 text-sm transform hover:scale-105">Translator Sumba</a>
			<a href="https://toko.yandrien.my.id" target="blank" class="block px-4 py-2 hover:text-green-300 transition duration-300 text-sm transform hover:scale-105">iSales</a>
			</div>
			</div>
			<a data-key="nav_contact" href="#" id="contact-link" class="text-white hover:text-green-300 font-semibold transition duration-300 text-sm transform hover:scale-105">Kontak</a>
			
			<!-- PEMILIH BAHASA (DESKTOP) - Ditempatkan di sisi kiri menu -->
			<div class="relative inline-block group">
				<button id="dropdown-toggle-desk" 
					class="language-button text-white hover:text-green-300 font-semibold transition duration-300 flex items-center focus:outline-none text-sm transform hover:scale-105">
					<span id="button-label-desk">Indonesia</span>
					<!-- Panah Dropdown -->
					<svg class="ml-1 w-3 h-3 text-gray-500 group-hover:text-green-300 transition duration-300 transform hover:scale-105" fill="currentColor" viewBox="0 0 20 20">
						<path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
					</svg>
				</button>
			
			<!-- Container Dropdown Desktop - Tampil saat group di-hover -->
			<!-- ID ini akan diisi secara dinamis oleh JavaScript menggunakan tag <a> -->
			<div id="language-list-desk-menu"
				 class="absolute hidden group-hover:block bg-black shadow-lg rounded-md w-48 py-2 text-white font-semibold z-50 origin-top-left">
				<!-- Daftar Bahasa (Tag <a>) dimasukkan di sini oleh JS -->
			</div>
			</div>
			
			<!-- END PEMILIH BAHASA DESKTOP -->
			

			<!-- TOMBOL LOGIN DENGAN IKON -->
			<a href="#" id="login-link" class="group relative flex items-center space-x-1 bg-green-600 hover:bg-green-500 px-4 py-1 rounded-xl text-sm font-bold transition duration-300 shadow-lg shadow-green-600/20 active:scale-95">
				<span data-key="nav_login" id="outin">Masuk</span>
				<svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
					<path id="icon-login" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
				</svg>
			</a>
		</nav>
	</div>

</header>
    <main class="overflow-x-hidden">
	<!-- Konten unik dari setiap halaman akan dimasukkan di sini -->
	@yield('content')

@if (request()->is('/') || request()->is('articles'))
<div class="relative"> {{-- Tambahkan div wrapper dengan posisi relatif --}}
    <span data-key="title_buatartikel"
        onclick="
            @auth
                window.location.href = '{{ route('articles.create') }}'
            @else
                document.getElementById('login-link').click();
            @endauth
        "
        class="
            fixed bottom-10 right-2
            bg-green-600 text-white
            p-2
            rounded-full
            shadow-xl
            cursor-pointer
            hover:bg-green-700
            transition duration-300
            flex items-center justify-center
            z-50
            group" {{-- Tambahkan kelas 'group' untuk mengontrol hover --}}
			title="Buat Artike Baru" {{-- title tetap dipertahankan untuk aksesibilitas dan fallback --}}
    >
        {{-- Ikon Plus/Tambah (SVG) --}}
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>

        {{-- Tooltip Kustom (Hanya Muncul saat hover) --}}
        <div class="
            absolute right-full bottom-0 mb-2 mr-4 p-2
            bg-gray-800 text-white text-sm font-semibold
            rounded-md opacity-0 pointer-events-none
            transition duration-300 ease-in-out
            group-hover:opacity-100 group-hover:mr-6
            whitespace-nowrap"
        >
            <span  data-key="tambah_artikel">Tambah Artikel</span>
        </div>
    </span>
</div>
@endif


    </main>
	
	
	

    <!-- FOOTER: Bagian bawah berisi informasi kontak dan hak cipta -->
   <footer class="bg-green-900 text-white py-12 mt-16 rounded-t-xl relative overflow-hidden">
    
    @if(isset($unique_visitors))
    <div id="visitor-stats-kambaniru" class="z-50">
        @php
			$isAdmin = auth()->check() && auth()->user()->is_admin;
		@endphp

    <!-- Jika Admin, bungkus dengan <a>, jika tidak gunakan <div> biasa -->
    <{!! $isAdmin ? 'a href="'.url('/monitoring-pengunjung').'"' : 'div' !!} 
        class="flex flex-row items-center gap-2 text-xs {{ $isAdmin ? 'hover:bg-white/5 transition-colors duration-200 rounded-lg p-1' : '' }}">
            <div class="flex items-center gap-1.5">
                <span>👤</span>
                <span class="font-bold">{{ number_format($unique_visitors, 0, ',', '.') }}</span>
                <span class="opacity-60 uppercase text-[9px]">Unik</span>
            </div>
            <div class="w-px h-3 bg-white/20"></div>
            <div class="flex items-center gap-1.5">
                <span>📈</span>
                <span class="font-bold">{{ number_format($total_hits, 0, ',', '.') }}</span>
                <span class="opacity-60 uppercase text-[9px]">Hits</span>
            </div>
            <div class="w-px h-3 bg-white/20"></div>
            <div class="flex items-center gap-1.5 text-green-300">
                <span>🌍</span>
                <span class="font-bold uppercase tracking-tight">
                    @forelse($top_countries as $c)
                        {{ $c->country }}
                    @empty
                        -
                    @endforelse
                </span>
            </div>
        </{!! $isAdmin ? 'a' : 'div' !!}>
    </div>
    @endif

    <div class="container mx-auto px-4 text-center">
        <h3 class="text-xl font-bold mb-4">Yandrien Wohangara</h3>
        <div class="flex justify-center items-center space-x-6 mb-6">
            <a href="https://www.facebook.com/yandrien wohangara" target="_blank" class="text-white hover:text-green-300 transition-colors duration-300">
                <i class="fa-brands fa-square-facebook text-4xl"></i>
            </a>
            <a href="https://www.linkedin.com/in/yandrien-wohangara-015147a5/" target="_blank" class="text-white hover:text-green-300 transition-colors duration-300">
                <i class="fa-brands fa-linkedin-in text-4xl"></i>
            </a>
            <a href="https://www.instagram.com/yandrien" target="_blank" class="text-white hover:text-green-300 transition-colors duration-300">
                <i class="fa-brands fa-square-instagram text-4xl"></i>
            </a>
            <a href="https://wa.me/6281805342365" target="_blank" class="text-white hover:text-green-300 transition-colors duration-300">
                <i class="fa-brands fa-square-whatsapp text-4xl"></i>
            </a>
        </div>
        <p class="text-sm mb-2 text-green-200">Sumba Timur - NTT</p>
        <p class="text-xs text-gray-400">Hak Cipta: &copy;2025 - {{ date('Y') }} Kambaniru</p>
    </div>

    <script>
        function adjustVisitorStats() {
            const stats = document.getElementById('visitor-stats-kambaniru');
            if (!stats) return;
            
            if (window.innerWidth >= 1024) {
                stats.style.position = 'absolute';
                stats.style.left = '32px';
                stats.style.top = '32px';
                stats.style.width = 'auto';
                stats.style.display = 'block';
                stats.style.marginBottom = '0';
            } else {
                stats.style.position = 'relative';
                stats.style.left = '0';
                stats.style.top = '0';
                stats.style.width = '100%';
                stats.style.display = 'flex';
                stats.style.justifyContent = 'center';
                stats.style.marginBottom = '40px';
            }
        }
        window.addEventListener('load', adjustVisitorStats);
        window.addEventListener('resize', adjustVisitorStats);
    </script>
</footer>
	
	<!--popup Login-->
	<div id="login-modal" style="background-color: rgba(0, 0, 0, 0.5);" class="fixed inset-0 hidden z-[100] items-center justify-center">
		<div class="bg-white rounded-lg p-8 mx-4 shadow-inner max-w-md w-full max-h-full relative transform transition-all ease-in-out duration-300 scale-95 overflow-y-auto">
			<button id="close-modal-btn" class="absolute top-4 right-4 height-[auto] text-gray-400 hover:text-gray-600 transition duration-300">
				<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
				</svg>
			</button>
			<!-- Perubahan di sini: Menambahkan kelas `absolute top-4 left-4` untuk memosisikan elemen -->
				<span id="keterangan" class="text-[12px] leading-none text-red-600 font-bold absolute top-4 left-1/2 transform -translate-x-1/2"></span>
			<h2 data-key="login_title" class="text-1xl font-bold text-center text-gray-800">Masuk ke Akun Anda</h2>    
			<form action="{{ route('login') }}" method="POST" class="space-y-4">
			@csrf
				<div>
					<label for="email" class="block text-sm font-medium text-gray-700">Email</label>
					<input data-key="email_placeholder" type="email" id="email" name="email" autocomplete="email" class="mt-[-1px] block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm" placeholder="example@gmail.com">
				</div>
				<div>
					<label data-key="sandi" for="password" class="block text-sm font-medium text-gray-700">Kata Sandi</label>
					<div class="relative mt-[-1px]">
						<input type="password" id="password" name="password" autocomplete="current-password" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm pr-10 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm" placeholder="********">
						<span class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer" id="toggle-password">
							<i class="far fa-eye text-gray-400 hover:text-gray-600"></i>
						</span>
					</div>
				</div>
				<div class="flex items-center justify-between">
					<div class="flex items-center">
						<!--<input id="remember_me" name="remember_me" type="checkbox" class="h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
						<label for="remember_me" class="ml-2 block text-sm text-gray-900">Ingat saya</label>-->
					</div>
					<a data-key="lupa_sandi" href="{{ route('password.request') }}" class="text-sm text-green-600 hover:text-green-500 font-medium">Lupa Kata Sandi?</a>
				</div>
				<div>
					<button type="submit" data-key="masuk" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-300">
						Masuk
					</button>
				</div>
			</form>
			<div class="flex items-center my-6">
				<div class="flex-grow border-t border-gray-300"></div>
				<span data-key="opsi_login" class="flex-shrink mx-4 text-gray-500">Atau</span>
				<div class="flex-grow border-t border-gray-300"></div>
			</div>
			<div class="space-y-4 mb-4">
				<a data-key="login_google" href="{{ route('socialite.redirect', ['provider' => 'google']) }}" class="w-full flex items-center justify-center py-2 px-4 rounded-full bg-red-500 text-white font-semibold shadow-md hover:bg-red-600 transition duration-300">
					<i class="fab fa-google text-lg mr-3"></i> Masuk dengan Google
				</a>
				<a data-key="login_fb" href="{{ route('socialite.redirect', ['provider' => 'facebook']) }}" class="w-full flex items-center justify-center py-2 px-4 rounded-full bg-blue-600 text-white font-semibold shadow-md hover:bg-blue-700 transition duration-300">
					<i class="fab fa-facebook text-lg mr-3"></i> Masuk dengan Facebook
				</a>
			</div>
			<!-- Tautan Registrasi Manual yang baru ditambahkan -->
			<p class="text-center text-sm text-gray-600">
				<span data-key="belumpunya_akun">Belum punya Akun?</span> 
				<a data-key="daftar_sini" href="{{ route('register') }}" class="font-medium text-green-600 hover:text-green-500">
					Daftar di sini!
				</a>
			</p>
		</div>
	</div>


<!-- Modal untuk Kontak -->
    <div id="contact-modal" style="background-color: rgba(0, 0, 0, 0.5);" class="fixed inset-0 hidden z-[100] flex items-center justify-center">
    <div class="bg-white rounded-lg p-8 mx-4 shadow-inner max-w-md w-full max-h-full relative transform transition-all ease-in-out duration-300 scale-95 overflow-y-auto">
        <button id="close-contact-modal" name="close-contact-modal" type="button" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition duration-300">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        <h2 data-key="hubungi" class="text-2xl font-bold text-center text-gray-800 mb-6">Hubungi Kami</h2>
        
        <form id="contact-form" action="{{ route('contact.store') }}" method="POST" class="space-y-4">
            @csrf 
            <div>
                <label data-key="namalengkap" for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                <input data-key="placeholdernamalengkap" type="text" id="name" name="name" autocomplete="name" class="mt-[-1px] block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm" placeholder="Nama Anda">
            </div>

            <div>
                <label data-key="labelemail" for="emailcontact" class="block text-sm font-medium text-gray-700">Email</label>
                <input data-key="placeholderemail" type="email" id="emailcontact" name="email" autocomplete="email" class="mt-[-1px] block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm" placeholder="nama@contoh.com">
            </div>

            <div>
                <label data-key="pesan" for="message" class="block text-sm font-medium text-gray-700">Pesan</label>
                <textarea data-key="placeholderpesan" id="message" name="message" rows="4" class="mt-[-1px] block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm" placeholder="Tulis pesan Anda di sini..."></textarea>
            </div>

            <div>
                <button type="submit" name="tombolkirim" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-300">
                    <span data-key="kirimpesan">Kirim Pesan</span>
                </button>
            </div>
        </form>
        </div>
	</div>

    <!-- Modal Konfirmasi -->
    <div id="success-modal" style="background-color: rgba(0, 0, 0, 0.5);" class="fixed inset-0 hidden z-[100] flex items-center justify-center">
        <div class="bg-white p-6 rounded-lg shadow-xl max-w-sm w-full mx-4 transform transition-all duration-300 scale-95">
            <div class="flex flex-col items-center justify-center space-y-4 text-center">
				<div class="bg-green-100 rounded-full p-3 mb-1">
                    <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
				</div>
                <h2 id="modalMessage" class="text-xl font-bold text-gray-800">info</h2>
                
                <button id="closeModal" class="mt-4 px-6 py-2 bg-blue-600 text-white rounded-md font-semibold hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-150 ease-in-out">
                    OK
                </button>
            </div>
        </div>
    </div>

	<!-- Pesan Koneksi internet putus -->
   <div id="error-message-container" class="hidden">
    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-4 rounded-md shadow-sm animate-pulse">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-red-700">
                    <span class="font-bold">Koneksi Terganggu:</span> Gagal memuat library eksternal. Beberapa fitur mungkin tidak berjalan normal.
                </p>
            </div>
        </div>
    </div>
	</div> 

<!--Alpine.js adalah fasilitas untuk modal confirm delete custom, bisa ditambahkan di tag head, atau seperti di bawah ini-->
	<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
	
	<script>
	
		
		// Array berisi URL gambar yang akan dirotasi.
    const images = [
        "{{ asset('images/welcomeimage-forest.webp') }}",
        "{{ asset('images/rumah-pintar.webp') }}",
        "{{ asset('images/drone-farming.webp') }}",
        "{{ asset('images/ai-robot.webp') }}",
    ];
    
    const AUTOSLIDE_INTERVAL_MS = 10000; // 10 detik
    const MANUAL_DELAY_MS = 20000;       // Jeda 20 detik setelah klik manual
    const FADE_DURATION_MS = 500;         // Samakan dengan durasi CSS transition
    
    let currentIndex = 0;
    let autoSlideInterval = null;
    let manualDelayTimeout = null;
    
    const heroImage = document.getElementById('welcomeimage');
    const prevButton = document.getElementById('prevImage');
    const nextButton = document.getElementById('nextImage');
    
    // Fungsi terpusat untuk mengganti gambar dengan efek transisi yang mulus
    function goToSlide(index) {
        if (!heroImage) return;
    
        // 1. Mulai Fade Out
        heroImage.classList.remove('fade-in');
    
        // 2. Tunggu animasi fade-out selesai, baru ganti src dan Fade In kembali
        setTimeout(() => {
            currentIndex = index;
            heroImage.src = images[currentIndex];
            heroImage.classList.add('fade-in');
        }, FADE_DURATION_MS);
    }
    
    function nextSlide() {
        const newIndex = (currentIndex + 1) % images.length;
        goToSlide(newIndex);
    }
    
    function prevSlide() {
        const newIndex = (currentIndex - 1 + images.length) % images.length;
        goToSlide(newIndex);
    }
    
    function startAutoSlide() {
        stopAutoSlide(); // Hindari penumpukan interval ganda
        autoSlideInterval = setInterval(nextSlide, AUTOSLIDE_INTERVAL_MS);
    }
    
    function stopAutoSlide() {
        if (autoSlideInterval) clearInterval(autoSlideInterval);
        if (manualDelayTimeout) clearTimeout(manualDelayTimeout);
    }
    
    function handleManualNavigation(actionFn) {
        stopAutoSlide(); // Hentikan autoslide sementara
        actionFn();      // Jalankan fungsi navigasi (nextSlide / prevSlide)
    
        // Resume autoslide setelah jeda manual
        manualDelayTimeout = setTimeout(() => {
            startAutoSlide();
        }, MANUAL_DELAY_MS);
    }
    
    // --- INISIALISASI ---
    if (heroImage) {

        // Jalankan autoslide
        startAutoSlide();
    
        // Event listeners
        if (prevButton) {
            prevButton.addEventListener('click', () => handleManualNavigation(prevSlide));
        }
    
        if (nextButton) {
            nextButton.addEventListener('click', () => handleManualNavigation(nextSlide));
        }
    }
		
		
		
//kontrol tombol navigasi menu untuk hp
	const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');
	const menuIconPath = document.getElementById('menu-icon-path');

    mobileMenuToggle.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
		
		// Ubah ikon SVG saat menu ditoggle
        if (mobileMenu.classList.contains('hidden')) {
            // Menu tertutup, tampilkan ikon hamburger
            menuIconPath.setAttribute('d', 'M4 6h16M4 12h16M4 18h16');
			
			document.body.style.overflow = ''; // Lepas kunci scroll, 11 peb 2026
        } else {
            // Menu terbuka, tampilkan ikon 'X'
            menuIconPath.setAttribute('d', 'M6 18L18 6M6 6l12 12');
			
			document.body.style.overflow = 'hidden'; // Kunci scroll layar belakang, 11 peb 2026
        }
    });
	
	// Event listener untuk mengklik di luar area menu
	document.addEventListener('click', (e) => {
		// Periksa apakah menu sedang terbuka
		if (!mobileMenu.classList.contains('hidden')) {
			// Jika elemen yang diklik BUKAN tombol toggle DAN BUKAN bagian dari menu, maka tutup menu
			if (!mobileMenuToggle.contains(e.target) && !mobileMenu.contains(e.target)) {
				mobileMenu.classList.add('hidden');
				menuIconPath.setAttribute('d', 'M4 6h16M4 12h16M4 18h16');
				
				document.body.style.overflow = ''; // Lepas kunci scroll, 11 peb 2026
			}
		}
	});

		
		
		 // Temukan tombol login
		const loginLink = document.getElementById('login-link');
		const mloginLink = document.getElementById('mlogin-link');

@guest
		const loginModal = document.getElementById('login-modal');
		const loginContent = loginModal.querySelector('.transform');
		
		const closeModalBtn = document.getElementById('close-modal-btn');
		
		// Pastikan tombol login ditemukan sebelum menambahkan event listener
	if (loginLink) {
		
		// Event listener untuk tombol "Login"
		loginLink.addEventListener('click', (e) => {
			e.preventDefault();
			showModal(loginModal, loginContent);
		});
		
		// Event listener untuk tombol "mobile Login"
		mloginLink.addEventListener('click', (e) => {
			e.preventDefault();
			document.body.style.overflow = 'hidden';
			showModal(loginModal, loginContent);
		});
		
		
		// Event listener untuk tombol tutup (x) di dalam modal
		closeModalBtn.addEventListener('click', () => {
			hideModal(loginModal, loginContent);
		});

		/*// Event listener untuk mengklik di luar area modal
		loginModal.addEventListener('click', (e) => {
			if (e.target === loginModal) {
				hideModal(loginModal, loginContent);
			}
		});*/
		
		// Event listener untuk modal dan modal content
		loginModal.addEventListener('click', (e) => {
			e.stopPropagation(); // Mencegah klik menyebar ke dokumen agar menu hp tidak tertutup
		});
		loginContent.addEventListener('click', (e) => {
			e.stopPropagation(); // Mencegah klik menyebar ke dokumen agar menu hp tidak tertutup
		});
		
		
		/*// Fungsi untuk mendeteksi perangkat seluler
        function isMobileDevice() {
            return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
        }

        // Logika ini hanya akan berjalan jika perangkat terdeteksi sebagai HP
        if (isMobileDevice()) {
		const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');
		
		
		// Event listener untuk menggeser modal ke atas saat input password mendapatkan fokus
        passwordInput.addEventListener('focus', () => {
            modalContent.classList.add('modal-shift-up');
        });
        
        // Event listener untuk menggeser modal kembali ke bawah saat input password kehilangan fokus
        passwordInput.addEventListener('blur', () => {
            // Memberi sedikit penundaan untuk memastikan user tidak mengklik input lain
            setTimeout(() => {
                // Periksa apakah input yang sedang aktif bukan input password
                if (document.activeElement !== passwordInput) {
                    modalContent.classList.remove('modal-shift-up');
                }
            }, 0);
        });
		} */
		
		//Ditambhkan kode ini agar HR bisa live demo dari landing page-22/05/'26
    	function handleLoginModalHash() {
            if (window.location.hash === '#login') {
                showModal(loginModal, loginContent);
            }
        }
        // Eksekusi saat pertama kali halaman dimuat browser
        window.addEventListener('DOMContentLoaded', handleLoginModalHash);
		
	}
	
	// Temukan form login
const loginForm = document.querySelector('#login-modal form');

// Pastikan elemen form ditemukan sebelum menambahkan event listener
if (loginForm) {
	
    loginForm.addEventListener('submit', function(event) {
        // Mencegah pengiriman formulir bawaan
        event.preventDefault();

        // Ambil data formulir
        const formData = new FormData(loginForm);

        // Hapus pesan error sebelumnya (jika ada)
        const existingError = loginForm.querySelector('.text-red-500');
        if (existingError) {
            existingError.remove();
        }

        fetch(loginForm.action, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            },
            body: formData
        })
        .then(response => {
            if (response.status === 401 || response.status === 422) {
                // Tangani respons error dari server
                return response.json().then(errorData => {
                    const errorDiv = document.createElement('div');
                    errorDiv.classList.add('text-red-500', 'text-sm', 'mt-2', 'text-center');
                    errorDiv.textContent = errorData.message || 'Informasi login tidak valid.';
                    loginForm.prepend(errorDiv);
                });
            } else if (response.ok) {
                // Tangani respons sukses
                return window.location.reload();
            } else {
                throw new Error('Terjadi kesalahan yang tidak diketahui.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            const errorDiv = document.createElement('div');
            errorDiv.classList.add('text-red-500', 'text-sm', 'mt-2', 'text-center');
            errorDiv.textContent = 'Terjadi kesalahan jaringan atau server.';
            loginForm.prepend(errorDiv);
        });
    });
}
	
	// JavaScript untuk fungsionalitas show/hide password
    const passwordInput = document.getElementById('password');
    const togglePassword = document.getElementById('toggle-password');

    togglePassword.addEventListener('click', function () {
        // Toggle the type attribute
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);

        // Toggle the eye icon
        this.querySelector('i').classList.toggle('fa-eye');
        this.querySelector('i').classList.toggle('fa-eye-slash'); // Ganti dengan ikon mata terbuka
    });
	
	//fasilitas drag untuk modal content 

	let isDragging = false;
	let startY;
	let initialY;

	loginContent.addEventListener('mousedown', (e) => {
		isDragging = true;
		// Catat posisi awal mouse pada sumbu Y
		startY = e.clientY;
		// Catat posisi awal modal
		const style = window.getComputedStyle(loginContent);
		const matrix = new WebKitCSSMatrix(style.transform);
		initialY = matrix.m42;
		loginContent.style.transition = 'none'; // Hapus transisi selama drag
	});

	loginModal.addEventListener('mousemove', (e) => {
		if (!isDragging) return;
		e.preventDefault();

		// Hitung pergerakan Y
		const currentY = e.clientY;
		const deltaY = currentY - startY;
		const newY = initialY + deltaY;

		// Batasi pergerakan di dalam wadah
		const containerHeight = loginModal.clientHeight;
		const contentHeight = loginContent.clientHeight;
		const minTranslateY = -((containerHeight - contentHeight) / 2);
		const maxTranslateY = (containerHeight - contentHeight) / 2;
		
		const clampedY = Math.max(Math.min(newY, maxTranslateY), minTranslateY);

		// Terapkan posisi baru
		loginContent.style.transform = `translateY(${clampedY}px)`;
	});

	loginModal.addEventListener('mouseup', () => {
		isDragging = false;
		loginContent.style.transition = ''; // Kembalikan transisi setelah drag
	});
	
@endguest


//Modal untuk Kontak
	const contactModal = document.getElementById('contact-modal');
	const contactContent = contactModal.querySelector('.transform');
	
	const contactLink = document.getElementById('contact-link');
	const mcontactLink = document.getElementById('mcontact-link');
	const closeContactModalBtn = document.getElementById('close-contact-modal');
	

	// Event Listener untuk modal Kontak
	if (contactLink) {
		contactLink.addEventListener('click', (e) => {
			e.preventDefault();
			if (!mobileMenu.classList.contains('hidden')) {
				toggleMobileMenu();
			}
			showModal(contactModal, contactContent);
		});
	
	
	//dr menu hp
	mcontactLink.addEventListener('click', (e) => { 
		e.preventDefault();
		document.body.style.overflow = 'hidden';
		showModal(contactModal, contactContent);
	});
	
	//close btn
	closeContactModalBtn.addEventListener('click', () => hideModal(contactModal, contactContent));
	
	/*//clik dimana saja utk close
	contactModal.addEventListener('click', (e) => {
		if (e.target === contactModal) {
			hideModal(contactModal, contactContent);
		}
	});*/
	
	// Event listener untuk modal dan modal content
		contactModal.addEventListener('click', (e) => {
			e.stopPropagation(); // Mencegah klik menyebar ke dokumen agar menu hp tidak tertutup
		});
		contactContent.addEventListener('click', (e) => {
			e.stopPropagation(); // Mencegah klik menyebar ke dokumen agar menu hp tidak tertutup
		});
	}
	
	//Ditambhkan kode ini agar HR bisa live demo dari landing page-23/05/'26
    	function handleContactModalHash() {
            if (window.location.hash === '#contact') {
                showModal(contactModal, contactContent);
            }
        }
        // Eksekusi saat pertama kali halaman dimuat browser
        window.addEventListener('DOMContentLoaded', handleContactModalHash);


	// =========================================================
	//	Kirim data kontak via AJAX--29/05/2026
	// =========================================================
	
	//	DEKLARASI ELEMEN GLOBAL (Browser cuma nyari 1x saja)
	const successModal = document.getElementById('success-modal');
	// Sekalian ambil modalBox-nya agar tidak perlu querySelector berulang kali
	const successModalBox = successModal ? successModal.querySelector('.transform') : null;

	document.getElementById('contact-form').addEventListener('submit', async function(e) {
		// 1. Hentikan perilaku bawaan form (mencegah refresh halaman)
		e.preventDefault();

		const form = this;
		const button = form.querySelector('button[type="submit"]');
		const buttonText = button.querySelector('span');
		
		// Simpan teks asli tombol (misal: "Kirim Pesan")
		const originalText = buttonText.textContent;
		
		// 2. Ubah status tombol menjadi loading
		button.disabled = true;
		buttonText.textContent = 'Mengirim...';

		// 3. Ambil semua data dari input form
		const formData = new FormData(form);

		try {
			// 4. Kirim data ke Laravel menggunakan fetch
			const response = await fetch(form.action, {
				method: 'POST',
				body: formData,
				headers: {
					// Memberitahu Laravel bahwa ini adalah request AJAX
					'X-Requested-With': 'XMLHttpRequest',
					
					// ➔ Kirim token CSRF dari objek global window
					'X-CSRF-TOKEN': window.LaravelEnv.csrfToken
				}
			});

			const result = await response.json();

			if (response.ok && result.success) {
				//5. Jika berhasil
				// Bersihkan isi form kontak
				form.reset(); 
				
				// ➔ Perbarui token global agar form lain tidak error 419
				if (result.token) {
					// Perbarui di objek window
					window.LaravelEnv.csrfToken = result.token;
					
					// Perbarui juga di Meta Tag HTML agar sinkron luar dalam
					const metaCsrf = document.querySelector('meta[name="csrf-token"]');
					if (metaCsrf) {
						metaCsrf.setAttribute('content', result.token);
					}
				}

				//Sembunyikan Modal Form Kontak
				const contactModal = document.getElementById('contact-modal');
				if (contactModal) contactModal.classList.add('hidden');

				//Masukkan teks pesan dari Laravel ke Modal Sukses
				const modalMessage = document.getElementById('modalMessage');
				if (modalMessage) {
					modalMessage.textContent = result.message; // Mengganti teks "info" dengan pesan dari server
				}

				//Tampilkan Modal Sukses
				if (successModal) {
					successModal.classList.remove('hidden');
					
					// efek scale-100 agar transisi Tailwind-nya jalan
					if (successModalBox) {
						setTimeout(() => {
							successModalBox.classList.remove('scale-95');
							successModalBox.classList.add('scale-100');
						}, 10);
					}
				}
			} else {
				// ➔ Antisipasi jika session habis di tengah jalan (Error 419)
				if (response.status === 419) {
					alert('Sesi Anda telah berakhir demi keamanan. Halaman akan dimuat ulang otomatis.');
					window.location.reload();
				} else {
					alert('Oops! Periksa kembali data Anda.');
				}
			}

		} catch (error) {
			console.error('Error:', error);
			alert('Gagal terhubung ke server. Silakan coba lagi nanti.');
		} finally {
			// 6. Kembalikan status tombol seperti semula setelah proses selesai
			button.disabled = false;
			buttonText.textContent = originalText;
		}
	});
	
	// LOGIKA UNTUK MENUTUP MODAL SUKSES SAAT TOMBOL "OK" DIKLIK
	document.getElementById('closeModal').addEventListener('click', function() {
		if (successModal) {
			if (successModalBox) {
				successModalBox.classList.remove('scale-100');
				successModalBox.classList.add('scale-95');
			}
			// Beri jeda sedikit agar efek transisi mengecil selesai sebelum disembunyikan
			setTimeout(() => {
				successModal.classList.add('hidden');
			}, 150);
		}
	});

/////////////////Modal dipakai oleh Login dan Kontak///////////////////////

// Fungsi untuk menampilkan modal dengan efek transisi
	function showModal(modal, modalContent) {
		modal.style.display = 'flex';
		setTimeout(() => {
			modalContent.classList.remove('scale-95', 'opacity-0');
			modalContent.classList.add('scale-100', 'opacity-100');
		}, 200);
	}

	// Fungsi untuk menyembunyikan modal dengan efek transisi
	function hideModal(modal, modalContent) {
		
		modalContent.classList.remove('scale-100', 'opacity-100');
		modalContent.classList.add('scale-95', 'opacity-0');
		
		//utk hp, aktifkan lg scroll pada body
		document.body.style.overflow = 'visible';
		
		setTimeout(() => {
			modal.style.display = 'none';
		}, 0); // Sesuaikan dengan durasi transisi
	}
////////////////////////////////////////////////////////////////	
	
//tampilkan konfirmasi pengiriman pesan kontak
/* diganti ke cara AJAX --29/05/2026
	const urlParams = new URLSearchParams(window.location.search);
	const successMessage = "{{ session('success') }}";
	const modalAlert = document.getElementById('success-modal');
	const closeModalButton = document.getElementById('closeModal');
	const modalMessage = document.getElementById('modalMessage');

	// Tampilkan modal jika parameter "success" ada di URL
	if (successMessage) {
		// Mengambil dan mendekode pesan dari URL
		modalMessage.textContent = decodeURIComponent(successMessage);
		modalAlert.classList.remove('hidden');
	}

	// Sembunyikan modal saat tombol "OK" diklik
	closeModalButton.addEventListener('click', () => {
		modalAlert.classList.add('hidden');
		
		// Hapus parameter 'success' dari URL
		const url = new URL(window.location.href);
		url.searchParams.delete('success');
		window.history.replaceState(null, '', url.toString());
	});
*/


@auth
	  loginLink.href = "{{ route('logout') }}";
	  document.getElementById("outin").innerHTML = "Logout";
	  document.getElementById("icon-login").setAttribute('d', 'M19 8l4 4m0 0l-4 4m4-4H9m6 4v1a3 3 0 01-3 3H5a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1');
	  mloginLink.href = "{{ route('logout') }}";
	  document.getElementById("moutin").innerHTML = "Logout";
@endauth
   
	
	
	
	//tampilkan login form setelah user mendaftar
	// Periksa apakah ada pesan 'status' dari session
    @if(session('status'))
			const status = "{{ session('status') }}";
			if(status != "back"){
			document.getElementById("keterangan").innerHTML = "{{ session('status') }}";
			}
            loginModal.classList.remove('hidden');
            loginModal.classList.add('flex');
            console.log("Status: {{ session('status') }}");
    @endif
	
	
	
/**
 * 1. Fungsi khusus untuk memformat elemen tanggal (.tglartikel)
 * @param {string} langCode - Kode bahasa (id-ID atau en-US)
 */
function updateArticleDates(langCode) {
    const pElements = document.querySelectorAll(".tglartikel");
    if (pElements.length === 0) return;

    pElements.forEach(function(el) {
        const tanggalartikelISO = el.getAttribute('data-isodateartikel');
        
        if (tanggalartikelISO) {
            const tanggalartikel = new Date(tanggalartikelISO);

            if (!isNaN(tanggalartikel.getTime())) {
                // Gunakan langCode yang dikirim dari fungsi updateContent
                const formatDinamisartikel = new Intl.DateTimeFormat(langCode, { 
                    day: 'numeric', 
                    month: 'long', 
                    year: 'numeric' 
                }); 

                const hasilTanggalartikel = formatDinamisartikel.format(tanggalartikel);
                el.innerHTML = hasilTanggalartikel;
            }
        }
    });
}
	
	///////////////////////////////////
////////////Pilihan Bahasa/////////
//////////////////////////////////

const languages = [
    { code: 'id-ID', name: 'Indonesia', flag: '🇮🇩' },
    { code: 'en-US', name: 'English', flag: '🇺🇸' },
    { code: 'zh-CN', name: '简体中文', flag: '🇨🇳' }, // Cina (Sederhana)
    { code: 'ja-JP', name: '日本語', flag: '🇯🇵' },    // Jepang
    { code: 'ar-SA', name: 'العربية', flag: 'SA' },   // Arab
    { code: 'hi-IN', name: 'हिन्दी', flag: '🇮🇳' },      // India (Hindi)
    { code: 'de-DE', name: 'Deutsch', flag: '🇩🇪' },    // Jerman
    { code: 'fr-FR', name: 'Français', flag: '🇫🇷' },   // Prancis
    { code: 'es-ES', name: 'Español', flag: '🇪🇸' },    // Spanyol
    { code: 'ko-KR', name: '한국어', flag: '🇰🇷' },     // Korea
    { code: 'ru-RU', name: 'Pусский', flag: '🇷🇺' }     // Rusia
];

const translations = {
    'id-ID': {
        nav_home: 'Beranda', nav_profile: 'Profil', nav_products: 'Aplikasi', nav_contact: 'Kontak', nav_login: '@guest Masuk @else Keluar @endguest',
        footer: 'Hak Cipta: ©2025 Kambaniru',
        login_title: 'Masuk ke Akun Anda',
        sandi: 'Kata Sandi',
        lupa_sandi: 'Lupa Kata Sandi?',
        masuk: 'Masuk',
        opsi_login: 'Atau',
        login_google: 'Masuk dengan Google',
        login_fb: 'Masuk dengan Facebook',
        belumpunya_akun: 'Belum punya Akun?',
        daftar_sini: 'Daftar di sini!',
		
		mari: 'Teknologi Informasi',
		hero_title1: 'Terus belajar dan berinovasi.',
		hero_title2: 'Jelajahi karya-karya saya!',
        title_buatartikel: 'Buat Artikel Baru',
        tambah_artikel: 'Tambah Artikel',
		article: 'Artikel Terbaru',
		article_show: 'Baca Selengkapnya',
		article_terbit: 'Diterbitkan:',
		buatlahartikel: 'Buatlah artikel pada situs ini',
		buatartikel: 'Buat Artikel',
		numberartikel: 'Artikel',
		akanrilis: 'Akan segera dirilis...',
		
		edit_profil: 'Edit Profil',
		tentang_saya: 'Tentang Saya',
		profil_kontak: 'Kontak',
		no_telp: 'Nomor Telepon',
		ttl: 'Tempat & Tanggal Lahir',
		lokasi: 'Lokasi',
		alamat: 'Alamat',
		sosmed: 'Tautan Sosial Media',
		sumba: 'Sumba TImur - NTT',
		
		edit_profil_title: 'Edit Profil Anda',
		des_edit: 'Perbarui semua informasi profil Anda di bawah ini.',
		ubah_foto_button: 'Ubah Foto',
		edit_name: 'Nama',
		nama_placeholder: 'Masukkan nama Anda',
		email_placeholder: 'Masukkan email Anda',
		telp_placeholder: 'Masukkan nomor telepon',
		tlahir_paceholder: 'Tempat Lahir',
		tgllahir_placeholder: 'Tanggal Lahir',
		alamat_placeholder: 'Masukkan alamat lengkap...',
		edit_peran: 'Peran',
		peran_placeholder: 'Contoh: Pengembang Web, Desainer Grafis',
		edit_biografi: 'Biografi',
		placeholder_biografi: 'Ceritakan sedikit tentang diri Anda...',
		lokasi_placeholder: 'Contoh: Jakarta, Indonesia',
		note_edit_profil: 'Pastikan semua data yang Anda masukkan akurat sebelum disimpan.',
		simpan_button: 'Simpan Perubahan',
		batal_button: 'Batal',
		
		//show article
		dok_lampiran: 'Dokumen Lampiran',
		lihat_dok: 'Lihat Dokumen',
		down_dok: 'Download Dokumen',
		des_lihat: '* Klik "Lihat" untuk membuka di tab baru, atau "Download" untuk menyimpan ke perangkat.',
		kembali_list: 'Kembali ke List',
		edit_artikel: 'Edit Artikel',
		hapus: 'Hapus',
		hapusartikel: 'Hapus Artikel?',
		delwarning: 'Tindakan ini permanen. Artikel',
		delwarning2: 'akan dihapus selamanya.',
		yahapus: 'Ya, Hapus Sekarang',
		batal: 'Batalkan',
		
		//Kontak
		hubungi: 'Hubungi Kami',
		namalengkap: 'Nama Lengkap',
		placeholdernamalengkap: 'Nama Anda',
		placeholderemail: 'nama@contoh.com',
		pesan: 'Pesan',
		placeholderpesan: 'Tulis pesan Anda di sini...',
		kirimpesan: 'Kirim Pesan',
		atauhubungi: 'Atau hubungi kami melalui media sosial:'

		
    },
    'en-US': {
        nav_home: 'Home', nav_profile: 'Profile', nav_products: 'Application', nav_contact: 'Contact', nav_login: '@guest Login @else Logout @endguest',
        footer: '©2025 Kambaniru. All rights reserved',
        login_title: 'Sign in to your account',
        sandi: 'Password',
        lupa_sandi: 'Forgot Password?',
        masuk: 'Login',
        opsi_login: 'Or',
        login_google: 'Login with Google',
        login_fb: 'Login with Facebook',
        belumpunya_akun: "Don't have an account yet?",
        daftar_sini: 'Register here!',
		
		mari: "Information Technology",
		hero_title1: 'Keep learning and innovating.',
		hero_title2: 'Explore my works!',
        title_buatartikel: 'Write new article',
        tambah_artikel: 'New Article',
		article: 'Latest Articles',
		article_show: 'Read More',
		article_terbit: 'Published:',
		buatlahartikel: 'Create an article on this site',
		buatartikel: 'Create an Article',
		numberartikel: 'Article',
		akanrilis: 'Will be released soon...',

		
		edit_profil: 'Edit Profile',
		tentang_saya: 'About Me',
		profil_kontak: 'Contact',
		no_telp: 'Phone Numner',
		ttl: 'Place & Date of Birth',
		lokasi: 'Location',
		alamat: 'Address',
		sosmed: 'Social Media Link',
		sumba: 'East Sumba - East Nusa Tenggara',
		
		edit_profil_title: 'Edit Your Profile',
		des_edit: 'Update all your profile information below.',
		ubah_foto_button: 'Change Photo',
		edit_name: 'Name',
		nama_placeholder: 'Enter your name',
		email_placeholder: 'Enter your email',
		telp_placeholder: 'Enter phone number',
		tlahir_paceholder: 'Place of birth',
		tgllahir_placeholder: 'Date of birth',
		alamat_placeholder: 'Enter your full address...',
		edit_peran: 'Role',
		peran_placeholder: 'Examples: Web Developer, Graphic Designer',
		edit_biografi: 'Biography',
		placeholder_biografi: 'Tell us a little about yourself...',
		lokasi_placeholder: 'Example: Jakarta, Indonesia',
		note_edit_profil: 'Make sure all the data you enter is accurate before saving.',
		simpan_button: 'Save Changes',
		batal_button: 'Cancel',
		
		//show article
		dok_lampiran: 'Attachment Documents',
		lihat_dok: 'View Documents',
		down_dok: 'Download Document',
		des_lihat: '* Click "View" to open in a new tab, or "Download" to save to your device.',
		kembali_list: 'Back to List',
		edit_artikel: 'Edit Article',
		hapus: 'Delete',
		hapusartikel: 'Delete Article?',
		delwarning: 'This action is permanent. Article',
		delwarning2: 'will be deleted forever.',
		yahapus: 'Yes, Delete Now',
		batal: 'Cancel',
		
		//Kontakhubungi: 'Hubungi Kami',
		namalengkap: 'Full name',
		placeholdernamalengkap: 'Your name',
		placeholderemail: 'name@example.com',
		pesan: 'Message',
		placeholderpesan: 'Write your message here...',
		kirimpesan: 'Send message',
		atauhubungi: 'Or contact us via social media:'

    }
};

/**
 * Fungsi Update Konten
 * @param {string} langCode 
 * @param {boolean} isInitial - Jika true, hapus shielding setelah selesai
 */
 
 // async memberi tahu JavaScript bahwa fungsi tersebut akan melakukan pekerjaan di latar belakang,
 // dan await adalah perintah untuk "tunggu sebentar sampai proses itu beres" sebelum lanjut ke langkah berikutnya.
 //jadi jika di dalam kode menggunakan await, maka pembungkusnya harus menggunakan async.
 
async function updateContent(langCode, isInitial = false) {

    const dictionary = translations[langCode];
    const elements = document.querySelectorAll('[data-key]');
    const currentLang = localStorage.getItem('user_lang') || 'id-ID';

	
	// 1. Simpan preferensi bahasa
    localStorage.setItem('user_lang', langCode);

	// 2. PROSES KAMUS LOKAL (Teks Statis seperti Menu, Tombol, dll)
    elements.forEach(el => {
        const key = el.getAttribute('data-key');
        if (dictionary && dictionary[key]) {
            const newText = dictionary[key];

            // Fungsi internal untuk menerapkan teks berdasarkan jenis elemen/key
            const applyTranslation = () => {
                if (key.startsWith('title_')) {
                    // Jika key diawali 'title_', update atribut title (untuk tooltip)
                    el.setAttribute('title', newText);
                } else if (el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') {
                    // Jika elemen input/textarea, update placeholder
                    el.setAttribute('placeholder', newText);
                } else {
                    // Default: update teks di dalam elemen
                    el.textContent = newText;
                }
            };

            if (isInitial) {
                // TANPA ANIMASI untuk pemuatan pertama
                applyTranslation();
            } else {
                // DENGAN ANIMASI untuk pergantian manual
                el.style.transition = 'opacity 0.2s';
                el.style.opacity = '0';
                setTimeout(() => {
                    applyTranslation();
                    el.style.opacity = '1';
                }, 200);
            }
        }
    });
	
	// Panggil fungsi update tanggal di sini agar sinkron!
    updateArticleDates(langCode);
	
	//const kodeasal = currentLang.startsWith('id') ? "id" : "en";
	//const kodebahasa = langCode.startsWith('id') ? "id" : "en";
	
	//karena lebih dari 2 bahasa
	// Ambil 2 huruf pertama (misal: 'en-US' jadi 'en', 'ar-SA' jadi 'ar')
	// Logika pemotongan kode yang lebih cerdas
	let kodebahasa, kodeasal;
	if (langCode === 'zh-CN') {
		kodebahasa = 'zh-CN'; // Tetap biarkan lengkap untuk Cina
	} else {
		kodebahasa = langCode.split('-')[0]; // Ambil 2 huruf depan untuk lainnya (en, ja, ar, dll)
	}
	if (currentLang === 'zh-CN') {
		kodeasal = 'zh-CN'; // Tetap biarkan lengkap untuk Cina
	} else {
		kodeasal = currentLang.split('-')[0]; // Ambil 2 huruf depan untuk lainnya (en, ja, ar, dll)
		
	}
	
	if(kodebahasa === 'id'){ 
		if(kodebahasa != kodeasal){
			backToOriginal();
		}
	} else {
		changeLanguage(kodebahasa, kodeasal, langCode);
	}

	//Hapus Shielding Loading jika ini pemuatan awal
    if (isInitial) { 
        requestAnimationFrame(() => {
            document.documentElement.classList.remove('lang-loading');
        });
    }
}

async function initializeDropdown() {
    // Selector untuk Desktop & Mobile
    const deskMenu = document.getElementById('language-list-desk-menu');
    const deskLabel = document.getElementById('button-label-desk');
    
    const mobMenu = document.getElementById('language-list-mob');
    const mobLabel = document.getElementById('button-label-mob');
    const mobDropdownContainer = document.getElementById('language-dropdown-mob');
    const mobButton = document.getElementById('dropdown-toggle-mob');

    	// Ambil bahasa dari LocalStorage
    let savedLang = localStorage.getItem('user_lang') || 'id-ID'; 
    
    
    const currentLangObj = languages.find(l => l.code === savedLang);

    // 1. Fungsi Helper untuk Proteksi No-Translate
    const protectElement = (el) => {
        if (el) {
            el.classList.add('notranslate');
            el.setAttribute('translate', 'no');
        }
    };

    [deskLabel, mobLabel, deskMenu, mobMenu].forEach(protectElement);

    // 2. Set Label Awal
    if (currentLangObj) {
        if (deskLabel) deskLabel.textContent = currentLangObj.name;
        if (mobLabel) mobLabel.textContent = currentLangObj.name;
    }

    updateContent(savedLang, true);

    // 3. Render Daftar Bahasa (Looping Sekali untuk Kedua Menu)
    const renderList = (container, isMobile) => {
        if (!container) return;
        container.innerHTML = '';

        languages.forEach(lang => {
            const item = document.createElement('div');
            item.className = 'notranslate group/item flex items-center px-5 py-3 text-sm text-gray-300 hover:bg-white/10 hover:text-white transition-all cursor-pointer border-b border-white/5 last:border-0';
            item.setAttribute('translate', 'no');

            item.innerHTML = `
                <span class="text-xl mr-4 group-hover/item:scale-125 transition-transform duration-300">${lang.flag}</span>
                <span class="font-semibold tracking-wide">${lang.name}</span>
            `;

            item.addEventListener('click', () => {
				// --- PROTEKSI: CEK APAKAH BAHASA SAMA? ---
				// Kita ambil label yang sedang aktif saat ini
				const currentLabelText = deskLabel ? deskLabel.textContent : (mobLabel ? mobLabel.textContent : '');
				if (lang.name === currentLabelText) {
					console.log("Bahasa sama (" + lang.name + "), tidak perlu diproses.");
					
					// Jika di mobile, kita tetap tutup dropdown-nya agar tidak bingung
					if (isMobile) toggleMobileDropdown(false);
					
					return; // STOP! Keluar dari fungsi, updateContent tidak akan dipanggil
				}
				// ------------------------------------------
				
                // Update kedua label sekaligus
                if (deskLabel) deskLabel.textContent = lang.name;
                if (mobLabel) mobLabel.textContent = lang.name;

                // Tutup dropdown mobile setelah pilih (khusus mobile)
                if (isMobile) toggleMobileDropdown(false);

                updateContent(lang.code, false);
            });

            container.appendChild(item);
        });
    };

    renderList(deskMenu, false);
    renderList(mobMenu, true);

    // 4. Logika Buka/Tutup Dropdown Mobile (Toggle)
    function toggleMobileDropdown(show) {
        if (!mobDropdownContainer) return;
        if (show) {
            mobDropdownContainer.classList.remove('opacity-0', 'scale-95', 'pointer-events-none');
            mobDropdownContainer.classList.add('opacity-100', 'scale-100', 'pointer-events-auto');
        } else {
            mobDropdownContainer.classList.add('opacity-0', 'scale-95', 'pointer-events-none');
            mobDropdownContainer.classList.remove('opacity-100', 'scale-100', 'pointer-events-auto');
        }
    }

    if (mobButton) {
        mobButton.addEventListener('click', (e) => {
            e.stopPropagation();
            const isHidden = mobDropdownContainer.classList.contains('opacity-0');
            toggleMobileDropdown(isHidden);
        });
    }

    // Klik di luar menu untuk menutup dropdown mobile
    document.addEventListener('click', () => toggleMobileDropdown(false));
}


document.addEventListener('DOMContentLoaded', () => {
    initializeDropdown();

    const header = document.getElementById('header');
    if (header) {
        let lastScrollY = window.scrollY;
        window.addEventListener('scroll', () => {
            if (lastScrollY < window.scrollY && window.scrollY > 50) {
                header.classList.add('transform', '-translate-y-full');
            } else {
                header.classList.remove('transform', '-translate-y-full');
            }
            lastScrollY = window.scrollY;
        });
    }
});


   </script>

<style>
    /* 1. Menghilangkan bar atas (semua versi) */
    .goog-te-banner-frame.skiptranslate, 
    .goog-te-banner, 
    #goog-gt-tt, 
    .goog-te-balloon-frame {
        display: none !important;
        visibility: hidden !important;
    }

    /* 2. Menghilangkan margin/ruang kosong yang disisakan Google di atas body */
    body {
        top: 0px !important;
        position: static !important;
    }

    /* 3. Menghilangkan widget melayang (jika ada) */
    .skiptranslate {
        display: none !important;
    }

    /* 4. Pastikan iframe google benar-benar hilang */
    iframe.goog-te-banner-frame {
        display: none !important;
    }
</style>

<div id="google_translate_element"  name="google_translate_element"></div>

<script type="text/javascript">
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({
            pageLanguage: 'id',
            includedLanguages: 'en,id,ar,zh-CN,ja,hi,de,fr,es,ko,ru',
            
        }, 'google_translate_element');
    }
	
	//menyuntikkan id dan name pada select google agar tidak ada warning di browser inspect--8/06/2026
    //awasi kemunculan elemen Google Translate secara real-time
    const observer = new MutationObserver((mutations, obs) => {
        const googleSelect = document.querySelector('.goog-te-combo');
        
        // Begitu elemennya ketemu, langsung eksekusi!
        if (googleSelect) {
            if (!googleSelect.hasAttribute('id')) googleSelect.setAttribute('id', 'google_translate_select');
            if (!googleSelect.hasAttribute('name')) googleSelect.setAttribute('name', 'google_translate_select');
            
            // Setelah sukses menyuntikkan id & name, matikan satpam agar hemat baterai/RAM
            obs.disconnect(); 
        }
    });

    // Mulai mengawasi seluruh perubahan struktur HTML di halaman portfolio
    observer.observe(document.body, {
        childList: true,
        subtree: true
    });

    function changeLanguage(kodebahasa, kodeasal, langCode) {
        
		// 1. Ambil elemen dropdown yang dibuat otomatis oleh Google
		const select = document.querySelector('.goog-te-combo');
		
		if (select) {
			
			// JALANKAN MONITORING DISINI, 28 jan 2026
			// Jalankan monitor LEBIH DULU sebelum memicu Google
			// Agar observer sudah 'siap siaga' saat teks mulai berubah
			monitorLoadingTranslate();
			
			// 2. JEMBATAN: Samakan nilai dropdown Google dengan tombol kita
		    select.value = kodebahasa;
			
			// 3. JEMBATAN: Picu event 'change' agar Google merespon
            select.dispatchEvent(new Event('change'));
			
			if(kodeasal != kodebahasa){ 
				updateContent(langCode, false); //ulangi klik
			}
			
						
        } else {
            console.log("Menunggu Google Translate...");
		}
    } //Biasanya klik pertama hanya berfungsi untuk mengaktifkan library Google, dan klik kedua baru mengubah bahasa
	
	function backToOriginal() {
		// 1. Cari dropdown rahasia
		const select = document.querySelector('.goog-te-combo');
		
		if (select) {
			// 2. Set ke Indonesia (Bahasa asal)
			select.value = 'id';
			select.dispatchEvent(new Event('change'));
			
			// 3. Beritahu Google untuk menutup sesi (Cara internal)
			if (typeof(google) !== 'undefined' && google.translate && google.translate._setLanguage) {
				google.translate._setLanguage('id');
			}

			// 4. Bersihkan Cookie agar bar Google tidak muncul lagi saat pindah halaman
			document.cookie = "googtrans=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/";
			document.cookie = "googtrans=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/; domain=" + location.hostname;
			
		}
	}
	
	let cekJaringan;
	// Pastikan observer didefinisikan di luar agar bisa di-disconnect kapan saja
	let translationObserver = null; 

	function monitorLoadingTranslate() {
		const ter = document.getElementById('terjemahan');
		
		// 1. Bersihkan timer & observer sebelumnya agar tidak tumpang tindih
		clearTimeout(cekJaringan);
		
		
		if (translationObserver) {
			translationObserver.disconnect();
		}

		// 2. Set timer 5 detik
		cekJaringan = setTimeout(() => {
			showWarning("Koneksi lambat, mencoba menghubungi Google...");
			
			// Opsional: Hentikan pengamatan jika sudah timeout
			if (translationObserver) translationObserver.disconnect();
		}, 5000); 

		// 3. Deteksi jika teks berubah (berhasil diterjemahkan)
		if (ter) {
			translationObserver = new MutationObserver((mutations) => {
				// Jika ada perubahan (berhasil), matikan timer peringatan
				clearTimeout(cekJaringan);
				console.log("Translasi berhasil diterima.");
				
				// PAKSA SEMBUNYIKAN UI LOADING GOOGLE
				const googleLoadingStatus = document.querySelector('.goog-te-spinner-pos');
				if (googleLoadingStatus) {
					googleLoadingStatus.style.display = 'none';
				}
				
				translationObserver.disconnect();
			});

			translationObserver.observe(ter, { 
				characterData: true, 
				childList: true, 
				subtree: true 
			});
		}
	}
	
	function showWarning(message) {
		// Cari container notifikasi, jika tidak ada, buat baru
		let container = document.getElementById('notification-container');
		if (!container) {
			container = document.createElement('div');
			container.id = 'notification-container';
			container.className = 'fixed bottom-5 right-5 z-50'; // Posisi di pojok
			document.body.appendChild(container);
		}

		const toast = document.createElement('div');
		toast.className = 'bg-red-600 text-white px-6 py-3 rounded-lg shadow-lg mb-3 animate-bounce';
		toast.innerHTML = `
			<div class="flex items-center gap-2">
				<span>⚠️</span>
				<p>${message}</p>
			</div>
		`;

		container.appendChild(toast);

		// Hilang otomatis setelah 4 detik
		setTimeout(() => {
			toast.style.opacity = '0';
			setTimeout(() => toast.remove(), 500);
		}, 4000);
	}
	
	//jika pada awal loading halaman tidak dapat memuat elemen google, maka pesan konek internet akan muncul, 28 jan 2026
	function handleScriptError() {
    // Buat elemen div secara dinamis
    const toast = document.createElement('div');
    toast.className = "fixed bottom-5 right-5 z-50 bg-gray-800 text-white px-6 py-3 rounded-lg shadow-2xl flex items-center space-x-3 border-l-4 border-red-500 animate-bounce";
    
    toast.innerHTML = `
        <span class="text-red-400">⚠️</span>
        <span class="text-sm font-medium">Gagal memuat sistem. Cek koneksi internet!</span>
        <button onclick="this.parentElement.remove()" class="ml-4 text-gray-400 hover:text-white">&times;</button>
    `;

    document.body.appendChild(toast);

    // Otomatis hilang setelah 8 detik
    setTimeout(() => {
        if(toast) toast.remove();
    }, 8000);
}
</script>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit" onerror="handleScriptError()"></script>

</body>
</html>
