<?php
class Project
{

    private $conn;
    private $table_name = "projects";

    // public $id;
    // public $name;
    // public $description;
    // public $price;
    // public $category_id;
    // public $category_name;
    // public $created;

    public function __construct($db)
    {
        $this->conn = $db;
    }
    // read products
    public function read()
    {

        // select all query
        $query = "SELECT * FROM " . $this->table_name;

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }
    public function create()
    {
        $query = "INSERT INTO
	" . $this->table_name . "
	SET
	address = :address,
	title = :title,
	description = :description,
	open_date = :open_date,
	tags = :tags,
	progress = :progress,
	hits = :hits,
	img = :img,
	user_id = 0";

        $stmt = $this->conn->prepare($query);

        //TODO Sanitization of special characters

        //bind values
        $tags = $this->tags;
        $tags = implode(",", $tags);
        $stmt->bindParam(':address', $this->address);
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':open_date', $this->open_date);
        $stmt->bindParam(':tags', $tags);
        $stmt->bindParam(':progress', $this->progress);
        $stmt->bindParam(':hits', $this->hits);
        $stmt->bindParam(':img', $this->img);

        if ($stmt->execute()) {
            return true;
        }
        return false;

    }
    public function delete()
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id= ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
    public function update()
    {
        $query = "UPDATE
			" . $this->table_name . "
			SET
			address = :address,
			title = :title,
			description = :description,
			open_date = :open_date,
			tags = :tags,
			progress = :progress,
			hits = :hits,
			img = :img,
			WHERE
				id = :id";
        $stmt = $this->conn->prepare($query);

        //TODO Sanitization of special characters

        //bind values

        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':address', $this->address);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':open_date', $this->open_date);
        $stmt->bindParam(':tags', $this->tags);
        $stmt->bindParam(':progress', $this->progress);
        $stmt->bindParam(':hits', $this->hits);
        $stmt->bindParam(':img', $this->img);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
