<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\Profile;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman profil pengguna.
     *
     * @return \Illuminate\View\View
     */
  public function show()
    {
        // Ambil data profil pertama. Jika tabel kosong, hasilnya adalah null.
        $profile = Profile::first();

        // Cek apakah data profil tidak ditemukan.
        if (!$profile) {
            // Jika tidak ada data, buat objek profil palsu (dummy)
            // sehingga view tidak akan error.
            $profile = (object) [
                'name' => 'Yandrien LW',
                'biografi' => 'Halo! Ini adalah profil default. Silakan tambahkan data profil Anda di database.',
                
            ];
        }

        // Kirim objek profil (asli atau palsu) ke view.
        return view('profile.profile', [
            'profile' => $profile,
        ]);
    }

    /**
     * Tampilkan formulir untuk mengedit profil pengguna.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
		// Mendapatkan pengguna yang sedang login
        $user = Auth::user();
        
        // Mengambil profil yang terhubung dengan pengguna
        // Jika profil tidak ada, buat instance profil kosong
        $profile = $user->profile ?? new Profile();
		
        //cek pengguna
		if (auth()->id() !== (int)$profile->user_id && !auth()->user()->is_admin) {
			return redirect()->route('profile');
		}
		
		return view('profile.edit', [
            'user' => $user,
            'profile' => $profile,
        ]);
    }

    /**
     * Update profil pengguna.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
		// Mendapatkan pengguna yang sedang login
        $user = Auth::user();
        
        // Mengambil profil yang terhubung dengan pengguna
        // Jika profil tidak ada, buat instance profil kosong
        $profile = $user->profile ?? new Profile();
		
        //cek pengguna
		if (auth()->id() !== (int)$profile->user_id && !auth()->user()->is_admin) {
			return redirect()->route('profile');
		}

        // Validasi semua data dari formulir.
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'peran' => 'nullable|string|max:255',
            'biografi' => 'nullable|string',
			'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:1024', // Maksimal 1MB
            'lokasi' => 'nullable|string|max:255',
            'linkedin_url' => 'nullable|url',
            'github_url' => 'nullable|url',
			'nomor_telepon' => 'nullable|string',
			'tlahir' => 'nullable|string',
			'tgllahir' => 'nullable|string',
			'alamat_lengkap' => 'nullable|string',
        ]);

        // Tangani unggahan foto profil.
        if ($request->hasFile('foto_profil')) {
            // Hapus foto profil lama jika ada.
            if ($user->profiles && $user->profiles->foto_profil) {
                Storage::disk('public')->delete($user->profiles->foto_profil);
            }

            // Simpan foto baru dan dapatkan path-nya.
            $path = $request->file('foto_profil')->store('profile_photos', 'public');
           $validatedData['foto_profil'] = $path;
        }

        // Perbarui data pengguna (nama dan email).
        $user->update([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
        ]);

        // Persiapkan data untuk model `Profile`.
        $profileData = [
            'peran' => $validatedData['peran'] ?? null,
            'biografi' => $validatedData['biografi'] ?? null,
            'lokasi' => $validatedData['lokasi'] ?? null,
            'linkedin_url' => $validatedData['linkedin_url'] ?? null,
            'github_url' => $validatedData['github_url'] ?? null,
			'nomor_telepon' => $validatedData['nomor_telepon'] ?? null,
			'tlahir' => $validatedData['tlahir'] ?? null,
			'tgllahir' => $validatedData['tgllahir'] ?? null,
			'alamat_lengkap' => $validatedData['alamat_lengkap'] ?? null,
        ];

        // Tambahkan path foto ke data profil jika ada unggahan.
        if (isset($validatedData['foto_profil'])) {
            $profileData['foto_profil'] = $validatedData['foto_profil'];
        }

        // Gunakan metode 'updateOrCreate' untuk memperbarui atau membuat profil.
        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            $profileData
        );

        // Redirect kembali ke halaman profil dengan pesan sukses.
        return redirect()->route('profile')
                         ->with('success', 'Profil berhasil diperbarui!');
    }
}
