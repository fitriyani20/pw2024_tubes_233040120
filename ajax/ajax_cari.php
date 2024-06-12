<?php
require '../php/functions.php';

if (isset($_GET['keywords'])) {
    $keywords = $_GET['keywords'];
    $query = "SELECT b.*, k.*, b.id as id_brg
        FROM barang b
        JOIN kategori k
        ON b.kategori_id = k.id
        WHERE ";

    $conditions = [];
    foreach ($keywords as $key => $keyword) {
        $conditions[] = "nama LIKE '%$keyword%' OR brand LIKE '%$keyword%' OR deskripsi LIKE '%$keyword%'";
    }
    $query .= implode(" OR ", $conditions);

    $barang = query($query);
} else {
    $barang = query("SELECT b.*, k.*, b.id as id_brg
        FROM barang b
        JOIN kategori k
        ON b.kategori_id = k.id");
}

$i = 0;
?>

<!-- Kode HTML untuk menampilkan data items -->
<div class="table-responsive admin-container">
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Images</th>
                <th>Name</th>
                <th>Brand</th>
                <th>Category</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($barang as $b) : ?>
                <?php $i++; ?>
                <tr>
                    <td><?= $i; ?></td>
                    <td><img width="150px" src="../assets/img/<?= $b['gambar']; ?>"></td>
                    <td><?= $b['nama']; ?></td>
                    <td><?= $b['brand']; ?></td>
                    <td><?= $b['kategori']; ?></td>
                    <td><?= $b['deskripsi']; ?></td>
                    <td>
                        <a href="../php/update.php?id=<?= $b['id_brg']; ?>" class="badge text-dark p-1 bg-warning">Change</a> |
                        <a href="../php/delete.php?id=<?= $b['id_brg']; ?>" class="badge text-light p-1 bg-danger">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>