<?php require_once(APPPATH . "Views/Template/header_v.php"); ?>

<div class='container-fluid'>
    <div class='row'>
        <div class='col-12'>
            <div class="card">
                <div class="card-body">


                    <div class="row">
                        <?php if (!isset($_GET['nilai_id']) && !isset($_POST['new']) && !isset($_POST['edit'])) {
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
                        <select onchange="pilihpoin(0,0)" class="form-control" id="ujian_id" name="ujian_id">
                            <option value="0">Pilih Ujian</option>
                            <?php $build = $this->db->table("ujian");
                            if (session()->get("position_id") > -1) {
                                $build->where("schools_id", session()->get("schools_id"));
                            }
                            $ujian = $build->get();
                            foreach ($ujian->getResult() as $row) { ?>
                                <option value="<?= $row->ujian_id; ?>">(<?= $row->ujian_date; ?>) <?= $row->ujian_name; ?></option>
                            <?php } ?>
                        </select>
                        <select required class="form-control" id="ujiand_id" name="ujiand_id">
                            <option value="">Pilih Ujian Dulu!</option>
                        </select>
                        <script>
                            function pilihpoin(ujiand_id,ujian_id) {
                                if (ujian_id == 0) {
                                    ujian_id = $("#ujian_id").val();
                                }
                                $.get("<?= base_url("api/pilihpoin"); ?>", {
                                        ujian_id: ujian_id
                                    })
                                    .done(function(data) {
                                        $("#ujiand_id").html(data);
                                        $("#ujiand_id").val(ujiand_id);
                                    });
                            }
                        </script>
                        <select class="form-control" id="user_id" name="user_id">
                            <option value="0">Pilih Member</option>
                            <?php $build = $this->db->table("user");
                            if (session()->get("position_id") > -1) {
                                $build->where("schools_id", session()->get("schools_id"));
                            }
                            $user = $build->get();
                            foreach ($user->getResult() as $row) { ?>
                                <option value="<?= $row->user_id; ?>"><?= $row->user_name; ?></option>
                            <?php } ?>
                        </select>
                        <input type="text" class="form-control" placeholder="Nilai" id="nilai_nominal" name="nilai_nominal">
                        <input type="hidden" id="nilai_id" name="nilai_id">

                        <button type="submit" class="btn btn-primary" id="eksekusi" name="create" value="OK">Create</button>
                        <button type="button" onclick="batalin()" class="btn btn-danger" id="batal">Cancel</button>
                    </form>
                    <form method="get" class="form-inline">
                        <?php
                        $dari = date("Y-m-d", strtotime("-5 days"));
                        $ke = date("Y-m-d");
                        $nilai_type = "";
                        if (isset($_GET["dari"])) {
                            $dari = $_GET["dari"];
                        }
                        if (isset($_GET["ke"])) {
                            $ke = $_GET["ke"];
                        }
                        if (isset($_GET["nilai_type"])) {
                            $nilai_type = $_GET["nilai_type"];
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
                                    <th>Member</th>
                                    <th>Ujian</th>
                                    <th>Poin Penilaian</th>
                                    <th>Nilai</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $build = $this->db
                                    ->table("nilai")
                                    ->join("ujian", "ujian.ujian_id=nilai.ujian_id", "left")
                                    ->join("ujiand", "ujiand.ujiand_id=nilai.ujiand_id", "left")
                                    ->join("user", "user.user_id=nilai.user_id", "left")
                                    ->join("schools", "schools.schools_id=nilai.schools_id", "left");
                                if ($this->session->get("position_id") > -1) {
                                    $build->where("nilai.schools_id", $this->session->get("schools_id"));
                                }
                                if (isset($_GET["dari"]) && isset($_GET["ke"])) {
                                    $build->where("ujian.ujian_date >=", $_GET["dari"]);
                                    $build->where("ujian.ujian_date <=", $_GET["ke"]);
                                }
                                $usr = $build
                                    ->orderBy("nilai.schools_id", "ASC")
                                    ->orderBy("nilai.user_id", "ASC")
                                    ->orderBy("nilai.nilai_nominal", "ASC")
                                    ->get();

                                //echo $this->db->getLastquery();
                                $no = 1;
                                foreach ($usr->getResult() as $usr) { ?>
                                    <tr>
                                        <?php if (!isset($_GET["report"])) { ?>
                                            <td style="padding-left:0px; padding-right:0px;">
                                                <form method="post" class="btn-action" style="">
                                                    <button type="button" onclick="editn('<?= $usr->nilai_id; ?>')" class="btn btn-sm btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
                                                    <input type="hidden" id="nilai_id<?= $usr->nilai_id; ?>" name="nilai_id" value="<?= $usr->nilai_id; ?>" />
                                                    <input type="hidden" id="schools_id<?= $usr->nilai_id; ?>" name="schools_id" value="<?= $usr->schools_id; ?>" />
                                                    <input type="hidden" id="user_id<?= $usr->nilai_id; ?>" name="user_id" value="<?= $usr->user_id; ?>" />
                                                    <input type="hidden" id="ujian_id<?= $usr->nilai_id; ?>" name="ujian_id" value="<?= $usr->ujian_id; ?>" />
                                                    <input type="hidden" id="ujiand_id<?= $usr->nilai_id; ?>" name="ujiand_id" value="<?= $usr->ujiand_id; ?>" />
                                                    <input type="hidden" id="nilai_nominal<?= $usr->nilai_id; ?>" name="nilai_nominal" value="<?= $usr->nilai_nominal; ?>" />
                                                    <input type="hidden" id="user_id<?= $usr->nilai_id; ?>" name="user_id" value="<?= $usr->user_id; ?>" />
                                                </form>
                                                <form method="post" class="btn-action" style="">
                                                    <button class="btn btn-sm btn-danger delete" onclick="return confirm(' you want to delete?');" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
                                                    <input type="hidden" name="nilai_id" value="<?= $usr->nilai_id; ?>" />
                                                </form>
                                            </td>
                                        <?php } ?>
                                        <!-- <td><?= $no++; ?></td> -->
                                        <td><?= $usr->schools_name; ?></td>
                                        <td><?= $usr->ujian_date; ?></td>
                                        <td><?= $usr->user_name; ?></td>
                                        <td><?= $usr->ujian_name; ?></td>
                                        <td><?= $usr->ujiand_name; ?></td>
                                        <td><?= $usr->nilai_nominal; ?></td>
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
        let nilai_id = $("#nilai_id" + id).val();
        let user_id = $("#user_id" + id).val();
        let ujiand_id = $("#ujiand_id" + id).val();
        let ujian_id = $("#ujian_id" + id).val();
        let nilai_nominal = $("#nilai_nominal" + id).val();
        pilihpoin(ujiand_id,ujian_id);

        
        $("#schools_id").val(schools_id);
        $("#nilai_id").val(nilai_id);
        $("#user_id").val(user_id);
        $("#ujian_id").val(ujian_id);
        $("#nilai_nominal").val(nilai_nominal);
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