<?php

function generateNo(){
    global $koneksi;

    $queryNo = mysqli_query($koneksi, "SELECT max(no_jual) as maxno FROM jual_head");
    $row = mysqli_fetch_assoc($queryNo);
    $maxno = $row["maxno"];
    
    $noUrut = (int) substr($maxno, 2, 4);
    $noUrut++;
    $maxno = 'PJ' . sprintf("%04s", $noUrut);

    return $maxno;
}

function totalJual($noJual)
{
    global $koneksi;

    $totalJual = mysqli_query($koneksi, "SELECT sum(jml_harga) AS total FROM jual_detail WHERE no_jual = '$noJual'");
    $data = mysqli_fetch_assoc($totalJual);
    $total = $data["total"];

    return $total;
}

function insertJual($data){
    global $koneksi;

    $no = mysqli_real_escape_string($koneksi, $data['nojual']);
    $tgl = mysqli_real_escape_string($koneksi, $data['tglNota']);
    $kode = mysqli_real_escape_string($koneksi, $data['barcode']);
    $nama = mysqli_real_escape_string($koneksi, $data['namaBrg']);
    $qty = (int)$data['qty'];
    $harga = (float)$data['harga'];
    $jmlharga = (float)$data['jmlHarga'];
    $stok = (int)$data['stock'];

    // cek barang sudah diinput atau belum
    $cekbrg = mysqli_query($koneksi, "SELECT * FROM jual_detail WHERE no_jual = '$no' AND barcode = '$kode'");

    if(mysqli_num_rows($cekbrg)){
        echo "<script>
                alert('Barang sudah ada, anda harus menghapusnya dulu jika ingin mengubah qty nya..');
        </script>";
        return false;
    }
    
    // qty tidak boleh kosong
    if(empty($qty)){
        echo "<script>
                alert('Qty barang tidak boleh kosong');
        </script>";
        return false;
    } else if ($qty > $stok){
        echo "<script>
                alert('Stok barang tidak mencukupi');
        </script>";
        return false;
    }

    $sqljual = "INSERT INTO jual_detail VALUES (null, '$no', '$tgl', '$kode', '$nama', $qty, $harga, $jmlharga)";
    mysqli_query($koneksi, $sqljual);
    
    mysqli_query($koneksi, "UPDATE barang SET stock = stock - $qty WHERE barcode = '$kode'");

    return mysqli_affected_rows($koneksi);
}

function deleteJual($barcode, $idjual, $qty){
    global $koneksi;

    $sqlDel = "DELETE FROM jual_detail WHERE barcode = '$barcode' AND no_jual = '$idjual'";
    mysqli_query($koneksi, $sqlDel);

    mysqli_query($koneksi, "UPDATE barang SET stock = stock + $qty WHERE barcode = '$barcode'");

    return mysqli_affected_rows($koneksi);
}

function simpanJual($data){
    global $koneksi;

    $nojual = mysqli_real_escape_string($koneksi, $data['nojual']);
    $tgl = mysqli_real_escape_string($koneksi, $data['tglNota']);
    $total = (float)$data['total'];
    $customer = mysqli_real_escape_string($koneksi, $data['customer']);
    $keterangan = mysqli_real_escape_string($koneksi, $data['ketr']);
    $bayar = (float)$data['bayar'];
    $kembalian = (float)$data['kembalian'];

    // Validasi pembayaran
    if($bayar < $total) {
        echo "<script>
                alert('Pembayaran kurang dari total penjualan. Transaksi tidak dapat diproses!');
                document.getElementById('bayar').focus();
              </script>";
        return false;
    }

    // Validasi field required
    if(empty($nojual) || empty($tgl) || empty($customer)) {
        die("Required fields are missing");
    }

    // Validasi apakah ada barang yang dibeli
    $cekDetail = mysqli_query($koneksi, "SELECT * FROM jual_detail WHERE no_jual = '$nojual'");
    if(mysqli_num_rows($cekDetail) == 0) {
        echo "<script>
                alert('Tidak ada barang yang dibeli. Transaksi tidak dapat diproses!');
              </script>";
        return false;
    }

    $sqljual = "INSERT INTO jual_head (no_jual, tgl_jual, customer, total, keterangan, jml_bayar, kembalian) 
                VALUES ('$nojual', '$tgl', '$customer', $total, '$keterangan', $bayar, $kembalian)";
    
    $result = mysqli_query($koneksi, $sqljual);

    if(!$result) {
        die("Error in query: " . mysqli_error($koneksi));
    }

    return mysqli_affected_rows($koneksi);
}

