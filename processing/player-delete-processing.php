<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    require_once "./database.php";
    $id = $_GET['id'];
    $sql="DELETE FROM account WHERE id=\"$id\"";
    $conn->query($sql);
    header("location: ./index.php?page=admin");
}
?>