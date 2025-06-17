<?php require_once(APPPATH . "Views/Template/header_v.php"); ?>

<div class='container-fluid'>
    <div class='row'>
        <div class='col-12'>
            <div class="card">
                <div class="card-body">


                    <div class="row">
                        <?php if (!isset($_GET['tagihan_id']) && !isset($_POST['new']) && !isset($_POST['edit'])) {
                            $coltitle = "col-md-10";
                        } else {
                            $coltitle = "col-md-8";
                        } ?>
                        <div class="<?= $coltitle; ?>">
                            <h4 class="card-title"></h4>
                            <!-- <h6 class="card-subtitle">Export data to Copy, CSV, Excel, PDF & Print</h6> -->
                        </div>
                    </div>
                    <?php if ($message != "") { ?>
                        <div class="alert alert-info alert-dismissable">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong><?= $message; ?></strong>
                        </div>
                    <?php } ?>
                    <form id="formeksekusi" method="post" class="form-inline alert alert-dark">
                        <?php if (session()->get("position_id") == -1) { ?>
                            <select class="form-control" id="schools_id" name="schools_id">
                                <option value="">Pilih Club</option>
                                <?php $schools = $this->db->table("schools")->orderBy("schools_name", "ASC")->get();
                                foreach ($schools->getResult() as $row) { ?>
                                    <option value="<?= $row->schools_id; ?>"><?= $row->schools_name; ?></option>
                                <?php } ?>
                            </select>
                        <?php } else { ?>
                            <input type="hidden" class="form-control" placeholder="Club Name" name="schools_id" value="<?= session()->get("schools_id"); ?>">
                        <?php } ?>
                        <input type="date" class="form-control" id="tagihan_date" name="tagihan_date"/>
                        <select class="form-control" id="class_id" name="class_id">
                            <option value="0">Semua Kelas</option>
                            <?php $build = $this->db->table("class");
                            if (session()->get("position_id") > -1) {
                                $build->where("schools_id", session()->get("schools_id"));
                            }
                            $class = $build->get();
                            foreach ($class->getResult() as $row) { ?>
                                <option value="<?=$row->class_id;?>"><?=$row->class_name;?></option>
                            <?php } ?>
                        </select>
                         <select class="form-control" id="user_id" name="user_id">
                            <option value="0">Semua Member</option>
                            <?php $build = $this->db->table("user");
                            if (session()->get("position_id") > -1) {
                                $build->where("schools_id", session()->get("schools_id"));
                            }
                            $user = $build->get();
                            foreach ($user->getResult() as $row) { ?>
                                <option value="<?=$row->user_id;?>"><?=$row->user_name;?></option>
                            <?php } ?>
                        </select>
                        <input type="text" class="form-control" placeholder="Nama Tagihan" id="tagihan_name" name="tagihan_name">
                        <input type="text" class="form-control" placeholder="Nominal Tagihan" id="tagihan_nominal" name="tagihan_nominal">
                        <input type="hidden" id="tagihan_id" name="tagihan_id">

                        <button type="submit" class="btn btn-primary" id="eksekusi" name="create" value="OK">Create</button>
                        <button type="button" onclick="batalin()" class="btn btn-danger" id="batal">Cancel</button>
                    </form>
                    <form method="get" class="form-inline">
                        <?php
                        $dari = date("Y-m-d", strtotime("-5 days"));
                        $ke = date("Y-m-d");
                        $tagihan_type = "";
                        if (isset($_GET["dari"])) {
                            $dari = $_GET["dari"];
                        }
                        if (isset($_GET["ke"])) {
                            $ke = $_GET["ke"];
                        }
                        if (isset($_GET["tagihan_type"])) {
                            $tagihan_type = $_GET["tagihan_type"];
                        }
                        ?>

                        <label class="text-dark">Dari :</label>
                        <input type="date" class="form-control" placeholder="Dari" name="dari" value="<?= $dari; ?>">
                        <label class="text-dark">Ke :</label>
                        <input type="date" class="form-control" placeholder="Ke" name="ke" value="<?= $ke; ?>">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </form>
                    <div class="table-responsive m-t-40">
                        <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <!-- <table id="dataTable" class="table table-condensed table-hover w-auto dtable"> -->
                            <thead class="">
                                <tr>
                                    <?php if (!isset($_GET["report"])) { ?>
                                        <th>Action</th>
                                    <?php } ?>
                                    <!-- <th>No.</th> -->
                                    <th>Club</th>
                                    <th>Tanggal</th>
                                    <th>Class</th>
                                    <th>Member</th>
                                    <th>Tagihan</th>
                                    <th>Nominal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $build = $this->db
                                    ->table("tagihan")
                                    ->select("*,tagihan.user_id as user_id")
                                    ->join("class", "class.class_id=tagihan.class_id", "left")
                                    ->join("user", "user.user_id=tagihan.user_id", "left")
                                    ->join("schools", "schools.schools_id=tagihan.schools_id", "left");
                                if ($this->session->get("position_id") > -1) {
                                    $build->where("tagihan.schools_id", $this->session->get("schools_id"));
                                }
                                if (isset($_GET["dari"]) && isset($_GET["ke"])) {
                                    $build->where("tagihan.tagihan_date >=", $_GET["dari"]);
                                    $build->where("tagihan.tagihan_date <=", $_GET["ke"]);
                                }
                                $usr = $build
                                    ->orderBy("tagihan.schools_id", "ASC")
                                    ->orderBy("tagihan.user_id", "ASC")
                                    ->orderBy("tagihan.tagihan_nominal", "ASC")
                                    ->get();

                                //echo $this->db->getLastquery();
                                $no = 1;
                                foreach ($usr->getResult() as $usr) { ?>
                                    <tr>
                                        <?php if (!isset($_GET["report"])) { ?>
                                            <td style="padding-left:0px; padding-right:0px;">
                                                <form method="post" class="btn-action" style="">
                                                    <button type="button" onclick="editn('<?= $usr->tagihan_id; ?>')" class="btn btn-sm btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
                                                    <input type="hidden" id="tagihan_id<?= $usr->tagihan_id; ?>" name="tagihan_id" value="<?= $usr->tagihan_id; ?>" />
                                                    <input type="hidden" id="schools_id<?= $usr->tagihan_id; ?>" name="schools_id" value="<?= $usr->schools_id; ?>" />
                                                    <input type="hidden" id="user_id<?= $usr->tagihan_id; ?>" name="user_id" value="<?= $usr->user_id; ?>" />
                                                    <input type="hidden" id="class_id<?= $usr->tagihan_id; ?>" name="class_id" value="<?= $usr->class_id; ?>" />
                                                    <input type="hidden" id="tagihan_nominal<?= $usr->tagihan_id; ?>" name="tagihan_nominal" value="<?= $usr->tagihan_nominal; ?>" />
                                                    <input type="hidden" id="tagihan_name<?= $usr->tagihan_id; ?>" name="tagihan_name" value="<?= $usr->tagihan_name; ?>" />
                                                    <input type="hidden" id="user_id<?= $usr->tagihan_id; ?>" name="user_id" value="<?= $usr->user_id; ?>" />
                                                    <input type="hidden" id="tagihan_date<?= $usr->tagihan_id; ?>" name="tagihan_date" value="<?= $usr->tagihan_date; ?>" />
                                                </form>
                                                <form method="post" class="btn-action" style="">
                                                    <button class="btn btn-sm btn-danger delete" onclick="return confirm(' you want to delete?');" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
                                                    <input type="hidden" name="tagihan_id" value="<?= $usr->tagihan_id; ?>" />
                                                </form>
                                            </td>
                                        <?php } ?>
                                        <!-- <td><?= $no++; ?></td> -->
                                        <td><?= $usr->schools_name; ?></td>
                                        <td><?= $usr->tagihan_date; ?></td>
                                        <td><?= ($usr->class_name=="")?"ALL":$usr->class_name; ?></td>
                                        <td><?= ($usr->user_name=="")?"ALL":$usr->user_name; ?></td>
                                        <td><?= $usr->tagihan_name; ?></td>
                                        <td class="text-right"><?= number_format($usr->tagihan_nominal,0,",","."); ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $("#batal").hide();
    });

    function batalin() {
        $("#eksekusi").attr("name", "create");
        $("#eksekusi").text("Create");
        $("#batal").hide();

        let schools_id = $("#schools_id").val();
        $("#formeksekusi")[0].reset();
        $("#schools_id").val(schools_id);
    }

    function editn(id) {
        let schools_id = $("#schools_id" + id).val();
        let tagihan_id = $("#tagihan_id" + id).val();
        let user_id = $("#user_id" + id).val();
        let class_id = $("#class_id" + id).val();
        let tagihan_name = $("#tagihan_name" + id).val();
        let tagihan_nominal = $("#tagihan_nominal" + id).val();
        let tagihan_date = $("#tagihan_date" + id).val();

        $("#schools_id").val(schools_id);
        $("#tagihan_id").val(tagihan_id);
        $("#user_id").val(user_id);
        $("#class_id").val(class_id);
        $("#tagihan_name").val(tagihan_name);
        $("#tagihan_nominal").val(tagihan_nominal);
        $("#tagihan_date").val(tagihan_date);
        $("#eksekusi").attr("name", "change");
        $("#eksekusi").text("Update");
        $("#batal").show();
    }
    var title = "<?= $title; ?>";
    $("title").text(title);
    $(".card-title").text(title);
    $("#page-title").text(title);
    $("#page-title-link").text(title);
</script>


<?php require_once(APPPATH . "Views/Template/footer_v.php"); ?>