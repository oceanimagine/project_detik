<?php

if($route == "gettoken"){
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $hasil['message'] = 'TOKEN GENERATED.';
        $hasil['token'] = md5(date('Y-m-d H:i'));
        echo json_encode($hasil);
        exit();
    } else {
        $hasil['message'] = 'YOU SHOULD USE GET METHOD.';
        echo json_encode($hasil);
        exit();
    }
}

else if($route == "testtoken"){
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $hasil['message'] = 'TOKEN VALID.';
        echo json_encode($hasil);
        exit();
    } else {
        $hasil['message'] = 'YOU SHOULD USE GET METHOD.';
        echo json_encode($hasil);
        exit();
    }
}

else if($route == "puttransaction"){
    if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
        parse_str(file_get_contents("php://input"),$_POST);
        $item_name = mysqli_real_escape_string($connect, $_POST['item_name']);
        $amount = mysqli_real_escape_string($connect, $_POST['amount']);
        $payment_type = mysqli_real_escape_string($connect, $_POST['payment_type']);
        $customer_name = mysqli_real_escape_string($connect, $_POST['customer_name']);
        $merchant_id = mysqli_real_escape_string($connect, $_POST['merchant_id']);
        $references_id = md5(milliseconds());
        $nomor_va = "";
        $status = "Pending";
        if($payment_type == 'virtual_account'){
            $rand_ = rand(1,999999999);
            $rslt_ = str_pad($rand_,10,0,STR_PAD_LEFT);
            $nomor_va = $rslt_;
        }
        mysqli_query($connect, "
            insert into tbl_transaksi_pembayaran set
            item_name = '".$item_name."',
            amount = '".$amount."',
            payment_type = '".$payment_type."',
            customer_name = '".$customer_name."',
            merchant_id = '".$merchant_id."',
            nomor_va = '".$nomor_va."',
            status = '".$status."',
            references_id = '".$references_id."'
        ");
        $hasil['message'] = 'FAILED INSERT TRANSACTION.';
        if(mysqli_affected_rows($connect) > 0){
            $id = mysqli_insert_id($connect);
            $hasil['message'] = 'SUCCESS INSERT TRANSACTION.';
            $hasil['references_id'] = $references_id;
            $hasil['number_va'] = $nomor_va;
            $hasil['status'] = $status;
        }
        echo json_encode($hasil);
        exit();
    } else {
        $hasil['message'] = 'YOU SHOULD USE PUT METHOD.';
        echo json_encode($hasil);
        exit();
    }
}

else if($route == "getonethousandlasttransaction"){
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $query_transaksi = mysqli_query($connect, "
            select
                references_id,
                item_name,
                amount,
                payment_type,
                customer_name,
                merchant_id,
                nomor_va,
                status,
                timestamp
            from tbl_transaksi_pembayaran
            order by timestamp desc
            limit 0, 1000
        ");
        $hasil['message'] = 'NO DATA TRANSACTION YET.';
        if(mysqli_num_rows($query_transaksi) > 0){
            $hasil['message'] = 'SUCCESS GET DATA TRANSACTION.';
            $hasil['data'] = array();
            while($hasil_transaksi = mysqli_fetch_array($query_transaksi, MYSQLI_ASSOC)){
                $hasil['data'][] = $hasil_transaksi;
            }
        }
        echo json_encode($hasil);
        exit();
    } else {
        $hasil['message'] = 'YOU SHOULD USE GET METHOD.';
        echo json_encode($hasil);
        exit();
    }
}

else if($route == "getlasttransaction"){
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $references_id = isset($_GET['references_id']) ? mysqli_real_escape_string($connect, $_GET['references_id']) : "";
        $merchant_id = isset($_GET['merchant_id']) ? mysqli_real_escape_string($connect, $_GET['merchant_id']) : "";
        $query_transaksi = mysqli_query($connect, "
            select
                references_id,
                invoice_id,
                status
            from tbl_transaksi_pembayaran
            where
            references_id = '".$references_id."' and
            merchant_id = '".$merchant_id."'
            
        ");
        $hasil['message'] = 'NO DATA TRANSACTION WITH REFERENCE '.$references_id.'.';
        if(mysqli_num_rows($query_transaksi) > 0){
            $hasil['message'] = 'SUCCESS GET DATA TRANSACTION WITH REFERENCE '.$references_id.'.';
            $hasil = mysqli_fetch_array($query_transaksi, MYSQLI_ASSOC);
        }
        echo json_encode($hasil);
        exit();
    } else {
        $hasil['message'] = 'YOU SHOULD USE GET METHOD.';
        echo json_encode($hasil);
        exit();
    }
}

else if($route == "removetransaction"){
    if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
        $invoice_id = isset($_GET['invoice_id']) ? mysqli_real_escape_string($connect, $_GET['invoice_id']) : "";
        mysqli_query($connect, "
            delete
            from tbl_transaksi_pembayaran
            where
            invoice_id = '".$invoice_id."'
        ");
        $hasil['message'] = 'FAILED DELETE TRANSACTION WITH ID '.$invoice_id.'.';
        if(mysqli_affected_rows($connect) > 0){
            $hasil['message'] = 'SUCCESS DELETE TRANSACTION WITH ID '.$invoice_id.'.';
        }
        echo json_encode($hasil);
    } else {
        $hasil['message'] = 'YOU SHOULD USE DELETE METHOD.';
        echo json_encode($hasil);
        exit();
    }
}