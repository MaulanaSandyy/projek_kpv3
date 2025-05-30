<?php
ob_start();
session_start();

if (!isset($_SESSION["ssLoginPOS"])) {
    header("location: ../auth/login.php");
    exit();
}

require "../config/config.php";
require "../config/functions.php";
require "../module/mode-jual.php";
require "../module/mode-customer.php";

$title = "Transaksi - Toko Bangunan Mutiara";
require "../templatess/header.php";
require "../templatess/navbar.php";
require "../templatess/sidebar.php";

$alert = '';

if (isset($_POST['simpan_customer'])) {
    if (insertCustomer($_POST)) {
        header("Location: index.php");
        exit();
    }
}

if(isset($_GET['msg'])){
    $msg    = $_GET['msg'];
} else {
    $msg    = '';
}

//jika barang dihapus
if($msg == 'deleted'){
    $barcode = $_GET['barcode'];
    $idjual = $_GET['idjual'];
    $qty = $_GET['qty'];
    $tgl = $_GET['tgl'];
    deleteJual($barcode, $idjual, $qty);
}

//jika ada barcode yang dikirim
$kode = @$_GET['barcode'] ? @$_GET['barcode'] : '';
if($kode){
  $tgl = $_GET['tgl'];
  $dataBrg = mysqli_query($koneksi, "SELECT * FROM barang WHERE barcode = '$kode'");
  $selectBrg = mysqli_fetch_assoc($dataBrg);
  if(!mysqli_num_rows($dataBrg)) {
    echo "<script>
            alert('barang dengan barcode tersebut tidak ada..');
            document.location = '?tgl=$tgl';
          </script>";
  }
}

//jika tombol tambah barang di tekan
if(isset($_POST['addbrg'])) {
  $tgl = $_POST['tglNota'];
  if(insertJual($_POST)){
    echo "<script>
            document.location = '?tgl=$tgl';
          </script>";
  }
}

// Update your existing simpan_transaksi script
if (isset($_POST['simpan_transaksi'])) {
    $nota = $_POST['nojual'];
    $gbrUser = userLogin()['username'];
    $total = (float) $_POST['total'];
    $bayar = (float) str_replace('.', '', $_POST['bayar']); // Hilangkan format ribuan
    $kembalian = $bayar - $total;
    
    if ($bayar < $total) {
        echo "<script>
                alert('Pembayaran kurang dari total penjualan. Transaksi tidak dapat diproses!');
                document.location = 'index.php?tgl=".$_POST['tglNota']."';
              </script>";
        exit();
    }
    
    // Pastikan nilai yang dikirim ke fungsi simpanJual sudah benar
    $_POST['bayar'] = $bayar;
    $_POST['kembalian'] = $kembalian;
    
    if (simpanJual($_POST)) {
        echo "<script>
                $(document).ready(function(){
                    // Toast notifikasi
                    $(document).Toasts('create',{
                        title : '$user',
                        body  : 'Transaksi berhasil disimpan',
                        class : 'bg-success',
                        image  : '../assets/images/$gbrUser',
                        position : 'bottomRight',
                        autohide : true,
                        delay : 3000,
                    });
                    
                    // Modal konfirmasi cetak struk
                    Swal.fire({
                        title: 'Transaksi Berhasil',
                        html: '<div style=\"text-align:left\">' +
                              '<p style=\"margin-bottom:10px\">Transaksi berhasil disimpan!</p>' +
                              '<p>Total Harga: " . number_format($total, 0, ',', '.') . "</p>' +
                              '<p>Jumlah Bayar: " . number_format($bayar, 0, ',', '.') . "</p>' +
                              '<p>Kembalian: " . number_format($kembalian, 0, ',', '.') . "</p>' +
                              '<p>Apakah Anda ingin mencetak struk transaksi?</p>' +
                              '</div>',
                        icon: 'success',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Cetak',
                        cancelButtonText: 'Tidak',
                        allowOutsideClick: false,
                        customClass: {
                            popup: 'swal-wide'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Jika memilih cetak, buka halaman struk
                            window.open('../report/r-struk-jual.php?nota=$nota', '_blank');
                        }
                        // Redirect ke halaman transaksi baru
                        window.location.href = '../penjualan';
                    });
                });
            </script>";
    }
}

