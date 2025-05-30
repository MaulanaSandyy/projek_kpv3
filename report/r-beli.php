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
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }
        .header h2 {
            margin: 5px 0 0 0;
            font-size: 18px;
            color: #555;
        }
        .report-title {
            text-align: center;
            margin-bottom: 30px;
        }
        .report-title h3 {
            margin: 0;
            font-size: 20px;
            color: #333;
        }
        .report-period {
            text-align: center;
            margin-bottom: 20px;
            font-size: 16px;
            color: #555;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th {
            background-color: #f2f2f2;
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
            font-weight: bold;
        }
        table td {
            padding: 8px 10px;
            border: 1px solid #ddd;
        }
        .main-row td {
            font-weight: bold;
            background-color: #f8f8f8;
        }
        .detail-row td {
            background-color: #ffffff;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .total-row {
            font-weight: bold;
            background-color: #f2f2f2;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-style: italic;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Toko Bangunan Mutiara</h1>
        <h2>Jl. Serua Raya, Serua, Kec. Bojongsari<br>
        Kota Depok, Jawa Barat 16517</h2>
    </div>

    <div class="report-title">
        <h3>LAPORAN PEMBELIAN BARANG</h3>
    </div>

    <div class="report-period">
        Periode: <?= in_date($tgl1) ?> s/d <?= in_date($tgl2) ?>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 15%;">Tanggal</th>
                <th style="width: 15%;">No. Pembelian</th>
                <th style="width: 25%;">Supplier</th>
                <th style="width: 15%;">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $grandTotal = 0;
            foreach ($dataBeli as $data) { 
                $grandTotal += $data['total'];
                ?>
                <tr class="main-row">
                    <td class="text-center"><?= $no++ ?></td>
                    <td><?= in_date($data['tgl_beli']) ?></td>
                    <td><?= $data['no_beli'] ?></td>
                    <td><?= htmlspecialchars($data['nama_supplier']) ?></td>
                    <td class="text-right"><?= number_format($data['total'],0,',','.') ?></td>
                </tr>

                <?php
                $detailBrg = getData("SELECT bd.*, b.satuan FROM beli_detail bd LEFT JOIN barang b ON bd.kode_brg = b.id_barang WHERE bd.no_beli = '{$data['no_beli']}'");
                foreach ($detailBrg as $barang) { ?>
                    <tr class="detail-row">
                        <td></td>
                        <td colspan="2"><?= htmlspecialchars($barang['nama_brg']) ?></td>
                        <td>Qty : <?= $barang['qty'] ?> | Satuan : <?= htmlspecialchars($barang['satuan'] ?? '-') ?></td>
                        <td class="text-right">Rp <?= number_format($barang['harga_beli'],0,',','.') ?></td>
                    </tr>
                <?php } 
            } ?>
            
            <tr class="total-row">
                <td colspan="4" class="text-right"><strong>TOTAL PEMBELIAN</strong></td>
                <td class="text-right"><strong>Rp <?= number_format($grandTotal,0,',','.') ?></strong></td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: <?= date('d-m-Y H:i:s') ?>
    </div>

    <script>
        window.print();
    </script>
</body>
</html>