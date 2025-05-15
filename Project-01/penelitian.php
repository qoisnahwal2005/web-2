<?php

include_once 'layout/header.php';
include_once 'layout/sidebar.php';

$host = "localhost";
$user = "root";
$pass = "";
$db = "dbkegiatan_dosen";
$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi)
    die("Tidak bisa terkoneksi ke database");

$judul = $mulai = $akhir = $tahun_ajaran = $bidang_ilmu_id = "";
$sukses = $error = "";

if (isset($_GET['op']))
    $op = $_GET['op'];
else
    $op = "";

if ($op == 'delete') {
    $id = $_GET['id'];
    mysqli_query($koneksi, "DELETE FROM tim_penelitian WHERE penelitian_id = '$id'");
    $q1 = mysqli_query($koneksi, "DELETE FROM penelitian WHERE id = '$id'");
    $sukses = $q1 ? "Berhasil hapus data" : "Gagal menghapus data";
}

if ($op == 'edit') {
    $id = $_GET['id'];
    $q1 = mysqli_query($koneksi, "SELECT * FROM penelitian WHERE id='$id'");
    $r1 = mysqli_fetch_array($q1);
    extract($r1);

    // Ambil tim penelitian yang terkait
    $q_tim = mysqli_query($koneksi, "SELECT * FROM tim_penelitian WHERE penelitian_id = '$id'");
    $tim_penelitian = [];
    while ($row = mysqli_fetch_array($q_tim)) {
        $tim_penelitian[] = $row;
    }
}

