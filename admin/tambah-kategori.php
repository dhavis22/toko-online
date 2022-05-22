<?php
    require "session.php";
    require "../koneksi.php";

    $queryKategori = mysqli_query($con, "SELECT * FROM kategori");
    $jumlahKategori = mysqli_num_rows($queryKategori);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/fontawesome.min.css">
</head>
<style>
    .no-decoration{
        text-decoration: none;
    }
</style>
<body>
    <?php require "navbar.php"; ?>
    <div class="container mt-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <a href="../admin/" class="no-decoration text-muted">
                        <i class="fas fa-house-chimney"></i> Home
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Kategori
                </li>
            </ol>
        </nav>

        <div class="my-5 col-12 col-md-6">
            <h3>Tambah Kategori</h3>

            <form action="" method="post">
                <div>
                    <label for="kategori">Nama Kategori</label>
                    <input type="text" name="kategori" id="kategori" placeholder="Masukkan nama kategori" 
                    class="form-control mt-2" autocomplete="off">
                </div>
                <div class="mt-2">
                    <button class="btn btn-primary" type="submit" name="simpan_kategori">Submit</button>
                </div>
            </form>

            <?php
                if(isset($_POST['simpan_kategori'])){
                    $kategori = htmlspecialchars($_POST['kategori']);

                    $queryExist = mysqli_query($con, "SELECT nama FROM kategori WHERE nama='$kategori'");
                    $jumlahDataKategoriBaru = mysqli_num_rows($queryExist);
                    
                    if($jumlahDataKategoriBaru > 0){
                        ?>
                        <div class="alert alert-warning mt-2" role="alert">
                            Kategori Sudah Ada!
                        </div>
                        <?php
                    }else{
                        $querySimpan = mysqli_query($con, "INSERT INTO kategori (nama) VALUES ('$kategori')");

                        if($querySimpan){
                            ?>
                            <div class="alert alert-success mt-2" role="alert">
                                Kategori Berhasil Tersimpan
                            </div>

                            <meta http-equiv="refresh" content="2; url=kategori.php" />
                            <?php 
                        }else{
                            echo mysqli_error($conn);
                        }
                    }
                }
            ?>
        </div>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>
</body>
</html>