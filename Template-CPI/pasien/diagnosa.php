<?php
date_default_timezone_set('Asia/Jakarta');
include '../assets/conn/config.php';

function generateRandomString ($Length = 10) {
    //untuk membuat nomor regdiagnosa
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $Length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
$panjangString = 10;
if (isset($_GET['aksi'])) {
    if ($_GET['aksi'] == 'diagnosa') {
        $no_regdiagnosa = generateRandomString($panjangString);
        $tgl_diagnosa = date('Y-m-d');
        $id_admin = $_POST['id_admin'];

        $query = mysqli_query($conn, "INSERT INTO tbl_diagnosa (no_regdiagnosa, tgl_diagnosa, id_admin, Id_gejala, nilai_pasien) 
        VALUES (?, ?, ?, ?, ?)") or die(mysqli_error($conn));
        
        if ($stmt = mysqli_prepare($conn, $query)) {
            mysqli_stmt_bind_param($stmt, "ssiss", $no_regdiagnosa, $tgl_diagnosa, 
            $id_admin, $id_gejala, $kondisi);

            foreach ($_POST['kondisi'] as $key =>$value){
                $kondisi =$value;
                $id_gejala = $_POST ['id_gejaala'][$key];
                mysqli_stmt_execute($stmt);
            }

            mysqli_close($conn);
            header("loaction:diagnosa?no_regdiagnosa=$no_regdiagnosa");
            exit();
        }
    }
}
include 'header.php';
$username = $_SESSION['username'];
$pass = mysqli_query($conn, "SELECT * FROM tbl_admin WHERE username='$username'");
$P = mysqli_fetch_array($pass);
$id_admin = $P['id_admin'];
?>

<div class="container">
    <div class="card shadow p-5 mb-5">
        <div class="card-header">
            <h5 class="m-0 font-weight-bold text-primary">Diagnosa</h5>
        </div>
        <div class="card-body">
            <form action="diagnosa.php?aksi=diagnosa" method="post">
                <table class="table table-bordered">
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Gejala</th>
                            <th class="text-center">Pilih</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $data = mysqli_query($conn, "SELECT * FROM tbl_gejala ORDER BY id_gejala");
                        $i = 0;
                        while ($a = mysqli_fetch_array($data)) {
                            $i++;
                            echo "
                            <tr>
                                <td class='text-center'>$i</td>
                                <td class='text-justify'>Apakah anda mengalami gejala
                                <b>{$a['nama_gejala']}?</b></td>

                                <td>
                                <select class='form-control' name='kondisi[]'>
                                    <option selected disabled>Pilih Kondisi</option>
                                    <option value='0.8'>Yakin</option>
                                    <option value='0.6'>Cukup Yakin</option>
                                    <option value='0.4'>Kurang Yakin</option>
                                    <option value='0.2'>Tidak Yakin</option>
                                    <option value='0'>Sangat Tidak Yakin</option>
                                </select>
                                </td>
                            </tr>
                            <input type='hidden' name='id_gejala[]' value='{$a['id_gejala']}'>
                            ";
                        }
                        ?>
                    </tbody>
                </table>
                <input type="hidden" name="id_admin" value="<?= $id_admin ?>">
                <a href="index.php" class="btn btn-secondary mb-2">Batal</a>
                <input type="submit" value="Proses Diagnosa" class="btn btn-primary mb-2">
            </form>
        </div>
    </div>
</div>

<?php
include 'footer.php';
?>