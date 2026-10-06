<?php

session_start();

if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: admin_login.php");
    exit;
}

include_once 'Connection.php';

// Ambil pendaftaran yang berstatus 'Diterima' sahaja
$sql = "SELECT * FROM pendaftaran_taska WHERE status = 'Diterima' ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
$jumlah_diterima = mysqli_num_rows($result);

?>

<!DOCTYPE html>
<html lang="ms">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Senarai Diterima | TASKA CERDIK</title>

    <style>

        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f8fb;
            color: #333;
        }

        header {
            background: #2c7a7b;
            color: white;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        header h2 {
            margin: 0;
            font-size: 1.5rem;
        }

        .btn-kembali {
            background: #4a5568;
            color: white;
            text-decoration: none;
            padding: 10px 18px;
            border-radius: 8px;
            font-weight: bold;
            transition: background 0.2s ease;
        }

        .btn-kembali:hover {
            background: #2d3748;
        }

        .container {
            padding: 30px;
            max-width: 1000px;
            margin: 0 auto;
        }

        .summary-card {
            background: white;
            border-left: 5px solid #2c7a7b;
            padding: 15px 25px;
            border-radius: 10px;
            margin-bottom: 25px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            font-size: 1.1rem;
            font-weight: 600;
        }

        .summary-card span {
            color: #2c7a7b;
            font-size: 1.3rem;
        }

        .table-box {
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #2c7a7b;
            color: white;
            padding: 14px 15px;
            text-align: left;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        td {
            padding: 14px 15px;
            border-bottom: 1px solid #edf2f7;
            font-size: 0.95rem;
            vertical-align: middle;
        }

        tr:hover {
            background: #f8fafc;
        }

    </style>

</head>

<body>

<header>

    <h2>✅ SENARAI PENDAFTARAN DITERIMA</h2>

    <a href="admin.php" class="btn-kembali">
        ⬅ Kembali ke Admin
    </a>

</header>

<div class="container">

    <div class="summary-card">
        📊 Jumlah Keseluruhan Budak Diterima: <span><?php echo $jumlah_diterima; ?> Orang</span>
    </div>

    <div class="table-box">

        <table>

            <tr>
                <th>ID</th>
                <th>Nama Anak</th>
                <th>Umur</th>
                <th>Jantina</th>
                <th>Tempoh</th>
            </tr>

            <?php

            if ($jumlah_diterima > 0) {

                while ($row = mysqli_fetch_assoc($result)) {

            ?>

            <tr>

                <td><?php echo $row['id']; ?></td>

                <td><strong><?php echo htmlspecialchars($row['nama_anak']); ?></strong></td>

                <td><?php echo htmlspecialchars($row['umur']); ?></td>

                <td><?php echo htmlspecialchars($row['jantina']); ?></td>

                <td><strong><?php echo htmlspecialchars($row['tempoh']); ?></strong></td>

            </tr>

            <?php

                }

            } else {

                echo "<tr><td colspan='5' style='text-align:center;'>Tiada rekod anak yang diterima lagi.</td></tr>";

            }

            ?>

        </table>

    </div>

</div>

</body>
</html>