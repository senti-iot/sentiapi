<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include_once '../config/database.php';
include_once '../objects/device.php';

$database= new Database();
$db = $database->getConnection();

$device = new Device($db);

// get keywords
$pid=isset($_GET["pid"]) ? $_GET["pid"] : "";
$did=isset($_GET["did"]) ? $_GET["did"] : "";

// query devices
$stmt = $device->readAllRegsByDeviceId($did, $pid);
$num = $stmt->rowCount();
//  echo $device->readAllByProjectId($project_id);
// check if more than 0 record found
if($num>0){
 
    // devices array
    $devices_arr=array();
    // $devices_arr[]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $device_item=array(
            "device_id" => $device_id,
            "reg_id" => $reg_id,
            "project_id" => $project_id,
            "hits"=> $hits
        );
 
        array_push($devices_arr, $device_item);
    }
 
    echo json_encode($devices_arr);
}
 
else{
    echo json_encode(
        array(null)
    );
}

?>