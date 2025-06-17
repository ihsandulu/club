<?php require_once(APPPATH . "Views/Template/header_v.php"); ?>

<div class='container-fluid'>
    <div class='row'>
        <div class='col-12'>
            <div class="card">
                <div class="card-body">


                    <div class="row">
                        <?php if (!isset($_GET['pay_id']) && !isset($_POST['new']) && !isset($_POST['edit'])) {
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
                        <input type="date" class="form-control" id="pay_date" name="pay_date" />
                        <select onchange="nom()" class="form-control" id="tagihan_id" name="tagihan_id">
                            <option value="0">Semua Tagihan</option>
                            <?php $build = $this->db->table("tagihan");
                            if (session()->get("position_id") > -1) {
                                $build->where("schools_id", session()->get("schools_id"));
                            }
                            $class = $build->get();
                            foreach ($class->getResult() as $row) { ?>
                                <option data-nom="<?= $row->tagihan_nominal; ?>" value="<?= $row->tagihan_id; ?>"><?= $row->tagihan_name; ?></option>
                            <?php } ?>
                        </select>
                        <script>
                            function nom() {
                                let tagihan_id = $("#tagihan_id option:selected").data("nom");
                                $("#pay_nominal").val(tagihan_id);
                            }
                        </script>
                        <select onchange="isikelas()" required class="form-control" id="user_id" name="user_id">
                            <option value="">Pilih Member</option>
                            <?php $build = $this->db->table("user");
                            if (session()->get("position_id") > -1) {
                                $build->where("schools_id", session()->get("schools_id"));
                            }
                            $user = $build->get();
                            foreach ($user->getResult() as $row) { ?>
                                <option data-class="<?= $row->user_class; ?>" value="<?= $row->user_id; ?>"><?= $row->user_name; ?></option>
                            <?php } ?>
                        </select>
                        <script>
                            function isikelas() {
                                let kelas = $("#user_id option:selected").data("class");
                                $("#class_id").val(kelas);
                            }
                        </script>
                        <input type="text" class="form-control" placeholder="Nominal pay" id="pay_nominal" name="pay_nominal">
                        <input type="hidden" id="pay_id" name="pay_id">
                        <input type="hidden" id="class_id" name="class_id">

                        <button type="submit" class="btn btn-primary" id="eksekusi" name="create" value="OK">Create</button>
                        <button type="button" onclick="batalin()" class="btn btn-danger" id="batal">Cancel</button>
                    </form>
                    <select required class="mr-2" id="tipepencarian" name="tipepencarian" style="float:left; border-radius:5px; padding:6px; border:#d8d8d8 solid 1px;">
                        <option value="">Tipe Pencarian</option>
                        <option value="tanggal">Tanggal</option>
                        <option value="member">Member</option>
                    </select>
                    <script>
                        function pilihtipe() {
                            $(".tipe").hide();
                        }
                    </script>
                    <form method="get" class="form-inline" id="tanggal">
                        <?php
                        $dari = date("Y-m-d", strtotime("-5 days"));
                        $ke = date("Y-m-d");
                        if (isset($_GET["dari"])) {
                            $dari = $_GET["dari"];
                        }
                        if (isset($_GET["ke"])) {
                            $ke = $_GET["ke"];
                        }
                        ?>

                        <label class="text-dark mr-2">Dari :</label>
                        <input type="date" class="form-control mr-2" placeholder="Dari" name="dari" value="<?= $dari; ?>">
                        <label class="text-dark mr-2">Ke :</label>
                        <input type="date" class="form-control mr-2" placeholder="Ke" name="ke" value="<?= $ke; ?>">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </form>
                    <form method="get" class="form-inline" id="member">
                        <?php
                        $member = 0;
                        if (isset($_GET["member"])) {
                            $member = $_GET["member"];
                        }
                        ?>

                        <label class="text-dark mr-2">Member :</label>
                        <select required class="form-control mr-2" id="user_id" name="user_id">
                            <option value="">Pilih Member</option>
                            <?php $build = $this->db->table("user");
                            if (session()->get("position_id") > -1) {
                                $build->where("schools_id", session()->get("schools_id"));
                            }
                            $user = $build->get();
                            foreach ($user->getResult() as $row) { ?>
                                <option value="<?= $row->user_id; ?>"><?= $row->user_name; ?></option>
                            <?php } ?>
                        </select>
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
                                    <th>Tagihan</th>
                                    <th>Member</th>
                                    <th>Pay</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $build = $this->db
                                    ->table("pay")
                                    ->select("*,pay.user_id as user_id")
                                    ->join("tagihan", "tagihan.tagihan_id=pay.tagihan_id", "left")
                                    ->join("user", "user.user_id=pay.user_id", "left")
                                    ->join("schools", "schools.schools_id=pay.schools_id", "left");
                                if ($this->session->get("position_id") > -1) {
                                    $build->where("pay.schools_id", $this->session->get("schools_id"));
                                }
                                if (isset($_GET["dari"]) && isset($_GET["ke"])) {
                                    $build->where("pay.pay_date >=", $_GET["dari"]);
                                    $build->where("pay.pay_date <=", $_GET["ke"]);
                                }
                                $usr = $build
                                    ->orderBy("pay.schools_id", "ASC")
                                    ->orderBy("pay.user_id", "ASC")
                                    ->orderBy("pay.pay_nominal", "ASC")
                                    ->get();

                                //echo $this->db->getLastquery();
                                $no = 1;
                                foreach ($usr->getResult() as $usr) { ?>
                                    <tr>
                                        <?php if (!isset($_GET["report"])) { ?>
                                            <td style="padding-left:0px; padding-right:0px;">
                                                <form method="post" class="btn-action" style="">
                                                    <button type="button" onclick="editn('<?= $usr->pay_id; ?>')" class="btn btn-sm btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
                                                    <input type="hidden" id="pay_id<?= $usr->pay_id; ?>" name="pay_id" value="<?= $usr->pay_id; ?>" />
                                                    <input type="hidden" id="schools_id<?= $usr->pay_id; ?>" name="schools_id" value="<?= $usr->schools_id; ?>" />
                                                    <input type="hidden" id="user_id<?= $usr->pay_id; ?>" name="user_id" value="<?= $usr->user_id; ?>" />
                                                    <input type="hidden" id="tagihan_id<?= $usr->pay_id; ?>" name="tagihan_id" value="<?= $usr->tagihan_id; ?>" />
                                                    <input type="hidden" id="pay_nominal<?= $usr->pay_id; ?>" name="pay_nominal" value="<?= $usr->pay_nominal; ?>" />
                                                    <input type="hidden" id="user_id<?= $usr->pay_id; ?>" name="user_id" value="<?= $usr->user_id; ?>" />
                                                    <input type="hidden" id="pay_date<?= $usr->pay_id; ?>" name="pay_date" value="<?= $usr->pay_date; ?>" />
                                                    <input type="hidden" id="class_id<?= $usr->pay_id; ?>" name="class_id" value="<?= $usr->class_id; ?>" />
                                                </form>
                                                <form method="post" class="btn-action" style="">
                                                    <button class="btn btn-sm btn-danger delete" onclick="return confirm(' you want to delete?');" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
                                                    <input type="hidden" name="pay_id" value="<?= $usr->pay_id; ?>" />
                                                </form>
                                            </td>
                                        <?php } ?>
                                        <!-- <td><?= $no++; ?></td> -->
                                        <td><?= $usr->schools_name; ?></td>
                                        <td><?= $usr->pay_date; ?></td>
                                        <td><?= $usr->tagihan_name; ?></td>
                                        <td><?= $usr->user_name; ?></td>
                                        <td class="text-right"><?= number_format($usr->pay_nominal, 0, ",", "."); ?></td>
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
        let pay_id = $("#pay_id" + id).val();
        let user_id = $("#user_id" + id).val();
        let tagihan_id = $("#tagihan_id" + id).val();
        let pay_nominal = $("#pay_nominal" + id).val();
        let pay_date = $("#pay_date" + id).val();
        let class_id = $("#class_id" + id).val();

        $("#schools_id").val(schools_id);
        $("#pay_id").val(pay_id);
        $("#user_id").val(user_id);
        $("#tagihan_id").val(tagihan_id);
        $("#pay_nominal").val(pay_nominal);
        $("#pay_date").val(pay_date);
        $("#class_id").val(class_id);
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