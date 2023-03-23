<?php
    class Quote{
        // Connection
        private $conn;
        // Table
        private $db_table = "quotes";
        // Columns
        public $id;
        public $quote;
        public $author_id;
        public $category_id;
        public $category;
        public $author;
        // Db connection
        public function __construct($db){
            $this->conn = $db;
        }
        // GET ALL
        public function getQuotes(){


            $sqlQuery = "SELECT
                        quotes.id,
                        quotes.quote,
                        authors.author,
                        categories.category
                        FROM quotes
                        INNER JOIN authors ON quotes.author_id = authors.id
                        INNER JOIN categories ON quotes.category_id = categories.id";

            // $sqlQuery = "SELECT id, name, email, age, designation, created FROM " . $this->db_table . "";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }

        public function doesAuthorExist(){

            $sqlQuery = 'SELECT * FROM authors WHERE id = ' . $this->author_id;

            $stmt = $this->conn->prepare($sqlQuery);
  
            // Execute query
            $stmt->execute();
  
            //$row = $stmt->fetch(PDO::FETCH_ASSOC);
  
            //$this->author = $row['author'];
            if ($stmt->rowCount() > 0){
                return true;
            }
            return false;
        }

        public function doesCategoryExist(){

            $sqlQuery = 'SELECT * FROM categories WHERE id = ' . $this->category_id;

            $stmt = $this->conn->prepare($sqlQuery);
  
            // Execute query
            $stmt->execute();
  
            //$row = $stmt->fetch(PDO::FETCH_ASSOC);
  
            //$this->category = $row['category'];
            if ($stmt->rowCount() > 0){
                return true;
            }
            return false;
        }

        public function createQuote(){

            $sqlQuery = 'INSERT INTO ' . $this->db_table . ' (quote, author_id, category_id) VALUES (:quote, :author_id, :category_id)' ;

            $stmt = $this->conn->prepare($sqlQuery);

            // sanitize
            $this->quote=htmlspecialchars(strip_tags($this->quote));
            $this->author_id=htmlspecialchars(strip_tags($this->author_id));
            $this->category_id=htmlspecialchars(strip_tags($this->category_id));

            // bind data
            $stmt->bindParam(":quote", $this->quote);
            $stmt->bindParam(":author_id", $this->author_id);
            $stmt->bindParam(":category_id", $this->category_id);

            if($stmt->execute()){
                $this->id = $this->conn->lastInsertId();
                return true;
            }
            return false;
        }


        // CREATE
        /*public function createQuote(){
            $sqlQuery = "INSERT INTO
                        ". $this->db_table ."


                    SET
                        quote = :quote,
                        author_id = :author_id,
                        category_id = :category_id";

        
            // sanitize
            $this->quote=htmlspecialchars(strip_tags($this->quote));
            $this->author_id=htmlspecialchars(strip_tags($this->author_id));
            $this->category_id=htmlspecialchars(strip_tags($this->category_id));

            // bind data
            $stmt->bindParam(":quote", $this->quote);
            $stmt->bindParam(":author_id", $this->author_id);
            $stmt->bindParam(":category_id", $this->category_id);

            if($stmt->execute()){
               return true;
            }
            return false;
        }*/
                   

        // READ single by Id
        public function getSingleQuoteById() {
            // Create query
            $sqlQuery = "SELECT
                        quotes.id,
                        quotes.quote,
                        authors.author as author,
                        categories.category as category
                        FROM quotes
                        INNER JOIN authors ON quotes.author_id = authors.id
                        INNER JOIN categories ON quotes.category_id = categories.id
                        WHERE quotes.id = ?";
  
            // Prepare statement
            $stmt = $this->conn->prepare($sqlQuery);
  
            // Bind ID
            $stmt->bindParam(1, $this->id);
  
            // Execute query
            $stmt->execute();
  
            //$row = $stmt->fetch(PDO::FETCH_ASSOC);
  
            // Set properties
            /*$this->id = $row['id'];
            $this->quote = $row['quote'];
            $this->author = $row['author'];
            $this->category = $row['category'];*/

            return $stmt;
        }

        public function getQuotesByAuthorId() {
            // Create query
            $sqlQuery = "SELECT
                        quotes.id,
                        quotes.quote,
                        authors.author as author,
                        categories.category as category
                        FROM quotes
                        INNER JOIN authors ON quotes.author_id = authors.id
                        INNER JOIN categories ON quotes.category_id = categories.id
                        WHERE quotes.author_id = ?";
  
            // Prepare statement
            $stmt = $this->conn->prepare($sqlQuery);
  
            // Bind ID
            $stmt->bindParam(1, $this->author_id);
  
            // Execute query
            $stmt->execute();
  
            /*$row = $stmt->fetch(PDO::FETCH_ASSOC);
  
            // Set properties
            $this->id = $row['id'];
            $this->quote = $row['quote'];
            $this->author = $row['author'];
            $this->category = $row['category'];*/

            return $stmt;
        }

        public function getQuotesByCategoryId() {
            // Create query
            $sqlQuery = "SELECT
                        quotes.id,
                        quotes.quote,
                        authors.author as author,
                        categories.category as category
                        FROM quotes
                        INNER JOIN authors ON quotes.author_id = authors.id
                        INNER JOIN categories ON quotes.category_id = categories.id
                        WHERE quotes.category_id = ?";
  
            // Prepare statement
            $stmt = $this->conn->prepare($sqlQuery);
  
            // Bind ID
            $stmt->bindParam(1, $this->category_id);
  
            // Execute query
            $stmt->execute();
  
            /*$row = $stmt->fetch(PDO::FETCH_ASSOC);
  
            // Set properties
            $this->id = $row['id'];
            $this->quote = $row['quote'];
            $this->author = $row['author'];
            $this->category = $row['category'];*/
            return $stmt;
        }

        public function getQuotesByCategoryAndAuthorId() {
            // Create query
            $sqlQuery = "SELECT
                        quotes.id,
                        quotes.quote,
                        authors.author as author,
                        categories.category as category
                        FROM quotes
                        INNER JOIN authors ON quotes.author_id = authors.id
                        INNER JOIN categories ON quotes.category_id = categories.id
                        WHERE quotes.category_id = ? AND quotes.author_id = ?";
  
            // Prepare statement
            $stmt = $this->conn->prepare($sqlQuery);
  
            // Bind ID
            $stmt->bindParam(1, $this->category_id);
            $stmt->bindParam(2, $this->author_id);
  
            // Execute query
            $stmt->execute();
  
            /*$row = $stmt->fetch(PDO::FETCH_ASSOC);
  
            // Set properties
            $this->id = $row['id'];
            $this->quote = $row['quote'];
            $this->author = $row['author'];
            $this->category = $row['category'];*/
            return $stmt;
        }

        // UPDATE
        public function updateQuote(){
            $sqlQuery = "UPDATE
                        ". $this->db_table ."
                    SET
                        quote = :quote,
                        author_id = :author_id,
                        category_id = :category_id
                    WHERE
                        id = :id";

            $stmt = $this->conn->prepare($sqlQuery);

            $this->quote=htmlspecialchars(strip_tags($this->quote));
            $this->author_id=htmlspecialchars(strip_tags($this->author_id));
            $this->category_id=htmlspecialchars(strip_tags($this->category_id));

            // bind data
            $stmt->bindParam(":quote", $this->quote);
            $stmt->bindParam(":author_id", $this->author_id);
            $stmt->bindParam(":category_id", $this->category_id);

            if($stmt->execute()){
               return true;
            }
            return false;
        }

        // DELETE
        function deleteQuote(){
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

