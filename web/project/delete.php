<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
 
include_once '../config/database.php';
include_once '../objects/project.php';
 
$database = new Database();
$db = $database->getConnection();
 
$project = new Project($db);
 
$data = json_decode(file_get_contents("php://input"));

$project->id = $data->id;
 
if($project->delete()){
    echo '{';
        echo '"message": "Product was deleted."';
    echo '}';
}
 
else{
    echo '{';
        echo '"message": "Unable to delete object."';
    echo '}';
}
?>