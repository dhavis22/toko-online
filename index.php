<?php
    require "koneksi.php";
    $queryProduk = mysqli_query($con, "SELECT id, nama, harga, foto, detail FROM produk LIMIT 6");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Darin Shop | Home</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php require "navbar.php"; ?>
    <!-- Banner -->
    <div class="container-fluid banner d-flex align-items-center">
        <div class="container">
            <h1 class="text-light">Darin Shop</h1>
            <h4 class="text-light">Semua Kebutuhan Anda dengan Pilihan yang Terbaik</h4>
            <h6 class="text-light">Aneka Fashion Milenial</h6>
        </div>
    </div>

    <!-- Highlight -->
    <div class="container-fluid py-5">
        <div class="container text-center">
            <h4>Apa yang anda Butuhkan?</h4>
            <div class="row mt-5">
                <div class="col-md-4 mb-3">
                    <div class="highlight d-flex align-items-center justify-content-center kategori-sepatu">
                        <h3 class="text-light"> <a class="text-light no-decoration" href="produk.php?kategori=Sepatu">Sepatu</a></h3>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="highlight d-flex align-items-center justify-content-center kategori-sweater">
                        <h3 class="text-light"> <a class="text-light no-decoration" href="produk.php?kategori=Sweater">Sweater</a></h3>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="highlight d-flex align-items-center justify-content-center kategori-jamTangan">
                        <h3 class="text-light"> <a class="text-light no-decoration" href="produk.php?kategori=JamTangan">Jam Tangan</a></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Produk Terlaris -->
    <div class="container-fluid pt-5">
        <div class="container text-center">
            <h4>Produk Terlaris</h4>

            <div class="row mt-5">
                <?php while($data = mysqli_fetch_array($queryProduk)){ ?>
                <div class="col-sm-6 col-md-4 mb-4">
                    <div class="card">
                        <div class="img-box">
                            <img src="image/<?php echo $data['foto']; ?>" class="card-img-top" alt="...">
                        </div>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $data['nama']; ?></h5>
                                <p class="card-text text-truncate"><?php echo $data['detail']; ?></p>
                                <p class="text-harga">Rp. <?php echo $data['harga']; ?></p>
                                <a href="produk-detail.php?nama=<?php echo $data['nama']; ?>" class="btn btn-success">Lihat Detail</a>
                            </div>
                    </div>
                </div>
                <?php } ?>
                </div>
            </div>
        <div class="text-center">
            <a class="btn btn-outline-dark mb-3" href="produk.php">Lihat Lebih Banyak</a>
        </div>
    </div>

    <!-- Footer -->
    <?php require "footer.php" ?>

    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="fontawesome/js/all.min.js"></script>
</body>
</html>