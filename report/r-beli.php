<?php

session_start();

if(!isset($_SESSION["ssLoginPOS"])){
  header("location: ../auth/login.php");
  exit();
}

require "../config/config.php";
require "../config/functions.php";

$tgl1 = $_GET['tgl1'];
$tgl2 = $_GET['tgl2'];

$dataBeli = getData("
  SELECT bh.*, s.nama AS nama_supplier 
  FROM beli_head bh 
  LEFT JOIN supplier s ON bh.suplier = s.id_supplier 
  WHERE bh.tgl_beli BETWEEN '$tgl1' AND '$tgl2'
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pembelian</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 6px; }
        .barang-row td { padding-left: 30px; font-size: 14px; }
        .grey-line { margin-bottom: 2px; margin-left: -5px; margin-top: 1px; }
    </style>
</head>
<body>
    <div style="text-align: center;">
        <h2 style="margin-bottom: -15px">Rekap Laporan Pembelian</h2>
        <h2 style="margin-bottom: 15px">Toko Bangunan Mutiara</h2>
    </div>

    <table>
        <thead>
            <tr>
                <td colspan="5" style="height: 5px;">
                    <hr class="grey-line" size="3" color="grey">
                </td>
            </tr>
            <tr>
                <th>No</th>
                <th style="width: 120px;">Tgl Pembelian</th>
                <th style="width: 120px;">Id Pembelian</th>
                <th style="width: 300px;">Suplier</th>
                <th>Total Pembelian</th>
            </tr>
            <tr>
                <td colspan="5" style="height: 5px;">
                    <hr class="grey-line" size="3" color="grey">
                </td>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            foreach ($dataBeli as $data) { ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td align="center"><?= in_date($data['tgl_beli']) ?></td>
                    <td align="center"><?= $data['no_beli'] ?></td>
                    <td align="center"><?= htmlspecialchars($data['nama_supplier']) ?></td>
                    <td align="right"><?= number_format($data['total'],0,',','.') ?></td>
                </tr>

                <?php
                $detailBrg = getData("SELECT bd.*, b.satuan FROM beli_detail bd LEFT JOIN barang b ON bd.kode_brg = b.id_barang WHERE bd.no_beli = '{$data['no_beli']}'");
                foreach ($detailBrg as $barang) { ?>
                    <tr style="background-color: #f9f9f9; font-size: 12px;">
                        <td></td>
                        <td colspan="2"><?= htmlspecialchars($barang['nama_brg']) ?> (<?= $barang['qty'] ?> <?= htmlspecialchars($barang['satuan'] ?? '-') ?>)</td>
                        <td colspan="2" align="right">Rp <?= number_format($barang['harga_beli'],0,',','.') ?></td>
                    </tr>
                <?php } 
            } ?>
        </tbody>

        <tfoot>
            <tr>
                <td colspan="5" style="height: 5px;">
                    <hr class="grey-line" size="3" color="grey">
                </td>
            </tr>
        </tfoot>
    </table>

    <script>
        window.print();
    </script>
</body>
</html>
