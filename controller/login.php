<?php
session_start();
include("../dB/config.php");

if (isset($_POST["login"])) {

    $email = $_POST["email"];
    $password = $_POST["password"];

    $query = "SELECT `userId`, `firstName`, `lastName`, `email`, `password`, `phoneNumber`, `gender`, `birthday`, `verification`, `role` 
    FROM `users` WHERE email = '$email' AND password = '$password' LIMIT 1";

    $query_run = mysqli_query($conn, $query);

    if ($query_run) {
        if (mysqli_num_rows($query_run) > 0) {
            $data = mysqli_fetch_assoc($query_run);

            $userID = $data["userId"];
            $fullname = $data["firstName"] . " " . $data["lastName"];
            $emailAddress = $data["email"];
            $userRole = $data["role"];

            $_SESSION["auth"] = true;
            $_SESSION["role"] = $userRole;
            $_SESSION["authUser"] = [
                'userId' => $userID, // fixed typo: was $userId
                'fullName' => $fullname,
                'emailAddress' => $emailAddress,
            ];

            if ($userRole == 'admin') {
                header("Location: ../view/admin/dashboard.php");
            } else if ($userRole == "user") {
                header("Location: ../view/users/dashboard.php");
            } else {
                $_SESSION['message'] = "Unauthorized role";
                $_SESSION["code"] = "error";
                header("Location: ../login.php");
            }
            exit();
        } else {
            $_SESSION['message'] = "Invalid email or password!";
            $_SESSION["code"] = "error";
            header("Location: ../login.php");
            exit();
        }
    } else {
        $_SESSION['message'] = "Something went wrong. Please try again.";
        $_SESSION["code"] = "error";
        header("Location: ../login.php");
        exit();
    }
}
?>
