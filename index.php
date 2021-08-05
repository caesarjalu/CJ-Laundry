<?php
session_start();
require_once 'oraconn.php';
$sql = "SELECT SUM(TOTAL) AS SUM_TOTAL, SUM(BERAT) AS SUM_BERAT, COUNT(ID_PESANAN) AS COUNT_PESANAN FROM VIEW_PESANAN";
$stmt = oci_parse($conn, $sql);
oci_execute($stmt);
$row = oci_fetch_object($stmt);
$sumtotal = $row->SUM_TOTAL;
$sumberat = $row->SUM_BERAT;
$countpesanan = $row->COUNT_PESANAN;
$sql = "SELECT COUNT(ID_PESANAN) AS COUNT_KOSONG FROM VIEW_PESANAN WHERE TGL_TERIMA IS NULL";
$stmt = oci_parse($conn, $sql);
oci_execute($stmt);
$row = oci_fetch_object($stmt);
$countkosong = $row->COUNT_KOSONG;
?>

<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:ital,wght@0,200;0,300;0,400;0,600;0,700;0,900;1,200;1,300;1,400;1,600;1,700;1,900&display=swap" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="assets/css/style.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <script src="https://kit.fontawesome.com/f28a88fe23.js" crossorigin="anonymous"></script>

        <style>
            .dashboard-box{
                background-color: aliceblue;
                transition: 0.1s;
            }
            .dashboard-box:hover{
                background-color: lightcyan;
            }
        </style>

        <title>CJ Laundry</title>
    </head>
    <body>
        <div class="vertical-nav bg-info" id="sidebar">
            <div class="py-4 px-3 my-3 bg-info">      
                <div class="media-body">
                    <h4 class="font-weight-white text-light mb-0">CJ Laundry</h4>
                </div>      
            </div>

            <ul class="nav flex-column bg-info mb-0">
                <li class="nav-item">
                    <a href="index.php" class="nav-link font-weight-bold  text-light bg-info">
                        <span class="material-icons mr-3 align-middle pb-1">dashboard</span>
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="harga.php" class="nav-link text-light bg-info">
                        <span class="material-icons mr-3 align-middle pb-1">local_offer</span>
                        Daftar Harga Laundry
                    </a>
                </li>
                <li class="nav-item">
                    <a href="data-pesanan.php" class="nav-link text-light bg-info">
                        <span class="material-icons mr-3 align-middle pb-1">receipt_long</span>
                        Data Pesanan
                    </a>
                </li>
                <li class="nav-item vertical-nav-bottom pb-3">
                    <a href="tambah-pesanan.php" class="nav-link text-light bg-info align-middle">
                        <span class="material-icons mr-3 align-middle pb-1">add</span>
                        Tambah Pesanan Baru
                    </a>
                </li>
            </ul>
        </div>

        <div class="page-content p-5" id="content">

            <?php
            if (isset($_SESSION['message'])):
            ?>
            <div class="alert alert-<?=$_SESSION['msg_type']?> alert-dismissible fade show" role="alert">
            <?php 
            echo $_SESSION['message'];
            unset($_SESSION['message'], $_SESSION['msg_type']);
            ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <?php endif;?>
        
            <!-- Toggle button -->
            <div class="pt-3 sticky-top">
                <button id="sidebarCollapse" type="button" class="btn btn-info bg-info rounded-pill shadow-sm px-4 mb-4 text-uppercase font-weight-bold align-middle">
                    <i class="fas fa-bars mr-2"></i>
                    Menu
                </button>
            </div>

            <!-- Page content -->
            <h1 class="text-center">Selamat Datang!</h1>
            <div class="container-fluid mt-5">
                <div class="row justify-content-center text-center">
                    <div class="col dashboard-box m-2 p-5">
                        <h2 class="font-weight-normal">Rp <?php echo $sumtotal?></h2>
                        <p>Total Pendapatan</p>
                    </div>
                    <div class="col dashboard-box m-2 p-5">
                        <div class="align-middle">
                        <h2 class="font-weight-normal"><?php echo $sumberat?> Kg</h2>
                        <p>Total berat laundry yang telah dicuci</p>
                        </div>
                    </div>
                    <div class="w-100"></div>
                    <div class="col dashboard-box m-2 p-5">
                        <h2 class="font-weight-normal"><?php echo $countpesanan?></h2>
                        <p>Jumlah Pesanan yang telah dibuat</p>
                    </div>
                    <div class="col dashboard-box m-2 p-5">
                        <h2 class="font-weight-normal"><?php echo $countkosong?></h2>
                        <p>Jumlah Pesanan yang belum diambil</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script src="assets/js/verticalnavbar.js"></script>
    </body>
</html>