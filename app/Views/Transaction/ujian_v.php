<?php require_once(APPPATH . "Views/Template/header_v.php"); ?>

<div class='container-fluid'>
    <div class='row'>
        <div class='col-12'>
            <div class="card">
                <div class="card-body">


                    <div class="row">
                        <?php if (!isset($_GET['ujian_id']) && !isset($_POST['new']) && !isset($_POST['edit'])) {
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
                        <input type="date" class="form-control" placeholder="Tanggal" id="ujian_date" name="ujian_date">
                        <input type="text" class="form-control" placeholder="Nama Ujian" id="ujian_name" name="ujian_name">
                        <input type="hidden" id="ujian_id" name="ujian_id">

                        <button type="submit" class="btn btn-primary" id="eksekusi" name="create" value="OK">Create</button>
                        <button type="button" onclick="batalin()" class="btn btn-danger" id="batal">Cancel</button>
                    </form>
                    <form method="get" class="form-inline">
                        <?php
                        $dari = date("Y-m-d", strtotime("-5 days"));
                        $ke = date("Y-m-d");
                        $ujian_type = "";
                        if (isset($_GET["dari"])) {
                            $dari = $_GET["dari"];
                        }
                        if (isset($_GET["ke"])) {
                            $ke = $_GET["ke"];
                        }
                        if (isset($_GET["ujian_type"])) {
                            $ujian_type = $_GET["ujian_type"];
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
                                    <th>Ujian</th>
                                    <th></th>
                                    <th>Poin Penilaian</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                //poinpenilaian
                                $build = $this->db
                                    ->table("ujiand")
                                    ->join("ujian", "ujian.ujian_id=ujiand.ujian_id", "left")
                                    ->join("schools", "schools.schools_id=ujian.schools_id", "left");
                                if ($this->session->get("position_id") > -1) {
                                    $build->where("ujian.schools_id", $this->session->get("schools_id"));
                                }
                                if (isset($_GET["dari"]) && isset($_GET["ke"])) {
                                    $build->where("ujian.ujian_date >=", $_GET["dari"]);
                                    $build->where("ujian.ujian_date <=", $_GET["ke"]);
                                }
                                $usr = $build
                                    ->orderBy("ujian.schools_id", "ASC")
                                    ->orderBy("ujian.ujian_date", "ASC")
                                    ->orderBy("ujian.ujian_name", "ASC")
                                    ->get();

                                //echo $this->db->getLastquery();
                                $no = 1;
                                $arpoin = array();
                                foreach ($usr->getResult() as $row) {
                                    $arpoin[$row->ujian_id][] = [
                                        'id' => $row->ujiand_id,
                                        'name' => $row->ujiand_name,
                                    ];
                                }

                                //ujian
                                $build = $this->db
                                    ->table("ujian")
                                    ->join("schools", "schools.schools_id=ujian.schools_id", "left");
                                if ($this->session->get("position_id") > -1) {
                                    $build->where("ujian.schools_id", $this->session->get("schools_id"));
                                }
                                if (isset($_GET["dari"]) && isset($_GET["ke"])) {
                                    $build->where("ujian.ujian_date >=", $_GET["dari"]);
                                    $build->where("ujian.ujian_date <=", $_GET["ke"]);
                                }
                                $usr = $build
                                    ->orderBy("ujian.schools_id", "ASC")
                                    ->orderBy("ujian.ujian_date", "ASC")
                                    ->orderBy("ujian.ujian_name", "ASC")
                                    ->get();

                                //echo $this->db->getLastquery();
                                $no = 1;
                                foreach ($usr->getResult() as $usr) { ?>
                                    <tr>
                                        <?php if (!isset($_GET["report"])) { ?>
                                            <td style="padding-left:0px; padding-right:0px;">
                                                <form method="post" class="btn-action" style="">
                                                    <button class="btn btn-sm btn-danger delete" onclick="return confirm(' you want to delete?');" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
                                                    <input type="hidden" name="ujian_id" value="<?= $usr->ujian_id; ?>" />
                                                </form>
                                                <form method="post" class="btn-action" style="">
                                                    <button type="button" onclick="editn('<?= $usr->ujian_id; ?>')" class="btn btn-sm btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
                                                    <input type="hidden" id="ujian_id<?= $usr->ujian_id; ?>" name="ujian_id" value="<?= $usr->ujian_id; ?>" />
                                                    <input type="hidden" id="schools_id<?= $usr->ujian_id; ?>" name="schools_id" value="<?= $usr->schools_id; ?>" />
                                                    <input type="hidden" id="ujian_name<?= $usr->ujian_id; ?>" name="ujian_name" value="<?= $usr->ujian_name; ?>" />
                                                    <input type="hidden" id="ujian_date<?= $usr->ujian_id; ?>" name="ujian_date" value="<?= $usr->ujian_date; ?>" />
                                                </form>
                                            </td>
                                        <?php } ?>
                                        <!-- <td><?= $no++; ?></td> -->
                                        <td><?= $usr->schools_name; ?></td>
                                        <td><?= $usr->ujian_date; ?></td>
                                        <td><?= $usr->ujian_name; ?></td>
                                        <td style="white-space: nowrap;">
                                            <span onclick="pointoggle(<?= $usr->ujian_id; ?>)" class="btn btn-success fa fa-plus"></span>
                                            <span class="poin" id="poin<?= $usr->ujian_id; ?>">
                                                <input type="text" id="ujiand_name<?= $usr->ujian_id; ?>" />
                                                <button onclick="submitpoin(<?= $usr->ujian_id; ?>)" class="btn btn-xs btn-primary">Submit</button>
                                            </span>
                                        </td>
                                        <td>

                                            <span class="dpoin" id="dpoin<?= $usr->ujian_id; ?>">
                                                <?php if (!empty($arpoin[$usr->ujian_id])) { ?>
                                                    <?php foreach ($arpoin[$usr->ujian_id] as $arpo) { ?>
                                                        <span onclick="poindelete(<?= esc($arpo["id"]); ?>,<?= $usr->ujian_id; ?>)" class="btn btn-danger fa fa-times"></span> <?= esc($arpo["name"]); ?>,
                                                    <?php } ?>
                                                <?php } else { ?>
                                                    <em><small>(Belum ada poin)</small></em>
                                                <?php } ?>
                                            </span>
                                        </td>
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
    function poindelete(id, ujid) {
        let ujiand_id = id;
        let url = "<?= base_url("api/poindelete"); ?>?ujiand_id=" + ujiand_id + "&ujian_id=" + ujid;
        // alert(url);
        $.get("<?= base_url("api/poindelete"); ?>", {
                ujiand_id: ujiand_id,
                ujian_id: ujid
            })
            .done(function(data) {
                $("#dpoin" + ujid).html(data);
            });
    }

    function submitpoin(id) {
        let ujiand_name = $("#ujiand_name" + id).val();
        let ujian_id = id;
        let url = "<?= base_url("api/submitpoin"); ?>?ujian_id=" + ujian_id + "&ujiand_name=" + ujiand_name;
        // alert(url);
        $.get("<?= base_url("api/submitpoin"); ?>", {
                ujian_id: ujian_id,
                ujiand_name: ujiand_name,
                schools_id: '<?= session()->get("schools_id"); ?>'
            })
            .done(function(data) {
                $("#dpoin" + id).html(data);
                $("#ujiand_name" + id).val("");
                $("#poin" + id).toggle();
            });
    }

    function pointoggle(id) {
        $("#poin" + id).toggle();
        $("#ujiand_name" + id).focus();
    }
    $(document).ready(function() {
        $("#batal").hide();
        $(".poin").hide();
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
        let ujian_id = $("#ujian_id" + id).val();
        let ujian_date = $("#ujian_date" + id).val();
        let ujian_name = $("#ujian_name" + id).val();

        $("#schools_id").val(schools_id);
        $("#ujian_id").val(ujian_id);
        $("#ujian_date").val(ujian_date);
        $("#ujian_name").val(ujian_name);
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