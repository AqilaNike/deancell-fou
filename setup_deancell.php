<?php

$migrationsDir = __DIR__ . '/database/migrations/';
$modelsDir = __DIR__ . '/app/Models/';

$migrations = [
    'create_pelanggans_table.php' => <<<PHP
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pelanggans', function (Blueprint \$table) {
            \$table->char('idPelanggan', 6)->primary();
            \$table->string('nama', 255);
            \$table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pelanggans');
    }
};
PHP,

    'create_karyawans_table.php' => <<<PHP
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('karyawans', function (Blueprint \$table) {
            \$table->char('idKaryawan', 6)->primary();
            \$table->string('nama', 255)->nullable();
            \$table->string('noTelp', 15)->nullable();
            \$table->string('Alamat', 255)->nullable();
            \$table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('karyawans');
    }
};
PHP,

    'create_produks_table.php' => <<<PHP
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produks', function (Blueprint \$table) {
            \$table->char('idProduk', 6)->primary();
            \$table->string('namaProduk', 255)->nullable();
            \$table->string('jenisProduk', 50)->nullable();
            \$table->decimal('harga_beli', 10, 2)->nullable();
            \$table->decimal('harga_jual', 10, 2)->nullable();
            \$table->integer('stok')->nullable();
            \$table->string('merk', 50)->nullable();
            \$table->string('warna', 30)->nullable();
            \$table->string('imei_sn', 50)->nullable();
            \$table->enum('kondisi', ['Baru', 'Bekas'])->default('Baru');
            \$table->string('garansi', 50)->nullable();
            \$table->string('provider', 30)->nullable();
            \$table->string('nominal_kuota', 50)->nullable();
            \$table->integer('masa_aktif')->nullable();
            \$table->decimal('biaya_admin', 12, 2)->nullable();
            \$table->string('tipe_layanan', 50)->nullable();
            \$table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};
PHP,

    'create_merchant_brilinks_table.php' => <<<PHP
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('merchant_brilinks', function (Blueprint \$table) {
            \$table->char('id_merchant', 10)->primary();
            \$table->string('no_agen_bri', 20)->unique();
            \$table->string('nama_toko', 100);
            \$table->string('pemilik', 50)->nullable();
            \$table->string('no_hp_terdaftar', 20)->nullable();
            \$table->string('tipe_perangkat', 20);
            \$table->decimal('saldo_limit', 15, 2)->default(0);
            \$table->string('no_rekening_operasional', 25)->nullable();
            \$table->string('kantor_wilayah', 100)->nullable();
            \$table->integer('target_bulanan')->default(0);
            \$table->boolean('status_aktif')->default(true);
            \$table->text('alamat_toko')->nullable();
            \$table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('merchant_brilinks');
    }
};
PHP,

    'create_outlets_table.php' => <<<PHP
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('outlets', function (Blueprint \$table) {
            \$table->char('id_outlet', 10)->primary();
            \$table->string('nama_outlet', 100);
            \$table->text('alamat');
            \$table->string('no_telp_outlet', 20);
            \$table->string('nama_manajer', 50);
            \$table->string('jam_operasional', 50);
            \$table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('outlets');
    }
};
PHP,

    'create_transaksis_table.php' => <<<PHP
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksis', function (Blueprint \$table) {
            \$table->char('idTransaksi', 6)->primary();
            \$table->date('tanggal');
            \$table->char('id_outlet', 10);
            \$table->char('idPelanggan', 6);
            \$table->char('idKaryawan', 6);
            \$table->decimal('total', 10, 2);
            \$table->string('metodeBayar', 20);
            
            \$table->foreign('id_outlet')->references('id_outlet')->on('outlets')->onDelete('cascade');
            \$table->foreign('idPelanggan')->references('idPelanggan')->on('pelanggans')->onDelete('cascade');
            \$table->foreign('idKaryawan')->references('idKaryawan')->on('karyawans')->onDelete('cascade');
            
            \$table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
