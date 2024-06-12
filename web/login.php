<?php
session_start();

if (isset($_SESSION["login"])) {
    header("location: ../index.php");
    exit;
}

require '../php/functions.php';

if (isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $conn = koneksi();

    $result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");

    // CEK USERNAME
    if (mysqli_num_rows($result) === 1) {
        // CEK PASSWORD
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row["password"])) {
            // set session
            $_SESSION["login"] = true;
            $_SESSION["user_id"] = $row["user_id"];

            // set cookie
            setcookie("username", $username, time() + 3600);

            // CEK ROLE
            if ($row["role"] === "admin") {
                header("location: ../adminpanel/dashboard.php"); // arahkan ke halaman dashboard
                exit;
            } elseif ($row["role"] === "user") {
                header("location: ../index.php"); // arahkan ke halaman index
                exit;
            }
        }
    }

    $error = true;
}
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Login</title>
    <style>
        .card-login {
            max-width: 400px;
            margin: 0 auto;
            margin-top: 100px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card card-login p-4 bg-secondart rounded-3 shadow border border-secondary">
            <div class="card-body">
                <h2 class="card-title text-center mb-3">TechZone</h2>
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control border-2 border-dark" name="username" id="username" placeholder="Masukkan username">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control border-2 border-dark" name="password" id="password" placeholder="Masukkan password">
                    </div>
                    <button type="submit" name="login" class="btn btn-primary mb-5">Login</button>
                    <p class="text-center">Belum memiliki akun ? <a href="register.php">Daftar</a></p>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>