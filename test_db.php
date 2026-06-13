<?php
$pdo = new PDO('mysql:host=127.0.0.1;dbname=laravelali', 'root', '');
echo 'Karyawan: ' . $pdo->query('SELECT idKaryawan FROM karyawans LIMIT 1')->fetchColumn() . PHP_EOL;
echo 'Pelanggan: ' . $pdo->query('SELECT idPelanggan FROM pelanggans LIMIT 1')->fetchColumn() . PHP_EOL;
echo 'Outlet: ' . $pdo->query('SELECT id_outlet FROM outlets LIMIT 1')->fetchColumn() . PHP_EOL;
