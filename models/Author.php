<?php
    class Author{
        // Connection
        private $conn;
        // Table
        private $db_table = "authors";
        // Columns
        public $id;
        public $author;
        // Db connection
        public function __construct($db){
            $this->conn = $db;
        }
        // GET ALL
        public function getAuthors(){


            $sqlQuery = "SELECT
                        quotes.id,
                        quotes.quote,
                        authors.author,
                        categories.category
                        FROM quotes
                        INNER JOIN authors ON  quotes.author_id = authors.id
                        INNER JOIN categories ON quotes.category_id = categories.id";

            // $sqlQuery = "SELECT id, name, email, age, designation, created FROM " . $this->db_table . "";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }
        // CREATE
        public function createAuthor(){

            $sqlQuery = 'INSERT INTO ' . $this->db_table . ' (author) VALUES (:author)' ;

            $stmt = $this->conn->prepare($sqlQuery);

            // sanitize
            $this->author=htmlspecialchars(strip_tags($this->author));

            // bind data
            $stmt->bindParam(":author", $this->author);

            if($stmt->execute()){
                $this->id = $this->conn->lastInsertId();
                return true;
            }
            return false;
        }

        // READ single
        public function getSingleAuthorById(){
            // Create query
            $query = 'SELECT
                  id,
                  author
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
              //$this->author = $row['author'];
              return $stmt;
          }

        // UPDATE
        public function updateAuthor(){
            $sqlQuery = "UPDATE "
                        . $this->db_table .
                    " SET
                        author = :author
                    WHERE
                        id = :id";

            $stmt = $this->conn->prepare($sqlQuery);

            $this->author=htmlspecialchars(strip_tags($this->author));

            // bind data
            $stmt->bindParam(":id", $this->id);
            $stmt->bindParam(":author", $this->author);

            if($stmt->execute()){
               return true;
            }
            return false;
        }
        // DELETE
        function deleteAuthor(){
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



        