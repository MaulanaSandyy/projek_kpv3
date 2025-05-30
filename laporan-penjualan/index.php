<?php
session_start();

if(!isset($_SESSION["ssLoginPOS"])){
  header("location: ../auth/login.php");
  exit();
}

require "../config/config.php";
require "../config/functions.php";
require "../module/mode-barang.php";

$title = "Laporan - Toko Bangunan Mutiara";
require "../templatess/header.php";
require "../templatess/navbar.php";
require "../templatess/sidebar.php";

$penjualan = getData("SELECT * FROM jual_head ORDER BY tgl_jual DESC");
?>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Laporan Penjualan</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= $main_url ?>dashboard.php">Home</a></li>
            <li class="breadcrumb-item active">Penjualan</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>

  <section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-list fa-sm"></i> Data Penjualan
                </h3>
                <button type="button" class="btn btn-sm btn-outline-primary float-right" data-toggle="modal" data-target="#mdlPeriodejual">
                    <i class="fas fa-print"></i> Cetak
                </button>
            </div>
            <div class="card-body table-responsive p-3">
              <?php
                $totalSemua = 0;
                foreach ($penjualan as $jual) {
                    $totalSemua += $jual['total'];
                }
              ?>
                <table class="table table-hover text-nowrap" id="tblData">
                  <thead>
                      <tr>
                          <th>No</th>
                          <th>No Penjualan</th>
                          <th>Tanggal Penjualan</th>
                          <th>Customer</th>
                          <th>Total Penjualan</th>
                          <th style="width: 10%;" class="text-center">Opsi</th>
                      </tr>
                  </thead>
                  <tbody>
                      <?php $no = 1; foreach($penjualan as $jual): ?>
                      <tr>
                          <td><?= $no++ ?></td>
                          <td><?= $jual['no_jual'] ?></td>
                          <td><?= in_date($jual['tgl_jual']) ?></td>
                          <td><?= $jual['customer'] ?></td>
                          <td class="text-left"><?= number_format($jual['total'],0,",",".") ?></td>
                          <td class="text-center">
                              <a href="detail-penjualan.php?id=<?= $jual['no_jual'] ?>&tgl=<?= in_date($jual['tgl_jual']) ?>" 
                                class="btn btn-sm btn-info" title="rincian barang">
                                  Detail
                              </a>
                          </td>
                      </tr>
                      <?php endforeach; ?>
                  </tbody>
                  <tfoot>
                      <tr>
                          <th colspan="4" class="text-right">Total Keseluruhan:</th>
                          <th class="text-left">Rp. <?= number_format($totalSemua, 0, ",", ".") ?></th>
                          <th></th>
                      </tr>
                  </tfoot>
              </table>

            </div>
        </div>
    </div>
  </section>

  <!-- Print Modal -->
  <div class="modal fade" id="mdlPeriodejual">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Periode Penjualan</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="form-group row">
                <label for="tgl1" class="col-sm-3 col-form-label">Tanggal Awal</label>
                <div class="col-sm-9">
                    <input type="date" class="form-control" id="tgl1" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="tgl2" class="col-sm-3 col-form-label">Tanggal Akhir</label>
                <div class="col-sm-9">
                    <input type="date" class="form-control" id="tgl2" required>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" onclick="printDoc()">
              <i class="fas fa-print"></i> Cetak
          </button>
        </div>
      </div>
    </div>
  </div>

  <script>
    function printDoc() {
        let tgl1 = document.getElementById('tgl1').value;
        let tgl2 = document.getElementById('tgl2').value;
        
        if(tgl1 && tgl2) {
            if(tgl1 > tgl2) {
                alert("Tanggal awal tidak boleh lebih besar dari tanggal akhir");
                return;
            }
            window.open("../report/r-jual.php?tgl1=" + tgl1 + "&tgl2=" + tgl2, "_blank", "width=900,height=600,left=100");
        } else {
            alert("Silakan pilih tanggal awal dan tanggal akhir");
        }
    }
  </script>

</div>

<?php
require "../templatess/footer.php";
?>