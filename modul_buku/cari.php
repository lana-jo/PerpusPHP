<?php
include '../connection.php';
?>
<form class='cari' action="cari.php" method="get">
  <label>Cari :</label>
  <input type="text" name="cari">
  <input type="submit" value="Cari">
</form>



<?php
$query = "SELECT buku.*, kategori.*
FROM buku
JOIN kategori ON buku.kategori_id=kategori.kategori_id
where buku.kategori_id=kategori.kategori_id";

if (isset($_GET['cari'])) {
	$cari = $_GET['cari'];
	echo "<b>Hasil pencarian : " . $cari .$query."</b>";
}
?>

<?php

// $query = "SELECT buku.*, kategori.kategori_nama
//     FROM buku
//     JOIN kategori
//     ON buku.kategori_id = kategori.kategori_id";

if (isset($_GET['cari'])) {
	$cari = $_GET['cari',$query];
  $data = mysqli_query("select * from db_perpus where nama like '%" . $cari . "%'");
  
} else {
	$data = mysqli_query($db,$query);
}
$data_buku = array();
$no = 1;
while ($d = mysql_fetch_array($data, "select * from db_perpus")) {
?>
<tr>
  <th>Judul</th>
  <th>Kategori</th>
  <th>Deskripsi</th>
  <th>Jumlah</th>
  <th>Cover</th>
  <th width="20%">Pilihan</th>
</tr>
<?php $data_buku[] = $row;} ?>
</table>