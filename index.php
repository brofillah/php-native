<?php
    session_start();
    require 'functions.php';

    //paginations
    //konfigurasi
    $jumlahDataPerHalaman = 2;
    $jumlahData = count(query("SELECT * FROM mahasiswa"));
    $jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
    $halamanAktif = (isset($_GET['halaman'])) ? $_GET['halaman'] : 1;
    $awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;
    
    $mahasiswa = query("SELECT * FROM mahasiswa LIMIT $awalData, $jumlahDataPerHalaman");

    if(isset($_GET['halaman'])){
        $halamanAktif = $_GET['halaman'];
    } else {
        $halamanAktif = 1;
    }

    if(!isset($_SESSION['login'])){
        header("Location: login.php");
        exit;
    }

    //$mahasiswa = query("SELECT * FROM mahasiswa ORDER BY id DESC");

    if(isset($_POST['cari'])){
        $mahasiswa = cari($_POST['keyword']);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .loader{
            width: 100px;
            position: absolute;
            top: 135px;
            display: none;
        }
    </style>
</head>
<body>

    <a href="logout.php">Logout</a> | <a href="cetak.php" target="_blank">Cetak</a>

    <h1>Tabel Mahasiswa</h1>
    <a href="tambah.php">Tambah data mahasiswa</a>
    <br><br>

    <form action="" method="post">
        <input type="text" name="keyword" size="30" autofocus placeholder="masukan keyword pencarian..." autocomplete="off" id="keyword">
        <button type="button" name="cari" id="tombol-cari">Cari!</button>
        <img src="js/straight-loader.gif" class="loader">
    </form>
    <br><br>

    <!-- Navigasi -->
    <?php if($halamanAktif > 1){ ?>
    <a href="?halaman=<?= $halamanAktif-1; ?>">&laquo;</a>
    <?php } ?>

    <?php 
        for ($i=1; $i <= $jumlahHalaman; $i++) {
            if($i == $halamanAktif){ ?>
                <a href="?halaman=<?= $i; ?>" style="font-weight:bold; color:red;"><?= $i; ?></a>
    <?php   } else { ?>
                <a href="?halaman=<?= $i; ?>"><?= $i; ?></a>
    <?php   }
        } ?>
    <?php if($halamanAktif < $jumlahHalaman){ ?>
        <a href="?halaman=<?= $halamanAktif + 1 ?>">&raquo;</a>
    <?php } ?>

    <br>
    <div id="container">
        <table border="1" cellpadding="10" cellspacing="0">
            <tr>
                <th>No</th>
                <th>Aksi</th>
                <th>Gambar</th>
                <th>NRP</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Jurusan</th>
            </tr>
            <?php
                $i = 0;
                foreach($mahasiswa as $row){
            ?>
            <tr>
                <td><?= $i++ ?></td>
                <td>
                    <a href="ubah.php?id=<?= $row['id']; ?>">ubah</a>
                    <a href="hapus.php?id=<?= $row['id']; ?>" onclick="return confirm('yakin?');">hapus</a>
                </td>
                <td><img src="img/<?=$row["gambar"];?>" width="40"></td>
                <td><?=$row["nrp"];?></td>
                <td><?=$row["nama"];?></td>
                <td><?=$row["email"]?></td>
                <td><?=$row["jurusan"]?></td>
            </tr>
            <?php } ?>
        </table>
    </div>

    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/script.js"></script>
    
</body>
</html>