<?php
session_start();

//jika belum login, alihkan ke login
if (empty($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Daftar Petugas</title>
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <div class="container clearfix">
    <h1>Perpustakaan</h1>
    <hr>
    </hr>
    <div class="sidebar">
      <ul>
        <li><a href="modul_kategori/list-kategori.php">Data Kategori</a></li>
        <li><a href="modul_buku/list-buku.php">Data Buku</a></li>
        <li><a href="modul_anggota/list-anggota.php">Data Anggota</a></li>
        <li><a href="modul_peminjaman/pinjam-data.php">Peminjaman</a></li>
        <li><a href="modul_pengembalian/list-pengembalian.php">Pengembalian</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </div>
    <div class="content">
      <h1>
        <center> Perpustakaan Ma'had Aly Balekambang</center>
      </h1>
      <?php
            $images = glob("images/mly.png");
            for ($i = 0; $i < count($images); $i++) {
                $single_image = $images[$i];
            ?>
      <center> <img src="<?php echo $single_image; ?>" width="260" height="260" /> </center>
      <?php
            }
            ?>
    </div>
  </div>
</body>

</html>