<?php

// ... ambil data dari database
include 'proses-list-buku.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Daftar Kategori</title>
  <link rel="stylesheet" href="../css/style.css">
</head>

<body>
  <div class="container clearfix">
    <h1>Perpustakaan</h1>

    <?php include '../sidebar.php' ?>

    <div class="content">
      <h1>Daftar Buku</h1>
      <div class="btn-tambah-div">
        <a href="tambah-buku.php"><button class="btn btn-tambah">Tambah Data</button></a>
        <?php if (empty($data_buku)) : ?>
        Tidak ada data.
        <?php else : ?>


        <form class="cari-div" action="list-buku.php" method="get">
          <div><input class="cari-div" type="text" name="cari">
            <input class="btn-cari-div" type="submit" value="Cari">
          </div>
        </form>

        <?php
          if (isset($_GET['cari'])) {
            $cari = $_GET['cari'];
          }
          ?>
        <table class="data">
          <tr>
            <th align="center">Judul</th>
            <th align="center">Kategori</th>
            <th align="center">Deskripsi</th>
            <th align="center">Jumlah</th>
            <th align="center">Cover</th>
            <th align="center">Pilihan</th>

          </tr>
          <?php
            include '../connection.php';


            if (isset($_GET['cari'])) {
              $cari = $_GET['cari'];
              $data = mysqli_query($db, "select * from buku where  buku_id like '%".$cari."%' OR buku_judul like '%".$cari."%' 
			OR kategori_id like '%".$cari."%' OR buku_deskripsi like '%".$cari."%' OR buku_jumlah like '%".$cari."%' 
			OR buku_cover like '%".$cari."%'");
              
            } else {
              $data = mysqli_query($db,$query);
            }
            // $data_buku = array();
            while ($buku = mysqli_fetch_array($data)) {
            ?>
          <tr>
            <td align="left"><?php echo $buku['buku_judul']; ?></td>
            <td align="left"><?php echo $buku['kategori_nama']; ?></td>
            <td align="left"><?php echo $buku['buku_deskripsi']; ?></td>
            <td align="center"><?php echo $buku['buku_jumlah']; ?></td>
            <td align="center"><img class="buku-cover" src="cover/<?php echo $buku['buku_cover']; ?>"></td>
            <td align="center">
              <a href="edit-buku.php?id_buku=<?php echo $buku['buku_id']; ?>" class="btn btn-edit">Edit</a>
              <a href="delete-buku.php?id_buku=<?php echo $buku['buku_id']; ?>" class="btn btn-hapus"
                onclick="return confirm('anda yakin akan menghapus data?');">Hapus</a>
            </td>
          </tr>
          <?php } ?>

        </table>
        <?php endif ?>
      </div>

    </div>
</body>

</html>