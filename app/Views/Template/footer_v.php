
</div>
</div>

<!--Toast-->
<div class="toast" data-autohide="false">
    <div class="toast-header">
        <strong class="mr-auto text-primary">Alert</strong>
        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button>
    </div>
    <div class="toast-body">
        asdfaf
    </div>
</div>

<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.forEach(function (tooltipTriggerEl) {
        new bootstrap.Tooltip(tooltipTriggerEl);
    });
</script>
<script>
    function showmessage(a) {
        //alert('<?= (isset($_GET['message'])) ? $_GET['message'] : $this->session->getFlashdata("message"); ?>');
        <?php
        if (isset($_GET['message'])) {
            $isipesan = $_GET['message'];
        } else {
            $isipesan = $this->session->getFlashdata("message");
        }
        ?>
        /* $('.toast-body').html('<?= $isipesan ?>');
        $('.toast').toast('show');
        if (a > 0) {
            setTimeout(function() {
                $('.toast').toast('hide');
            }, a);
        } */

        toast('INFO >>>', '<?= $isipesan ?>');
    }



    function toast(judul, isi) {
        toastr.warning(isi, judul, {
            "positionClass": "toast-bottom-right",
            timeOut: 3000,
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

    $(document).ready(function() {
        setTimeout(() => {
            $(".toast").fadeOut();
        }, 1000);
        $('#example23').DataTable({
            dom: 'Bfrtip',
            buttons: [{
                extend: 'excelHtml5',
                autoFilter: true,
                sheetName: 'Exported data'
            }]
        });
        $('#example231').DataTable({});

        /* $('.dtable').DataTable(); */
        $('.select').select2();
        <?php if ($this->session->getFlashdata("message") != "" || isset($_GET['message'])) { ?>
            showmessage(3000);
        <?php } ?>
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
<script type="text/javascript">
    function showHideRow(row) {
        $("#" + row).toggle();
    }
</script>


<!-- <script src="<?= base_url("js/lib/datatables/datatables.min.js');?>"); ?>"></script>
<script src="<?= base_url("js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js');?>"); ?>"></script>
<script src="<?= base_url("js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js');?>"); ?>"></script>
<script src="<?= base_url("js/lib/datatables/cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js');?>"); ?>"></script>
<script src="<?= base_url("js/lib/datatables/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js');?>"); ?>"></script>
<script src="<?= base_url("js/lib/datatables/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js');?>"); ?>"></script>
<script src="<?= base_url("js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js');?>"); ?>"></script>
<script src="<?= base_url("js/lib/datatables/datatables-init.js');?>"); ?>"></script> -->



<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.1.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.html5.min.js"></script>
<script src="<?= base_url("js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js');?>"); ?>"></script>





<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
</body>

</html>