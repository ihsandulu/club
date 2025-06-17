<?php require_once(APPPATH . "Views/Template2/header_v.php"); ?>
<style>
    .font14 {
        font-size: 14px !important;
    }

    .section-title1 {
        margin-top: 100px;
        padding-top: 80px;
        margin-bottom: 80px;
        border-top: bisque solid 1px;
        text-align: center;
    }
</style>

<div style="background-color: #68346F; height:150px;">&nbsp;?></div>
<main id="main">

    <!-- ======= About Section ======= -->
    <section id="about" class="about">
        <div class="container-fluid">

            <div class="row">

                <div class="col-lg-5 align-items-stretch video-box" style='background-image: url("assets/img/about.jpg");'>
                    <div class="section-title">
                        <h2>Penilaian</h2>
                        <p id="waktu">
                            <a href="<?= base_url(); ?>" class="btn btn-warning btn-lg btn-block">
                                << BACK</a>
                        </p>
                    </div>
                </div>

                <div class="col-lg-7 d-flex flex-column justify-content-center align-items-stretch">

                    <div class="content">
                        <h3>Penilaian <strong>(<?= session()->get("user_name"); ?>)</strong></h3>
                        <p class="fst-italic">Poin Penilaian</p>
                        <ul>
                            <li><i class="bx bx-check-double"></i>
                                <?php
                                $nilai = $this->db->table("nilai")
                                    ->join("ujian", "ujian.ujian_id=nilai.ujian_id", "left")
                                    ->join("ujiand", "ujiand.ujiand_id=nilai.ujiand_id", "left")
                                    ->where("user_id", session()->get("user_id"))
                                    ->get();
                                // echo $this->db->getLastQuery();
                                $arnilai = array();
                                foreach ($nilai->getResult() as $nilai) {
                                    $arnilai[$nilai->ujian_id][] = [
                                        "name" => $nilai->ujiand_name,
                                        "nominal" => $nilai->nilai_nominal
                                    ];
                                }
                                $nilai = $this->db->table("nilai")
                                    ->join("ujian", "ujian.ujian_id=nilai.ujian_id", "left")
                                    ->where("user_id", session()->get("user_id"))
                                    ->groupBy("nilai.ujian_id")
                                    ->get();
                                // echo $this->db->getLastQuery();
                                foreach ($nilai->getResult() as $nilai) { ?>
                                    <div class="alert alert-success">
                                        <div class="mb-2"><?= $nilai->ujian_name; ?></div>
                                        <?php if (isset($arnilai[$nilai->ujian_id]) && is_array($arnilai[$nilai->ujian_id])): ?>
                                            <?php foreach ($arnilai[$nilai->ujian_id] as $nil): ?>
                                                <div class="alert alert-warning">
                                                    <?= esc($nil["name"]); ?> = <?= esc($nil["nominal"]); ?>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <div class="alert alert-info">
                                                Belum ada nilai untuk ujian ini.
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php } ?>
                            </li>
                        </ul>
                    </div>

                </div>

            </div>

        </div>
    </section><!-- End About Section -->




</main><!-- End #main -->


<?php require_once(APPPATH . "Views/Template2/footer_v.php"); ?>