PHP,

    'create_detail_transaksis_table.php' => <<<PHP
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_transaksis', function (Blueprint \$table) {
            \$table->char('idTransaksi', 6);
            \$table->char('idProduk', 6);
            \$table->char('id_merchant', 10)->nullable();
            \$table->integer('harga_satuan');
            \$table->integer('jumlah');
            \$table->integer('total');
            
            \$table->foreign('idTransaksi')->references('idTransaksi')->on('transaksis')->onDelete('cascade');
            \$table->foreign('idProduk')->references('idProduk')->on('produks')->onDelete('cascade');
            \$table->foreign('id_merchant')->references('id_merchant')->on('merchant_brilinks')->onDelete('set null');
            
            \$table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_transaksis');
    }
};
PHP,

    'create_pemasoks_table.php' => <<<PHP
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pemasoks', function (Blueprint \$table) {
            \$table->char('idPemasok', 6)->primary();
            \$table->string('nama', 255)->nullable();
            \$table->string('noTelp', 15)->nullable();
            \$table->string('kategoriProduk', 100)->nullable();
            \$table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemasoks');
    }
};
PHP,

    'create_pengadaan_barangs_table.php' => <<<PHP
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengadaan_barangs', function (Blueprint \$table) {
            \$table->char('idPengadaan', 6)->primary();
            \$table->char('idPemasok', 6)->nullable();
            \$table->date('tanggal_pesan')->nullable();
            \$table->date('tanggal_terima')->nullable();
            \$table->decimal('total_biaya', 10, 2)->nullable();
            
            \$table->foreign('idPemasok')->references('idPemasok')->on('pemasoks')->onDelete('set null');
            \$table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengadaan_barangs');
    }
};
PHP,

    'create_detail_pengadaans_table.php' => <<<PHP
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_pengadaans', function (Blueprint \$table) {
            \$table->char('idPengadaan', 6);
            \$table->char('idProduk', 6);
            \$table->integer('jumlah_pesan')->nullable();
            \$table->decimal('total', 10, 2)->nullable();
            
            \$table->foreign('idPengadaan')->references('idPengadaan')->on('pengadaan_barangs')->onDelete('cascade');
            \$table->foreign('idProduk')->references('idProduk')->on('produks')->onDelete('cascade');
            \$table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_pengadaans');
    }
};
PHP,
];

// Replace migrations
$files = scandir($migrationsDir);
foreach ($files as $file) {
    foreach ($migrations as $key => $content) {
        if (strpos($file, $key) !== false) {
            file_put_contents($migrationsDir . $file, $content);
            echo "Updated migration: \$file\n";
        }
    }
}