if (isset($_POST['simpan'])) {
    $judul = $_POST['judul'];
    $mulai = $_POST['mulai'];
    $akhir = $_POST['akhir'];
    $tahun_ajaran = $_POST['tahun_ajaran'];
    $bidang_ilmu_id = $_POST['bidang_ilmu_id'];
    $dosen_ids = $_POST['dosen_id'];
    $peran_dosen = $_POST['peran'];

    if ($judul && $mulai && $akhir && $tahun_ajaran && $bidang_ilmu_id) {
        if ($op == 'edit') {
            $sql1 = "UPDATE penelitian SET judul='$judul', mulai='$mulai', akhir='$akhir', tahun_ajaran='$tahun_ajaran', bidang_ilmu_id='$bidang_ilmu_id' WHERE id='$id'";
        } else {
            $sql1 = "INSERT INTO penelitian (judul, mulai, akhir, tahun_ajaran, bidang_ilmu_id) VALUES ('$judul', '$mulai', '$akhir', '$tahun_ajaran', '$bidang_ilmu_id')";
        }

        $q1 = mysqli_query($koneksi, $sql1);
        if ($q1) {
            $penelitian_id = ($op == 'edit') ? $id : mysqli_insert_id($koneksi);
            mysqli_query($koneksi, "DELETE FROM tim_penelitian WHERE penelitian_id = '$penelitian_id'");

            foreach ($dosen_ids as $i => $dosen_id) {
                $peran = mysqli_real_escape_string($koneksi, $peran_dosen[$i]);
                mysqli_query($koneksi, "INSERT INTO tim_penelitian (dosen_id, penelitian_id, peran) VALUES ('$dosen_id', '$penelitian_id', '$peran')");
            }

            $sukses = "Berhasil menyimpan data";
        } else {
            $error = "Gagal menyimpan data";
        }
    } else {
        $error = "Harap isi semua data";
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
            width: 880px
        }

        .card {
            margin-top: 10px
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class='content-wrapper'>
            <div class='card ml-5 mr-5 mt-3'>
                <div class='card-header bg-success text-white'>Form Penelitian</div>
                <div class='card-body'>
                    <?php if ($error)
                        echo "<div class='alert alert-danger'>$error</div>"; ?>
                    <?php if ($sukses) {
                        echo "<div class='alert alert-success'>$sukses</div>";
                        header("refresh:2;url=penelitian.php");
                    } ?>
                    <form method='POST'>
                        <div class='mb-3'><label>Judul</label><textarea name='judul'
                                class='form-control'><?= $judul ?></textarea></div>
                        <div class='mb-3'><label>Mulai</label><input type='date' name='mulai' class='form-control'
                                value='<?= $mulai ?>'></div>
                        <div class='mb-3'><label>Akhir</label><input type='date' name='akhir' class='form-control'
                                value='<?= $akhir ?>'></div>
                        <div class='mb-3'><label>Tahun Ajaran</label><input type='text' name='tahun_ajaran'
                                class='form-control' value='<?= $tahun_ajaran ?>'></div>
                        <div class='mb-3'><label>Bidang Ilmu</label>
                            <select name='bidang_ilmu_id' class='form-control'>
                                <?php
                                $q_bi = mysqli_query($koneksi, "SELECT * FROM bidang_ilmu");
                                while ($r = mysqli_fetch_array($q_bi)) {
                                    $selected = ($r['id'] == $bidang_ilmu_id) ? "selected" : "";
                                    echo "<option value='{$r['id']}' $selected>{$r['nama']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class='mb-3'><label>Tim Peneliti</label>
                            <div id='tim-penelitian'>
                                <?php
                                $q_dosen = mysqli_query($koneksi, "SELECT * FROM dosen");
                                $all_dosen = [];
                                while ($d = mysqli_fetch_array($q_dosen)) {
                                    $all_dosen[] = $d;
                                }

                                $jumlah = isset($tim_penelitian) ? count($tim_penelitian) : 1;
                                for ($i = 0; $i < $jumlah; $i++) {
                                    $selected_dosen = $tim_penelitian[$i]['dosen_id'] ?? '';
                                    $peran = $tim_penelitian[$i]['peran'] ?? '';
                                    echo "<div class='d-flex mb-2'>
        <select name='dosen_id[]' class='form-control me-2'>";
                                    foreach ($all_dosen as $dosen) {
                                        $sel = ($dosen['id'] == $selected_dosen) ? "selected" : "";
                                        echo "<option value='{$dosen['id']}' $sel>{$dosen['nama']}</option>";
                                    }
                                    echo "</select>
        <input type='text' name='peran[]' class='form-control' placeholder='Peran' value='$peran'>
    </div>";
                                }
                                ?>
                            </div>
                        </div>
                        <div class='mb-3'><input type='submit' name='simpan' value='Simpan Data'
                                class='btn btn-success'>
                        </div>
                    </form>
                </div>
            </div>

            <div class='card mr-2 ml-2'>
                <div class='card-header bg-dark text-white'>Data Penelitian</div>
                <div class='card-body'>
                    <table class='table'>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Judul</th>
                                <th>Mulai</th>
                                <th>Akhir</th>
                                <th>Bidang Ilmu</th>
                                <th>Tim</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $q2 = mysqli_query($koneksi, "SELECT p.*, b.nama as bidang FROM penelitian p JOIN bidang_ilmu b ON p.bidang_ilmu_id = b.id ORDER BY p.id DESC");
                            $urut = 1;
                            while ($r2 = mysqli_fetch_array($q2)) {
                                echo "<tr><td>{$urut}</td>
    <td>{$r2['judul']}</td>
    <td>{$r2['mulai']}</td>
    <td>{$r2['akhir']}</td>
    <td>{$r2['bidang']}</td>
    <td>";
                                $q_tim = mysqli_query($koneksi, "SELECT d.nama, t.peran FROM tim_penelitian t JOIN dosen d ON t.dosen_id = d.id WHERE t.penelitian_id = '{$r2['id']}'");
                                while ($tim = mysqli_fetch_array($q_tim)) {
                                    echo "<div>{$tim['nama']} - <i>{$tim['peran']}</i></div>";
                                }
                                echo "</td>
    <td>
        <a href='?op=edit&id={$r2['id']}' class='btn btn-warning btn-sm'>Edit</a>
        <a href='?op=delete&id={$r2['id']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Hapus data?')\">Delete</a>
    </td></tr>";
                                $urut++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php include "layout/footer.php"; ?>
</body>

</html>