<?php
session_start();
if(isset($_POST['submit'])){
    include 'includes/db_connect.php';
    
    $uid = mysqli_real_escape_string($conn, $_POST['a']);
    $pwd = mysqli_real_escape_string($conn, $_POST['b']);
    
    if(empty($uid) || empty($pwd)){
        header("Location: login.php?login=empty");
        exit();
    } else {
        $sql = "SELECT * FROM users WHERE nameusers ='".$uid."'";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);
        if($resultCheck < 1) {
            header("Location: login.php?login=no-user");
            exit();
        } else {
            if($row = mysqli_fetch_assoc($result)) {
                //DE-HASHING PWD
                $hashedPwdCheck = md5($pwd);
                if($hashedPwdCheck != $row['passwordusers']) {
                    header("Location: login.php?login=incorrect");
                    exit();
                } else {
                    $_SESSION['id'] = $row['idusers'];
                    $_SESSION['name'] = $row['nameusers'];
                    $_SESSION['email'] = $row['emailusers'];
                    header("Location: index.php");
                    exit();
                }
            }
        }
    }
} else {
    header("Location: login.php");
    exit();
}
?>