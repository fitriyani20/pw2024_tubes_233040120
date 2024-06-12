<?php
session_start();

if (!isset($_SESSION["login"])) {
    header("location: ../web/login.php");
    exit;
}

require '../php/functions.php';
// koneksi ke dbms
$conn = koneksi();

// ambil data di url
$id = $_GET["id"];

// query data barang berdasarkan id
$barang = query("SELECT * FROM barang WHERE id = $id")[0];

// cek apakah tombol submit sudah ditekan atau belum
if (isset($_POST["submit"])) {

    // ambil data dari form
    $id = $_POST["id"];
    $nama = $_POST["nama"];
    $brand = $_POST["brand"];
    $deskripsi = $_POST["deskripsi"];
    $kategori_id = $_POST["kategori_id"];

    // periksa apakah ada file gambar yang diunggah
    if ($_FILES["gambar"]["error"] === 4) {
        // jika tidak ada gambar yang diunggah, gunakan gambar yang sudah ada
        $gambar = $barang["gambar"];
    } else {
        // jika ada gambar yang diunggah, upload gambar baru
        $gambar = uploadImage();
        if (!$gambar) {
            // jika upload gambar gagal, tampilkan pesan error
            echo "
                <script>
                    alert('Upload gambar gagal!');
                    document.location.href = 'ubah.php?id=$id';
                </script>
            ";
            exit;
        }
    }

    // query update data barang
    $query = "UPDATE barang SET
                nama = '$nama',
                brand = '$brand',
                gambar = '$gambar',
                deskripsi = '$deskripsi',
                kategori_id = '$kategori_id'
              WHERE id = $id";

    // cek apakah data berhasil diubah atau tidak
    if (mysqli_query($conn, $query)) {
        echo "
           <script> 
            alert('Data berhasil diubah!');
            document.location.href = '../adminpanel/daftar-barang.php';
           </script>
        ";
    } else {
        echo "
           <script>
            alert('Data gagal diubah!');
            document.location.href = 'update.php';
           </script>
        ";
    }
}

// Fungsi untuk upload gambar
function uploadImage()
{
    $namaFile = $_FILES["gambar"]["name"];
    $ukuranFile = $_FILES["gambar"]["size"];
    $error = $_FILES["gambar"]["error"];
    $tmpName = $_FILES["gambar"]["tmp_name"];

    // cek apakah tidak ada gambar yang diupload
    if ($error === 4) {
        echo "
            <script>
                alert('Pilih gambar terlebih dahulu!');
                document.location.href = 'update.php';
            </script>
        ";
        exit;
    }

    // cek apakah yang diupload adalah gambar
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));
    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo "
            <script>
                alert('Format gambar tidak valid! Hanya menerima format JPG, JPEG, dan PNG.');
                document.location.href = 'update.php';
            </script>
        ";
        exit;
    }

    // cek jika ukuran file terlalu besar (maksimal 2MB)
    if ($ukuranFile > 2097152) {
        echo "
            <script>
                alert('Ukuran gambar terlalu besar! Maksimal 2MB.');
                document.location.href = 'update.php';
            </script>
        ";
        exit;
    }

    // generate nama baru untuk gambar
    $namaFileBaru = uniqid() . '.' . $ekstensiGambar;

    // pindahkan gambar ke folder yang ditentukan
    move_uploaded_file($tmpName, '../assets/img/' . $namaFileBaru);

    return $namaFileBaru;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update items</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-4 mb-5">
        <div class="card border border-secondary rounded shadow">
            <div class="card-body p-2">
                <h1 class="text-center mt-4">Update items</h1>
                <form class="p-5" action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $barang['id']; ?>">
                    <img class="img-preview w-25" src="../assets/img/<?= $barang["gambar"]; ?>" alt="Preview" id="preview" class="preview-image" />
                    <div class="mb-3 mt-4">
                        <label for="gambar" class="form-label">Gambar</label>
                        <input type="file" onchange="previewImage(event)" class="form-control" id="gambar" name="gambar" />
                    </div>
                    <div class="mb-3">
                        <label for="nama">Name</label>
                        <input type="text" class="form-control border border-secondary" name="nama" placeholder="Enter name" value="<?php echo $barang['nama']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="brand">Brand</label>
                        <input type="text" class="form-control border border-secondary" name="brand" placeholder="Enter brand" value="<?php echo $barang['brand']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="kategori_id">Category</label>
                        <select class="form-control border border-secondary" name="kategori_id">
                            <option value="">Select Category</option>
                            <option value="1" <?php if ($barang['kategori_id'] == 1) echo 'selected'; ?>>Camera</option>
                            <option value="2" <?php if ($barang['kategori_id'] == 2) echo 'selected'; ?>>Lens</option>
                            <option value="3" <?php if ($barang['kategori_id'] == 3) echo 'selected'; ?>>Gimbal</option>
                            <option value="4" <?php if ($barang['kategori_id'] == 4) echo 'selected'; ?>>Laptop</option>
                            <option value="5" <?php if ($barang['kategori_id'] == 5) echo 'selected'; ?>>Tripod</option>
                            <option value="6" <?php if ($barang['kategori_id'] == 6) echo 'selected'; ?>>Smartphone</option>
                            <option value="7" <?php if ($barang['kategori_id'] == 7) echo 'selected'; ?>>Equipment</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi">Description</label>
                        <textarea class="form-control border border-secondary" name="deskripsi" rows="3" placeholder="Enter description"><?php echo $barang['deskripsi']; ?></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary" name="submit">Update</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('preview');
                output.src = reader.result;
                output.style.display = 'block'; // Tampilkan gambar pratinjau
            }
            reader.readAsDataURL(event.target.files[0]);
        }

        function changeKategori() {
            var select = document.getElementById("kategoriSelect");
            var input = document.getElementById("kategoriInput");
            var selectedValue = select.value;
            input.value = selectedValue;
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>