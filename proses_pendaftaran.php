<?php

include_once 'Connection.php';

if (isset($_POST['submit'])) {

    // ==========================================
    // 1. MAKLUMAT ANAK
    // ==========================================
    $nama_anak = $_POST['nama_anak'];
    $tarikh_lahir = $_POST['tarikh_lahir'];
    $umur = $_POST['umur'];
    $jantina = $_POST['jantina'];
    $alamat = $_POST['alamat'];
    $kesihatan = $_POST['kesihatan'];

    // ==========================================
    // 2. MAKLUMAT BAPA / PENJAGA
    // ==========================================
    $nama_bapa = $_POST['nama_bapa'];
    $ic_bapa = $_POST['ic_bapa'];
    $tel_bapa = $_POST['tel_bapa'];
    $kerja_bapa = $_POST['kerja_bapa'];

    // ==========================================
    // 3. MAKLUMAT IBU / PENJAGA
    // ==========================================
    $nama_ibu = $_POST['nama_ibu'];
    $ic_ibu = $_POST['ic_ibu'];
    $tel_ibu = $_POST['tel_ibu'];
    $kerja_ibu = $_POST['kerja_ibu'];

    // ==========================================
    // 4. PILIHAN TEMPAT & WAKTU
    // ==========================================
    $pusat = $_POST['pusat'];
    $tempoh = $_POST['tempoh'];

    // ==========================================
    // INSERT DATABASE
    // ==========================================
    $sql = "INSERT INTO pendaftaran_taska
    (
        nama_anak,
        tarikh_lahir,
        umur,
        jantina,
        alamat,
        kesihatan,
        nama_bapa,
        ic_bapa,
        tel_bapa,
        kerja_bapa,
        nama_ibu,
        ic_ibu,
        tel_ibu,
        kerja_ibu,
        pusat,
        tempoh
    )
    VALUES
    (
        '$nama_anak',
        '$tarikh_lahir',
        '$umur',
        '$jantina',
        '$alamat',
        '$kesihatan',
        '$nama_bapa',
        '$ic_bapa',
        '$tel_bapa',
        '$kerja_bapa',
        '$nama_ibu',
        '$ic_ibu',
        '$tel_ibu',
        '$kerja_ibu',
        '$pusat',
        '$tempoh'
    )";

    if (mysqli_query($conn, $sql)) {

        echo '<script>
                alert("Pendaftaran TASKA Cerdik telah berjaya dihantar!");
                window.location.href = "pendaftaran.html";
              </script>';

        exit;

    } else {

        echo "Error: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}

?>