<?php require_once(APPPATH . "Views/Template2/header_v.php"); ?>

<!-- ======= Hero Section ======= -->
<section id="hero">
    <div class="hero-container">
        <div id="heroCarousel" data-bs-interval="5000" class="carousel slide carousel-fade" data-bs-ride="carousel">

            <ol class="carousel-indicators" id="hero-carousel-indicators"></ol>

            <div class="carousel-inner" role="listbox">

                <!-- Slide 1 -->
                <div class="carousel-item active" style="background: url(<?= base_url("images/global/brain-background.jpg"); ?>);">
                    <div class="carousel-container">
                        <div class="carousel-content">
                            <h2 class="animate__animated animate__fadeInDown"><span><?= $identity->identity_name; ?></span> </h2>
                            <p class="animate__animated animate__fadeInUp">Welcome <?= $this->session->get("user_name"); ?></p>
                            <div>
                                <?php if ($this->session->get("schools_mbti") == 1) { ?>
                                    <a href="<?= base_url("transactionm/qmbti"); ?>" class="btn-menu animate__animated animate__fadeInUp scrollto">Start MBTI</a>
                                <?php } ?>
                                <?php if ($this->session->get("schools_papi") == 1) { ?>
                                    <a href="<?= base_url("transactionm/qpapi"); ?>" class="btn-menu animate__animated animate__fadeInUp scrollto">Start PAPI</a>
                                <?php } ?>
                                <?php if ($this->session->get("schools_ist") == 1) { ?>
                                    <a href="<?= base_url("transactionm/qist"); ?>" class="btn-menu animate__animated animate__fadeInUp scrollto">Start IST</a>
                                <?php } ?>
                                <?php if ($this->session->get("schools_sds") == 1) { ?>
                                    <a href="<?= base_url("transactionm/qsds"); ?>" class="btn-menu animate__animated animate__fadeInUp scrollto">Start SDS</a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Slide 2 -->
                <div class="carousel-item" style="background: url(<?= base_url("images/global/1533504.jpg"); ?>);">
                    <div class="carousel-container">
                        <div class="carousel-content">
                            <h2 class="animate__animated animate__fadeInDown"><?= $identity->identity_name; ?></h2>
                            <p class="animate__animated animate__fadeInUp">Access for <?= $this->session->get("schools_name"); ?></p>
                            <div>
                                <?php if ($this->session->get("schools_mbti") == 1) { ?>
                                    <a href="<?= base_url("transactionm/qmbti"); ?>" class="btn-menu animate__animated animate__fadeInUp scrollto">Start MBTI</a>
                                <?php } ?>
                                <?php if ($this->session->get("schools_papi") == 1) { ?>
                                    <a href="<?= base_url("transactionm/qpapi"); ?>" class="btn-menu animate__animated animate__fadeInUp scrollto">Start PAPI</a>
                                <?php } ?>
                                <?php if ($this->session->get("schools_ist") == 1) { ?>
                                    <a href="<?= base_url("transactionm/qist"); ?>" class="btn-menu animate__animated animate__fadeInUp scrollto">Start IST</a>
                                <?php } ?>
                                <?php if ($this->session->get("schools_sds") == 1) { ?>
                                    <a href="<?= base_url("transactionm/qsds"); ?>" class="btn-menu animate__animated animate__fadeInUp scrollto">Start SDS</a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>



            </div>

            <a class="carousel-control-prev" href="#heroCarousel" role="button" data-bs-slide="prev">
                <span class="carousel-control-prev-icon bi bi-chevron-left" aria-hidden="true"></span>
            </a>

            <a class="carousel-control-next" href="#heroCarousel" role="button" data-bs-slide="next">
                <span class="carousel-control-next-icon bi bi-chevron-right" aria-hidden="true"></span>
            </a>

        </div>
    </div>
</section><!-- End Hero -->


<?php require_once(APPPATH . "Views/Template2/footer_v.php"); ?>