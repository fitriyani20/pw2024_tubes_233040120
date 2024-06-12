<?php
require '../php/functions.php';

if (isset($_GET["keyword"])) {
    $keyword = $_GET["keyword"];

    $query = "SELECT b.*, k.*, b.id as id_brg 
            FROM barang b 
            JOIN kategori k 
            ON b.kategori_id = k.id
            WHERE b.nama LIKE '%$keyword%' OR b.brand LIKE '%$keyword%'";

    $tampil = query($query);
} else {
    $tampil = query("SELECT b.*, k.*, b.id as id_brg 
                  FROM barang b 
                  JOIN kategori k 
                  ON b.kategori_id = k.id");
}
?>

<div class="row mt-5">
    <?php foreach ($tampil as $brg) : ?>
        <div class="col-lg-4 ">
            <div class="card border border-secondary shadow">
                <img src="assets/img/<?= $brg['gambar']; ?>" class="card-img-top" alt="fix" />
                <div class="card-body">
                    <h5 class="card-title"><?= $brg['nama']; ?></h5>
                    <p class="card-text top mb-5 text-secondary">
                        <small><?= $brg['kategori']; ?></small>
                    </p>
                    <a href="../web/detail-item.php?id=<?= $brg['id_brg']; ?>" class="btn btn-primary">Details</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <?php if (empty($tampil)) : ?>
        <div class="col-lg-12 mt-3">
            <div class="alert alert-warning" role="alert">
                No items found.
            </div>
        </div>
    <?php endif; ?>
</div>