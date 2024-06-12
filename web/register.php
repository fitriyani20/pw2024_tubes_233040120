<?php

require '../php/functions.php';

if (isset($_POST["register"])) {

    if (registrasi($_POST) > 0) {
        echo "<script>
            alert('Akun berhasil ditambahkan');
            window.location = 'login.php';
          </script>";
    } else {
        echo mysqli_error($conn);
    }
}

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Register</title>
    <style>
        .card-login {
            max-width: 400px;
            margin: 0 auto;
            margin-top: 100px;
        }
    </style>
</head>

<body>

    <div class="container mt-4">
        <div class="card card-login p-4 bg-secondart rounded-3 shadow border border-secondary">
            <div class="card-body">
                <h2 class="card-title text-center mb-3">TechZone</h2>
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="username">Username</label>
                        <input type="text" class="form-control border-2 border-dark" name="username" placeholder="Masukkan username">
                    </div>
                    <div class="mb-3">
                        <label for="nama_lengkap">Nama Lengkap</label>
                        <input type="text" class="form-control border-2 border-dark" name="nama_lengkap" placeholder="Masukkan nama lengkap">
                    </div>
                    <div class="mb-3">
                        <label for="email">Email</label>
                        <input type="email" class="form-control border-2 border-dark" name="email" placeholder="Masukkan email">
                    </div>
                    <div class="mb-3">
                        <label for="password">Password</label>
                        <input type="password" class="form-control border-2 border-dark" name="password" placeholder="Masukkan password">
                    </div>
                    <div class="mb-3">
                        <label for="password2">Verifikasi Password</label>
                        <input type="password" class="form-control border-2 border-dark" name="password2" placeholder="Masukkan ulang password">
                    </div>
                    <button type="submit" name="register" class="btn btn-primary mb-5">Daftar</button>
                    <p class="text-center">Sudah memiliki akun ? <a href="login.php">Login</a></p>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>