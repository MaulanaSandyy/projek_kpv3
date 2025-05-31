<?php
session_start();

if(!isset($_SESSION["ssLoginPOS"])){
  header("location: ../auth/login.php");
  exit();
}

require "../config/config.php";
require "../config/functions.php";
require "../module/mode-beli.php";

$title = "Transaksi - Toko Bangunan Mutiara";
require "../templatess/header.php";
require "../templatess/navbar.php";
require "../templatess/sidebar.php";

if(isset($_GET['msg'])){
    $msg    = $_GET['msg'];
} else {
    $msg    = '';
}

if($msg == 'deleted'){
    $idbrg = $_GET['idbrg'];
    $idbeli = $_GET['idbeli'];
    $qty = $_GET['qty'];
    $tgl = $_GET['tgl'];
    delete($idbrg, $idbeli, $qty);
    echo "<script>
            document.location.href = 'index.php?tgl=$tgl';
        </script>";
    exit();
}

if (isset($_POST['addbrg'])){
    $tgl = $_POST['tglNota'];
    $supplier = $_POST['supplier'];
    
    if (insert($_POST)){
        echo "<script>
                document.location.href = 'index.php?tgl=$tgl';
            </script>";
        exit();
    }
}

if (isset($_POST['simpan'])){
    $tgl = $_POST['tglNota'];
    
    if (simpan($_POST)){
        $noBeli = generateNo();
        echo "<script>
                alert('Data berhasil disimpan');
                document.location.href = 'index.php?msg=sukses';
            </script>";
        exit();
    }
}