$nojual = generateNo();

// Ambil data customer dengan pencarian jika ada
$search_customer = isset($_GET['search_customer']) ? $_GET['search_customer'] : '';
$query_customer = "SELECT * FROM customer";
if(!empty($search_customer)) {
    $query_customer .= " WHERE nama LIKE '%$search_customer%'";
}
$customers = getData($query_customer);

// Ambil data barang untuk pencarian
$search_barang = isset($_GET['search_barang']) ? $_GET['search_barang'] : '';
$query_barang = "SELECT * FROM barang WHERE 1";

if(!empty($search_barang)) {
    // Escape string untuk pencarian
    $search_term = mysqli_real_escape_string($koneksi, $search_barang);
    $query_barang .= " AND (nama_barang LIKE '%$search_term%' OR barcode LIKE '%$search_term%')";
}
$barang_list = getData($query_barang);
?>

<style>
    /* Add to your existing CSS */
.alert-modal {
    position: fixed;
    bottom: 20px;
    right: 20px;
    width: 300px;
    background-color: #fff;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0,0,0,0.2);
    padding: 15px;
    z-index: 9999;
    display: none;
    animation: slideIn 0.5s forwards;
}

.alert-modal-header {
    font-weight: bold;
    margin-bottom: 10px;
    color: #28a745;
}

.alert-modal-body {
    margin-bottom: 15px;
}

.alert-modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
}

