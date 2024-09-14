<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title('|', true, 'right'); ?></title>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <header class="dashboard-header">
        <nav class="dashboard-header-wrap">
            <div class="dashboard-logo">
                <a class="brand-logo" href="<?php home_url(); ?>"><img src="https://demo.bootstrapdash.com/purple-admin-free/assets/images/logo.svg" alt="logo"></a>
            </div>
            <div class="dashboard-header-search">
                <form class="d-flex align-items-center h-100" action="#">
                    <div class="input-group">
                        <div class="input-group-prepend bg-transparent">
                            <i class="input-group-text border-0 mdi mdi-magnify"></i>
                        </div>
                        <input type="text" class="form-control bg-transparent border-0" placeholder="Search projects" data-ninja-font="ubuntu_regular_normal_vwj1b">
                    </div>
                </form>
            </div>
            <div class="dashboard-header-info">
                <ul>
                    <li><a href="#">My Account</a>
                        <!-- <ul>
                            <li><a href="#">Setting</a></li>
                            <li><a href="#">Logout</a></li>
                        </ul> -->
                    </li>
                    <li><a href="#"><i class="fa fa-envelope-o"></i></a></li>
                    <li><a href="#"><i class="fa fa-bell-o"></i></a></li>
                    <li><a href="#">Add Listing</a></li>
                </ul>
            </div>
        </nav>
    </header>