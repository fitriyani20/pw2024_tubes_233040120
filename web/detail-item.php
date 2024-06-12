<?php
session_start();

if (!isset($_SESSION["login"])) {
    header("location: web/login.php");
    exit;
}
require '../php/functions.php';

$id = $_GET["id"];
$brg = query("SELECT b.*, k.*, b.id as id_brg 
FROM barang b 
JOIN kategori k 
ON b.kategori_id = k.id 
WHERE b.id = $id")[0];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item Detail</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .img-fluid {
            width: 450px !important;
            height: 350px !important;
        }

        .card-body {
            margin-left: -30px !important;
        }


        .small {
            margin-top: -18px !important;
            margin-left: 5px !important;
            font-size: 17px !important;
        }

        .card {
            margin-top: 100px !important;
            background-color: #F3EAE0;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-light bg-dark p-3">
        <div class="container-fluid">
            <a class="navbar-brand text-light" href="../index.php">
                TechZone
            </a>
        </div>
    </nav>


    <div class="card d-flex justify-content-center m-auto border-2 border-dark shadow rounded-3" style="max-width: 100%;">
        <div class="container row g-0 ">
            <div class="col-md-4">
                <img src="../assets/img/<?= $brg['gambar']; ?>" class="img-fluid rounded-start" alt="...">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h2 class="card-title"><?= $brg['nama']; ?></h2>
                    <p class="card-text small ms-3"><small class="text-muted"><?= $brg['brand']; ?> / <?= $brg['kategori']; ?></small></p>
                    <p class="card-text mt-4"><br><?= $brg['deskripsi']; ?></p>

                </div>
            </div>
        </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>