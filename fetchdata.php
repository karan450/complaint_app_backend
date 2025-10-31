<?php 
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    http_response_code(200);
    exit(0);
    }
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    header("Content-Type: application/json");

    include("./index.php");
    $data = json_decode(file_get_contents('php://input'));

    if(isset($data->status)){

        if($data->status == "sent"){
            $result = mysqli_query($con, "SELECT * FROM $data->table WHERE status = '".$data->status."'");
            $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
            echo json_encode($rows);
        }else if($data->status == "inprogress"){
            $result = mysqli_query($con, "SELECT * FROM $data->table WHERE status = '".$data->status."'");
            $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
            echo json_encode($rows);
        }else if($data->status == "resolved"){
            $result = mysqli_query($con, "SELECT * FROM $data->table WHERE status = '".$data->status."'");
            $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
            echo json_encode($rows);
        }else if($data->status == "onhold"){
            $result = mysqli_query($con, "SELECT * FROM $data->table WHERE status = '".$data->status."'");
            $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
            echo json_encode($rows);
        }
        
    }


?>
