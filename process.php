<?php
session_start();
require_once 'oraconn.php';

//Perintah untuk menambahkan data baru ke tabel PESANAN
if (isset($_POST['tambah'])){
    $kodelaundry = $_POST['jenis'];
    $berat = $_POST['berat'];
    $tglpesan = $_POST['tglpesan'];
    if ($tglpesan == NULL || $berat == NULL){
        if ($tglpesan == NULL)
            $_SESSION['message'] = "Tanggal pesan tidak boleh kosong!";
        else if ($berat == NULL)
            $_SESSION['message'] = "Berat tidak boleh kosong!";
        $_SESSION['kodelaundry'] = $kodelaundry;
        $_SESSION['berat'] = $berat;
        header("Location:tambah-pesanan.php");
        exit;
    }
    $sql = "INSERT INTO PESANAN (KODE_LAUNDRY, BERAT, TGL_PESAN) VALUES (:kodelaundry, :berat, TO_DATE(:tglpesan, 'YYYY-MM-DD'))";
    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ':kodelaundry', $kodelaundry);
    oci_bind_by_name($stmt, ':berat', $berat);
    oci_bind_by_name($stmt, ':tglpesan', $tglpesan);
    oci_execute($stmt);
    unset($_SESSION['kodelaundry'], $_SESSION['berat']);
    $_SESSION['message'] = "Berhasil menambahkan data!";
    $_SESSION['msg_type'] = "success";
}

//Perintah untuk menghapus data yang telah dipilih pada tabel PESANAN
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    $sql = "DELETE FROM PESANAN WHERE ID_PESANAN=:id";
    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ':id', $id);
    oci_execute($stmt);
    $_SESSION['message'] = "Berhasil menghapus data!";
    $_SESSION['msg_type'] = "warning";
}

//Perintah untuk mengedit data yang telah dipilih pada tabel PESANAN
if(isset($_POST['update'])){
    $id = $_POST['id'];
    $kodelaundry = $_POST['jenis'];
    $berat = $_POST['berat'];
    $tglpesan = $_POST['tglpesan'];
    $tglterima = $_POST['tglterima'];
    if ($tglpesan == NULL || ($tglterima != NULL && $tglterima < $tglpesan) || $berat == NULL){
        if($tglpesan == NULL)
            $_SESSION['message'] = "Tanggal pesan tidak boleh kosong!";
        else if ($berat == NULL)
            $_SESSION['message'] = "Berat tidak boleh kosong!";
        else if ($tglterima < $tglpesan)
            $_SESSION['message'] = "Tanggal terima harus setelah tanggal pesan!";
        header("Location:edit-pesanan.php?edit=$id");
        exit;
    }
    $sql = "UPDATE PESANAN SET KODE_LAUNDRY=:kodelaundry, BERAT=:berat, TGL_PESAN=TO_DATE(:tglpesan, 'YYYY-MM-DD'), TGL_TERIMA=TO_DATE(:tglterima, 'YYYY-MM-DD') WHERE ID_PESANAN=:id";
    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ':kodelaundry', $kodelaundry);
    oci_bind_by_name($stmt, ':berat', $berat);
    oci_bind_by_name($stmt, ':tglpesan', $tglpesan);
    oci_bind_by_name($stmt, ':tglterima', $tglterima);
    oci_bind_by_name($stmt, ':id', $id);
    oci_execute($stmt);
    $_SESSION['message'] = "Berhasil mengubah data!";
    $_SESSION['msg_type'] = "primary";
}

//Perintah untuk mengedit harga JENIS_LAUNDRY yang telah dipilih
if(isset($_POST['updateharga'])){
    $kode = $_POST['kode'];
    $harga = $_POST['harga'];
    if ($harga == NULL){
        $_SESSION['message'] = "Harga tidak boleh kosong!";
        header("Location:edit-harga.php?edit=$kode");
        exit;
    }
    $sql = "UPDATE JENIS_LAUNDRY SET harga=:harga WHERE KODE_LAUNDRY=:kode";
    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ':harga', $harga);
    oci_bind_by_name($stmt, ':kode', $kode);
    oci_execute($stmt);
    $_SESSION['message'] = "Berhasil mengubah harga!";
    $_SESSION['msg_type'] = "primary";
    header("Location:harga.php");
    exit;
}

header("Location:data-pesanan.php");
exit;
?>