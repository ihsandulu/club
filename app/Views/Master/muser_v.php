<?php require_once(APPPATH . "Views/Template/header_v.php"); ?>

<div class='container-fluid'>
    <div class='row'>
        <div class='col-12'>
            <div class="card">
                <div class="card-body">


                    <div class="row">
                        <?php if (!isset($_GET['user_id']) && !isset($_POST['new']) && !isset($_POST['edit'])) {
                            $coltitle = "col-md-10";
                        } else {
                            $coltitle = "col-md-8";
                        } ?>
                        <div class="<?= $coltitle; ?>">
                            <h4 class="card-title"></h4>
                            <!-- <h6 class="card-subtitle">Export data to Copy, CSV, Excel, PDF & Print</h6> -->
                        </div>
                        <?php if (isset($_GET['report'])) { ?>
                            <form method="post" class="col-md-2">
                                <h1 class="page-header col-md-12">
                                    <a href="<?= site_url("saran"); ?>" class="btn btn-danger btn-block btn-lg" value="OK" style="">Suggestion</a>

                                </h1>
                            </form>
                        <?php } ?>
                        <?php if (!isset($_POST['new']) && !isset($_POST['edit']) && !isset($_GET['report'])) { ?>
                            <?php if (isset($_GET["user_id"])) { ?>
                                <form action="<?= site_url("user"); ?>" method="get" class="col-md-2">
                                    <h1 class="page-header col-md-12">
                                        <button class="btn btn-warning btn-block btn-lg" value="OK" style="">Back</button>
                                    </h1>
                                </form>
                            <?php } ?>
                            <form method="post" class="col-md-2">
                                <h1 class="page-header col-md-12">
                                    <button name="new" class="btn btn-info btn-block btn-lg" value="OK" style="">New</button>
                                    <input type="hidden" name="schools_id" />
                                </h1>
                            </form>
                        <?php } ?>
                    </div>

                    <?php if (isset($_POST['new']) || isset($_POST['edit'])) { ?>
                        <div class="">
                            <?php if (isset($_POST['edit'])) {
                                $namabutton = 'name="change"';
                                $judul = "Update " . $title;
                            } else {
                                $namabutton = 'name="create"';
                                $judul = "Add " . $title;
                            } ?>
                            <div class="lead">
                                <h3><?= ucwords($judul); ?></h3>
                            </div>
                            <form class="form-horizontal" method="post" enctype="multipart/form-data">

                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="position_id">Position:</label>
                                    <div class="col-sm-10">
                                        <select class="form-control select" id="position_id" name="position_id" ochange="posisi()">
                                            <?php
                                            $build = $this->db->table("position");
                                            if ($this->session->get("position_id") > -1) {
                                                if ($posisi == "member") {
                                                    $build->where("position_id", "0");
                                                }
                                                if ($posisi == "admin") {
                                                    $build->where("position_id", "1");
                                                }
                                            }
                                            $position = $build->get();
                                            foreach ($position->getResult() as $position) { ?>
                                                <option value="<?= $position->position_id; ?>" <?= ($position_id == $position->position_id) ? "selected" : ""; ?>><?= $position->position_name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <script>
                                    function posisi() {

                                        if ($("#position_id").val() == 0) {
                                            $(".sekolah").show();
                                        } else {
                                            $(".sekolah").hide();
                                        }
                                    }
                                    $(document).ready(function() {
                                        posisi();
                                    });
                                </script>

                                <div class="form-group ">
                                    <label class="control-label col-sm-2" for="schools_id">Club:</label>
                                    <div class="col-sm-10">
                                        <select onchange="pilihclass()" class="form-control select" id="schools_id" name="schools_id">
                                            <option value="0" <?= ($schools_id == "0") ? "selected" : ""; ?>>Pilih Club</option>
                                            <?php
                                            $build = $this->db->table("schools");
                                            if ($this->session->get("position_id") > -1) {
                                                $build->where("schools_id", $this->session->get("schools_id"));
                                            }
                                            $schools = $build->get();
                                            foreach ($schools->getResult() as $schools) { ?>
                                                <option value="<?= $schools->schools_id; ?>" <?= ($this->session->get("schools_id") == $schools->schools_id) ? "selected" : ""; ?>><?= $schools->schools_name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group sekolah">
                                    <label class="control-label col-sm-2" for="user_class">Class:</label>
                                    <div class="col-sm-10">
                                        <select class="form-control select" id="user_class" name="user_class">
                                            <option value="" <?= ($user_class == "") ? "selected" : ""; ?>>Pilih Kelas</option>
                                            <?php
                                            $build = $this->db->table("class");
                                            if ($this->session->get("position_id") > -1) {
                                                $build->where("schools_id", $this->session->get("schools_id"));
                                            }
                                            $class = $build->orderBy("class_id", "asc")->get();
                                            foreach ($class->getResult() as $class) { ?>
                                                <option value="<?= $class->class_id; ?>" <?= ($user_class == $class->class_id) ? "selected" : ""; ?>><?= $class->class_name; ?></option>
                                            <?php } ?>
                                        </select>
                                        <script>
                                            function pilihclass() {
                                                let schools_id = $("#schools_id").val();
                                                let user_class = "<?= $user_class; ?>";
                                                // alert("<?= base_url("api/listclass"); ?>?schools_id=" + schools_id + "&user_class=" + user_class);
                                                $.get("<?= base_url("api/listclass"); ?>", {
                                                        schools_id: schools_id,
                                                        user_class: user_class
                                                    })
                                                    .done(function(data) {
                                                        $("#user_class").html(data);
                                                    });
                                            }
                                        </script>
                                    </div>
                                </div>

                                <div class="form-group sekolah">
                                    <label class="control-label col-sm-2" for="user_gender">L/P:</label>
                                    <div class="col-sm-10">
                                        <select class="form-control select" id="user_gender" name="user_gender">
                                            <option value="" <?= ($user_gender == "") ? "selected" : ""; ?>>Pilih Gender</option>
                                            <option value="L" <?= ($user_gender == "L") ? "selected" : ""; ?>>Laki-laki</option>
                                            <option value="P" <?= ($user_gender == "P") ? "selected" : ""; ?>>Perempuan</option>
                                        </select>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="user_name">Name:</label>
                                    <div class="col-sm-10">
                                        <input type="text" autofocus class="form-control" id="user_name" name="user_name" placeholder="Enter Name" value="<?= $user_name; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="user_phone">HP:</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="user_phone" name="user_phone" placeholder="" value="<?= $user_phone; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="user_birthdate">Birth Date:</label>
                                    <div class="col-sm-10">
                                        <input type="date" class="form-control" id="user_birthdate" name="user_birthdate" placeholder="" value="<?= $user_birthdate; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="user_token">Token:</label>
                                    <div class="col-sm-10">
                                        <input readonly type="text" class="form-control" id="user_token" name="user_token" placeholder="" value="<?= $user_token; ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="user_picture">Picture:</label>
                                    <div class="col-sm-10" align="left">
                                        <input type="file" class="form-control" id="user_picture" name="user_picture"><br />
                                        <?php if ($user_picture != "") {
                                            $user_image = "images/user_picture/" . $user_picture;
                                        } else {
                                            $user_image = "images/global/brain.png";
                                        } ?>
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






                                <input type="hidden" name="user_id" value="<?= $user_id; ?>" />
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" id="submit" class="btn btn-primary col-md-5" <?= $namabutton; ?> value="OK">Submit</button>
                                        <button class="btn btn-warning col-md-offset-1 col-md-5" onClick="location.href=<?= site_url("user"); ?>">Back</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    <?php } else { ?>
                        <?php if ($message != "") { ?>
                            <div class="alert alert-info alert-dismissable">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong><?= $message; ?></strong><br /><?= $uploaduser_picture; ?>
                            </div>
                        <?php } ?>

                        <div class="table-responsive m-t-40">
                            <table id="example23" class="display nowrap table table-hover  table-bordered" cellspacing="0" width="100%">
                                <thead class="">
                                    <tr style="background-color: bisque;">
                                        <?php if (!isset($_GET["report"])) { ?>
                                            <th>Action</th>
                                        <?php } ?>
                                        <th>Position</th>
                                        <th>Gender</th>
                                        <th>Club</th>
                                        <th>Class</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Token</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // dd($this->session->get());
                                    $schoolsid = $this->session->get("schools_id");
                                    $schoolsname = $this->session->get("schools_name");
                                    $build = $this->db
                                        ->table("user")
                                        ->join("position", "position.position_id=user.position_id", "left")
                                        ->join("class", "class.class_id=user.user_class", "left")
                                        ->join("schools", "schools.schools_id=user.schools_id", "left");
                                    if ($this->session->get("position_id") > -1) {
                                        $build->where("user.schools_id", $schoolsid);

                                        if ($posisi == "member") {
                                            $build->where("user.position_id", "0");
                                        }
                                        if ($posisi == "admin") {
                                            $build->where("user.position_id", "1");
                                        }
                                    }
                                    $usr = $build->orderBy("user.user_id", "desc")
                                        ->get();
                                    //echo $this->db->getLastquery();
                                    $no = 1;
                                    foreach ($usr->getResult() as $usr) {
                                        $age = hitung_umur($usr->user_birthdate);
                                    ?>
                                        <tr id="d<?= $usr->user_id; ?>">
                                            <?php if (!isset($_GET["report"])) { ?>
                                                <td style="padding-left:0px; padding-right:0px;">
                                                    <form method="post" class="btn-action" style="">
                                                        <a href="#" onclick="tampilrow(this,'d<?= $usr->user_id; ?>','6', ['Birth Date', 'Age'], ['<?= $usr->user_birthdate; ?>', '<?= $age; ?>'])" class="btn btn-sm btn-success tampilrow">
                                                            <span class="fa fa-plus" style="color:white;"></span>
                                                        </a>
                                                    </form>

                                                    <form method="post" class="btn-action" style="">
                                                        <button class="btn btn-sm btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
                                                        <input type="hidden" name="user_id" value="<?= $usr->user_id; ?>" />
                                                    </form>

                                                    <form method="post" class="btn-action" style="">
                                                        <button class="btn btn-sm btn-danger delete" onclick="return confirm(' you want to delete?');" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
                                                        <input type="hidden" name="user_id" value="<?= $usr->user_id; ?>" />
                                                    </form>

                                                    <form method="post" class="btn-action" style="">
                                                        <?php

                                                        if (substr($usr->user_phone, 0, 1) == 0) {
                                                            $phone = "62" . substr($usr->user_phone, 1);
                                                        } else if (substr($usr->user_phone, 0, 1) == "+") {
                                                            $phone = substr($usr->user_phone, 1);
                                                        } else {
                                                            $phone = "";
                                                        }
                                                        $text = "Selamat anda berhasil mendaftar di " . $schoolsname . ". Token anda adalah " . $usr->user_token;
                                                        $text = str_replace(" ", "%20", $text);
                                                        $link = "https://api.whatsapp.com/send?phone=" . $phone . "&text=" . $text; ?>
                                                        <a target="_blank" href="<?= $link; ?>" class="btn btn-sm btn-success">
                                                            <span class="fa fa-whatsapp" style="color:white;"></span>
                                                        </a>
                                                    </form>
                                                </td>
                                            <?php } ?>
                                            <td><?= $usr->position_name; ?></td>
                                            <td><?= $usr->user_gender; ?></td>
                                            <td><?= $usr->schools_name; ?></td>
                                            <td><?= $usr->class_name; ?></td>
                                            <td><?= $usr->user_name; ?></td>
                                            <td><?= $usr->user_phone; ?></td>
                                            <td><?= $usr->user_token; ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var title = "<?= $title; ?>";
    $("title").text(title);
    $(".card-title").text(title);
    $("#page-title").text(title);
    $("#page-title-link").text(title);
    toastr.success('Have fun storming the castle!', 'Miracle Max Says');
</script>

<?php require_once(APPPATH . "Views/Template/footer_v.php"); ?>