@keyframes slideIn {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

@keyframes fadeOut {
    from {
        opacity: 1;
    }
    to {
        opacity: 0;
    }
}

/* Style untuk input uang */
.formatted-input {
    text-align: right;
}
</style>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Penjualan Barang</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= $main_url ?>dashboard.php">Home</a></li>
                        <li class="breadcrumb-item active">Tambah Penjualan</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section>
        <div class="container-fluid">
            <form action="" method="post" id="formPenjualan">
                <div class="row">
                    <!-- Form Input Kiri -->
                    <div class="col-lg-6">
                        <div class="card card-outline card-warning p-3">
                            <div class="form-group row mb-2">
                                <label for="noNota" class="col-sm-2 col-form-label">No Nota</label>
                                <div class="col-sm-4">
                                    <input type="text" name="nojual" class="form-control" id="noNota" value="<?= $nojual ?>" readonly>
                                </div>
                                <label for="tglNota" class="col-sm-2 col-form-label">Tgl Nota</label>
                                <div class="col-sm-4">
                                    <input type="date" name="tglNota" class="form-control" id="tglNota" value="<?= @$_GET['tgl'] ? $_GET['tgl'] : date('Y-m-d') ?>" required>
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label for="searchBarang" class="col-sm-2 col-form-label">Cari</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="searchBarangInput" placeholder="Masukkan nama atau barcode barang" value="<?= $search_barang ?>">
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label for="barcode" class="col-sm-2 col-form-label">Barang</label>
                                <div class="col-sm-10">
                                    <select name="barcode" id="barcode" class="form-control">
                                        <option value="">-- Pilih barang --</option>
                                        <?php foreach($barang_list as $row): ?>
                                            <option value="?barcode=<?= $row['barcode'] ?>" 
                                                data-deskripsi="<?= htmlspecialchars($row['nama_barang']) ?>"
                                                <?= @$_GET['barcode'] == $row['barcode'] ? 'selected' : null ?>>
                                                <?= htmlspecialchars($row['barcode'] . ' | ' . $row['nama_barang']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="card card-outline card-danger pt-3 px-3 pb-2">
                            <h6 class="font-weight-bold text-right">Total Penjualan</h6>
                            <h1 class="font-weight-bold text-right" style="font-size: 40pt;">
                                <input type="hidden" name="total" id="total" value="<?= totalJual($nojual) ?>"><?= number_format(totalJual($nojual),0,',','.') ?>
                            </h1>
                        </div>
                    </div>
                </div>
                
                <div class="card pt-1 pb-2 px-3">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <input type="hidden" value="<?= @$_GET['barcode'] ? $selectBrg['barcode'] : '' ?>" name="barcode">
                                <label for="namaBrg">Nama Barang</label>
                                <input type="text" name="namaBrg" class="form-control form-control-sm" id="namaBrg" value="<?= @$_GET['barcode'] ? $selectBrg['nama_barang'] : '' ?>" readonly>
                            </div>
                        </div>
                        <div class="col-lg-1">
                            <div class="form-group">
                                <label for="stock">Stok</label>
                                <input type="number" name="stock" class="form-control form-control-sm" id="stock" value="<?= @$_GET['barcode'] ? $selectBrg['stock'] : '' ?>" readonly>
                            </div>
                        </div>
                        <div class="col-lg-1">
                            <div class="form-group">
                                <label for="satuan">Satuan</label>
                                <input type="text" name="satuan" class="form-control form-control-sm" id="satuan" value="<?= @$_GET['barcode'] ? $selectBrg['satuan'] : '' ?>" readonly>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="harga">Harga</label>
                                <input type="number" name="harga" class="form-control form-control-sm" id="harga" value="<?= @$_GET['barcode'] ? $selectBrg['harga_jual'] : '' ?>" readonly>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="qty">Jumlah Barang</label>
                                <input type="number" name="qty" class="form-control form-control-sm" id="qty" value="<?= @$_GET['barcode'] ? 1 : '' ?>">
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="jmlHarga">Total</label>
                                <input type="number" name="jmlHarga" class="form-control form-control-sm" id="jmlHarga" value="<?= @$_GET['barcode'] ? $selectBrg['harga_jual'] : '' ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-sm btn-info btn-block" name="addbrg"><i class="fas fa-cart-plus fa-sm"></i> Tambah Barang</button>
                </div>
                
                <div class="card card-outline card-success table-responsive px-2">
                    <table class="table table-sm table-hover text-nowrap" id="tblPenjualan">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Barcode</th>
                                <th>Nama Barang</th>
                                <th class="text-right">Harga</th>
                                <th class="text-right">Jumlah Barang</th>
                                <th class="text-right">Jumlah Harga</th>
                                <th class="text-center" width="10%">Operasi</th>
                            </tr>
                        </thead>
                        <tbody>
                          <?php 
                            $no = 1;
                            $brgDetail = getData("SELECT * FROM jual_detail WHERE no_jual = '$nojual'");
                            foreach($brgDetail as $detail) { ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $detail['barcode'] ?></td>
                                    <td><?= $detail['nama_brg'] ?></td>
                                    <td class="text-right"><?= number_format($detail['harga_jual'], 0,',','.') ?></td>
                                    <td class="text-right"><?= $detail['qty'] ?>
                                        <!-- Tombol Edit -->
                                        <a href="#" 
                                            class="btn btn-sm btn-warning btn-edit-qty ml-3" 
                                            data-idjual="<?= $detail['no_jual'] ?>" 
                                            data-barcode="<?= $detail['barcode'] ?>" 
                                            data-qty="<?= $detail['qty'] ?>" 
                                            data-tgl="<?= $detail['tgl_jual'] ?>" 
                                            title="Edit jumlah">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    </td>
                                    <td class="text-right"><?= number_format($detail['jml_harga'], 0,',','.') ?></td>
                                    <td class="text-center">
                                        <!-- Tombol Hapus -->
                                        <a href="#" 
                                            class="btn btn-sm btn-danger btn-delete-detail" 
                                            data-nama="<?= htmlspecialchars($detail['nama_brg']) ?>" 
                                            data-barcode="<?= $detail['barcode'] ?>" 
                                            data-idjual="<?= $detail['no_jual'] ?>" 
                                            data-qty="<?= $detail['qty'] ?>" 
                                            data-tgl="<?= $detail['tgl_jual'] ?>" 
                                            data-toggle="modal" 
                                            data-target="#modalDeleteDetail" 
                                            title="Hapus barang">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="card card pt-1 pb-2 px-3">
                    <div class="row">
                        <div class="col-lg-4 p-2">
                            <div class="form-group row mb-2">
                                <label for="customer" class="col-sm-3 form-label col-form-label-sm">Customer</label>
                                <div class="col-sm-9">
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control form-control-sm" id="searchCustomer" 
                                            placeholder="Cari customer..." value="<?= $search_customer ?>">
                                        <div class="input-group-append">
                                            <button class="btn btn-sm btn-outline-secondary" type="button" id="btnSearchCustomer">
                                                <i class="fas fa-search"></i>
                                            </button>
                                            <a href="#" class="btn btn-sm btn-outline-primary ml-1" data-toggle="modal" data-target="#customerModal">
                                                <i class="fas fa-plus"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <select name="customer" id="customer" class="form-control form-control-sm">
                                        <?php
                                        foreach($customers as $customer) {
                                            ?>
                                            <option value="<?= $customer['nama'] ?>"><?= $customer['nama'] ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label for="ketr" class="col-sm-3 col-form-label">Keterangan</label>
                                <div class="col-sm-9">
                                    <textarea name="ketr" id="ketr" class="form-control form-control-sm"></textarea>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-4 py-2 px-3">
                            <div class="form-group row mb-2">
                                <label for="bayar" class="col-sm-3 col-form-label">Bayar</label>
                                <div class="col-sm-9">
                                    <input type="text" name="bayar" class="form-control form-control-sm text-right formatted-input" id="bayar" placeholder="0" onkeyup="calculateChange()">
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label for="kembalian" class="col-sm-3 col-form-label">Kembalian</label>
                                <div class="col-sm-9">
                                    <input type="text" name="kembalian" class="form-control form-control-sm text-right" id="kembalian" readonly value="0">
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-4 p-2">
                            <button type="submit" name="simpan_transaksi" id="simpan" class="btn btn-primary btn-sm btn-block"><i class="fa fa-save"></i> Simpan</button>
                            <button type="button" id="resetBtn" class="btn btn-danger btn-sm btn-block mt-2">
                                <i class="fa fa-trash"></i> Reset Pembelian
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    
    <!-- Modal untuk tambah customer -->
    <div class="modal fade" id="customerModal" tabindex="-1" role="dialog" aria-labelledby="customerModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="customerModalLabel">Tambah Customer Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <form action="" method="POST">
                        <div class="card-header">
                            <h3 class="card-title">
                            <i class="fas fa-plus fa-sm"></i> Tambah Customer
                            </h3>
                            <button type="submit" name="simpan_customer" class="btn btn-primary btn-sm float-right">
                            <i class="fas fa-save"></i> Simpan
                            </button>
                            <button type="reset" class="btn btn-danger btn-sm float-right mr-1">
                            <i class="fas fa-times"></i> Reset
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-8 mb-3">
                                    <?php if($alert != ''){
                                    echo $alert;
                                    } ?>
                                    <div class="form-group">
                                    <label for="name">Nama Customer</label>
                                    <input type="text" name="nama" class="form-control" id="nama" placeholder="Nama Customer" autofocus autocomplete="off" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>

    <!-- Add this before </body> -->
    <div class="alert-modal" id="printAlertModal">
        <div class="alert-modal-header">
            <i class="fas fa-check-circle"></i> Transaksi Berhasil
        </div>
        <div class="alert-modal-body">
            Apakah Anda ingin mencetak struk?
        </div>
        <div class="alert-modal-footer">
            <button class="btn btn-sm btn-secondary" id="btnNoPrint">Tidak</button>
            <button class="btn btn-sm btn-primary" id="btnYesPrint">Ya, Cetak</button>
        </div>
    </div>

    <!-- Modal Hapus Detail -->
    <div class="modal fade" id="modalDeleteDetail" tabindex="-1" role="dialog" aria-labelledby="modalDeleteDetailLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content bg-danger animate__animated animate__zoomIn">
                <div class="modal-header">
                    <h5 class="modal-title text-white">Konfirmasi Hapus</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-white">
                    <p>Yakin mau hapus barang <strong id="namaDetail"></strong>?</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Batal</button>
                    <a href="#" class="btn btn-light" id="btnConfirmDeleteDetail">Hapus</a>
                </div>
            </div>
        </div>
    </div>

    <!-- model edit qty -->
    <div class="modal fade" id="modalEditQty" tabindex="-1" role="dialog" aria-labelledby="modalEditQtyLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditQtyLabel">Edit Jumlah Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formEditQty">
                        <input type="hidden" name="no_jual" id="edit_no_jual">
                        <input type="hidden" name="barcode" id="edit_barcode">
                        <input type="hidden" name="tgl" id="edit_tgl">
                        <div class="form-group">
                            <label for="edit_qty">Jumlah Barang</label>
                            <input type="number" class="form-control text-right" name="new_qty" id="edit_qty" min="1" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="btnSaveEditQty">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    
    <script>

        //script edit qty walaupun sudah di table
        $(document).ready(function() {
            // Handle klik tombol edit
            $(document).on('click', '.btn-edit-qty', function() {
                const no_jual = $(this).data('idjual');
                const barcode = $(this).data('barcode');
                const qty = $(this).data('qty');
                const tgl = $(this).data('tgl');
                
                // Isi form modal
                $('#edit_no_jual').val(no_jual);
                $('#edit_barcode').val(barcode);
                $('#edit_qty').val(qty);
                $('#edit_tgl').val(tgl);
                
                $('#modalEditQty').modal('show');
            });
            
            // Handle simpan edit qty
            $('#btnSaveEditQty').click(function() {
                const formData = $('#formEditQty').serialize();
                
                $.ajax({
                    url: '../module/update-qty.php',
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        if(response.success) {
                            // Refresh halaman untuk update tampilan
                            const tgl = $('#edit_tgl').val();
                            window.location.href = 'index.php?tgl=' + tgl;
                        } else {
                            alert('Gagal update qty: ' + response.message);
                        }
                    },
                    error: function() {
                        alert('Terjadi kesalahan saat update qty');
                    }
                });
            });
        });

        //script untuk modal alert
        $(document).ready(function () {
            $('.btn-delete-detail').on('click', function () {
                const nama = $(this).data('nama');
                const barcode = $(this).data('barcode');
                const idjual = $(this).data('idjual');
                const qty = $(this).data('qty');
                const tgl = $(this).data('tgl');

                $('#namaDetail').text(nama);
                $('#btnConfirmDeleteDetail').attr('href', '?barcode=' + barcode + '&idjual=' + idjual + '&qty=' + qty + '&tgl=' + tgl + '&msg=deleted');
            });
        });



        // Fungsi untuk mendapatkan nilai numerik dari input yang diformat
        function getNumericValue(formattedValue) {
            // Hilangkan semua karakter non-digit dan konversi ke float
            return parseFloat(formattedValue.replace(/[^\d]/g, '')) || 0;
        }

        // Fungsi untuk menghitung kembalian
        function calculateChange() {
            const total = parseFloat(document.getElementById('total').value);
            const bayar = getNumericValue(document.getElementById('bayar').value);
            const kembalian = bayar - total;
            
            // Format kembalian dengan pemisah ribuan
            document.getElementById('kembalian').value = kembalian > 0 ? kembalian.toLocaleString('id-ID') : '0';
        }

        // Validasi form sebelum submit
        document.getElementById('formPenjualan').addEventListener('submit', function(e) {
            if (e.submitter && e.submitter.name === 'simpan_transaksi') {
                const total = parseFloat(document.getElementById('total').value);
                const bayar = getNumericValue(document.getElementById('bayar').value);
                const kembalian = bayar - total;
                
                if (bayar < total) {
                    e.preventDefault();
                    alert('Pembayaran kurang dari total penjualan. Transaksi tidak dapat diproses!');
                    document.getElementById('bayar').focus();
                    return false;
                }
                
                // Set nilai bayar dan kembalian tanpa format sebelum submit
                document.getElementById('bayar').value = bayar.toString();
                document.getElementById('kembalian').value = kembalian.toString();
            }
            return true;
        });

        // Fungsi untuk memformat angka dengan pemisah ribuan
        function formatNumber(num) {
            return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
        }

        // Fungsi untuk menghilangkan format ribuan
        function unformatNumber(num) {
            return num.toString().replace(/\./g, '');
        }

        // Fungsi untuk menghitung kembalian
        function calculateChange() {
            const total = parseFloat(document.getElementById('total').value);
            const bayar = parseFloat(unformatNumber(document.getElementById('bayar').value)) || 0;
            const kembalian = bayar - total;
            
            // Format kembalian dengan pemisah ribuan
            document.getElementById('kembalian').value = kembalian > 0 ? formatNumber(kembalian) : '0';
        }

        // Format input bayar saat diketik
        document.getElementById('bayar').addEventListener('input', function(e) {
            // Simpan posisi cursor
            const cursorPosition = this.selectionStart;
            
            // Ambil nilai dan hapus semua karakter non-digit
            let value = this.value.replace(/[^\d]/g, '');
            
            // Format angka dengan pemisah ribuan jika ada nilai
            if (value.length > 0) {
                this.value = formatNumber(parseInt(value, 10));
            } else {
                this.value = '';
            }
            
            // Kembalikan posisi cursor
            const newLength = this.value.length;
            const newPosition = cursorPosition - (this.value.length - newLength);
            this.setSelectionRange(newPosition, newPosition);
            
            // Hitung kembalian
            calculateChange();
        });

        // Validasi form sebelum submit
        document.getElementById('formPenjualan').addEventListener('submit', function(e) {
            if (e.submitter && e.submitter.name === 'simpan_transaksi') {
                const total = parseFloat(document.getElementById('total').value);
                const bayar = parseFloat(unformatNumber(document.getElementById('bayar').value)) || 0;
                
                if (bayar < total) {
                    e.preventDefault();
                    alert('Pembayaran kurang dari total penjualan. Transaksi tidak dapat diproses!');
                    document.getElementById('bayar').focus();
                    return false;
                }
                
                // Format ulang nilai bayar sebelum submit (pastikan tanpa titik)
                document.getElementById('bayar').value = unformatNumber(document.getElementById('bayar').value);
            }
            return true;
        });

        function showPrintAlert(nota) {
            const modal = document.getElementById('printAlertModal');
            modal.style.display = 'block';
            
            // Auto hide after 5 seconds
            const timeout = setTimeout(() => {
                hidePrintAlert();
            }, 5000);
            
            // Button handlers
            document.getElementById('btnYesPrint').addEventListener('click', function() {
                clearTimeout(timeout);
                hidePrintAlert();
                printReceipt(nota);
            });
            
            document.getElementById('btnNoPrint').addEventListener('click', function() {
                clearTimeout(timeout);
                hidePrintAlert();
                window.location.href = 'index.php';
            });
        }

        function hidePrintAlert() {
            const modal = document.getElementById('printAlertModal');
            modal.style.animation = 'fadeOut 0.5s forwards';
            setTimeout(() => {
                modal.style.display = 'none';
                modal.style.animation = 'slideIn 0.5s forwards';
            }, 500);
        }

        function printReceipt(nota) {
            let win = window.open(`../report/r-struk-jual.php?nota=${nota}`, 'Struk Belanja Toko Bangunan Mutiara', 'width=260,height=400,left=10,top=10');
            if (win) {
                win.focus();
            }
            window.location.href = 'index.php';
        }

        // Tambahkan script ini di bagian JavaScript yang sudah ada
        document.getElementById('resetBtn').addEventListener('click', function() {
            const no_jual = document.getElementById('noNota').value;
            const tgl = document.getElementById('tglNota').value;
                
            fetch(`reset-penjualan.php?no_jual=${no_jual}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Reload halaman untuk update tampilan
                        window.location.href = `index.php?tgl=${tgl}`;
                    } else {
                        alert('Gagal mereset transaksi: ' + data.error);
                    }
                })
            .catch(error => {
                console.error('Error:', error);
                    alert('Terjadi kesalahan saat mereset transaksi');
                }
            );
        });

        // Fungsi pencarian barang
        document.getElementById('searchBarangInput').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const options = barcode.options;
            
            for (let i = 0; i < options.length; i++) {
                const option = options[i];
                if (option.text.toLowerCase().includes(searchTerm)) {
                    option.style.display = '';
                } else {
                    option.style.display = 'none';
                }
            }
        });

        // Aktifkan pencarian dengan tombol Enter
        document.getElementById('searchBarangInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                document.getElementById('btnSearchBarang').click();
            }
        });

        function resetTabelPenjualan() {
            const thead = tblPenjualan.querySelector('thead');
            thead.innerHTML = '';
        }

      let barcode = document.getElementById('barcode');
      let tgl = document.getElementById('tglNota');
      let qty = document.getElementById('qty');
      let harga = document.getElementById('harga');
      let jmlHarga = document.getElementById('jmlHarga');
      let total = document.getElementById('total');
      let formPenjualan = document.getElementById('formPenjualan')
      let tblPenjualan = document.getElementById('tblPenjualan')

      barcode.addEventListener('change', function(){
        document.location.href = this.options[this.selectedIndex].value + '&tgl=' + tgl.value;
      })

      qty.addEventListener('input', function(){
        jmlHarga.value = qty.value * harga.value;
      })

      // Fungsi pencarian customer
      document.getElementById('btnSearchCustomer').addEventListener('click', function() {
          const search = document.getElementById('searchCustomer').value;
          const url = new URL(window.location.href);
          url.searchParams.set('search_customer', search);
          window.location.href = url.toString();
      });

      // Aktifkan pencarian dengan tombol Enter
      document.getElementById('searchCustomer').addEventListener('keypress', function(e) {
          if (e.key === 'Enter') {
              document.getElementById('btnSearchCustomer').click();
          }
      });

      // Validasi form sebelum submit
      formPenjualan.addEventListener('submit', function(e) {
          if (e.submitter && e.submitter.name === 'addbrg') {
              
              if (!barcode.value) {
                  e.preventDefault();
                  alert('Silakan pilih barang terlebih dahulu');
                  return false;
              }
              
              const qtyValue = parseInt(qty.value);
              if (isNaN(qtyValue) || qtyValue <= 0) {
                  e.preventDefault();
                  alert('Jumlah barang harus lebih dari 0');
                  return false;
              }
          }
          
          if (e.submitter && e.submitter.name === 'simpan_transaksi') {
              const brgDetailRows = tblPenjualan.querySelectorAll('tbody tr');
              if (brgDetailRows.length === 0) {
                  e.preventDefault();
                  alert('Anda belum menambahkan barang untuk pembelian ini');
                  return false;
              }
              
              // Set timeout untuk reset form setelah simpan
              setTimeout(() => {
                  resetFormBarang();
                  resetTabelPembelian();
                  // Generate nomor pembelian baru
                  document.getElementById('noNota').value = 'PJ' + Math.floor(1000 + Math.random() * 9000);
              }, 100);
          }
          return true;
      });
    </script>
</div>

<?php
require "../templatess/footer.php";
?>