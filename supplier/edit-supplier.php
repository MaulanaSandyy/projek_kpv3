<?php
session_start();

if(!isset($_SESSION["ssLoginPOS"])){
  header("location: ../auth/login.php");
  exit();
}

require "../config/config.php";
require "../config/functions.php";
require "../module/mode-supplier.php";

$title = "Edit Supplier - Toko Bangunan Mutiara";
require "../templatess/header.php";
require "../templatess/navbar.php";
require "../templatess/sidebar.php";

$id = $_GET['id'] ?? 0;
$supplier = getData("SELECT * FROM supplier WHERE id_supplier = $id")[0] ?? null;

if(!$supplier) {
  header("location: ../supplier");
  exit();
}

$produkSupplier = getProdukBySupplier($id);
$allProduk = getData("SELECT * FROM barang ORDER BY nama_barang");

$alert = '';
$error = '';

// Handle update supplier data
if(isset($_POST['update'])){
    if(update($_POST, $id)){
        header("Location: ../supplier?msg=updated");
        exit();
    }
}

// Handle add product
if(isset($_POST['tambah_produk'])){
    $idBarang = $_POST['id_barang'];
    
    if(!empty($idBarang)){
        // Check if product already exists
        $cek = getData("SELECT * FROM produk_supplier WHERE id_supplier = $id AND id_barang = '$idBarang'");
        if(!$cek){
            if(tambahProdukSupplier($id, $idBarang)){
                echo "<script>document.location.href = 'edit-supplier.php?id=$id';</script>";
            }
        } else {
            $error = '<div class="alert alert-warning alert-dismissible fade show">
                        <i class="icon fas fa-exclamation-triangle"></i> Produk sudah ada dalam daftar!
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                      </div>';
        }
    }
}

