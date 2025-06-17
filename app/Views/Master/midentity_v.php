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
                        <?php } ?>
                    </div>

                    <?php if (isset($_POST['new']) || isset($_POST['edit'])) { ?>
                        <div class="">
                            <?php if (isset($_POST['edit'])) {
                                $namabutton = 'name="change"';
                                $judul = "Update identity";
                            } else {
                                $namabutton = 'name="create"';
                                $judul = "Add identity";
                            } ?>
                            <div class="lead">
                                <h3><?= ucwords($judul); ?></h3>
                            </div>
                            <form class="form-horizontal" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="identity_name">Application Name:</label>
                                    <div class="col-sm-10">
                                        <input type="text" autofocus class="form-control" id="identity_name" name="identity_name" placeholder="" value="<?= $identity_name; ?>">

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="identity_company">Company:</label>
                                    <div class="col-sm-10">
                                        <input type="text" autofocus class="form-control" id="identity_company" name="identity_company" placeholder="" value="<?= $identity_company; ?>">

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="identity_address">Address:</label>
                                    <div class="col-sm-10">
                                        <input type="text" autofocus class="form-control" id="identity_address" name="identity_address" placeholder="" value="<?= $identity_address; ?>">

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="identity_phone">Phone:</label>
                                    <div class="col-sm-10">
                                        <input type="text" autofocus class="form-control" id="identity_phone" name="identity_phone" placeholder="" value="<?= $identity_phone; ?>">

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="identity_picture">Picture:</label>
                                    <input type="file" class="" id="identity_picture" name="identity_picture">
                                    <div>
                                        <?php
                                        if ($identity_picture != "") {
                                            $user_image = "images/identity_picture/" . $identity_picture;
                                        } else {
                                            $user_image = "images/global/noimage.jpg";
                                        }
                                        ?>
                                        <img id="identity_picture_image" width="100" height="100" src="<?= base_url($user_image); ?>" />
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

                                            $("#identity_picture").change(function() {
                                                readURL(this);
                                            });
                                        </script>
                                    </div>
                                </div>






                                <input type="hidden" name="identity_id" value="<?= $identity_id; ?>" />
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" id="submit" class="btn btn-primary col-md-5" <?= $namabutton; ?> value="OK">Submit</button>
                                        <button class="btn btn-warning col-md-offset-1 col-md-5" onClick="location.href=<?= site_url("identity"); ?>">Back</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    <?php } else { ?>
                        <?php if ($message != "") { ?>
                            <div class="alert alert-info alert-dismissable">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong><?= $message; ?></strong><br /><?= $uploadidentity_picture; ?>
                            </div>
                        <?php } ?>

                        <div class="table-responsive m-t-40">
                            <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead class="">
                                    <tr>
                                        <?php if (!isset($_GET["report"])) { ?>
                                            <th>Action</th>
                                        <?php } ?>
                                        <th>Identity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $usr = $this->db
                                        ->table("identity")
                                        ->orderBy("identity_id", "desc")
                                        ->get();
                                    //echo $this->db->getLastquery();
                                    $no = 1;
                                    foreach ($usr->getResult() as $usr) { ?>
                                        <tr>
                                            <?php if (!isset($_GET["report"])) { ?>
                                                <td style="padding-left:0px; padding-right:0px;">

                                                    <form method="post" class="btn-action" style="">
                                                        <button class="btn btn-sm btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
                                                        <input type="hidden" name="identity_id" value="<?= $usr->identity_id; ?>" />
                                                    </form>
                                                </td>
                                            <?php } ?>
                                            <td><?= $usr->identity_name; ?></td>
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
    var title = "Master Identity";
    $("title").text(title);
    $(".card-title").text(title);
    $("#page-title").text(title);
    $("#page-title-link").text(title);
    toastr.success('Have fun storming the castle!', 'Miracle Max Says');
</script>

<?php require_once(APPPATH . "Views/Template/footer_v.php"); ?>