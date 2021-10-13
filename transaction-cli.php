<?php

if(isset($argv) && is_array($argv) && isset($argv[1]) && 
   isset($argv) && is_array($argv) && isset($argv[2])
){
    $references_id = $argv[1];
    $status = $argv[2];
} else {
    echo "ARGS REQUIRED.\n\n";
    exit();
}

include_once __DIR__ . "/config/koneksi.php";

$references_id_ = mysqli_real_escape_string($connect, $references_id);
$status_ = mysqli_real_escape_string($connect, $status);
mysqli_query($connect, "
    update tbl_transaksi_pembayaran
    set status = '".$status_."' where 
    references_id = '".$references_id_."'
");
if(mysqli_affected_rows($connect) > 0){
    echo "Berhasil Update Status ke '".$status_."' untuk Reference ID '".$references_id_."'\n";
} else {
    echo "Gagal Update Status ke '".$status_."' untuk Reference ID '".$references_id_."'\n";
}