# Dokumentasi Struktur & Penulisan Kode — laravel-app

> Repositori: [https://github.com/RyHarJr/laravel-app](https://github.com/RyHarJr/laravel-app)  
> Framework: **Laravel 13** · PHP **^8.3** · Breeze Auth · Tailwind CSS · Pest Testing

---

## Daftar Isi

1. [Gambaran Umum](#gambaran-umum)
2. [Struktur Direktori](#struktur-direktori)
3. [Database & Migrasi](#database--migrasi)
4. [Models & Relasi](#models--relasi)
5. [Controllers](#controllers)
6. [Routes](#routes)
7. [Views (Blade)](#views-blade)
8. [Konvensi Penulisan Kode](#konvensi-penulisan-kode)
9. [Masalah & Rekomendasi](#masalah--rekomendasi)

---

## Gambaran Umum

Aplikasi manajemen data akademik sederhana yang mencakup:
- Autentikasi pengguna (login, register, reset password) via **Laravel Breeze**
- CRUD untuk **Fakultas**, **Program Studi (Prodi)**, **Mahasiswa**, **Berita**, dan **Periode**
- Upload foto mahasiswa menggunakan Laravel Storage (`public` disk)
- Deploy-ready untuk **Vercel** (`vercel.json` + `api/index.php`)

---

## Struktur Direktori

```
laravel-app/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/                        # Controller bawaan Breeze
│   │   │   ├── BeritaController.php
│   │   │   ├── DashboardController.php
│   │   │   ├── FakultasController.php
│   │   │   ├── MahasiswaController.php
│   │   │   ├── PeriodeController.php
│   │   │   ├── ProdiController.php
│   │   │   └── ProfileController.php
│   │   └── Requests/
│   │       ├── Auth/LoginRequest.php
│   │       └── ProfileUpdateRequest.php
│   ├── Models/
│   │   ├── Berita.php
│   │   ├── Fakultas.php
│   │   ├── Periode.php
│   │   ├── Prodi.php
│   │   ├── User.php
│   │   ├── mahasiswa.php                    # ⚠️ nama tidak konsisten (lowercase)
│   │   └── cr.php                           # ⚠️ file tidak terpakai / tidak jelas
│   ├── Providers/
│   │   └── AppServiceProvider.php
│   └── View/Components/
│       ├── AppLayout.php
│       └── GuestLayout.php
│
├── database/
│   ├── migrations/
│   │   ├── ..._create_users_table.php
│   │   ├── ..._create_fakultas_table.php
│   │   ├── ..._create_periodes_table.php
│   │   ├── ..._create_beritas_table.php
│   │   ├── ..._create_prodis_table.php
│   │   └── ..._create_mahasiswas_table.php
│   ├── factories/
│   └── seeders/
│
├── resources/
│   ├── views/
│   │   ├── auth/                            # View login, register, dll
│   │   ├── components/                      # Blade components reusable
│   │   ├── layouts/
│   │   │   ├── app.blade.php
│   │   │   └── guest.blade.php
│   │   ├── berita/    (index, create, edit)
│   │   ├── fakultas/  (index, create, edit)
│   │   ├── mahasiswa/ (index, create, edit)
│   │   ├── periode/   (index, create, edit)
│   │   ├── prodi/     (index, create, edit)
│   │   ├── profile/
│   │   └── dashboard.blade.php
│   ├── css/
│   └── js/
│
├── routes/
│   ├── web.php
│   ├── auth.php
│   └── console.php
│
├── public/
│   ├── index.php
│   ├── assets/
│   ├── css/
│   └── js/
│
├── api/
│   └── index.php                            # Entry point untuk Vercel deployment
├── vercel.json
├── composer.json
├── package.json
├── tailwind.config.js
└── vite.config.js
```

---

## Database & Migrasi

Setiap tabel dikelola melalui file migrasi di `database/migrations/`. Berikut skema masing-masing tabel:

### `users`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint (PK) | Auto increment |
| name | string | |
| email | string unique | |
| email_verified_at | timestamp | nullable |
| password | string | hashed |
| remember_token | string | |
| timestamps | — | created_at, updated_at |

### `fakultas`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint (PK) | |
| nama_fakultas | string(100) | |
| kode_fakultas | string(5) | |
| dekan_fakultas | string(100) | |
| timestamps | — | |

### `prodis`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint (PK) | |
| nama_prodi | string | |
| singkatan | string | |
| kaprodi | string | |
| fakultas_id | foreignId | FK → fakultas.id |
| timestamps | — | |

### `mahasiswas`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint (PK) | |
| npm | string | Nomor Pokok Mahasiswa |
| nama | string | |
| prodi_id | foreignId | FK → prodis.id |
| foto | string | path relatif di storage/public |
| timestamps | — | |

### `periodes`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint (PK) | |
| tahun_akademik | string(9) | contoh: `2025/2026` |
| kode_smt | char(1) | `1` = gasal, `2` = genap |
| timestamps | — | |

### `beritas`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint (PK) | |
| *(lihat migration)* | | |
| timestamps | — | |

---

## Models & Relasi

### Diagram Relasi

```
Fakultas (1) ──────< (N) Prodi (1) ──────< (N) Mahasiswa
```

### `Fakultas.php`
```php
protected $fillable = ['nama_fakultas', 'kode_fakultas', 'dekan_fakultas'];

public function prodis()
{
    return $this->hasMany(Prodi::class);  // one-to-many ke Prodi
}
```

### `Prodi.php`
```php
protected $fillable = ['nama_prodi', 'singkatan', 'kaprodi', 'fakultas_id'];

public function Fakultas()               // ⚠️ nama method sebaiknya lowercase: fakultas()
{
    return $this->belongsTo(Fakultas::class);
}

public function mahasiswa()
{
    return $this->hasMany(mahasiswa::class);
}
```

### `mahasiswa.php` *(nama file tidak sesuai konvensi)*
```php
protected $fillable = ['npm', 'nama', 'prodi_id', 'foto'];

public function Prodi()                  // ⚠️ nama method sebaiknya lowercase: prodi()
{
    return $this->belongsTo(Prodi::class);
}
```

---

## Controllers

Semua controller menggunakan pola **Resource Controller** bawaan Laravel (`index`, `create`, `store`, `show`, `edit`, `update`, `destroy`).

### Contoh — `MahasiswaController.php`

```php
// index: mengambil semua data dengan eager loading
public function index()
{
    $mahasiswas = Mahasiswa::with('prodi')->get();
    return view('mahasiswa.index', compact('mahasiswas'));
}

// store: validasi + handle upload foto
public function store(Request $request)
{
    $request->validate([
        'npm'      => 'required',
        'nama'     => 'required',
        'prodi_id' => 'required',
        'foto'     => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $data = $request->all();

    if ($request->hasFile('foto')) {
        $filename = $request->npm . '_' . $request->file('foto')->getClientOriginalName();
        $path = $request->file('foto')->storeAs('mahasiswa', $filename, 'public');
        $data['foto'] = $path;
    }

    Mahasiswa::create($data);
    return redirect()->route('mahasiswa.index')->with('success', '...');
}

// destroy: hapus file dari storage sebelum hapus record
public function destroy(mahasiswa $mahasiswa)
{
    if ($mahasiswa->foto && Storage::disk('public')->exists($mahasiswa->foto)) {
        Storage::disk('public')->delete($mahasiswa->foto);
    }
    $mahasiswa->delete();
    return redirect()->route('mahasiswa.index')->with('success', '...');
}
```

---

## Routes

File: `routes/web.php`

```php
// Redirect root ke dashboard
Route::get('/', fn() => redirect()->route('dashboard'));

// Semua route di bawah ini memerlukan autentikasi + email verified
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Resource routes otomatis menghasilkan 7 route (index, create, store, show, edit, update, destroy)
    Route::resource('fakultas',  FakultasController::class);
    Route::resource('periode',   PeriodeController::class);
    Route::resource('berita',    BeritaController::class);
    Route::resource('prodi',     ProdiController::class);
    Route::resource('mahasiswa', MahasiswaController::class);
});

require __DIR__ . '/auth.php';  // Route login, register, logout (dari Breeze)
```

---

## Views (Blade)

### Struktur Tiap Modul
Setiap modul memiliki tiga view standar:
```
resources/views/{modul}/
├── index.blade.php    # Daftar data (tabel)
├── create.blade.php   # Form tambah data
└── edit.blade.php     # Form edit data
```

### Layout
- `layouts/app.blade.php` — digunakan oleh halaman yang memerlukan autentikasi
- `layouts/guest.blade.php` — digunakan oleh halaman auth (login, register)

### Blade Components (reusable)
Tersedia di `resources/views/components/`:
- `primary-button`, `secondary-button`, `danger-button`
- `text-input`, `input-label`, `input-error`
- `modal`, `dropdown`, `dropdown-link`
- `nav-link`, `responsive-nav-link`
- `auth-session-status`

Cara pakai di Blade:
```blade
<x-primary-button>Simpan</x-primary-button>
<x-input-error :messages="$errors->get('nama')" class="mt-2" />
```

---

## Konvensi Penulisan Kode

### Yang Sudah Baik ✅
- Menggunakan `$fillable` di setiap model (mencegah mass assignment vulnerability)
- Validasi request dilakukan di controller sebelum menyimpan data
- Eager loading (`with('prodi')`) untuk menghindari N+1 query
- File upload menggunakan `Storage::disk('public')` dengan pengecekan keberadaan file sebelum dihapus
- Flash message (`with('success', ...)`) untuk feedback ke user
- Semua route dilindungi middleware `auth` dan `verified`

### Masalah & Rekomendasi ⚠️

**1. Nama class/file Model tidak konsisten**

Nama file `mahasiswa.php` (lowercase) seharusnya `Mahasiswa.php` (PascalCase) sesuai konvensi Laravel/PSR-4.

```php
// ❌ Saat ini
class mahasiswa extends Model { ... }
use App\Models\mahasiswa;

// ✅ Seharusnya
class Mahasiswa extends Model { ... }
use App\Models\Mahasiswa;
```

**2. Nama method relasi menggunakan PascalCase**

Method relasi Eloquent sebaiknya camelCase agar konsisten dengan konvensi Laravel.

```php
// ❌ Saat ini
public function Prodi() { return $this->belongsTo(Prodi::class); }

// ✅ Seharusnya
public function prodi() { return $this->belongsTo(Prodi::class); }
```

**3. File `cr.php` di folder Models**

File `app/Models/cr.php` tidak terpakai dan tidak jelas fungsinya. Sebaiknya dihapus untuk menjaga kebersihan kode.

**4. Validasi sebaiknya dipindah ke Form Request**

Daripada validasi inline di controller, gunakan dedicated Form Request class agar controller lebih bersih.

```php
// Buat file: app/Http/Requests/StoreMahasiswaRequest.php
class StoreMahasiswaRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'npm'      => 'required|string',
            'nama'     => 'required|string',
            'prodi_id' => 'required|exists:prodis,id',
            'foto'     => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}

// Di controller cukup:
public function store(StoreMahasiswaRequest $request) { ... }
```

**5. Upload foto di `update()` tidak menyimpan nama file yang konsisten**

Method `store()` menggunakan `storeAs()` dengan nama file custom, tapi method `update()` menggunakan `store()` biasa (nama acak). Sebaiknya disamakan.

**6. Tidak ada pagination**

`Mahasiswa::with('prodi')->get()` mengambil semua data sekaligus. Untuk data besar, gunakan pagination:

```php
$mahasiswas = Mahasiswa::with('prodi')->paginate(15);
// Di view: {{ $mahasiswas->links() }}
```

---

## Dependensi Utama

| Package | Versi | Keterangan |
|---|---|---|
| laravel/framework | ^13.0 | Core framework |
| laravel/breeze | ^2.4 | Scaffolding autentikasi |
| codeat3/blade-maki-icons | ^1.10 | Icon set untuk Blade |
| tailwindcss | — | CSS utility framework |
| vite | — | Asset bundler |
| pestphp/pest | ^4.6 | Testing framework |

---

*Dokumentasi ini digenerate otomatis berdasarkan analisis kode sumber repositori.*
