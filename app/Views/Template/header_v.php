<?php
$this->session = \Config\Services::session();
$this->request = \Config\Services::request();

use Config\Database;

$this->db = Database::connect("default");
$identity = $this->db->table("identity")->get()->getRow();

if ($this->session->get('user_id') == "") {
    $this->session->setFlashdata("message", "Selamat Datang !");
    header('Location:' . base_url('login?message=Silahkan Login !'));
    exit;
}

function hitung_umur($tanggal_lahir)
{
    $birthDate = new DateTime($tanggal_lahir);
    $today = new DateTime("today");
    if ($birthDate > $today) {
        exit("0 tahun 0 bulan 0 hari");
    }
    $y = $today->diff($birthDate)->y;
    $m = $today->diff($birthDate)->m;
    $d = $today->diff($birthDate)->d;
    return $y .
        " tahun " . $m .
        " bulan " . $d .
        " hari";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url("images/identity_picture/" . $identity->identity_picture); ?>">
    <title><?= $identity->identity_name; ?></title>

    <link href="<?= base_url('css/lib/chartist/chartist.min.css'); ?>" rel="stylesheet">
    <link href="<?= base_url('css/lib/owl.carousel.min.css'); ?>" rel="stylesheet" />
    <link href="<?= base_url('css/lib/owl.theme.default.min.css'); ?>" rel="stylesheet" />
    <!-- Bootstrap Core CSS -->
    <link href="<?= base_url('css/lib/bootstrap/bootstrap.min.4.5.2.css'); ?>" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?= base_url('css/helper.css'); ?>" rel="stylesheet">
    <link href="<?= base_url('css/style.css'); ?>" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:** -->
    <!--[if lt IE 9]>
    <script src="https:**oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https:**oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->



    <script src="<?= base_url('js/lib/jquery/jquery.min.js'); ?>"></script>
    <script src="<?= base_url('js/lib/bootstrap/js/popper.min.js'); ?>"></script>
    <script src="<?= base_url('js/lib/bootstrap/js/bootstrap.min.js'); ?>"></script>


    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">-->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>




    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="<?= base_url('js/jquery.slimscroll.js'); ?>"></script>
    <!--Menu sidebar -->
    <script src="<?= base_url('js/sidebarmenu.js'); ?>"></script>
    <!--stickey kit -->
    <script src="<?= base_url('js/lib/sticky-kit-master/dist/sticky-kit.min.js'); ?>"></script>

    <script src="<?= base_url('js/lib/datamap/d3.min.js'); ?>"></script>
    <script src="<?= base_url('js/lib/datamap/topojson.js'); ?>"></script>
    <script src="<?= base_url('js/lib/datamap/datamaps.world.min.js'); ?>"></script>
    <script src="<?= base_url('js/lib/datamap/datamap-init.js'); ?>"></script>

    <script src="<?= base_url('js/lib/weather/jquery.simpleWeather.min.js'); ?>"></script>
    <script src="<?= base_url('js/lib/weather/weather-init.js'); ?>"></script>
    <script src="<?= base_url('js/lib/owl-carousel/owl.carousel.min.js'); ?>"></script>
    <script src="<?= base_url('js/lib/owl-carousel/owl.carousel-init.js'); ?>"></script>

    <script src="<?= base_url('js/lib/chartist/chartist.min.js'); ?>"></script>
    <script src="<?= base_url('js/lib/chartist/chartist-plugin-tooltip.min.js'); ?>"></script>
    <script src="<?= base_url('js/lib/chartist/chartist-init.js'); ?>"></script>




    <!--Custom JavaScript -->
    <script src="<?= base_url('js/custom.min.js'); ?>"></script>

    <!--Fungsi Pemisah Ribuan -->
    <script src="<?= base_url('js/pemisah_ribuan.js'); ?>"></script>

    <!--Collapse Table Row -->
    <script src="<?= base_url('js/collapse.js'); ?>"></script>


    <!-- ckeditor -->
    <script src="<?= base_url('ckeditor5-build-classic/ckeditor.js') ?>" type="text/javascript"></script>
    <style>
        .ck-editor__editable_inline {
            min-height: 200px;
        }
    </style>


    <style>
        .toast {
            min-width: 300px;
            position: fixed;
            bottom: 50px;
            right: 50px;
            z-index: 1000000000 !important;
        }

        .toast-header {
            background-color: aquamarine;
        }

        .toast-body {
            min-height: 100px;
        }

        .border {
            border: black solid 1px !important;
        }

        th,
        td {
            text-align: center;
        }

        .btn-action {
            padding: 0px;
            margin: 2px;
            display: inline;
        }

        .page-wrapper {
            position: relative;
            top: -20px;
        }

        .page-titles {
            margin: 0px;
        }
        .card{padding: 20px 30px 20px 30px;}
        .bold{font-weight: bold;}
    </style>


</head>

<body class="fix-header fix-sidebar">
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
        </svg>
    </div>
    <div id="main-wrapper">
        <?= require_once('headertop_v.php'); ?>
        <?= require_once('headerside_v.php'); ?>
        <div class="page-wrapper">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 id="page-title" class="text-primary">Dashboard</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Home</a></li>
                        <li id="page-title-link" class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>