$noBeli = generateNo();
?>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Pembelian Barang</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= $main_url ?>dashboard.php">Home</a></li>
            <li class="breadcrumb-item active">Tambah Pembelian</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>

  <section>
    <div class="container-fluid">
        <form action="" method="post" id="formPembelian">
            <input type="hidden" id="currentSupplier" name="supplier" value="">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card card-outline card-warning p-3">
                        <div class="form-group row mb-2">
                            <label for="noNota" class="col-sm-2 col-form-label">No Nota</label>
                            <div class="col-sm-4">
                                <input type="text" name="nobeli" class="form-control" id="noNota" value="<?= $noBeli ?>" readonly>
                            </div>
                            <label for="tglNota" class="col-sm-2 col-form-label">Tgl Nota</label>
                            <div class="col-sm-4">
                                <input type="date" name="tglNota" class="form-control" id="tglNota" value="<?= @$_GET['tgl'] ? $_GET['tgl'] : date('Y-m-d') ?>" required>
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <label for="suplier" class="col-sm-2 col-form-label">Supplier</label>
                            <div class="col-sm-10">
                                <select name="suplier" id="suplier" class="form-control">
                                    <option value="">-- Pilih Supplier --</option>
                                    <?php
                                    $suppliers = getData("SELECT * FROM supplier ORDER BY nama");
                                    foreach($suppliers as $supplier): ?>
                                        <option value="<?= $supplier['id_supplier'] ?>">
                                            <?= $supplier['nama'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <label for="kodeBrg" class="col-sm-2 col-form-label">Barang</label>
                            <div class="col-sm-8">
                                <select name="kodeBrg" id="kodeBrg" class="form-control" disabled>
                                    <option value="">-- Pilih Supplier terlebih dahulu --</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <input type="text" id="searchBarang" class="form-control" placeholder="Cari..." disabled>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card card-outline card-danger pt-3 px-3 pb-2">
                        <h6 class="font-weight-bold text-right">Total Pembelian</h6>
                        <input type="hidden" name="total" value="<?= totalBeli($noBeli) ?>">
                        <h1 class="font-weight-bold text-right" style="font-size: 40pt;"><?= number_format(totalBeli($noBeli),0,',','.') ?></h6>
                    </div>
                </div>
            </div>
            <div class="card pt-1 pb-2 px-3">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <input type="hidden" id="selectedBarangId" name="kodeBrg" value="">
                            <label for="namaBrg">Nama Barang</label>
                            <input type="text" name="namaBrg" class="form-control form-control-sm" id="namaBrg" value="" readonly>
                        </div>
                    </div>
                    <div class="col-lg-1">
                        <div class="form-group">
                            <label for="stock">Stok</label>
                            <input type="number" name="stock" class="form-control form-control-sm" id="stock" value="" readonly>
                        </div>
                    </div>
                    <div class="col-lg-1">
                        <div class="form-group">
                            <label for="satuan">Satuan</label>
                            <input type="text" name="satuan" class="form-control form-control-sm" id="satuan" value="" readonly>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="harga">Harga</label>
                            <input type="number" name="harga" class="form-control form-control-sm" id="harga" value="" readonly>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="qty">Jumlah Barang</label>
                            <input type="number" name="qty" class="form-control form-control-sm" id="qty" value="1" min="1" required>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="jmlHarga">Jumlah Harga</label>
                            <input type="number" name="jmlHarga" class="form-control form-control-sm" id="jmlHarga" value="" readonly>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-sm btn-info btn-block" name="addbrg" disabled><i class="fas fa-cart-plus fa-sm"></i> Tambah Barang</button>
            </div>
            <div class="card card-outline card-success table-responsive px-2">
                <table class="table table-sm table-hover text-nowrap" id="tblPembelian">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Barang</th>
                            <th>Supplier</th>
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
                        $brgDetail = getData("SELECT * FROM beli_detail WHERE no_beli = '$noBeli'");
                        foreach($brgDetail as $detail){?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $detail['kode_brg'] ?></td>
                            <td><?= $detail['supplier_name'] ?></td>
                            <td><?= $detail['nama_brg'] ?></td>
                            <td class="text-right"><?= number_format($detail['harga_beli'], 0,',','.') ?></td>
                            <td class="text-right"><?= $detail['qty'] ?></td>
                            <td class="text-right"><?= number_format($detail['jml_harga'], 0,',','.') ?></td>
                            <td class="text-center">
                                <a href="?idbrg=<?= $detail['kode_brg'] ?>&idbeli=<?= $detail['no_beli'] ?>&qty=<?= $detail['qty']?>&tgl=<?= $detail['tgl_beli'] ?>&msg=deleted"
                                class="btn btn-sm btn-danger" title="hapus barang" onclick="return confirm('Anda yakin akan menghapus barang ini?')"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="card pt-1 pb-2 px-3">
                <div class="row">
                    <div class="col-lg-6 p-2">
                        <div class="form-group row mb-2">
                            <label for="supplierName" class="col-sm-3 form-label col-form-label-sm">Supplier</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control form-control-sm" id="supplierName" value="" readonly>
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <label for="ketr" class="col-sm-3 col-form-label">Keterangan</label>
                            <div class="col-sm-9">
                                <textarea name="ketr" id="ketr" class="form-control form-control-sm"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 p-2">
                        <button type="submit" name="simpan" id="simpan" class="btn btn-primary btn-sm btn-block" <?= empty($brgDetail) ? 'disabled' : '' ?>>
                            <i class="fa fa-save"></i> Simpan
                        </button>
                        <button type="button" id="resetBtn" class="btn btn-danger btn-sm btn-block mt-2">
                            <i class="fa fa-trash"></i> Reset Pembelian
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
  </section>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
        const supplierSelect = document.getElementById('suplier');
        const barangSelect = document.getElementById('kodeBrg');
        const searchBarang = document.getElementById('searchBarang');
        const currentSupplier = document.getElementById('currentSupplier');
        const simpanBtn = document.getElementById('simpan');
        const formPembelian = document.getElementById('formPembelian');
        const tblPembelian = document.getElementById('tblPembelian');
        const addBrgBtn = document.querySelector('button[name="addbrg"]');
        
        // Fungsi untuk memuat barang berdasarkan supplier
        function loadProducts(supplierId) {
            if (supplierId) {
                barangSelect.disabled = false;
                searchBarang.disabled = false;
                addBrgBtn.disabled = false;
                
                fetch(`../supplier/get-supplier.php?id_supplier=${supplierId}`)
                    .then(response => response.json())
                    .then(products => {
                        barangSelect.innerHTML = '<option value="">-- Pilih Barang --</option>';
                        products.forEach(product => {
                            const option = document.createElement('option');
                            option.value = product.id_barang;
                            option.textContent = `${product.id_barang} | ${product.nama_barang}`;
                            option.setAttribute('data-nama', product.nama_barang);
                            option.setAttribute('data-stock', product.stock);
                            option.setAttribute('data-satuan', product.satuan);
                            option.setAttribute('data-harga', product.harga_beli);
                            barangSelect.appendChild(option);
                        });
                    });
            } else {
                barangSelect.disabled = true;
                searchBarang.disabled = true;
                addBrgBtn.disabled = true;
                barangSelect.innerHTML = '<option value="">-- Pilih Supplier terlebih dahulu --</option>';
            }
        }
        
        // Event ketika supplier dipilih
        supplierSelect.addEventListener('change', function() {
            const supplierId = this.value;
            const supplierName = this.options[this.selectedIndex].text;
            
            currentSupplier.value = supplierId;
            document.getElementById('supplierName').value = supplierName;
            loadProducts(supplierId);
            resetFormBarang();
        });
        
        // Fungsi reset form barang
        function resetFormBarang() {
            document.getElementById('selectedBarangId').value = '';
            document.getElementById('namaBrg').value = '';
            document.getElementById('stock').value = '';
            document.getElementById('satuan').value = '';
            document.getElementById('harga').value = '';
            document.getElementById('qty').value = '1';
            document.getElementById('jmlHarga').value = '';
        }
        
        // Fungsi reset tabel pembelian
        function resetTabelPembelian() {
            const tbody = tblPembelian.querySelector('tbody');
            tbody.innerHTML = '';
            
            // Update total pembelian
            document.querySelector('h1.font-weight-bold.text-right').textContent = '0';
            document.querySelector('input[name="total"]').value = '0';
        }
        
        // Fungsi pencarian barang
        searchBarang.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const options = barangSelect.options;
            
            for (let i = 0; i < options.length; i++) {
                const option = options[i];
                if (option.text.toLowerCase().includes(searchTerm)) {
                    option.style.display = '';
                } else {
                    option.style.display = 'none';
                }
            }
        });
        
        // Event ketika barang dipilih
        barangSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            
            if (selectedOption.value) {
                document.getElementById('selectedBarangId').value = selectedOption.value;
                document.getElementById('namaBrg').value = selectedOption.getAttribute('data-nama');
                document.getElementById('stock').value = selectedOption.getAttribute('data-stock');
                document.getElementById('satuan').value = selectedOption.getAttribute('data-satuan');
                document.getElementById('harga').value = selectedOption.getAttribute('data-harga');
                document.getElementById('qty').value = '1';
                document.getElementById('jmlHarga').value = selectedOption.getAttribute('data-harga');
            }
        });
        
        // Hitung jumlah harga ketika qty diubah
        const qty = document.getElementById('qty');
        const jmlHarga = document.getElementById('jmlHarga');
        const harga = document.getElementById('harga');
        
        qty.addEventListener('input', function() {
            const quantity = parseInt(this.value) || 0;
            const price = parseInt(harga.value) || 0;
            jmlHarga.value = quantity * price;
        });
        
        // Validasi form sebelum submit
        formPembelian.addEventListener('submit', function(e) {
            if (e.submitter.name === 'addbrg') {
                if (!supplierSelect.value) {
                    e.preventDefault();
                    alert('Silakan pilih supplier terlebih dahulu');
                    return false;
                }
                
                if (!barangSelect.value) {
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
            
            if (e.submitter.name === 'simpan') {
                const brgDetailRows = tblPembelian.querySelectorAll('tbody tr');
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
                    document.getElementById('noNota').value = 'PB' + Math.floor(1000 + Math.random() * 9000);
                }, 100);
            }
            return true;
        });
        
        // Reset pembelian
        document.getElementById('resetBtn').addEventListener('click', function() {
            const noBeli = document.getElementById('noNota').value;
            const tgl = document.getElementById('tglNota').value;
            fetch(`reset-pembelian.php?no_beli=${noBeli}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = `index.php?tgl=${tgl}`;
                    } else {
                        alert('Gagal mereset pembelian');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat mereset pembelian');
                });
        });
    });
  </script>

</div>

<?php
require "../templatess/footer.php"
?>