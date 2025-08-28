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

$tanggal_mulai = "";
$tanggal_selesai = "";
$tempat = "";
$deskripsi = "";
$jenis_kegiatan_id = "";
$sukses = "";
$error = "";

// Ambil daftar jenis kegiatan untuk dropdown
$jenisList = mysqli_query($koneksi, "SELECT * FROM jenis_kegiatan ORDER BY nama");

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}

// DELETE
if ($op == 'delete') {
    $id = $_GET['id'];
    $sql1 = "DELETE FROM kegiatan WHERE id = '$id'";
    $q1 = mysqli_query($koneksi, $sql1);
    $sukses = $q1 ? "Berhasil hapus data" : "Gagal menghapus data";
}

// EDIT
if ($op == 'edit') {
    $id = $_GET['id'];
    $sql1 = "SELECT * FROM kegiatan WHERE id = '$id'";
    $q1 = mysqli_query($koneksi, $sql1);
    $r1 = mysqli_fetch_array($q1);
    $tanggal_mulai = $r1['tanggal_mulai'];
    $tanggal_selesai = $r1['tanggal_selesai'];
    $tempat = $r1['tempat'];
    $deskripsi = $r1['deskripsi'];
    $jenis_kegiatan_id = $r1['jenis_kegiatan_id'];
}

// SIMPAN
if (isset($_POST['simpan'])) {
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_selesai = $_POST['tanggal_selesai'];
    $tempat = $_POST['tempat'];
    $deskripsi = $_POST['deskripsi'];
    $jenis_kegiatan_id = $_POST['jenis_kegiatan_id'];

    if ($tanggal_mulai && $tanggal_selesai && $tempat && $deskripsi && $jenis_kegiatan_id) {
        if ($op == 'edit') {
            $sql1 = "UPDATE kegiatan SET tanggal_mulai='$tanggal_mulai', tanggal_selesai='$tanggal_selesai',
                     tempat='$tempat', deskripsi='$deskripsi', jenis_kegiatan_id='$jenis_kegiatan_id' WHERE id='$id'";
        } else {
            $sql1 = "INSERT INTO kegiatan (tanggal_mulai, tanggal_selesai, tempat, deskripsi, jenis_kegiatan_id)
                     VALUES ('$tanggal_mulai','$tanggal_selesai','$tempat','$deskripsi','$jenis_kegiatan_id')";
        }
        $q1 = mysqli_query($koneksi, $sql1);
        $sukses = $q1 ? ($op == 'edit' ? "Data berhasil diupdate" : "Data berhasil ditambahkan") : "Gagal menyimpan data";
    } else {
        $error = "Silakan masukkan semua data";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset='UTF-8'>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css' rel='stylesheet'>
    <style>
        .mx-auto {
            width: 870px
        }

        .card {
            margin-top: 10px
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class='content-wrapper'>
            <div class='card mr-5 ml-5 mt-3'>
                <div class='card-header bg-primary text-white'>Form Data Kegiatan</div>
                <div class='card-body'>
                    <?php if ($error)
                        echo "<div class='alert alert-danger'>$error</div>"; ?>
                    <?php if ($sukses) {
                        echo "<div class='alert alert-success'>$sukses</div>";
                        header("refresh:2;url=kegiatan.php");
                    } ?>
                    <form method='POST'>
                        <div class='mb-3'><label>Tanggal Mulai</label>
                            <input type='date' name='tanggal_mulai' class='form-control' value='<?= $tanggal_mulai ?>'>
                        </div>
                        <div class='mb-3'><label>Tanggal Selesai</label>
                            <input type='date' name='tanggal_selesai' class='form-control'
                                value='<?= $tanggal_selesai ?>'>
                        </div>
                        <div class='mb-3'><label>Tempat</label>
                            <input type='text' name='tempat' class='form-control' value='<?= $tempat ?>'>
                        </div>
                        <div class='mb-3'><label>Deskripsi</label>
                            <textarea name='deskripsi' class='form-control'><?= $deskripsi ?></textarea>
                        </div>
                        <div class='mb-3'><label>Jenis Kegiatan</label>
                            <select name='jenis_kegiatan_id' class='form-control'>
                                <option value=''>- Pilih Jenis -</option>
                                <?php
                                mysqli_data_seek($jenisList, 0);
                                while ($r = mysqli_fetch_array($jenisList)) {
                                    $sel = ($r['id'] == $jenis_kegiatan_id) ? "selected" : "";
                                    echo "<option value='{$r['id']}' $sel>{$r['nama']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class='mb-3'>
                            <input type='submit' name='simpan' value='Simpan Data' class='btn btn-primary'>
                        </div>
                    </form>
                </div>
            </div>

            <div class='card mr-2 ml-2'>
                <div class='card-header bg-secondary text-white'>Data Kegiatan</div>
                <div class='card-body'>
                    <table class='table'>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Mulai</th>
                                <th>Selesai</th>
                                <th>Tempat</th>
                                <th>Deskripsi</th>
                                <th>Jenis</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql2 = "SELECT kegiatan.*, jenis_kegiatan.nama FROM kegiatan 
         LEFT JOIN jenis_kegiatan ON kegiatan.jenis_kegiatan_id = jenis_kegiatan.id 
         ORDER BY kegiatan.id DESC";
                            $q2 = mysqli_query($koneksi, $sql2);
                            $urut = 1;
                            while ($r = mysqli_fetch_array($q2)) {
                                echo "<tr>
            <td>$urut</td>
            <td>{$r['tanggal_mulai']}</td>
            <td>{$r['tanggal_selesai']}</td>
            <td>{$r['tempat']}</td>
            <td>{$r['deskripsi']}</td>
            <td>{$r['nama']}</td>
            <td>
                <a href='?op=edit&id={$r['id']}' class='btn btn-warning btn-sm'>Edit</a>
                <a href='?op=delete&id={$r['id']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Hapus data?')\">Delete</a>
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