<?php
ob_start();
?>



<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4" style="position: fixed;">
  <!-- Brand Logo -->
  <a href="<?= $main_url ?>dashboard.php" class="brand-link">
    <img src="<?= $main_url ?>assets/images/icon.png" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">TB - MUTIARA</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="<?= $main_url ?>assets/images/<?= userlogin()['foto'] ?>" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="<?= $main_url ?>dashboard.php" class="d-block text-white"><?= userLogin()['username'] ?></a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="<?= $main_url ?>dashboard.php" class="nav-link <?= menuHome() ?>">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
          </a>
        </li>

        <?php
          if(userLogin()['level'] != 3 && userLogin()['level'] != 2 && userLogin()['level'] != 4){
        ?>

        <li class="nav-item <?= menuMaster()?>">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-folder"></i>
            <p>
              Master
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= $main_url ?>supplier" class="nav-link <?= menuSupplier()?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Supplier</p>
              </a>
            </li>
            <!-- <li class="nav-item">
              <a href="<?= $main_url ?>customer/data-customer.php" class="nav-link <?= menuCustomer()?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Customer</p>
              </a>
            </li> -->
            <li class="nav-item">
              <a href="<?= $main_url ?>barang" class="nav-link <?= menuBarang()?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Barang</p>
              </a>
            </li>
          </ul>
        </li>
        
        <?php
        }
        ?>


        <?php
          if(userLogin()['level'] != 3 && userLogin()['level'] != 2){
        ?>

        <li class="nav-header">Transaksi</li>
        
        <li class="nav-item">
          <a href="<?= $main_url ?>pembelian" class="nav-link <?= MenuPembelian() ?>">
            <i class="nav-icon fas fa-shopping-cart"></i>
            <p>Pembelian</p>
          </a>
        </li>

         <?php
        }
        ?>

        <?php
          if(userLogin()['level'] != 2 && userLogin()['level'] != 4){
        ?>


        <li class="nav-item">
          <a href="<?= $main_url ?>penjualan" class="nav-link <?= MenuPenjualan() ?>">
            <i class="nav-icon fas fa-file-invoice"></i>
            <p>Penjualan</p>
          </a>
        </li>
        <?php
        }
        ?>

        <?php
          if(userLogin()['level'] != 2 && userLogin()['level'] != 3){
        ?>
        <li class="nav-header">Informasi</li>
        <li class="nav-item">
          <a href="<?= $main_url ?>stockBarang" class="nav-link <?= MenuStockBarang() ?>">
            <i class="nav-icon fas fa-file-invoice"></i>
            <p>Info Stok Barang</p>
          </a>
        </li>
        <?php
        }
        ?>
        

        <?php
          if(userLogin()['level'] != 3 && userLogin()['level'] != 4){
        ?>
        
        <li class="nav-header">Report</li>
        
        <li class="nav-item">
          <a href="<?= $main_url ?>laporan-pembelian" class="nav-link <?= laporanPembelian() ?>">
            <i class="nav-icon fas fa-chart-pie"></i>
            <p>Laporan Pembelian</p>
          </a>
        </li>
        
        <li class="nav-item">
          <a href="<?= $main_url ?>laporan-penjualan" class="nav-link <?= laporanPenjualan() ?>">
            <i class="nav-icon fas fa-chart-line"></i>
            <p>Laporan Penjualan</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="<?= $main_url ?>stock" class="nav-link <?= laporanStock() ?>">
            <i class="nav-icon fas fa-warehouse"></i>
            <p>Laporan Stock</p>
          </a>
        </li>
        
        <?php
        }
        ?>

        <?php
          if(userLogin()['level'] == 1){
        ?>


        <li class="nav-header">Administator</li>
        <li class="nav-item <?= menuSetting() ?>">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-cog"></i>
            <p> Pengaturan
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= $main_url ?>users/data_user.php" class="nav-link <?= menuUser() ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Users</p>
              </a>
            </li>
          </ul>
        </li>

        <?php
          }
        ?>

      </ul>
    </nav>
  </div>
</aside>