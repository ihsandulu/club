<?php require_once(APPPATH . "Views/Template/header_v.php"); ?>

<div class='container-fluid'>
    <div class='row'>
        <div class='col-12'>
            <div class="card">
                <div class="card-body">


                    <div class="row">
                        <?php if (!isset($_GET['sbank_id']) && !isset($_POST['new']) && !isset($_POST['edit'])) {
                            $coltitle = "col-md-8";
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
                            
                                <form action="<?= site_url("master/mschools"); ?>" method="get" class="col-md-2">
                                    <h1 class="page-header col-md-12">
                                        <button class="btn btn-warning btn-block btn-lg" value="OK" style="">Back</button>
                                    </h1>
                                </form>
                            
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
                                $judul = "Update Bank";
                            } else {
                                $namabutton = 'name="create"';
                                $judul = "Add Bank";
                            } ?>
                            <div class="lead">
                                <h3><?= ucwords($judul); ?></h3>
                            </div>
                            <form class="form-horizontal" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="bank_id">Bank:</label>
                                    <div class="col-sm-10">
                                        <select autofocus class="form-control" id="bank_id" name="bank_id">
                                            <option value="">-- Select Bank --</option>
                                            <?php
                                            $bank = $this->db->table("bank")->orderBy("bank_name", "asc")->get();
                                            foreach ($bank->getResult() as $row) { ?>
                                                <option value="<?= $row->bank_id; ?>" <?= ($bank_id == $row->bank_id) ? "selected" : ""; ?>><?= $row->bank_name; ?></option>
                                            <?php  } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="sbank_rek">Rekening:</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="sbank_rek" name="sbank_rek" placeholder="" value="<?= $sbank_rek; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="sbank_an">Atas Nama:</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="sbank_an" name="sbank_an" placeholder="" value="<?= $sbank_an; ?>">
                                    </div>
                                </div>



                                <input type="hidden" name="schools_id" value="<?= $this->request->getGet("schools_id"); ?>" />
                                <input type="hidden" name="sbank_id" value="<?= $sbank_id; ?>" />
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" id="submit" class="btn btn-primary col-md-5" <?= $namabutton; ?> value="OK">Submit</button>
                                        <button class="btn btn-warning col-md-offset-1 col-md-5" onClick="location.href=<?= site_url("sbank"); ?>">Back</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    <?php } else { ?>
                        <?php if ($message != "") { ?>
                            <div class="alert alert-info alert-dismissable">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong><?= $message; ?></strong><br /><?= $uploadsbank_picture; ?>
                            </div>
                        <?php } ?>

                        <div class="table-responsive m-t-40">
                            <table id="example23" class="display nowrap table table-hover  table-bordered" cellspacing="0" width="100%">
                                <thead class="">
                                    <tr style="background-color: bisque;">
                                        <?php if (!isset($_GET["report"])) { ?>
                                            <th>Action</th>
                                        <?php } ?>
                                        <th>Club</th>
                                        <th>Bank</th>
                                        <th>Rekening</th>
                                        <th>Atas Nama</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $schoolsid = $this->request->getGet("schools_id");
                                    $build = $this->db
                                        ->table("sbank")
                                        ->join("bank", "bank.bank_id=sbank.bank_id", "left")
                                        ->join("schools", "schools.schools_id=sbank.schools_id", "left");
                                    if ($schoolsid > 0) {
                                        $build->where("sbank.schools_id", $schoolsid);
                                    }
                                    $usr = $build->orderBy("sbank.sbank_id", "desc")
                                        ->get();
                                    // echo $this->db->getLastquery();
                                    $no = 1;
                                    foreach ($usr->getResult() as $usr) {
                                    ?>
                                        <tr id="d<?= $usr->sbank_id; ?>">
                                            <?php if (!isset($_GET["report"])) { ?>
                                                <td style="padding-left:0px; padding-right:0px;">
                                                    <form method="post" class="btn-action" style="">
                                                        <button class="btn btn-sm btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
                                                        <input type="hidden" name="sbank_id" value="<?= $usr->sbank_id; ?>" />
                                                    </form>
                                                    <form method="post" class="btn-action" style="">
                                                        <button class="btn btn-sm btn-danger delete" onclick="return confirm(' you want to delete?');" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
                                                        <input type="hidden" name="sbank_id" value="<?= $usr->sbank_id; ?>" />
                                                    </form>
                                                </td>
                                            <?php } ?>
                                            <td><?= $usr->schools_name; ?></td>
                                            <td><?= $usr->bank_name; ?></td>
                                            <td><?= $usr->sbank_rek; ?></td>
                                            <td><?= $usr->sbank_an; ?></td>
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
    var title = "Master Bank";
    $("title").text(title);
    $(".card-title").text(title);
    $("#page-title").text(title);
    $("#page-title-link").text(title);
    toastr.success('Have fun storming the castle!', 'Miracle Max Says');
</script>

<?php require_once(APPPATH . "Views/Template/footer_v.php"); ?>