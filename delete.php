<!-- DELETE -->
 <!-- allows user to delete a manager from the database -->

<?php
// connect to db
 require 'connect.php'; 
 
 // make sure we received an ID
 $id = (int) $_GET['id']; 
 
 // create the query 
 $sql = "DELETE from registrations WHERE id = :id"; 
 
 //prepare 
 $stmt = $pdo->prepare($sql); 
 //bind 
 $stmt->bindParam(':id', $id); 
 
 //execute 
 $stmt->execute(); 

 // Redirect back to home page 
 header("Location: index.php"); exit;