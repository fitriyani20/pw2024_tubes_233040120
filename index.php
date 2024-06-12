<?php
session_start();

if (!isset($_SESSION["login"])) {
  header("location: web/login.php");
  exit;
}

require 'php/functions.php';

$conn = koneksi();

$tampil = query("SELECT b.*, k.*, b.id as id_brg 
FROM barang b 
JOIN kategori k 
ON b.kategori_id = k.id");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>TechnoZone.</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />

  <link rel="stylesheet" href="assets/css/style.css" />
  <style>
   .card {
   
    height: 100%;
}

    .card-img-top {
      height: 350px;
      object-fit: cover;
    }

    .top {
      margin-top: -12px !important;
    }

    .card {
      box-shadow: 0 0 4px grey !important;
      border-radius: 10px !important;
      overflow: hidden;
    }

    @media (max-width: 700px) {
      .kecil img {

        width: 80% !important;
      }
    }
  </style>
</head>

<body>
  <!-- Navbar -->
  <nav class="navbar sticky-top navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="#">TechZone.</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#About">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#Items">Items</a>
                </li>
                <li class="nav-item">
                    <button class="btn btn-danger ms-2">
                        <a href="php/logout.php" class="text-decoration-none text-light">Logout</a>
                    </button>
                </li>
            </ul>
        </div>
    </div>
</nav>

  <!-- Navbar end -->

  <!-- Hero Section -->
  <div class="jumbotron">
    <h1>TechZone</h1>
    <p>Seputar Technology Terkini</p>
  </div>
  <!-- Hero Section -->

  <!-- About -->
  <div id="About">
    <div class="container mt-5">
      <h1>About</h1>
      <div class="row">
        <div class="col-lg-6 col-sm-12">
          <p>
          TechZone adalah toko produk teknologi terkemuka yang menyediakan berbagai macam perangkat dan aksesoris terkini. Didirikan dengan tujuan untuk memberikan akses mudah dan cepat ke produk teknologi terbaru, TechZone menawarkan segala sesuatu mulai dari smartphone, laptop, tablet, hingga perangkat rumah pintar dan aksesoris gaming. Kami bekerja sama dengan merek-merek ternama seperti Apple, Samsung, Dell, dan Sony untuk memastikan kualitas dan keandalan produk yang dijual.

Dengan mengutamakan pengalaman pelanggan, TechZone tidak hanya menjual produk, tetapi juga memberikan layanan purna jual yang handal, termasuk perbaikan dan dukungan teknis. Toko kami dilengkapi dengan staf berpengetahuan luas yang siap membantu Anda memilih produk yang tepat sesuai kebutuhan. Selain itu, TechZone juga menawarkan pembelian online dengan pengiriman cepat dan aman, serta berbagai promo menarik yang dapat diakses melalui situs web kami. Kami berkomitmen untuk menjadi solusi terbaik bagi kebutuhan teknologi Anda, baik untuk keperluan pribadi maupun profesional.
          </p>
        </div>
        <div class="col-lg-6 col-sm-12 kecil">
          <img src="assets/img/camera.jpg" alt="camera" />
        </div>
      </div>
    </div>
  </div>
  <!-- About End -->

  <!-- Items -->
  <div id="Items">
    <div class="container mt-5">
      <h1 class="text-center">Items</h1>

      <div class="row mb-5 mt-5">
        <div class="col-md-6">
          <form action="" method="get">
            <div class="input-group">
              <input type="search" class="form-control" name="keyword" id="keyword" form-control placeholder="Search students" autofocus autocomplete="off">
              <button class="btn btn-primary" name="search" id="search-button" type="submit" id="button-addon2">Search</button>
            </div>
          </form>
        </div>
      </div>
      <div id="search-container">
        <div class="row mt-5">
          <?php foreach ($tampil as $brg) : ?>
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
              <div class="card border border-secondary shadow">
                <img src="assets/img/<?= $brg['gambar']; ?>" class="card-img-top" alt="fix" />
                <div class="card-body">
                  <h5 class="card-title"><?= $brg['nama']; ?></h5>
                  <p class="card-text top mb-5 text-secondary">
                    <small><?= $brg['kategori']; ?></small>
                  </p>
                  <a href="web/detail-item.php?id=<?= $brg['id_brg']; ?>" class="btn btn-primary">Details</a>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
  <!-- Items End -->


  <!-- Footer -->
  <div id="Footer" class="bg-primary py-5 mt-5">
    <div class="container text-center text-light">
      <p class="">&copy; Copyright @Rahmadini</p>
    </div>
  </div>
  <!-- Footer end -->

  <script>
    const keyword = document.getElementById("keyword");
    const searchContainer = document.getElementById("search-container");

    keyword.addEventListener("keyup", function() {
      const xhr = new XMLHttpRequest();
      xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
          searchContainer.innerHTML = xhr.responseText;
        }
      };
      xhr.open("GET", "ajax/search.php?keyword=" + keyword.value, true);
      xhr.send();
    });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>