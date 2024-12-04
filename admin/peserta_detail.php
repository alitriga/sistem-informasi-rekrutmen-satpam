<?php
session_start();

// Memeriksa apakah pengguna sudah login dan memiliki role admin
if (!isset($_SESSION['idLogin']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php"); // Redirect ke halaman login jika belum login
    exit();
}

// Menghubungkan ke database
include '../config.php';

// Mendapatkan idDaftar dari parameter URL
$idDaftar = isset($_GET['idDaftar']) ? intval($_GET['idDaftar']) : 0;

if ($idDaftar <= 0) {
    die("Invalid ID");
}

// Query untuk mengambil data peserta berdasarkan idDaftar
$sql = "SELECT * FROM pendaftaran 
JOIN berkas ON berkas.idDaftar = pendaftaran.idDaftar 
JOIN bayar ON bayar.idBayar = pendaftaran.idDaftar 
-- JOIN paket ON paket.idPaket = bayar.idPaket
WHERE pendaftaran.idDaftar = ?";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("i", $idDaftar);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc(); // Fetch single row as associative array
    
    // Periksa apakah data ditemukan
    if (!$data) {
        die("Data tidak ditemukan untuk ID yang diberikan.");
    }
    
    $stmt->close();
} else {
    die("Error preparing statement: " . $conn->error);
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Peserta - PT. Nutrido Nusa Kampita</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="../asset/images/13.png" rel="icon">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container mt-4">
        <main>
            <h1 class="mb-4">Detail Peserta</h1>
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>NIK</th>
                                <td><?= ($data['nik']); ?></td>
                            </tr>
                            <tr>
                                <th>Nama</th>
                                <td><?= ($data['nama']); ?></td>
                            </tr>
                            <tr>
                                <th>Status Formulir</th>
                                <td>
                                    <?= ($data['statusDaftar']); ?>
                                    <button type="button" class="btn btn-sm btn-warning ml-2" data-toggle="modal" data-target="#editStatusModal">
                                        Edit
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <th>Status Berkas</th>
                                <td>
                                    <?= ($data['statusBerkas']); ?>
                                    <button type="button" class="btn btn-sm btn-warning ml-2" data-toggle="modal" data-target="#editBerkasStatusModal">
                                        Edit
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <th>Status Pembayaran</th>
                                <td>
                                    <?= htmlspecialchars($data['statusBayar']); ?>
                                    <button type="button" class="btn btn-sm btn-warning ml-2" data-toggle="modal" data-target="#editBayarStatusModal">
                                        Edit
                                    </button>
                                    <a href="cek_pembayaran.php?idDaftar=<?= urlencode($data['idDaftar']); ?>" class="btn btn-sm btn-primary ml-2"> Cek Pembayaran</a>
                                </td> 
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <td><?= htmlspecialchars($data['alamat']); ?></td>
                            </tr>
                            <tr>
                                <th>Kel.</th>
                                <td><?= htmlspecialchars($data['kel']); ?></td>
                            </tr>
                            <tr>
                                <th>Kec.</th>
                                <td><?= htmlspecialchars($data['kec']); ?></td>
                            </tr>
                            <tr>
                                <th>Kab/ Kota</th>
                                <td><?= htmlspecialchars($data['kabkota']); ?></td>
                            </tr>
                            <tr>
                                <th>Provinsi</th>
                                <td><?= htmlspecialchars($data['prov']); ?></td>
                            </tr>
                            <tr>
                                <th>Tempat Tanggal Lahir</th>
                                <td><?= htmlspecialchars($data['tLahir']).'/'.htmlspecialchars($data['tglLahir']); ?></td>
                            </tr>
                            <tr>
                                <th>Tangga Daftar</th>
                                <td><?= htmlspecialchars($data['tglDaftar']); ?></td>
                            </tr>
                            <tr>
                                <th>Foto</th>
                                <td><img src="<?= $data['foto']; ?>" alt="" class="img-fluid" width="150"></td>
                            </tr>
                            <tr>
                                <th>KTP</th>
                                <td><img src="<?= $data['ktp']; ?>" alt="" class="img-fluid" width="150"></td>
                            </tr>
                            <tr>
                                <th>SKCK</th>
                                <td><img src="<?= $data['skck']; ?>" alt="" class="img-fluid" width="150"></td>
                            </tr>
                            <tr>
                                <th>Surat Sehat</th>
                                <td><img src="<?= $data['sSehat']; ?>" alt="" class="img-fluid" width="150"></td>
                            </tr>
                        </tbody>
                    </table>
                    <a href="peserta.php" class="btn btn-primary">Kembali</a>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="editStatusModal" tabindex="-1" aria-labelledby="editStatusModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="update_status.php" method="post">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editStatusModalLabel">Edit Status Formulir</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="idDaftar" value="<?= htmlspecialchars($data['idDaftar']); ?>">
                                    <div class="form-group">
                                        <label for="statusDaftar">Status Formulir</label>
                                        <select id="statusDaftar" name="statusDaftar" class="form-control">
                                            <option value="dibuka" <?= $data['statusDaftar'] == 'dibuka' ? 'selected' : ''; ?>>Dibuka</option>
                                            <option value="proses" <?= $data['statusDaftar'] == 'proses' ? 'selected' : ''; ?>>Proses</option>
                                            <option value="lulus" <?= $data['statusDaftar'] == 'lulus' ? 'selected' : ''; ?>>lulus</option>
                                            <option value="gagal" <?= $data['statusDaftar'] == 'gagal' ? 'selected' : ''; ?>>Gagal</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
<!-- Modal for Editing Status Berkas -->
<div class="modal fade" id="editBerkasStatusModal" tabindex="-1" aria-labelledby="editBerkasStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="update_berkas_status.php" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="editBerkasStatusModalLabel">Edit Status Berkas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="idDaftar" value="<?= htmlspecialchars($data['idDaftar']); ?>">
                    <div class="form-group">
                        <label for="statusBerkas">Status Berkas</label>
                        <select id="statusBerkas" name="statusBerkas" class="form-control">
                            <option value="dibuka" <?= $data['statusBerkas'] == 'dibuka' ? 'selected' : ''; ?>>Dibuka</option>
                            <option value="proses" <?= $data['statusBerkas'] == 'proses' ? 'selected' : ''; ?>>Proses</option>
                            <option value="lulus" <?= $data['statusBerkas'] == 'lulus' ? 'selected' : ''; ?>>Lulus</option>
                            <option value="gagal" <?= $data['statusBerkas'] == 'gagal' ? 'selected' : ''; ?>>Gagal</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal for Editing Status Bayar -->
<div class="modal fade" id="editBayarStatusModal" tabindex="-1" aria-labelledby="editBayarStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="update_bayar_status.php" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="editBayarStatusModalLabel">Edit Status Pembayaran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="idDaftar" value="<?= htmlspecialchars($data['idDaftar']); ?>">
                    <div class="form-group">
                        <label for="statusBayar">Status Pembayaran</label>
                        <select id="statusBayar" name="statusBayar" class="form-control">
                            <option value="dibuka" <?= $data['statusBayar'] == 'dibuka' ? 'selected' : ''; ?>>dibuka</option>
                            <option value="proses" <?= $data['statusBayar'] == 'proses' ? 'selected' : ''; ?>>proses</option>
                            <option value="lulus" <?= $data['statusBayar'] == 'lulus' ? 'selected' : ''; ?>>lulus</option>
                            <option value="gagal" <?= $data['statusBayar'] == 'gagal' ? 'selected' : ''; ?>>gagal</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

            </div>
        </main>
    </div>
</body>
</html>
