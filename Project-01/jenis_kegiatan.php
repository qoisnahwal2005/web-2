<?php

include_once 'layout/header.php';
include_once 'layout/sidebar.php';

$host = "localhost";
$user = "root";
$pass = "";
$db = "dbkegiatan_dosen";
$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) {
    die("Tidak bisa terkoneksi ke database");
}

$nama = "";
$sukses = "";
$error = "";

$op = isset($_GET['op']) ? $_GET['op'] : "";
if ($op == 'delete') {
    $id = $_GET['id'];
    $sql1 = "DELETE FROM jenis_kegiatan WHERE id = '$id'";
    $q1 = mysqli_query($koneksi, $sql1);
    $sukses = $q1 ? "Berhasil hapus data" : "Gagal menghapus data";
}
if ($op == 'edit') {
    $id = $_GET['id'];
    $sql1 = "SELECT * FROM jenis_kegiatan WHERE id = '$id'";
    $q1 = mysqli_query($koneksi, $sql1);
    $r1 = mysqli_fetch_array($q1);
    $nama = $r1['nama'];
}
if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];

    if ($nama) {
        if ($op == 'edit') {
            $sql1 = "UPDATE jenis_kegiatan SET nama='$nama' WHERE id='$id'";
        } else {
            $sql1 = "INSERT INTO jenis_kegiatan (nama) VALUES ('$nama')";
        }

        $q1 = mysqli_query($koneksi, $sql1);
        if ($q1) {
            $sukses = ($op == 'edit') ? "Data berhasil diupdate" : "Berhasil menambahkan data baru";
        } else {
            $error = "Gagal menyimpan data";
        }
    } else {
        $error = "Silakan masukkan nama jenis kegiatan";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset='UTF-8'>
    <title>Manajemen Jenis Kegiatan</title>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css' rel='stylesheet'>
    <style>
        .mx-auto {
            width: 850px;
        }

        .card {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="wrapper">
    <div class="content-wrapper">
        <div class="card mr-5 ml-5 mt-3">
            <div class="card-header bg-primary text-white">Form Jenis Kegiatan</div>
            <div class="card-body">
                <?php if ($error): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                    <?php header("refresh:3;url=jenis_kegiatan.php"); endif; ?>

                <?php if ($sukses): ?>
                    <div class="alert alert-success"><?= $sukses ?></div>
                    <?php header("refresh:3;url=jenis_kegiatan.php"); endif; ?>

                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Nama Jenis Kegiatan</label>
                        <input type="text" name="nama" class="form-control" value="<?= $nama ?>">
                    </div>
                    <div class="mb-3">
                        <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabel Data -->
        <div class="card mr-2 ml-2">
            <div class="card-header bg-secondary text-white">Daftar Jenis Kegiatan</div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql2 = "SELECT * FROM jenis_kegiatan ORDER BY id DESC";
                        $q2 = mysqli_query($koneksi, $sql2);
                        $urut = 1;
                        while ($r2 = mysqli_fetch_array($q2)) {
                            echo "<tr>
                            <td>$urut</td>
                            <td>{$r2['nama']}</td>
                            <td>
                                <a href='?op=edit&id={$r2['id']}' class='btn btn-warning btn-sm'>Edit</a>
                                <a href='?op=delete&id={$r2['id']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Hapus data?')\">Delete</a>
                            </td>
                        </tr>";
                            $urut++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>

    <?php include 'layout/footer.php'; ?>
</body>

</html>