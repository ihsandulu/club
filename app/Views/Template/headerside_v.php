<div class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="nav-devider"></li>
                <li class="nav-label">Home</li>
                <li>
                    <a class="has-arrow  " href="<?= base_url(); ?>" aria-expanded="false">
                        <i class="fa fa-tachometer"></i><span class="hide-menu">Dashboard</span>
                    </a>

                </li>
                <li class="nav-label">Master</li>
                <?php if ($this->session->get("position_id") == -1) { ?>
                    <li> <a class="  " href="<?= base_url("master/midentity"); ?>" aria-expanded="false"><i class="fa fa-globe"></i><span class="hide-menu">Identity</span></a></li>
                <?php } ?>
                <li> <a class="  " href="<?= base_url("master/mschools"); ?>" aria-expanded="false"><i class="fa fa-globe"></i><span class="hide-menu">Clubs</span></a></li>
                <li> <a class="  " href="<?= base_url("master/mmember"); ?>" aria-expanded="false"><i class="fa fa-globe"></i><span class="hide-menu">Member</span></a></li>
                
                <li class="nav-label">Transaction</li>
                <li> <a class="  " href="<?= base_url("transaction/ujian"); ?>" aria-expanded="false"><i class="fa fa-globe"></i><span class="hide-menu">Ujian</span></a></li>
                <li> <a class="  " href="<?= base_url("transaction/nilai"); ?>" aria-expanded="false"><i class="fa fa-globe"></i><span class="hide-menu">Penilaian</span></a></li>
                <li> <a class="  " href="<?= base_url("transaction/tagihan"); ?>" aria-expanded="false"><i class="fa fa-globe"></i><span class="hide-menu">Tagihan</span></a></li>
                <li> <a class="  " href="<?= base_url("transaction/pay"); ?>" aria-expanded="false"><i class="fa fa-money"></i><span class="hide-menu">Pembayaran</span></a></li>                


            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</div>