<?php
require_once "../config/config.php";

if(isset($_POST['barcode'])) {
    $barcode = $_POST['barcode'];
    $query = mysqli_query($koneksi, "SELECT stock FROM barang WHERE barcode = '$barcode'");
    $row = mysqli_fetch_assoc($query);
    echo $row['stock'];
}
?>