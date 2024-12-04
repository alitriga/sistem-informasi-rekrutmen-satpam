<?php
session_start();
include '../config.php';

if (!isset($_SESSION['idLogin']) || $_SESSION['role'] != 'peserta') {
    http_response_code(403);
    exit();
}

$idLogin = $_SESSION['idLogin'];
$sql = "SELECT bayar.*, paket.nmPaket, paket.harga, pendaftaran.tglDaftar, pendaftaran.nama 
        FROM bayar 
        JOIN paket ON paket.idPaket = bayar.idPaket
        JOIN pendaftaran ON pendaftaran.idDaftar = bayar.idDaftar
        WHERE idBayar = ?";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("i", $idLogin);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc(); // Mengambil baris pertama dari hasil query
    $stmt->close();
} else {
    http_response_code(500);
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Pembayaran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 600px;
            margin: 0 auto;
            border: 1px solid #000;
            padding: 20px;
        }
        .header, .footer {
            text-align: center;
        }
        .header img {
            width: 50px;
            height: 50px;
        }
        .header, .info, .details, .footer {
            margin-bottom: 20px;
        }
        .info table, .details table {
            width: 100%;
            border-collapse: collapse;
        }
        .info td, .details td, .details th {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        .details th {
            background-color: #f2f2f2;
        }
        .info td:first-child {
            width: 30%;
        }
        .footer {
            font-size: 12px;
        }
    </style>
</head>
<body onload="window.print()">
    <div class="container">
        <div class="header">
            <img src="../assets/img/13.png" alt="Logo">
            <h2>PT. NUTRIDO NUSA KAMPITA</h2>
            <p>NUTRIDO SECURITY GUARD SERVICE & TRAINING<br>
               Jl. Bandar Purus No.15 Padang (samping Pasca Sarjana UNES)</p>
            <h3>Bukti Pembayaran</h3>
            <p>Payment Receipt</p>
        </div>
        <div class="info">
            <table>
                <tr>
                    <td>No. Register</td>
                    <td><?= htmlspecialchars($data['idBayar']); ?></td>
                </tr>
                <tr>
                    <td>Tanggal Pendaftaran</td>
                    <td><?= htmlspecialchars($data['tglDaftar']); ?></td>
                </tr>
                <tr>
                    <td>Nama</td>
                    <td><?= htmlspecialchars($data['nama']); ?></td>
                </tr>
            </table>
        </div>
        <div class="info">
            <table>
                <tr>
                    <td>Tanggal Pembayaran</td>
                    <td><?= htmlspecialchars($data['tglBayar']); ?></td>
                </tr>
                <tr>
                    <td>Metode Pembayaran</td>
                    <td><?= htmlspecialchars($data['metode']); ?></td>
                </tr>
                <tr>
                    <td>Total Pembayaran</td>
                    <td>Rp. <?= number_format($data['harga'], 0, ',', '.'); ?></td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td><?= htmlspecialchars($data['statusBayar']); ?></td>
                </tr>
            </table>
        </div>
        <div class="details">
            <table>
                <thead>
                    <tr>
                        <th>Keterangan</th>
                        <th>Jumlah</th>
                        <th>Satuan</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?= htmlspecialchars($data['nmPaket']); ?></td>
                        <td>1</td>
                        <td>Rp. <?= number_format($data['harga'], 0, ',', '.'); ?></td>
                        <td>Rp. <?= number_format($data['harga'], 0, ',', '.'); ?></td>
                    </tr>
                    <tr>
                        <td colspan="3"><strong>Total Dibayar</strong></td>
                        <td><strong>Rp. <?= number_format($data['harga'], 0, ',', '.'); ?></strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="footer">
            <p>Padang, <?= date('d/m/Y'); ?></p>
            <p>Hormat Kami</p><br><br><br>
            <p>PT. Nutrido Nusa Kampita</p>
            <i>Terima kasih telah mendaftar Diklat Satpam di PT. Nutrido Nusa Kampita<br>
               Dokumen ini adalah bukti pembayaran resmi yang diterbitkan secara elektronik oleh sistem PT. Nutrido Nusa Kampita</i>
            <p>PT. Nutrido Nusa Kampita<br>
               CUSTOMER CARE 0751 4670 014<br>
               0878 9599 0005</p>
        </div>
    </div>
</body>
</html>
