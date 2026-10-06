<?php

session_start();

if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: admin_login.php");
    exit;
}

include_once 'Connection.php';

// Proses kemas kini status jika butang Terima / Tolak ditekan
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $action = $_GET['action'];

    if ($action === 'terima') {
        $status = 'Diterima';
    } elseif ($action === 'tolak') {
        $status = 'Ditolak';
    }

    if (isset($status)) {
        $stmt = mysqli_prepare($conn, "UPDATE pendaftaran_taska SET status = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "si", $status, $id);
        mysqli_stmt_execute($stmt);
        
        // Redirect semula untuk bersihkan query string
        header("Location: admin.php");
        exit;
    }
}

$sql = "SELECT * FROM pendaftaran_taska ORDER BY id DESC";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="ms">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin | TASKA CERDIK</title>

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

        .header-nav {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .btn-pekerja-page {
            background: #3182ce;
            color: white;
            text-decoration: none;
            padding: 10px 18px;
            border-radius: 8px;
            font-weight: bold;
            transition: background 0.2s ease, transform 0.2s ease;
            box-shadow: 0 2px 5px rgba(0,0,0,0.15);
        }

        .btn-pekerja-page:hover {
            background: #2b6cb0;
            transform: translateY(-1px);
        }

        .btn-diterima-page {
            background: #2e7d32;
            color: white;
            text-decoration: none;
            padding: 10px 18px;
            border-radius: 8px;
            font-weight: bold;
            transition: background 0.2s ease, transform 0.2s ease;
            box-shadow: 0 2px 5px rgba(0,0,0,0.15);
        }

        .btn-diterima-page:hover {
            background: #1b5e20;
            transform: translateY(-1px);
        }

        .logout {
            background: #e74c3c;
            color: white;
            text-decoration: none;
            padding: 10px 18px;
            border-radius: 8px;
            font-weight: bold;
            transition: background 0.2s ease;
        }

        .logout:hover {
            background: #c0392b;
        }

        .container {
            padding: 30px;
        }

        .table-box {
            background: white;
            padding: 20px;
            border-radius: 15px;
            overflow-x: auto;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 1300px;
        }

        th {
            background: #2c7a7b;
            color: white;
            padding: 14px 10px;
            text-align: left;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        td {
            padding: 12px 10px;
            border-bottom: 1px solid #edf2f7;
            font-size: 0.95rem;
            vertical-align: middle;
        }

        tr:hover {
            background: #f8fafc;
        }

        /* Gaya khas untuk butang tindakan & badge status */
        .action-cell {
            white-space: nowrap;
            text-align: center;
        }

        .action-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 14px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.85rem;
            transition: all 0.2s ease;
            box-shadow: 0 2px 5px rgba(0,0,0,0.08);
        }

        .btn-terima {
            background-color: #2e7d32;
            color: white;
            border: 1px solid #2e7d32;
        }

        .btn-terima:hover {
            background-color: #1b5e20;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(46,125,50,0.25);
        }

        .btn-tolak {
            background-color: #d32f2f;
            color: white;
            border: 1px solid #d32f2f;
        }

        .btn-tolak:hover {
            background-color: #b71c1c;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(211,47,47,0.25);
        }

        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 0.85rem;
        }

        .status-diterima {
            background-color: #e8f5e9;
            color: #2e7d32;
            border: 1px solid #a5d6a7;
        }

        .status-ditolak {
            background-color: #ffebee;
            color: #c62828;
            border: 1px solid #ef9a9a;
        }

        .status-pending {
            background-color: #fff8e1;
            color: #f57f17;
            border: 1px solid #ffe082;
        }

    </style>

</head>

<body>

<header>

    <h2>🔐 ADMIN PANEL - TASKA CERDIK</h2>

    <div class="header-nav">
        <a href="senarai_pekerja.php" class="btn-pekerja-page">
            👩‍🏫 Senarai Pekerja
        </a>
        <a href="senarai_diterima.php" class="btn-diterima-page">
            ✅ Senarai Diterima
        </a>
        <a href="logout.php" class="logout">
            🚪 Log Keluar
        </a>
    </div>

</header>

<div class="container">

    <h2>📋 Senarai Pendaftaran</h2>

    <div class="table-box">

        <table>

            <tr>
                <th>ID</th>
                <th>Nama Anak</th>
                <th>Tarikh Lahir</th>
                <th>Umur</th>
                <th>Jantina</th>
                <th>Alamat</th>
                <th>Nama Bapa</th>
                <th>Telefon Bapa</th>
                <th>Nama Ibu</th>
                <th>Telefon Ibu</th>
                <th>Pusat</th>
                <th>Tempoh</th>
                <th style="text-align: center;">Tindakan / Status</th>
            </tr>

            <?php

            if (mysqli_num_rows($result) > 0) {

                while ($row = mysqli_fetch_assoc($result)) {
                    // Semak status semasa dari pangkalan data (default kepada 'Pending' jika tiada lajur status lagi)
                    $current_status = isset($row['status']) ? $row['status'] : 'Pending';
            ?>

            <tr>

                <td><?php echo $row['id']; ?></td>

                <td><?php echo htmlspecialchars($row['nama_anak']); ?></td>

                <td><?php echo $row['tarikh_lahir']; ?></td>

                <td><?php echo htmlspecialchars($row['umur']); ?></td>

                <td><?php echo htmlspecialchars($row['jantina']); ?></td>

                <td><?php echo htmlspecialchars($row['alamat']); ?></td>

                <td><?php echo htmlspecialchars($row['nama_bapa']); ?></td>

                <td><?php echo htmlspecialchars($row['tel_bapa']); ?></td>

                <td><?php echo htmlspecialchars($row['nama_ibu']); ?></td>

                <td><?php echo htmlspecialchars($row['tel_ibu']); ?></td>

                <td><?php echo htmlspecialchars($row['pusat']); ?></td>

                <td><?php echo htmlspecialchars($row['tempoh']); ?></td>

                <td class="action-cell">
                    <?php if ($current_status === 'Diterima'): ?>
                        <span class="status-badge status-diterima">✓ Diterima</span>
                    <?php elseif ($current_status === 'Ditolak'): ?>
                        <span class="status-badge status-ditolak">✕ Ditolak</span>
                    <?php else: ?>
                        <a href="admin.php?action=terima&id=<?php echo $row['id']; ?>" class="action-btn btn-terima" onclick="return confirm('Adakah anda pasti mahu MENERIMA pendaftaran ini?');">
                            ✓ Terima
                        </a>
                        <a href="admin.php?action=tolak&id=<?php echo $row['id']; ?>" class="action-btn btn-tolak" onclick="return confirm('Adakah anda pasti mahu MENOLAK pendaftaran ini?');">
                            ✕ Tolak
                        </a>
                    <?php endif; ?>
                </td>

            </tr>

            <?php

                }

            } else {

                echo "<tr><td colspan='13' style='text-align:center;'>Tiada pendaftaran lagi.</td></tr>";

            }

            ?>

        </table>

    </div>

</div>

</body>
</html>