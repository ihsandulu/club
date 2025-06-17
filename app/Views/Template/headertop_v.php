<?php
// $identity = $this->db->table("identity")->get()->getRow();
?>
<div class="header">
    <nav class="navbar top-navbar navbar-expand-md navbar-light">
        <div class="navbar-header">
            <a class="navbar-brand" href="<?= base_url(); ?>">
                <b><img src="<?= $this->session->get("schools_logo"); ?>" alt="" class="dark-logo" style="width:auto; height:50px;" /></b>
                <span><?= $this->session->get("schools_nname"); ?></span>
            </a>
        </div>
        <div class="navbar-collapse">
            <ul class="navbar-nav mr-auto mt-md-0">
                <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted  " href="javascript:void(0)"><i class="mdi mdi-menu"></i></a> </li>
                <li class="nav-item m-l-10"> <a class="nav-link sidebartoggler hidden-sm-down text-muted  " href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
            </ul>
            <ul class="navbar-nav my-lg-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-muted  " href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php if (session()->user_picture != "") {
                            $userpicture = base_url("images/user_picture/" . session()->user_picture);
                        } else {
                            $userpicture = base_url("images/global/brain.png");
                        } ?>
                        <img src="<?= $userpicture; ?>" alt="user" class="profile-pic" />
                        <?= $this->session->get("user_name"); ?>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right animated zoomIn">
                        <ul class="dropdown-user">
                            <!-- Tidak rubah password karena pakai token -->
                            <!-- <li><a href="<?= base_url("mpassword"); ?>"><i class="ti-user"></i> Change Password</a></li> -->
                            <li><a href="<?= base_url("logout"); ?>"><i class="fa fa-power-off"></i> Logout</a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</div>