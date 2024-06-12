<?php
session_start();

if (!isset($_SESSION["login"])) {
    header("location: ../web/login.php");
    exit;
}

require '../php/functions.php';
$conn = koneksi();
// cek apakah tombol submit sudah ditekan atau belum
if (isset($_POST["submit"])) {
    // cek apakah data berhasil di tambahkan atau tidak
    if (tambah($_POST) > 0) {
        echo "
            <script> 
            alert('Data berhasil ditambahkan!');
                document.location.href = 'tambah-barang.php';
            </script>
        ";
    } else {
        echo "
            <script>
                alert('Data gagal ditambahkan!');
                document.location.href = 'tambah-barang.php';
            </script>
        ";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard-add-items</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Dini tech</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item ">
                    <a class="nav-link" href="dashboard.php">Dashboard</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="tambah-barang.php">Add items</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="daftar-barang.php">Products</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="card border border-secondary rounded shadow">
            <div class="card-body p-2">
                <h3 class="card-title text-center mt-3 mb-3 p-3">Add items to website</h3>
                <form class="p-5" action="" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Name</label>
                        <input type="text" class="form-control border border-secondary" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="brand" class="form-label">Brand</label>
                        <input type="text" class="form-control border border-secondary" name="brand" required>
                    </div>
                    <div class="mb-3">
                        <label for="gambar" class="form-label">Image</label>
                        <input type="file" class="form-control border border-secondary" name="gambar" required>
                    </div>
                    <div class="mb-3">
                        <label for="kategori_id" class="form-label">Category</label>
                        <select class="form-control border border-secondary" name="kategori_id" required>
                            <option value="">Select Category</option>
                            <option value="1">Camera</option>
                            <option value="2">Lens</option>
                            <option value="3">Gimbal Stabilizer</option>
                            <option value="4">Laptop</option>
                            <option value="5">Tripod</option>
                            <option value="6">Smartphone</option>
                            <option value="7">Equipment</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Description</label>
                        <input type="text" class="form-control border border-secondary" name="deskripsi" required>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Send</button>
                </form>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>