<?php
use Illuminate\Support\Facades\Schema;

$tables = ['pelanggans', 'karyawans', 'merchant_brilinks', 'outlets', 'transaksis', 'pemasoks', 'pengadaan_barangs', 'detail_pengadaans', 'detail_transaksis'];
$schema = [];
foreach($tables as $t) {
    if (Schema::hasTable($t)) {
        $schema[$t] = Schema::getColumnListing($t);
    }
}
file_put_contents('schema.json', json_encode($schema, JSON_PRETTY_PRINT));
echo "Schema written to schema.json\n";
