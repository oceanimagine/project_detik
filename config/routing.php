<?php

function milliseconds() {
    $mt = explode(' ', microtime());
    return ((int)$mt[1]) * 1000 + ((int)round($mt[0] * 1000));
}

$route = isset($_GET['route']) ? $_GET['route'] : "";
if($route != "gettoken"){
    $hasil = array(
        'message' => 'ACCESS TOKEN REQUIRED.'
    );
    $timeout_token = 15; // menit
    $headers = getallheaders();
    if(isset($headers['Authorization']) && $headers['Authorization'] != ""){
        $Authorization = explode("Bearer ", $headers['Authorization']);
        if(isset($Authorization[1]) && $Authorization[1] != ""){
            $notfound = true;
            for($i = 0; $i <= $timeout_token; $i++){
                $newTime = strtotime('-'.$i.' minutes');
                $token_active = md5(date('Y-m-d H:i', $newTime));
                if($token_active == $Authorization[1]){
                    $notfound = false;
                    break;
                }
            }
            if($notfound){
                $hasil['message'] = 'TOKEN INVALID.';
                echo json_encode($hasil);
                exit();
            }
        }
    } else {
        echo json_encode($hasil);
        exit();
    }
}