<?php
    require "koneksi.php";
    $queryKategori = mysqli_query($con, "SELECT * FROM kategori");

    // Get Product by Nama Produk/Keyword
    if(isset($_GET['keyword'])){
        $queryProduk = mysqli_query($con, "SELECT * FROM produk
                                            WHERE produk.nama OR detail LIKE '%$_GET[keyword]%'");
    }
    // Get Product by Kategori
    else if(isset($_GET['kategori'])) {
        $queryGetKategoriId = mysqli_query($con, "SELECT id FROM kategori WHERE nama='$_GET[kategori]'");
        $IdKategori = mysqli_fetch_array($queryGetKategoriId);

        $queryProduk = mysqli_query($con, "SELECT * FROM produk WHERE id_kategori='$IdKategori[id]'");
    }
    // Get Product Default
    else {
        $queryProduk = mysqli_query($con, "SELECT * FROM produk");
    }

    $countdata = mysqli_num_rows($queryProduk);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Darin Shop | Produk</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php require "navbar.php" ?>

    <!-- Banner Produk -->
    <div class="container-fluid banner-produk text-center d-flex align-items-center">
        <div class="container">
            <h3 class="text-light">Kategori</h3>
        </div>
    </div>
    
    <!-- Content -->
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-3">
                <h5 class="mb-3">Kategori</h5>
            <ul class="list-group"> 
                <?php while ($data = mysqli_fetch_array($queryKategori)){ ?>    
                <li class="list-group-item">
                    <a class="no-decoration text-dark" href="produk.php?kategori=<?php echo $data['nama']; ?>">
                        <?php echo $data['nama']; ?>
                    </a>
                </li>
                <?php } ?>
            </ul>
            </div>
            <div class="col-lg-9">
                <h5 class="text-center mb-3 mt-3">Produk</h5>
                <div class="row">
                    <?php
                        if($countdata<1){
                    ?>
                        <h5 class="my-5 text-center text-secondary"><i class="fa-solid fa-magnifying-glass"></i> Maaf, Produk yang anda cari tidak tersedia</h5>
                    <?php
                        }
                    ?>

                    <?php while($produk=mysqli_fetch_array($queryProduk)){?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="img-box">
                                <img src="image/<?php echo $produk['foto']; ?>" class="card-img-top" alt="...">
                            </div>
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $produk['nama']; ?></h5>
                                    <p class="card-text text-truncate"><?php echo $produk['detail']; ?></p>
                                    <p class="text-harga">Rp. <?php echo $produk ['harga']; ?></p>
                                    <a href="produk-detail.php?nama=<?php echo $produk['nama']; ?>" class="btn btn-success">Lihat Detail</a>
                                </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php require "footer.php";?>
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="fontawesome/js/all.min.js"></script>
</body>
</html>