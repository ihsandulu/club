<?php

use Config\Database;

$this->db = Database::connect("default");
$identity = $this->db->table("identity")->get()->getRow();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login <?= $identity->identity_name; ?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->

    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url("images/identity_picture/" . $identity->identity_picture); ?>">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <link href="css/lib/toastr/toastr.min.css" rel="stylesheet">

    <!--===============================================================================================-->
    <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/animsition/js/animsition.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/bootstrap/js/popper.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/select2/select2.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/daterangepicker/moment.min.js"></script>
    <script src="vendor/daterangepicker/daterangepicker.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/countdowntime/countdowntime.js"></script>
    <!--===============================================================================================-->
    <script src="js/main.js"></script>
    <!--===============================================================================================-->

    <script src="js/lib/toastr/toastr.min.js"></script>
    <script src="js/lib/toastr/toastr.init.js"></script>

    <!-- background -->
    <link rel="stylesheet" type="text/css" href="css/gerak.css">

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


        body {
            background: #000;
        }

        .container-login100 {
            height: 100%;
            background-image: url(<?= base_url("images/global/brain-background.png"); ?>);
            background-size: 125%;
            background-repeat: repeat-x;
            animation: animatedBackground 15s linear alternate infinite;
        }

        @keyframes animatedBackground {
            0% {
                background-position: 0 0;
            }

            50% {
                background-position: 50% 0;
            }

            100% {
                background-position: 0 0;
            }
        }

        .flyinTxtCont {
            height: 100%;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -ms-flex-direction: column;
            flex-direction: column;
            -webkit-box-align: start;
            -ms-flex-align: start;
            align-items: flex-start;
            -webkit-box-pack: end;
            -ms-flex-pack: end;
            justify-content: flex-end;
            padding-bottom: 10%;
            margin-left: 2em;
        }

        .flyIn {
            color: #fff;
            font-family: 'Raleway';
            text-transform: uppercase;
            line-height: 1.2em;
            position: relative;
            text-shadow: 2px 2px 40px rgba(0, 0, 0, 0.7);
            font-size: 20px;
        }



        .lineOne {
            transition-delay: .2s;
            transition: .4s ease in;
            animation: txtFlyIn .3s linear;
        }

        .lineTwo {
            transition-delay: .4s;
            transition: .6s ease in;
            animation: txtFlyIn .6s linear;
        }

        .lineThree {
            transition-delay: .6s;
            transition: .8s ease in;
            animation: txtFlyIn .9s linear;
        }

        .lineOne {
            font-size: 110px;
            font-weight: bold;
            letter-spacing: 3px;
        }

        .lineTwo {
            font-size: 70px;
            font-weight: bold;
            letter-spacing: 3px;
        }

        .lineThree {
            font-size: 90px;
            font-weight: bold;
            letter-spacing: 3px;
        }

        .lineFour {
            transition-delay: 2s;
            transition: 2s ease in;
            animation: fadeIn 2s linear;
            width: 100%;
            background-color: rgba(255, 255, 255, 0.9);
            display: inline-block;
            color: #000;
            box-size: border-box;
            max-width: 63%;
            max-width: 22em;
            font-size: 32px;
            padding: .2em .5em;
            margin-top: 30px;
        }

        /* Tablet (lebar layar antara 768px – 1024px) */
        @media (max-width: 1024px) and (min-width: 768px) {

            .lineOne {
                font-size: 80px;
                font-weight: bold;
                letter-spacing: 3px;
            }

            .lineTwo {
                font-size: 50px;
                font-weight: bold;
                letter-spacing: 3px;
            }

            .lineThree {
                font-size: 70px;
                font-weight: bold;
                letter-spacing: 3px;
            }
        }

        /* HP (lebar layar di bawah 768px) */
        @media (max-width: 767px) {

            .lineOne {
                font-size: 50px;
                font-weight: bold;
                letter-spacing: 3px;
            }

            .lineTwo {
                font-size: 25px;
                font-weight: bold;
                letter-spacing: 3px;
            }

            .lineThree {
                font-size: 35px;
                font-weight: bold;
                letter-spacing: 3px;
                display: none;
            }
        }



        @keyframes fadeIn {
            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        @keyframes txtFlyIn {
            0% {
                transform: translateX(-100%);
            }

            100% {
                transform: translateX(0%);
            }
        }
    </style>
    <script>
        $(document).ready(function() {
            setTimeout(() => {
                $(".toast").fadeOut();
            }, 1000);
        });
    </script>
</head>

<body>
    <!--Toast-->
    <div class="toast" data-autohide="false">
        <div class="toast-header">
            <strong class="mr-auto text-primary">Alert</strong>
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button>
        </div>
        <div class="toast-body">
            asdfaf
        </div>
    </div>

    <div class="limiter">
        <div class="container-login100">
            <div class="col-md-7 col-sm-7 col-xs-12">
                <div class="flyinTxtCont">
                    <div class="flyIn lineOne"><?= $schools_nname ?></div>
                    <div class="flyIn lineTwo">Administration</div>
                    <div class="flyIn lineThree">Apps</div>
                    <div class="flyIn lineFour"><?= $schools_tagline; ?></div>
                </div>
            </div>

            <div class="col-md-5 col-sm-5 col-xs-12">
                <div class="wrap-login100">
                    <?php
                    if (isset($_GET["schools_nname"]) && $_GET["schools_nname"] != "") {
                        $url = base_url('login?schools_nname=' . $_GET["schools_nname"]);
                    } else {
                        $url = base_url('login');
                    } 
                    echo $url;
                    ?>
                    <form action="<?= $url; ?>" method="POST" class="login100-form validate-form p-l-55 p-r-55 p-t-178">
                        <span class="login100-form-title">
                            <!-- LP2K<br />
                            <small>.:: <i>Psikotest</i> ::.</small> -->
                            <img src="<?= $schools_logo; ?>" alt="" class="dark-logo" style="width:auto; height:90px;" />

                        </span>

                        <div class="wrap-input100 validate-input m-b-16" data-validate="Please enter phone number">
                            <input class="input100" type="text" name="user_phone" placeholder="Phone No.">
                            <span class="focus-input100"></span>
                        </div>

                        <div class="wrap-input100 validate-input" data-validate="Please enter token number">
                            <input class="input100" type="text" name="user_token" placeholder="Token">
                            <span class="focus-input100"></span>
                        </div>


                        <div class="text-right p-t-13 p-b-23">
                            <span class="txt1">
                                Register
                            </span>
                            <?php if ($schools_nname == "Club") {
                                $reg = "registerclub";
                            } else {
                                $reg = "register";
                            } ?>
                            <a href="#" class="txt2" data-toggle="modal" data-target="#<?= $reg; ?>">
                                Get Token
                            </a>
                        </div>

                        <div class="flex-col-c my-40">&nbsp;</div>

                        <div class="container-login100-form-btn">
                            <button class="login100-form-btn">
                                Sign in
                            </button>
                        </div>
                        <!--
					<div class="flex-col-c p-t-170 p-b-40">
						<span class="txt1 p-b-9">
							Don’t have an account?
						</span>

						<a href="#" class="txt3">
							Sign up now
						</a>
					</div>
                    -->
                        <div class="flex-col-c my-40">&nbsp;</div>
                    </form>

                    <!-- Register Anggota-->
                    <div class="modal fade" id="register" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Pendaftaran Anggota</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form class="form-horizontal" method="post" enctype="multipart/form-data">
                                        <?php if ($schools_nname == "Club") { ?>
                                            <div class="form-group sekolah">
                                                <label class="control-label col-sm-2" for="schools_id">Club:</label>
                                                <div class="col-sm-10">
                                                    <select class="form-control select" id="schools_id" name="schools_id">
                                                        <option value="0">Pilih Club</option>
                                                        <?php $schools = $this->db->table("schools")->get();
                                                        foreach ($schools->getResult() as $schools) { ?>
                                                            <option value="<?= $schools->schools_id; ?>"><?= $schools->schools_name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        <?php } else { ?>
                                            <input type="hidden" name="schools_id" value="<?= $schools_id; ?>" />
                                        <?php } ?>


                                        <div class="form-group">
                                            <label class="control-label col-sm-2" for="user_gender">L/P:</label>
                                            <div class="col-sm-10">
                                                <select class="form-control select" id="user_gender" name="user_gender">
                                                    <option value="">Pilih Gender</option>
                                                    <option value="L">Laki-laki</option>
                                                    <option value="P">Perempuan</option>
                                                </select>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label class="control-label col-sm-2" for="user_name">Name:</label>
                                            <div class="col-sm-10">
                                                <input type="text" autofocus class="form-control" id="user_name" name="user_name" placeholder="Enter Name" value="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-2" for="user_phone">HP:</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="user_phone" name="user_phone" placeholder="" value="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-2" for="user_birthdate">Birth Date:</label>
                                            <div class="col-sm-10">
                                                <input type="date" class="form-control" id="user_birthdate" name="user_birthdate" placeholder="" value="">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-sm-2" for="user_picture">Picture:</label>
                                            <div class="col-sm-10" align="left">
                                                <input type="file" class="form-control" id="user_picture" name="user_picture"><br />
                                                <?php
                                                $user_image = "images/global/brain.png";
                                                ?>
                                                <img id="user_picture_image" width="100" height="100" src="<?= base_url($user_image); ?>" />
                                                <script>
                                                    function readURL(input) {
                                                        if (input.files && input.files[0]) {
                                                            var reader = new FileReader();

                                                            reader.onload = function(e) {
                                                                $('#user_picture_image').attr('src', e.target.result);
                                                            }

                                                            reader.readAsDataURL(input.files[0]);
                                                        }
                                                    }

                                                    $("#user_picture").change(function() {
                                                        readURL(this);
                                                    });
                                                </script>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <button type="submit" id="submit" class="btn btn-primary col-md-12" name="create" value="OK">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Register Club-->
                    <div class="modal fade" id="registerclub" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Pendaftaran Club</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form class="form-horizontal" method="post" enctype="multipart/form-data">
                                        <!-- Club -->
                                        <div class="form-group">
                                            <label class="control-label col-sm-12" for="schools_name">Club Name:</label>
                                            <div class="col-sm-12">
                                                <input type="text" autofocus class="form-control" id="schools_name" name="schools_name" placeholder="Enter Club Name" value="">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-sm-12" for="schools_nname">Club Nick Name:</label>
                                            <div class="col-sm-12">
                                                <input type="text" autofocus class="form-control" id="schools_nname" name="schools_nname" placeholder="Panggilan Pendek Club" value="">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-sm-12" for="schools_tagline">Tagline:</label>
                                            <div class="col-sm-12">
                                                <input type="text" autofocus class="form-control" id="schools_tagline" name="schools_tagline" placeholder="Enter Tagline" value="">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-sm-12" for="schools_address">Address:</label>
                                            <div class="col-sm-12">
                                                <input type="text" autofocus class="form-control" id="schools_address" name="schools_address" placeholder="Enter Address" value="">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-sm-12" for="schools_logo">Logo:</label>
                                            <div class="col-sm-12" align="left">
                                                <input type="file" class="form-control" id="schools_logo" name="schools_logo"><br />
                                                <?php
                                                $user_image = "images/global/brain.png";
                                                ?>
                                                <img id="schools_logo_image" width="100" height="100" src="<?= base_url($user_image); ?>" />
                                                <script>
                                                    function readURL(input) {
                                                        if (input.files && input.files[0]) {
                                                            var reader = new FileReader();

                                                            reader.onload = function(e) {
                                                                $('#schools_logo_image').attr('src', e.target.result);
                                                            }

                                                            reader.readAsDataURL(input.files[0]);
                                                        }
                                                    }

                                                    $("#schools_logo").change(function() {
                                                        readURL(this);
                                                    });
                                                </script>
                                            </div>
                                        </div>

                                        <!-- User -->
                                         <h5 class="alert alert-success" id="exampleModalLabel">Data Admin</h5>
                                         <div class="form-group">
                                            <label class="control-label col-sm-2" for="user_gender">L/P:</label>
                                            <div class="col-sm-10">
                                                <select class="form-control select" id="user_gender" name="user_gender">
                                                    <option value="">Pilih Gender</option>
                                                    <option value="L">Laki-laki</option>
                                                    <option value="P">Perempuan</option>
                                                </select>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label class="control-label col-sm-2" for="user_name">Name:</label>
                                            <div class="col-sm-10">
                                                <input type="text" autofocus class="form-control" id="user_name" name="user_name" placeholder="Enter Name" value="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-2" for="user_phone">HP:</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="user_phone" name="user_phone" placeholder="" value="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-2" for="user_birthdate">Birth Date:</label>
                                            <div class="col-sm-10">
                                                <input type="date" class="form-control" id="user_birthdate" name="user_birthdate" placeholder="" value="">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-sm-2" for="user_picture">Picture:</label>
                                            <div class="col-sm-10" align="left">
                                                <input type="file" class="form-control" id="user_picture" name="user_picture"><br />
                                                <?php
                                                $user_image = "images/global/brain.png";
                                                ?>
                                                <img id="user_picture_image" width="100" height="100" src="<?= base_url($user_image); ?>" />
                                                <script>
                                                    function readURL(input) {
                                                        if (input.files && input.files[0]) {
                                                            var reader = new FileReader();

                                                            reader.onload = function(e) {
                                                                $('#user_picture_image').attr('src', e.target.result);
                                                            }

                                                            reader.readAsDataURL(input.files[0]);
                                                        }
                                                    }

                                                    $("#user_picture").change(function() {
                                                        readURL(this);
                                                    });
                                                </script>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <button type="submit" id="submit" class="btn btn-primary col-md-12" name="createclub" value="OK">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        <?php
        $this->session = \Config\Services::session();
        ?>
        showmessage(3000);

        function showmessage(a) {
            //alert('<?= (isset($_GET['message'])) ? $_GET['message'] : $this->session->getFlashdata("message"); ?>');

            <?php
            $isipesan = "";
            if (isset($_GET['message'])) {
                $isipesan = $_GET['message'];
            }

            if ($this->session->getFlashdata("message") != "") {
                $isipesan = $this->session->getFlashdata("message");
            }
            ?>


            toast('INFO >>>', '<?= $isipesan ?>');
        }

        <?php if ($this->session->getFlashdata("message") != "" || isset($_GET['message'])) { ?>
            showmessage(3000);
        <?php } ?>

        function toast(judul, isi) {
            toastr.warning(isi, judul, {
                "positionClass": "toast-bottom-right",
                timeOut: 300000,
                "closeButton": true,
                "debug": false,
                "newestOnTop": true,
                "progressBar": true,
                "preventDuplicates": true,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut",
                "tapToDismiss": false

            })
        }


        /*  //hilangkan lineThree dan lineFour pada layar HP
         function removeLinesOnMobile() {
             if (window.innerWidth <= 768) { // threshold untuk layar HP, bisa disesuaikan
                 const lineThree = document.querySelector('.lineThree');
                 const lineFour = document.querySelector('.lineFour');
                 if (lineThree) lineThree.remove();
                 if (lineFour) lineFour.remove();
             }
         }

         // Jalankan saat halaman dimuat
         window.addEventListener('load', removeLinesOnMobile);

         // Opsional: jalankan juga saat ukuran jendela diubah
         window.addEventListener('resize', removeLinesOnMobile); */
    </script>


</body>

</html>