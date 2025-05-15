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

$nidn = $nama = $gelar_belakang = $gelar_depan = $jenis_kelamin = $tempat_lahir = $tanggal_lahir = $alamat = $email = $tahun_masuk = $prodi_id = "";
$sukses = $error = "";

$op = isset($_GET['op']) ? $_GET['op'] : "";

if ($op == 'delete') {
    $id = $_GET['id'];
    $sql1 = "DELETE FROM dosen WHERE id = '$id'";
    $q1 = mysqli_query($koneksi, $sql1);
    $sukses = $q1 ? "Berhasil hapus data" : "Gagal melakukan delete data";
}

if ($op == 'edit') {
    $id = $_GET['id'];
    $sql1 = "SELECT * FROM dosen WHERE id = '$id'";
    $q1 = mysqli_query($koneksi, $sql1);
    $r1 = mysqli_fetch_array($q1);
    extract($r1);
}

if (isset($_POST['simpan'])) {
    $nidn = $_POST['nidn'];
    $nama = $_POST['nama'];
    $gelar_belakang = $_POST['gelar_belakang'];
    $gelar_depan = $_POST['gelar_depan'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $tempat_lahir = $_POST['tempat_lahir'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $alamat = $_POST['alamat'];
    $email = $_POST['email'];
    $tahun_masuk = $_POST['tahun_masuk'];
    $prodi_id = $_POST['prodi_id'];

    if ($nidn && $nama && $jenis_kelamin && $tempat_lahir && $tanggal_lahir && $alamat && $email && $tahun_masuk && $prodi_id) {
        if ($op == 'edit') {
            $sql1 = "UPDATE dosen SET nidn='$nidn', nama='$nama', gelar_belakang='$gelar_belakang', gelar_depan='$gelar_depan', jenis_kelamin='$jenis_kelamin', tempat_lahir='$tempat_lahir', tanggal_lahir='$tanggal_lahir', alamat='$alamat', email='$email', tahun_masuk='$tahun_masuk', prodi_id='$prodi_id' WHERE id='$id'";
        } else {
            $sql1 = "INSERT INTO dosen (nidn, nama, gelar_belakang, gelar_depan, jenis_kelamin, tempat_lahir, tanggal_lahir, alamat, email, tahun_masuk, prodi_id) VALUES ('$nidn','$nama','$gelar_belakang','$gelar_depan','$jenis_kelamin','$tempat_lahir','$tanggal_lahir','$alamat','$email','$tahun_masuk','$prodi_id')";
        }
        $q1 = mysqli_query($koneksi, $sql1);
        $sukses = $q1 ? ($op == 'edit' ? "Data berhasil diupdate" : "Berhasil memasukkan data baru") : "Gagal melakukan operasi";
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

        .card {
            margin-top: 5px
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class='content-wrapper'>
            <div class='card ml-5 mr-5 mt-3'>
                <div class='card-header bg-primary text-white'>Form Dosen</div>
                <div class='card-body'>
                    <?php if ($error)
                        echo "<div class='alert alert-danger'>$error</div>"; ?>
                    <?php if ($sukses)
                        echo "<div class='alert alert-success'>$sukses</div>"; ?>
                    <form method='POST'>
                        <div class='mb-3'><label>NIDN</label><input type='text' name='nidn' class='form-control'
                                value='<?= $nidn ?>'></div>
                        <div class='mb-3'><label>Nama</label><input type='text' name='nama' class='form-control'
                                value='<?= $nama ?>'></div>
                        <div class='mb-3'><label>Gelar Depan</label><input type='text' name='gelar_depan'
                                class='form-control' value='<?= $gelar_depan ?>'></div>
                        <div class='mb-3'><label>Gelar Belakang</label><input type='text' name='gelar_belakang'
                                class='form-control' value='<?= $gelar_belakang ?>'></div>
                        <div class='mb-3'><label>Jenis Kelamin</label>
                            <select name='jenis_kelamin' class='form-control'>
                                <option value=''>- Pilih -</option>
                                <option value='L' <?= ($jenis_kelamin == 'L') ? 'selected' : '' ?>>Laki-laki</option>
                                <option value='P' <?= ($jenis_kelamin == 'P') ? 'selected' : '' ?>>Perempuan</option>
                            </select>
                        </div>
                        <div class='mb-3'><label>Tempat Lahir</label><input type='text' name='tempat_lahir'
                                class='form-control' value='<?= $tempat_lahir ?>'></div>
                        <div class='mb-3'><label>Tanggal Lahir</label><input type='date' name='tanggal_lahir'
                                class='form-control' value='<?= $tanggal_lahir ?>'></div>
                        <div class='mb-3'><label>Alamat</label><input type='text' name='alamat' class='form-control'
                                value='<?= $alamat ?>'></div>
                        <div class='mb-3'><label>Email</label><input type='email' name='email' class='form-control'
                                value='<?= $email ?>'></div>
                        <div class='mb-3'><label>Tahun Masuk</label><input type='number' name='tahun_masuk'
                                class='form-control' value='<?= $tahun_masuk ?>'></div>
                        <div class='mb-3'><label>Program Studi</label>
                            <select name='prodi_id' class='form-control'>
                                <option value=''>- Pilih Prodi -</option>
                                <?php
                                $prodi = mysqli_query($koneksi, "SELECT * FROM prodi");
                                while ($row = mysqli_fetch_array($prodi)) {
                                    echo "<option value='{$row['id']}' " . ($row['id'] == $prodi_id ? 'selected' : '') . ">{$row['nama']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class='mb-3'><input type='submit' name='simpan' value='Simpan Data'
                                class='btn btn-primary'>
                        </div>
                    </form>
                </div>
            </div>

            <div class='card ml-2 mr-2 '>
                <div class='card-header bg-secondary text-white'>Data Dosen</div>
                <div class='card-body'>
                    <table class='table'>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>NIDN</th>
                                <th>Nama</th>
                                <th>Gelar</th>
                                <th>JK</th>
                                <th>Tmpt/Tgl.Lahir</th>
                                <th>Email</th>
                                <th>Prodi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql2 = "SELECT dosen.*, prodi.nama AS nama_prodi FROM dosen LEFT JOIN prodi ON dosen.prodi_id = prodi.id ORDER BY dosen.id DESC";
                            $q2 = mysqli_query($koneksi, $sql2);
                            $urut = 1;
                            while ($r2 = mysqli_fetch_array($q2)) {
                                echo "<tr>
                        <td>{$urut}</td>
                        <td>{$r2['nidn']}</td>
                        <td>{$r2['nama']}</td>
                        <td>{$r2['gelar_depan']} {$r2['gelar_belakang']}</td>
                        <td>{$r2['jenis_kelamin']}</td>
                        <td>{$r2['tempat_lahir']}, {$r2['tanggal_lahir']}</td>
                        <td>{$r2['email']}</td>
                        <td>{$r2['nama_prodi']}</td>
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