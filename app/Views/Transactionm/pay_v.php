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
                        <h2>Tagihan</h2>
                        <p id="waktu">
                            <a href="<?= base_url(); ?>" class="btn btn-warning btn-lg btn-block">
                                << BACK</a>
                        </p>
                    </div>
                </div>

                <div class="col-lg-7 d-flex flex-column justify-content-center align-items-stretch">

                    <div class="content">
                        <h3>Tagihan <strong>(<?= session()->get("user_name"); ?>)</strong></h3>
                        <p class="fst-italic">Tagihan</p>
                        <ul>
                            <li><i class="bx bx-check-double"></i>
                                <?php
                                $pay = $this->db->table("pay")
                                    ->join("tagihan", "tagihan.tagihan_id=pay.tagihan_id", "left")
                                    ->where("pay.user_id", session()->get("user_id"))
                                    ->get();
                                // echo $this->db->getLastQuery();
                                $arpay = array();
                                foreach ($pay->getResult() as $pay) {
                                    $arpay[$pay->tagihan_id][] = [
                                        "date" => $pay->pay_date,
                                        "nominal" => $pay->pay_nominal
                                    ];
                                }
                                $tagihan = $this->db->table("tagihan")
                                    ->where("tagihan.class_id", session()->get("user_class"))
                                    ->where("tagihan.schools_id", session()->get("schools_id"))
                                    ->groupBy("tagihan.tagihan_id")
                                    ->get();
                                // echo $this->db->getLastQuery();
                                foreach ($tagihan->getResult() as $tagihan) { ?>
                                    <div class="alert alert-success">
                                        <div class="mb-2"><?= $tagihan->tagihan_name; ?> = Rp. <?= number_format($tagihan->tagihan_nominal,0,",","."); ?>,-</div>
                                        <?php if (isset($arpay[$tagihan->tagihan_id]) && is_array($arpay[$tagihan->tagihan_id])): ?>
                                            <?php foreach ($arpay[$tagihan->tagihan_id] as $nil): ?>
                                                <div class="alert alert-warning">
                                                    <?= esc($nil["date"]); ?> = Rp. <?= number_format($nil["nominal"],0,",","."); ?>,- 
                                                </div>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <div class="alert alert-danger">
                                                Belum dibayar!
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