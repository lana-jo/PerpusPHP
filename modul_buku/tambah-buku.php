<?php
include '../modul_kategori/proses-list-kategori.php';

if (!isset($_SESSION['user'])) {
    header('Location: ../login.php');
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Form Buku</title>
  <link rel="stylesheet" href="../css/style.css">
</head>

<body>
  <div class="container clearfix">
    <h1>Perpustakaan</h1>

    <?php include '../sidebar.php' ?>

    <div class="content">
      <h3>Tambah Data Buku</h3>
      <form method="post" action="proses-tambah-buku.php" enctype="multipart/form-data">
        <p>Judul</p>
        <p><input type="text" name="judul"></p>

        <p>Kategori</p>
        <p>
          <select name="kategori">
            <?php foreach ($data_kategori as $kategori) : ?>
            <option value="<?php echo $kategori['kategori_id'] ?>"><?php echo $kategori['kategori_nama'] ?></option>
            <?php endforeach ?>
          </select>
        </p>

        <p>Deskripsi</p>
        <p><textarea name="deskripsi"></textarea></p>

        <p>Jumlah</p>
        <p><input type="number" name="jumlah"></p>

        <p>Cover</p>
        <p><input type="file" name="cover"></p>

        <p><input type="submit" class="btn btn-submit" value="Simpan"></p>
      </form>
    </div>

  </div>
</body>

</html>