<?php
session_start();
require_once 'oraconn.php';
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

        <title>Tambah Pesanan</title>
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
                    <a href="index.php" class="nav-link text-light bg-info">
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
                    <a href="tambah-pesanan.php" class="nav-link font-weight-bold text-light bg-info align-middle">
                        <span class="material-icons mr-3 align-middle pb-1">add</span>
                        Tambah Pesanan Baru
                    </a>
                </li>
            </ul>
        </div>

        <div class="page-content p-5" id="content">
            <!-- alert content -->
            <?php
            if (isset($_SESSION['message'])):
            ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php 
            echo $_SESSION['message'];
            unset($_SESSION['message']);
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
            <h1 class="text-center">Tambah Pesanan Baru</h1>
            <div class="container-fluid mt-5">
                <div class="row justify-content-center">
                    <div class="col-auto table-responsive">
                        <form action="process.php" method="POST" name="tambah">
                            <table class="table table-hover table-striped text-right">
                                <tr class="form-group">
                                    <td class="align-middle" style="width: 20%;">
                                        <label>Jenis Laundry : </label>
                                    </td>
                                    <td>
                                        <select name="jenis" id="jenis" class="form-control">
                                            <?php
                                            $stmt = oci_parse($conn, 'SELECT * FROM JENIS_LAUNDRY');
                                            oci_execute($stmt);
                                            while($row = oci_fetch_object($stmt)){
                                                unset($kode, $nama);
                                                $kode = $row->KODE_LAUNDRY;
                                                $nama = $row->NAMA_JENIS;
                                                if (isset($_SESSION['kodelaundry']) && $kode == $_SESSION['kodelaundry']){
                                                    echo '<option value =  "'.$kode.'" selected="selected">'.$nama.'</option>';
                                                }
                                                else
                                                    echo '<option value =  "'.$kode.'">'.$nama.'</option>';
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr class="form-group">
                                    <td class="align-middle" style="width: 20%;">
                                        <label>Berat (Kg) : </label>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" name="berat" id="berat" min="1" style="width: 100px;" value="<?php if(isset($_SESSION['berat']))echo $_SESSION['berat'];?>">
                                    </td>
                                </tr>
                                <tr class="form-group">
                                    <td class="align-middle" style="width: 20%;">
                                        <label>Tanggal Pesan : </label>
                                    </td>
                                    <td>
                                        <input type="date" class="form-control" name="tglpesan" style="width: 300px;" id="today" min="2000-01-01">
                                    </td>
                                </tr>
                            </table>
                            <button class="btn btn-info" type="submit" name="tambah" style="width: 100%;">Tambah Pesanan</button>
                        </form>
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
        <script src="assets/js/formcheck.js"></script>
    </body>
</html>