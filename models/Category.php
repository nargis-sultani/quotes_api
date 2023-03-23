<?php
    class Category{
        // Connection
        private $conn;
        // Table
        private $db_table = "categories";
        // Columns
        public $id;
        public $category;
        // Db connection
        public function __construct($db){
            $this->conn = $db;
        }
        // GET ALL
        public function getCategories(){



            $sqlQuery = "SELECT id, category FROM " . $this->db_table . "";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }
        // CREATE
        public function createCategory(){

            $sqlQuery = 'INSERT INTO ' . $this->db_table . ' (category) VALUES (:category)' ;

            $stmt = $this->conn->prepare($sqlQuery);

            // sanitize
            $this->category=htmlspecialchars(strip_tags($this->category));

            // bind data
            $stmt->bindParam(":category", $this->category);

            if($stmt->execute()){
                $this->id = $this->conn->lastInsertId();
                return true;
            }
            return false;
        }
        // READ single
        public function getSingleCategoryById(){
            // Create query
            $query = 'SELECT
                  id,
                  category
                FROM
                  ' . $this->db_table . '
              WHERE id = ?';
        
              //Prepare statement
              $stmt = $this->conn->prepare($query);
        
              // Bind ID
              $stmt->bindParam(1, $this->id);
        
              // Execute query
              $stmt->execute();
        
              //$row = $stmt->fetch(PDO::FETCH_ASSOC);
        
              // set properties
              //$this->id = $row['id'];
              //$this->category = $row['category'];

              return $stmt;
        }

        public function updateCategory(){
            $sqlQuery = "UPDATE "
                        . $this->db_table .
                    " SET
                        category = :category
                    WHERE
                        id = :id";

            $stmt = $this->conn->prepare($sqlQuery);

            $this->category=htmlspecialchars(strip_tags($this->category));

            // bind data
            $stmt->bindParam(":id", $this->id);
            $stmt->bindParam(":category", $this->category);

            if($stmt->execute()){
               return true;
            }
            return false;
        }
        // DELETE
        public function deleteCategory(){
            $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id = ?";
            $stmt = $this->conn->prepare($sqlQuery);

            $this->id=htmlspecialchars(strip_tags($this->id));

            $stmt->bindParam(1, $this->id);

            if($stmt->execute()){
                return true;
            }
            return false;
        }
    }
?>


