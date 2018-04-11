<?php
class Device{

	private $conn;
	private $table_name = "devices";
	private $device_regs = "device_reg";
	public $device_id;
	public $device_name;
	public $project_id;
	public $online;

	public function __construct($db){
		$this->conn = $db;
	}
	
function readAllByProjectId($project_id){
	// echo $project_id;
	$query = "SELECT * FROM " . $this->table_name . " WHERE projectId = ?";
	
	$stmt = $this->conn->prepare( $query );

	$stmt->bindParam(1, $project_id);
	$stmt->execute();
	return $stmt;
}
function readAllRegsByDeviceId($device_id, $project_id) {
	$query = "SELECT * FROM " . $this->device_regs . " WHERE project_id = ? AND device_id = ?";
	$stmt = $this->conn->prepare( $query );
	$stmt->bindParam(1, $project_id);
	$stmt->bindParam(2, $device_id);
	$stmt-> execute();
	return $stmt;
}
function read(){
 
    // select all query
    $query = "SELECT * FROM " . $this->table_name;
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // execute query
    $stmt->execute();
 
    return $stmt;
}
function create() {
	$query = "INSERT INTO
	" . $this->table_name . "
	SET
	device_name = :device_name,
	online = :online,
	projectId = :project_id,
	";

	$stmt = $this->conn->prepare($query);

	//TODO Sanitization of special characters

	//bind values
	$tags = $this->tags;
	$tags = implode(",", $tags);
	$stmt->bindParam(':device_name',$this->device_name);
	$stmt->bindParam(':project_id',$this->project_id);
	$stmt->bindParam(':online', $this->online);


	if($stmt->execute()){
		return true;
	}
	return false;

}
function update() {
	$query = "UPDATE
			" . $this->table_name . "
			SET
			device_name = :device_name,
			online = :online,
			projectId = :project_id
			WHERE
				device_id = :id";
	$stmt = $this->conn->prepare($query);

	//TODO Sanitization of special characters

	//bind values
	$stmt->bindParam(':id',$this->device_id);
	$stmt->bindParam(':device_name',$this->device_name);
	$stmt->bindParam(':project_id',$this->project_id);
	$stmt->bindParam(':online', $this->online);

		if($stmt->execute()){
			return true;
		}
		return false;
}
}
?>