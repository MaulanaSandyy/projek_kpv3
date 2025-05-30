<?php
require_once "../config/config.php";
require_once "../config/functions.php";
require_once "../module/mode-jual.php";

header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(updateQtyJual($_POST)) {
        $response['success'] = true;
        $response['message'] = 'Qty berhasil diupdate';
    } else {
        $response['message'] = 'Gagal update qty. Stok tidak mencukupi.';
    }
} else {
    $response['message'] = 'Invalid request method';
}

echo json_encode($response);
?>