$models = [
    'Pelanggan.php' => <<<PHP
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected \$table = 'pelanggans';
    protected \$primaryKey = 'idPelanggan';
    public \$incrementing = false;
    protected \$keyType = 'string';
    
    protected \$fillable = ['idPelanggan', 'nama'];

    public function transaksis()
    {
        return \$this->hasMany(Transaksi::class, 'idPelanggan', 'idPelanggan');
    }
}
PHP,

    'Karyawan.php' => <<<PHP
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    protected \$table = 'karyawans';
    protected \$primaryKey = 'idKaryawan';
    public \$incrementing = false;
    protected \$keyType = 'string';
    
    protected \$fillable = ['idKaryawan', 'nama', 'noTelp', 'Alamat'];

    public function transaksis()
    {
        return \$this->hasMany(Transaksi::class, 'idKaryawan', 'idKaryawan');
    }
}
PHP,

    'Produk.php' => <<<PHP
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected \$table = 'produks';
    protected \$primaryKey = 'idProduk';
    public \$incrementing = false;
    protected \$keyType = 'string';
    
    protected \$fillable = [
        'idProduk', 'namaProduk', 'jenisProduk', 'harga_beli', 'harga_jual',
        'stok', 'merk', 'warna', 'imei_sn', 'kondisi', 'garansi', 'provider',
        'nominal_kuota', 'masa_aktif', 'biaya_admin', 'tipe_layanan'
    ];
}
PHP,

    'MerchantBrilink.php' => <<<PHP
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MerchantBrilink extends Model
{
    protected \$table = 'merchant_brilinks';
    protected \$primaryKey = 'id_merchant';
    public \$incrementing = false;
    protected \$keyType = 'string';
    
    protected \$fillable = [
        'id_merchant', 'no_agen_bri', 'nama_toko', 'pemilik', 'no_hp_terdaftar',
        'tipe_perangkat', 'saldo_limit', 'no_rekening_operasional', 'kantor_wilayah',
        'target_bulanan', 'status_aktif', 'alamat_toko'
    ];
}
PHP,

    'Outlet.php' => <<<PHP
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Outlet extends Model
{
    protected \$table = 'outlets';
    protected \$primaryKey = 'id_outlet';
    public \$incrementing = false;
    protected \$keyType = 'string';
    
    protected \$fillable = [
        'id_outlet', 'nama_outlet', 'alamat', 'no_telp_outlet', 'nama_manajer', 'jam_operasional'
    ];
    
    public function transaksis()
    {
        return \$this->hasMany(Transaksi::class, 'id_outlet', 'id_outlet');
    }
}
PHP,

    'Transaksi.php' => <<<PHP
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected \$table = 'transaksis';
    protected \$primaryKey = 'idTransaksi';
    public \$incrementing = false;
    protected \$keyType = 'string';
    
    protected \$fillable = [
        'idTransaksi', 'tanggal', 'id_outlet', 'idPelanggan', 'idKaryawan', 'total', 'metodeBayar'
    ];

    public function outlet()
    {
        return \$this->belongsTo(Outlet::class, 'id_outlet', 'id_outlet');
    }

    public function pelanggan()
    {
        return \$this->belongsTo(Pelanggan::class, 'idPelanggan', 'idPelanggan');
    }

    public function karyawan()
    {
        return \$this->belongsTo(Karyawan::class, 'idKaryawan', 'idKaryawan');
    }

    public function detailTransaksis()
    {
        return \$this->hasMany(DetailTransaksi::class, 'idTransaksi', 'idTransaksi');
    }
}
PHP,

    'DetailTransaksi.php' => <<<PHP
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    protected \$table = 'detail_transaksis';
    public \$incrementing = false;
    
    protected \$fillable = [
        'idTransaksi', 'idProduk', 'id_merchant', 'harga_satuan', 'jumlah', 'total'
    ];

    public function transaksi()
    {
        return \$this->belongsTo(Transaksi::class, 'idTransaksi', 'idTransaksi');
    }

    public function produk()
    {
        return \$this->belongsTo(Produk::class, 'idProduk', 'idProduk');
    }

    public function merchantBrilink()
    {
        return \$this->belongsTo(MerchantBrilink::class, 'id_merchant', 'id_merchant');
    }
}
PHP,

    'Pemasok.php' => <<<PHP
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemasok extends Model
{
    protected \$table = 'pemasoks';
    protected \$primaryKey = 'idPemasok';
    public \$incrementing = false;
    protected \$keyType = 'string';
    
    protected \$fillable = [
        'idPemasok', 'nama', 'noTelp', 'kategoriProduk'
    ];
}
PHP,

    'PengadaanBarang.php' => <<<PHP
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengadaanBarang extends Model
{
    protected \$table = 'pengadaan_barangs';
    protected \$primaryKey = 'idPengadaan';
    public \$incrementing = false;
    protected \$keyType = 'string';
    
    protected \$fillable = [
        'idPengadaan', 'idPemasok', 'tanggal_pesan', 'tanggal_terima', 'total_biaya'
    ];

    public function pemasok()
    {
        return \$this->belongsTo(Pemasok::class, 'idPemasok', 'idPemasok');
    }

    public function detailPengadaans()
    {
        return \$this->hasMany(DetailPengadaan::class, 'idPengadaan', 'idPengadaan');
    }
}
PHP,

    'DetailPengadaan.php' => <<<PHP
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPengadaan extends Model
{
    protected \$table = 'detail_pengadaans';
    public \$incrementing = false;
    
    protected \$fillable = [
        'idPengadaan', 'idProduk', 'jumlah_pesan', 'total'
    ];

    public function pengadaanBarang()
    {
        return \$this->belongsTo(PengadaanBarang::class, 'idPengadaan', 'idPengadaan');
    }

    public function produk()
    {
        return \$this->belongsTo(Produk::class, 'idProduk', 'idProduk');
    }
}
PHP,
];

foreach ($models as $filename => $content) {
    file_put_contents($modelsDir . $filename, $content);
    echo "Updated model: \$filename\n";
}

echo "All migrations and models updated successfully.\n";
