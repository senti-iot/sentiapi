<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Accept: application/json");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/project.php';
 
// instantiate database and project object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$project = new Project($db);
 
// query projects
$stmt = $project->read();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // projects array
    $projects_arr=array();
    // $projects_arr["projects"]=array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);
		
        $project_item=array(
			"id" =>  (int)$id,
			"address" => $address,
			"title" => $title,
			"description" => $description,
			"open_date" => date_format(date_create($open_date),"d-m-Y"),
			"user_id" => $user_id,
			"tags" => $tags,
			"progress" => $progress,
			"hits" => $hits,
			"img" => $img,
			"seneste_reg" => date_format(date_create($last_modified),"H:i d-m-Y")
        );
 
        array_push($projects_arr, $project_item);
    }
 
    echo json_encode($projects_arr);
}
 
else{
    echo json_encode(
        array(null)
    );
}
?>