<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>

<meta charset="<?php bloginfo('charset'); ?>">
<meta name="description" content="<?php bloginfo('description'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">

<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<!-- =========================
     TOP BAR NAVIGATION
========================= -->
<?php
    $opt = get_option('dochive_options');

    if (!empty($opt['topbar_enable'])) :

    $bg = $opt['topbar_bg'] ?? '#0d6efd';
    $text = $opt['topbar_text'] ?? '#ffffff';
?>
<div class="top-bar py-1" style="background: <?php echo esc_attr($bg); ?>; color:<?php echo esc_attr($text); ?>;">
    <div class="container d-flex justify-content-between align-items-center">
        <!-- LEFT SIDE -->
        <div class="top-left">
            <small>Welcome to <?php bloginfo('name'); ?></small>
        </div>
        <!-- RIGHT SIDE -->
        <div class="top-right d-flex align-items-center gap-3">

            <!-- EMAIL -->
            <?php if (!empty($opt['topbar_email'])) : ?>
                <a href="mailto:<?php echo esc_attr($opt['topbar_email']); ?>" class="text-decoration-none" style="color:<?php echo esc_attr($text); ?>;">
                    <i class="bi bi-envelope"></i>
                    <small><?php echo esc_html($opt['topbar_email']); ?></small>
                </a>
            <?php endif; ?>

            <!-- PHONE -->
            <?php if (!empty($opt['topbar_phone'])) : ?>
                <a href="tel:<?php echo esc_attr($opt['topbar_phone']); ?>" class="text-decoration-none" style="color:<?php echo esc_attr($text); ?>;">
                    <i class="bi bi-telephone"></i>
                    <small><?php echo esc_html($opt['topbar_phone']); ?></small>
                </a>
            <?php endif; ?>

            <!-- SOCIAL ICONS -->
            <div class="social-icons d-flex gap-2">

                <?php if (!empty($opt['socials']) && is_array($opt['socials'])) : ?>
                    <?php foreach ($opt['socials'] as $social) : ?>
                        <a href="<?php echo esc_url($social['link']); ?>" target="_blank" class="" style="color:<?php echo esc_attr($text); ?>;">
                           <i class="bi <?php echo esc_attr($social['icon']); ?>"></i>
                        </a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

        </div>
    </div>
</div>

<?php endif; ?>

<!-- =========================
     MAIN NAVBAR
========================= -->
<header class="site-header">

    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">

            <!-- LOGO -->
            <a class="navbar-brand" href="<?php echo esc_url(home_url('/')); ?>">
                <?php if (!empty($opt['logo'])) : ?>
                    <img src="<?php echo esc_url($opt['logo']); ?>" alt="<?php bloginfo('name'); ?>" style="max-height:40px; width:auto;">
                <?php else : ?>
                    <?php bloginfo('name'); ?>
                <?php endif; ?>

            </a>

            <!-- MOBILE TOGGLER -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#primaryMenu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- MENU -->
            <div class="collapse navbar-collapse" id="primaryMenu">

                <?php
                wp_nav_menu([
                    'theme_location' => 'primary',
                    'menu_class'     => 'navbar-nav ms-auto mb-2 mb-lg-0',
                    'container'      => false,
                    'fallback_cb'    => false,
                    'depth'          => 3,
                    'walker'         => new WP_Bootstrap_Navwalker()
                    
                ]);
                ?>

            </div>

        </div>
    </nav>

</header>