<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once "./database.php";
    $id = $_GET['id'];
    if(array_key_exists('email', $_POST)){
        $sql = "UPDATE player SET email = \"".$_POST['email']."\" WHERE id = \"$id\"";
        $conn->query($sql);
    }
    if(array_key_exists('gender', $_POST)){
        $sql = "UPDATE player SET gender = \"".$_POST['gender']."\" WHERE id = \"$id\"";
        $conn->query($sql);
    }
    if(array_key_exists('nationality', $_POST)){
        $sql = "UPDATE player SET nationality = \"".$_POST['nationality']."\" WHERE id = \"$id\"";
        $conn->query($sql);
    }
    $sql = "UPDATE account SET username = \"".$_POST['username']."\" WHERE id = \"$id\"";
    $conn->query($sql);
    $sql = "UPDATE account SET password = \"".$_POST['password']."\" WHERE id = \"$id\"";
    $conn->query($sql);
    header("location: ./index.php?page=profile&id=$id");
}
