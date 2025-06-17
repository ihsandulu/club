<?php require_once(APPPATH . "Views/Template/header_v.php"); ?>

<div class='container-fluid'>
    <div class='row'>
        <div class='col-12'>
            <div class="card">
                <div class="card-body">


                    <div class="row">
                        <?php if (!isset($_GET['schools_id']) && !isset($_POST['new']) && !isset($_POST['edit'])) {
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
                            <?php if (isset($_GET["schools_id"])) { ?>
                                <form action="<?= site_url("schools"); ?>" method="get" class="col-md-2">
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
                                $judul = "Update Clubs";
                            } else {
                                $namabutton = 'name="create"';
                                $judul = "Add Clubs";
                            } ?>
                            <div class="lead">
                                <h3><?= ucwords($judul); ?></h3>
                            </div>
                            <form class="form-horizontal" method="post" enctype="multipart/form-data">

                                <?php if ($this->session->get("position_id") == -1) { ?>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="schools_date">Date:</label>
                                        <div class="col-sm-10">
                                            <input type="date" autofocus class="form-control" id="schools_date" name="schools_date" placeholder="Enter Date" value="<?= $schools_date; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="schools_name">Club Name:</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="schools_name" name="schools_name" placeholder="Enter Name" value="<?= $schools_name; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="schools_address">Fitur:</label>
                                        <div class="col-sm-10">
                                            <input type="checkbox" class="" value="1" id="schools_register" name="schools_register" <?= ($schools_register == "1") ? "checked" : ""; ?>> Pendaftaran &nbsp &nbsp &nbsp
                                            <input type="checkbox" class="" value="1" id="schools_score" name="schools_score" <?= ($schools_score == "1") ? "checked" : ""; ?>> Skor &nbsp &nbsp &nbsp
                                            <input type="checkbox" class="" value="1" id="schools_bill" name="schools_bill" <?= ($schools_bill == "1") ? "checked" : ""; ?>> Tagihan &nbsp &nbsp &nbsp
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="schools_nname">Club Nick Name (tanpa spasi):</label>
                                    <div class="col-sm-10">
                                        <input type="text" required class="form-control" id="schools_nname" name="schools_nname" placeholder="Enter Nick Name" value="<?= $schools_nname; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="schools_tagline">Tagline:</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="schools_tagline" name="schools_tagline" placeholder="" value="<?= $schools_tagline; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="schools_logo">Club Logo:</label>
                                    <input type="file" class="" id="schools_logo" name="schools_logo">
                                    <div>
                                        <?php
                                        if ($schools_logo != "") {
                                            $user_image = "images/schools_logo/" . $schools_logo;
                                        } else {
                                            $user_image = "images/global/noimage.jpg";
                                        }
                                        ?>
                                        <img id="schools_logo_image" width="100" height="100" src="<?= base_url($user_image); ?>" />
                                        <script>
                                            function readURL(input) {
                                                if (input.files && input.files[0]) {
                                                    var reader = new FileReader();

                                                    reader.onload = function(e) {
                                                        $('#' + input.id + '_image').attr('src', e.target.result);
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

                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="schools_address">Address:</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="schools_address" name="schools_address" placeholder="" value="<?= $schools_address; ?>">
                                    </div>
                                </div>




                                <input type="hidden" name="schools_id" value="<?= $schools_id; ?>" />
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" id="submit" class="btn btn-primary col-md-5" <?= $namabutton; ?> value="OK">Submit</button>
                                        <button class="btn btn-warning col-md-offset-1 col-md-5" onClick="location.href=<?= site_url("schools"); ?>">Back</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    <?php } else { ?>
                        <?php if ($message != "") { ?>
                            <div class="alert alert-info alert-dismissable">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong><?= $message; ?></strong><br /><?= $uploadschools_logo; ?><br /><?= $uploadschools_sponsorlogo; ?>
                            </div>
                        <?php } ?>

                        <div class="table-responsive m-t-40">
                            <table id="example23" class="display nowrap table table-hover  table-bordered" cellspacing="0" width="100%">
                                <thead class="">
                                    <tr style="background-color: bisque;">
                                        <?php if (!isset($_GET["report"])) { ?>
                                            <th>Action</th>
                                        <?php } ?>
                                        <th>Date</th>
                                        <th>ID.</th>
                                        <th>Club</th>
                                        <th>Tagline</th>
                                        <th>Address</th>
                                        <th>Service</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $build = $this->db
                                        ->table("schools");
                                    if ($this->session->get("position_id") > -1) {
                                        $build->where("schools_id", $this->session->get("schools_id"));
                                    }
                                    $usr =   $build->orderBy("schools.schools_id", "desc")
                                        ->get();
                                    $active = array("", "Active");
                                    //echo $this->db->getLastquery();
                                    $no = 1;
                                    foreach ($usr->getResult() as $usr) {
                                    ?>
                                        <tr id="d<?= $usr->schools_id; ?>">
                                            <?php if (!isset($_GET["report"])) { ?>
                                                <td style="padding-left:0px; padding-right:0px;">
                                                    <form method="get" class="btn-action" style="" action="<?= base_url("master/msbank"); ?>">
                                                        <button data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Bank" class="btn btn-sm btn-primary" name="class" value="OK"><span class="fa fa-bank" style="color:white;"></span> </button>
                                                        <input type="hidden" name="schools_id" value="<?= $usr->schools_id; ?>" />
                                                    </form>
                                                    <form method="get" class="btn-action" style="" action="<?= base_url("master/mclass"); ?>">
                                                        <button data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Kelas" class="btn btn-sm btn-info" name="class" value="OK"><span class="fa fa-building" style="color:white;"></span> </button>
                                                        <input type="hidden" name="schools_id" value="<?= $usr->schools_id; ?>" />
                                                    </form>

                                                    <form method="post" class="btn-action" style="">
                                                        <button class="btn btn-sm btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
                                                        <input type="hidden" name="schools_id" value="<?= $usr->schools_id; ?>" />
                                                    </form>

                                                    <?php if ($this->session->get("position_id") == -1) { ?>
                                                        <form method="post" class="btn-action" style="">
                                                            <button class="btn btn-sm btn-danger delete" onclick="return confirm(' you want to delete?');" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
                                                            <input type="hidden" name="schools_id" value="<?= $usr->schools_id; ?>" />
                                                        </form>
                                                        <?php if ($usr->schools_active == "1") {
                                                            $btn = "info";
                                                            $fa = "close";
                                                            $aktiv = "0";
                                                        } else {
                                                            $btn = "success";
                                                            $fa = "check";
                                                            $aktiv = "1";
                                                        }
                                                        ?>
                                                        <form method="post" class="btn-action" style="">
                                                            <button title="status aktif" class="btn btn-sm btn-<?= $btn; ?>" name="change" value="OK"><span class="fa fa-<?= $fa; ?>" style="color:white;"></span> </button>
                                                            <input type="hidden" name="schools_id" value="<?= $usr->schools_id; ?>" />
                                                            <input type="hidden" name="schools_active" value="<?= $aktiv; ?>" />
                                                        </form>
                                                    <?php } ?>
                                                </td>
                                            <?php } ?>
                                            <td><?= $usr->schools_date; ?></td>
                                            <td><?= $usr->schools_no; ?></td>
                                            <td><?= $usr->schools_name; ?> (<?= $usr->schools_nname; ?>)</td>
                                            <td><?= $usr->schools_tagline; ?></td>
                                            <td><?= $usr->schools_address; ?></td>
                                            <td>
                                                <?= ($usr->schools_register == "1") ? "register, " : ""; ?>
                                                <?= ($usr->schools_score == "1") ? "score, " : ""; ?>
                                                <?= ($usr->schools_bill == "1") ? "bill, " : ""; ?>
                                            </td>
                                            <td><?= $active[$usr->schools_active]; ?></td>
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
    var title = '<?= ucwords("Master Clubs"); ?>';
    $("title").text(title);
    $(".card-title").text(title);
    $("#page-title").text(title);
    $("#page-title-link").text(title);
    toastr.success('Have fun storming the castle!', 'Miracle Max Says');
</script>

<?php require_once(APPPATH . "Views/Template/footer_v.php"); ?>