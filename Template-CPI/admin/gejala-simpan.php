<?php
include '../assets/conn/config.php';
if (isset($_GET['aksi'])) {
    if ($_GET['aksi'] == 'simpan') {
        $nama_gejala = $_POST['nama_gejala'];
        $nilai_gejala = $_POST['nilai_gejala'];

        mysqli_query($conn, "INSERT INTO tbl_gejala (nama_gejala, nilai_gejala)VALUES
        ('$nama_gejala',  '$nilai_gejala')");
        header("location:gejala.php");
    }
}

include 'header.php';
?>

<div class="container">
    <div class="card shadow p-5 mb-5">
        <div class="card-header">
            <h5 class="m-0 font-weight-bold text-primary">Tambah Data</h5>
        </div>

        <div class="card-body">
            <form action="gejala-simpan.php?aksi=simpan" method="POST">
                <div class="form-group">
                    <label>Nama Gejala</label>
                    <input type="text" name="nama_gejala" class="form-control" placeholder="Masukkan Nama Gejala"
                        required>
                </div>
                <div class="form-group">
                    <label>Nilai Keyakinan</label>
                    <select name="nilai_gejala" class="form-control required">
                        <option selected disabled>Masukkan Tingkat Keyakinan</option>
                        <option value="0.1">Sangat Tidak Yakin (0.1)</option>
                        <option value="0.2">Kurang Yakin (0.2)</option>
                        <option value="0.3">Sedikit Yakin (0.3)</option>
                        <option value="0.4">Cukup Yakin (0.4)</option>
                        <option value="0.5">Setengah Yakin (0.5)</option>
                        <option value="0.6">Cukup Percaya (0.6)</option>
                        <option value="0.7">Yakin (0.7)</option>
                        <option value="0.8">Sangat Yakin (0.8)</option>
                        <option value="0.9">Hampir Pasti (0.9)</option>
                    </select>
                </div>
                <a href="gejala.php" class="btn btn-secondary mb-2">Batal</a>
                <input type="submit" value="Simpan" class="btn btn-primary mb-2">
            </form>
        </div>
    </div>
</div>

<?php
include 'footer.php';
?>