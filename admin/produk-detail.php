<?php
    require "session.php";
    require "../koneksi.php";

    $id = $_GET['p'];
    $queryProduk = mysqli_query($con, "SELECT produk.*, kategori.nama AS nama_kategori FROM produk LEFT JOIN kategori ON produk.id_kategori=kategori.id WHERE produk.id='$id'");
    $data = mysqli_fetch_array($queryProduk);

    $queryKategori = mysqli_query($con, "SELECT * FROM kategori WHERE id!='$data[id_kategori]'");

    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk Detail</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
</head>
<body>
    <?php require "navbar.php" ?>

    <div class="container mt-5">
        <h2>Detail Produk</h2>

        <div class="col-12 col-md-6 mb-5">
            <form action="" method="post" enctype="multipart/form-data">
                <div>
                    <label for="nama">Nama</label>
                    <input type="text" id="nama" name="nama" value="<?php echo $data['nama']; ?>" class="form-control mt-1" autocomplete="off" required>
                </div>
                <div>
                    <label for="kategori" class="mb-1">Kategori</label>
                    <select name="kategori" id="kategori" class="form-control" required>
                        <option value="<?php echo $data['id_kategori']; ?>"><?php echo $data['nama_kategori']; ?></option>
                        <?php 
                            while($dataKategori=mysqli_fetch_array($queryKategori)){
                        ?>
                            <option value="<?php echo $dataKategori['id']; ?>"><?php echo $dataKategori['nama']; ?>     </option>
                        <?php
                            }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="harga" class="mb-1">Harga</label>
                    <input type="number" class="form-control" value="<?php echo $data['harga']; ?>" name="harga" required>
                </div>
                <div>
                    <label for="cuttentFoto" class="mb-1">Foto Produk Sekarang</label>
                    <img class="form-control" src="../image/<?php echo $data['foto'] ?>" alt="" width="100px">
                </div>
                <div>
                    <label for="foto" class="mb-1">Foto</label>
                    <input type="file" name="foto" id="foto" class="form-control mt-2">
                </div>
                <div>
                    <label for="detail">Detail</label>
                    <textarea name="detail" id="detail" cols="30" rows="10" class="form-control mt-2" required>
                        <?php echo $data['detail']; ?>
                    </textarea>
                </div>
                <div>
                <label for="stok">Stok</label>
                    <select name="stok" id="stok" class="form-control mt-2">
                        <option value="<?php echo $data['stok']; ?>"><?php echo $data['stok']; ?></option>
                        <?php
                            if($data['stok']=='Tersedia'){
                        ?>
                            <option value="Habis">Habis</option>
                        <?php
                            }else {
                        ?>
                            <option value="Tersedia">Tersedia</option>
                        <?php
                            }
                        ?>
                    </select>
                </div>
                <div class="mt-3 d-flex justify-content-between">
                    <button type="submit"class="btn btn-primary" name="editBtn"><i class="fa-solid fa-pen"></i> Edit</button>
                    <button type="submit"class="btn btn-danger" name="deleteBtn"><i class="fa-solid fa-trash-can"></i> Delete</button>
                </div>
            </form>

            <?php
            if(isset($_POST['editBtn'])){
                $nama = htmlspecialchars($_POST['nama']);
                $kategori = htmlspecialchars($_POST['kategori']);
                $harga = htmlspecialchars($_POST['harga']);
                $detail = htmlspecialchars($_POST['detail']);
                $stok = htmlspecialchars($_POST['stok']);

                $target_dir = "../image/";
                $nama_file = basename($_FILES["foto"]["name"]);
                $target_file = $target_dir . $nama_file;
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                $image_size = $_FILES["foto"]["size"];
                $random_name = generateRandomString(20);
                $new_name = $random_name . "." . $imageFileType;

                if($nama=='' || $kategori=='' || $harga=='' || $detail==''){
            ?>
                <div class="alert alert-warning mt-3" role="alert">
                    Nama, Kategori, Harga, Detail Wajib diisi! 
                </div>
            <?php
                }else{
                    $queryUpdate = mysqli_query($con, "UPDATE produk SET id_kategori='$kategori', nama='$nama', harga='$harga', detail='$detail', stok='$stok' WHERE id=$id");

                    if($nama_file!=''){
                        if($image_size >= 5000000){
            ?>
                        <div class="alert alert-warning mt-3" role="alert">
                            File tidak boleh lebih dari 5 Mb
                        </div>
            <?php
                    }else{
                        if($imageFileType != 'jpg' && $imageFileType != 'png' && $imageFileType != 'jpeg'){
            ?>
                        <div class="alert alert-warning mt-3" role="alert">
                            File harus JPG, PNG, atau JPEG
                        </div>
            <?php
                        }else{
                            move_uploaded_file($_FILES["foto"]["tmp_name"], $target_dir . $new_name);

                            $queryUpdate = mysqli_query($con, "UPDATE produk SET foto='$new_name' WHERE id='$id'");
                            if($queryUpdate){
            ?>
                        <div class="alert alert-success mt-3" role="alert">
                            Produk Berhasil Diupdate!
                        </div>
                        <meta http-equiv="refresh" content="2; url=produk.php"/>
            <?php
                                }
                            }
                        }
                    }
                }
            }

            if(isset($_POST['deleteBtn'])){
                $queryDelete=mysqli_query($con, "DELETE FROM produk WHERE id='$id'");
    
                if($queryDelete){
            ?>
                <div class="alert alert-success mt-3" role="alert">
                    Produk Berhasil di Hapus!
                </div>
                <meta http-equiv="refresh" content="2; url=produk.php"/>
            <?php
                } else {
                    echo mysqli_error($con);
                }
            }
            ?>
        </div>
    </div>


    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>