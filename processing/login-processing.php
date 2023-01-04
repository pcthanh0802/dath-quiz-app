<?php
session_start();
function validate($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once "../database.php";
    $username = $_POST['username'];
    $password = $_POST['password'];

    // $sql = "SELECT * FROM user
    // where username='$username' and password='$password'";
    $sql = "SELECT * FROM account WHERE account.username = '$username' AND account.password = '$password'";
    $result = $conn->query($sql);
    $returnUserArray = $result->fetch_all(MYSQLI_ASSOC);
    if (count($returnUserArray) == 1) {
        $loginuser = $returnUserArray[0];
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $loginuser["role"];
        $cookie_name = "user";
        $cookie_value = $username;
        setcookie($cookie_name, $cookie_value, time() + (3600), "/");
        $_SESSION['userID'] = $loginuser['id'];
        //$_SESSION['avatar'] = $loginuser['avatar'];
        if ($loginuser['role'] == 0)
            header('location: ../index.php?page=player');
        else
            header('location: ../index.php?page=admin');

        // mysqli_close($conn);
        // if ($_SESSION['level'] == 'admin'){
        //     header('location: ../index.php?page=user');
        // }
        // else{
        //     header('location: ../index.php?page=task');
        // }
    } else {
        $_SESSION['loginerror'] = "Incorrect username or password";
        header('location: ../login.php');
    };
}