// Handle delete product
if(isset($_GET['hapus_produk'])){
    $idBarang = $_GET['hapus_produk'];
    mysqli_query($koneksi, "DELETE FROM produk_supplier WHERE id_supplier = $id AND id_barang = '$idBarang'");
    echo "<script>document.location.href = 'edit-supplier.php?id=$id';</script>";
}
?>

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Supplier</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= $main_url ?>dashboard.php">Home</a></li>
            <li class="breadcrumb-item"><a href="<?= $main_url ?>supplier">Supplier</a></li>
            <li class="breadcrumb-item active">Edit Supplier</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="card">
        <form action="" method="POST" id="formSupplier">
          <div class="card-header">
            <h3 class="card-title">
              <i class="fas fa-pen fa-sm"></i> Edit Supplier
            </h3>
            <button type="submit" name="update" class="btn btn-primary btn-sm float-right">
              <i class="fas fa-save"></i> Perbarui
            </button>
            <button type="reset" class="btn btn-danger btn-sm float-right mr-1">
              <i class="fas fa-times"></i> Reset
            </button>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-lg-8">
                <input type="hidden" name="id" value="<?= $supplier['id_supplier'] ?>">
                <?= $error ?>
                <?= $alert ?>
                <div class="form-group">
                  <label for="name">Nama Supplier *</label>
                  <input type="text" name="nama" class="form-control" id="nama" 
                         placeholder="Nama Supplier" value="<?= $supplier['nama'] ?>" required>
                </div>
                <div class="form-group">
                  <label for="telpon">Telpon *</label>
                  <input type="text" name="telpon" class="form-control" id="telpon" 
                         pattern="[0-9]{5,}" title="minimal 5 angka" 
                         placeholder="Nomer Telpon Supplier" value="<?= $supplier['telp'] ?>" required>
                </div>
                <div class="form-group">
                  <label for="ketr">Deskripsi *</label>
                  <textarea name="ketr" id="ketr" rows="1" class="form-control" 
                            placeholder="Keterangan Supplier"><?= $supplier['deskripsi'] ?></textarea>
                </div>
                <div class="form-group">
                  <label for="alamat">Alamat *</label>
                  <textarea name="alamat" id="alamat" rows="3" class="form-control" 
                            placeholder="Alamat Supplier"><?= $supplier['alamat'] ?></textarea>
                </div>
              </div>
              
              <!-- Kolom kanan untuk produk -->
              <div class="col-lg-4">
                <!-- Daftar Produk yang Dijual -->
                <div class="form-group">
                  <label>Produk yang Dijual</label>
                  <div id="daftarProduk" class="mb-3" style="max-height: 200px; overflow-y: auto;">
                    <?php 
                    $produkSupplier = getProdukBySupplier($id);
                    if(mysqli_num_rows($produkSupplier) > 0) {
                        while($ps = mysqli_fetch_assoc($produkSupplier)): 
                            $produkInfo = getData("SELECT * FROM barang WHERE id_barang = '{$ps['id_barang']}'")[0];
                    ?>
                    <div class="input-group mb-2 produk-item">
                      <input type="text" class="form-control form-control-sm" value="<?= $produkInfo['nama_barang'] ?>" readonly>
                      <div class="input-group-append">
                        <a href="#" 
                          class="btn btn-sm btn-danger btn-delete-produk" 
                          data-id="<?= $ps['id_barang'] ?>" 
                          data-nama="<?= htmlspecialchars($produkInfo['nama_barang']) ?>" 
                          data-idparent="<?= $id ?>" 
                          data-toggle="modal" 
                          data-target="#modalDeleteProduk" 
                          title="Hapus Produk">
                          <i class="fas fa-trash"></i>
                        </a>

                      </div>
                    </div>
                    <?php 
                        endwhile; 
                    } else {
                        echo '<p class="text-muted">Belum ada produk yang dijual</p>';
                    }
                    ?>
                  </div>
                </div>
                
                <!-- Form Tambah Produk Baru -->
                <div class="border-top pt-3">
                  <h5><i class="fas fa-plus-circle"></i> Tambah Produk</h5>
                  <form action="" method="POST">
                    <div class="form-group">
                      <select name="id_barang" class="form-control form-control-sm">
                        <option value="">-- Pilih Produk --</option>
                        <?php 
                        // Get products not already associated with this supplier
                        $produkTerdaftar = [];
                        $produkSupplier = getProdukBySupplier($id);
                        while($ps = mysqli_fetch_assoc($produkSupplier)) {
                            $produkTerdaftar[] = $ps['id_barang'];
                        }
                        
                        foreach($allProduk as $p): 
                            if(!in_array($p['id_barang'], $produkTerdaftar)):
                        ?>
                        <option value="<?= $p['id_barang'] ?>"><?= $p['nama_barang'] ?></option>
                        <?php 
                            endif;
                        endforeach; 
                        ?>
                      </select>
                    </div>
                    <button type="submit" name="tambah_produk" class="btn btn-primary btn-sm btn-block">
                      <i class="fas fa-plus"></i> Tambah Produk
                    </button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </section>
</div>

<!-- modal alert menghapus produk barang -->
<div class="modal fade" id="modalDeleteProduk" tabindex="-1" role="dialog" aria-labelledby="modalDeleteProdukLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
    <div class="modal-content bg-danger">
      <div class="modal-header">
        <h5 class="modal-title text-white">Konfirmasi Hapus</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-white">
        <p>Yakin mau hapus <strong id="namaProduk"></strong> dari daftar supplier?</p>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-outline-light" data-dismiss="modal">Batal</button>
        <a href="#" class="btn btn-light" id="btnConfirmDeleteProduk">Hapus</a>
      </div>
    </div>
  </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function() {
  // Validasi sebelum submit form
  document.getElementById('formSupplier').addEventListener('submit', function(e) {
    const produkItems = document.querySelectorAll('.produk-item');
    return true;
  });
});

  //script modal alert hapus produk
  $(document).ready(function () {
    $('.btn-delete-produk').on('click', function () {
      const idProduk = $(this).data('id');
      const namaProduk = $(this).data('nama');
      const idParent = $(this).data('idparent'); // dari parameter `id=...`

      $('#namaProduk').text(namaProduk);
      $('#btnConfirmDeleteProduk').attr('href', '?id=' + idParent + '&hapus_produk=' + idProduk);
    });
  });
</script>

<?php
require "../templatess/footer.php";
?>