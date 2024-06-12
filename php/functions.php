<?php

// Koneksi DB
function koneksi()
{
    $conn = mysqli_connect("localhost", "root", "", "tubes2");

    return $conn;
}

// Array query
function query($sql)
{
    $conn = koneksi();
    $result = mysqli_query($conn, "$sql");
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

// Insert data
function tambah($data)
{
    global $conn;
    // ambil data dari tiap elemen dalam form
    $nama = htmlspecialchars($data['nama']);
    $brand = htmlspecialchars($data['brand']);
    $kategori_id = $data['kategori_id'];
    $deskripsi = htmlspecialchars($data['deskripsi']);

    // UP GAMBAR
    $gambar = upload();
    if (!$gambar) {
        return false;
    }

    // INSERT DATA 
    $query = "INSERT INTO barang (nama, brand, gambar, deskripsi, kategori_id)
    VALUES ('$nama', '$brand', '$gambar', '$deskripsi', '$kategori_id')";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}


function upload()
{
    $namafile = $_FILES['gambar']['name'];
    $ukuranfile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];


    //cek apakah tidak ada gambar yang di upload
    $error = $_FILES['gambar']['error'];

    // cek apakah tidak ada gambar yang diupload
    if ($error === 4) {
        echo "<script>
    alert('Pilih gambar terlebih dahulu')
    </script>";
        return false;
    }

    // CEK VALIDASI GAMBAR
    $ekstensigambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensigambar = explode('.', $namafile);
    $ekstensigambar = strtolower(end($ekstensigambar));
    if (!in_array($ekstensigambar, $ekstensigambarValid)) {
        echo "<script>
        alert('yang anda upload bukan gambar')
        </script>";
        return false;
    }

    // CEK SIZE GAMBAR 
    if ($ukuranfile > 1000000) {
        echo "<script>
        alert('ukuran gambar terlalu besar')
        </script>";
        return false;
    }

    // LOLOS CEK, SIAP UPLOAD
    // GENERATE NEW NAME
    $namafilebaru = uniqid();
    $namafilebaru .= '.';
    $namafilebaru .= $ekstensigambar;

    move_uploaded_file($tmpName, '../assets/img/' . $namafilebaru);

    return $namafilebaru;
}



// REGISTRASI
function registrasi($data)
{
    $conn = koneksi();

    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);
    $nama_lengkap = mysqli_real_escape_string($conn, $data["nama_lengkap"]);
    $email = mysqli_real_escape_string($conn, $data["email"]);

    // cek username sudah ada atau belum 
    $result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");

    if (mysqli_fetch_assoc($result)) {
        echo "<script>
                alert('username sudah terdaftar')
              </script>";
        return false;
    }

    // cek konfirmasi password
    if ($password !== $password2) {
        echo "<script>
                alert('konfirmasi password tidak sesuai)
              </script>";
        return false;
    }

    // enkripsi password 
    $password = password_hash($password, PASSWORD_DEFAULT);

    // tambahkan user baru ke database
    mysqli_query($conn, "INSERT INTO user VALUES(null, '$username', '$password', '$nama_lengkap', '$email', 'user')");

    return mysqli_affected_rows($conn);
}


// Hapus
function hapus($id)
{
    $conn = koneksi();
    mysqli_query($conn, "DELETE FROM barang WHERE id = $id");

    return mysqli_affected_rows($conn);
}

function cari($keyword)
{
    // Kode untuk mencari data barang berdasarkan keyword
    $query = "SELECT b.*, k.*, b.id as id_brg
        FROM barang b
        JOIN kategori k
        ON b.kategori_id = k.id
        WHERE nama LIKE '%$keyword%' OR brand LIKE '%$keyword%' OR deskripsi LIKE '%$keyword%'";

    return query($query);
}
