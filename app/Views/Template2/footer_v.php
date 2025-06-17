<!-- ======= Footer ======= -->
<footer id="footer">
    <div class="container">
        <h3><?= session()->get("schools_name"); ?></h3>
        <p><?= session()->get("schools_address"); ?></p>
        <!-- <div class="social-links">
            <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
            <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
            <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
            <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
            <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
        </div> -->
        <div class="copyright">
            &copy; Copyright <strong><span><?= $identity->identity_name; ?></span></strong>. All Rights Reserved
        </div>
        <div class="credits">
            <!-- All the links in the footer should remain intact. -->
            <!-- You can delete the links only if you purchased the pro version. -->
            <!-- Licensing information: https://bootstrapmade.com/license/ -->
            <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/delicious-free-restaurant-bootstrap-theme/ -->
            Built by <a href="https://www.qithy.com/">Qithy.com</a><br />
            Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
        </div>
    </div>
</footer><!-- End Footer -->

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
<script src="<?= base_url("assets/vendor/bootstrap/js/bootstrap.bundle.min.js"); ?>"></script>
<script src="<?= base_url("assets/vendor/glightbox/js/glightbox.min.js"); ?>""></script>
<script src=" <?= base_url("assets/vendor/isotope-layout/isotope.pkgd.min.js"); ?>""></script>
<script src="<?= base_url("assets/vendor/swiper/swiper-bundle.min.js"); ?>""></script>
<script src=" <?= base_url("assets/vendor/php-email-form/validate.js"); ?>""></script>

<!-- Template Main JS File -->
<script src="<?= base_url("assets/js/main.js"); ?>"></script>

<link href="<?= base_url("css/lib/toastr/toastr.min.css"); ?>" rel="stylesheet">
<script src="<?= base_url("js/lib/toastr/toastr.min.js"); ?>"></script>
<script src="<?= base_url("js/lib/toastr/toastr.init.js"); ?>"></script>
<script>
    function toast(judul, isi) {
        toastr.warning(isi, judul, {
            "positionClass": "toast-bottom-right",
            timeOut: 2000,
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "preventDuplicates": true,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut",
            "tapToDismiss": false

        })
    }
</script>

</body>

</html>