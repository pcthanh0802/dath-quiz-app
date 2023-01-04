<?php
function validate($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once "./database.php";
    $nationality = validate($_POST['nationality']);
    $username = validate($_POST['username']);
    $role = validate($_POST['role']);
    $password = validate($_POST['password']);
    $gender = validate($_POST['gender']);
    $dob = validate($_POST['dob']);
    $email = validate($_POST['email']);

    $sql = "INSERT INTO account(username, password, role) VALUES('$username', '$password', '$role')";
    $conn->query($sql);
    $sql = "SELECT id FROM account WHERE username = \"$username\"";
    $res = $conn->query($sql)->fetch_assoc()['id'];
    $sql = "INSERT INTO player VALUES('$res', '$email', '$gender', '$dob', '$nationality')";
    $conn->query($sql);
    header("location: ./index.php?page=admin");
}

?>
