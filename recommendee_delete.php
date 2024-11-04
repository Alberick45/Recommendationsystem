<?php 
require_once "./includes/conn.php";

if (isset($_GET['id'])){
    $id = $_GET['id'];
    $query = "DELETE FROM  recommendee WHERE id = :id";
    $stmt = $conn -> prepare($query);
    $stmt -> bindParam(":id",$id);
    $stmt -> execute();
    $results = $stmt->fetchAll();
    header("Location: admin.php?Data deleted successfully");
    exit();
}

?>