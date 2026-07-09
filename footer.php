<?php
$locations = get_nav_menu_locations();

$menu1 = $locations['footer_menu_1'] ?? null;
$menu2 = $locations['footer_menu_2'] ?? null;

$menu1_obj = ($menu1) ? wp_get_nav_menu_object($menu1) : null;
$menu2_obj = ($menu2) ? wp_get_nav_menu_object($menu2) : null;

$active_menus = 0;

if ($menu1_obj) $active_menus++;
if ($menu2_obj) $active_menus++;

// column logic
$menu_col_class = 'col-lg-6';

if ($active_menus == 1) {
    $menu_col_class = 'col-lg-6'; // still 2 columns (site + menu + contact)
} elseif ($active_menus == 2) {
    $menu_col_class = 'col-lg-3'; // 2 menus side by side
}
$opt = get_option('dochive_options');
$fbg = $opt['footer_bg'] ?? '#0d6efd';
$ftext = $opt['footer_text'] ?? '#ffffff';
?>

<footer class="site-footer" style="background: <?php echo esc_attr($fbg); ?>; color:<?php echo esc_attr($ftext); ?>; --footer-text:<?php echo esc_attr($ftext); ?>;">

    <div class="footer-top py-5">
        <div class="container">

            <div class="row g-4">

                <!-- Column 1: Site Info -->
                <div class="col-lg-3 col-md-6">
                    <a class="navbar-brand text-start" href="<?php echo esc_url(home_url('/')); ?>">
                        <?php if (!empty($opt['logo'])) : ?>
                            <img src="<?php echo esc_url($opt['logo']); ?>" alt="<?php bloginfo('name'); ?>" style="max-height:40px; width:auto;">
                        <?php else : ?>
                            <?php bloginfo('name'); ?>
                        <?php endif; ?>

                    </a>
                    <p style="color:<?php echo esc_attr($ftext); ?>;" class="text-start">
                        <?php if (!empty($opt['footer_desc'])) : ?>
                            <?php echo nl2br(esc_html($opt['footer_desc'])); ?>
                        <?php endif; ?>
                    </p>
                </div>

                <!-- Column 2: Menu 1 -->
                <?php if ($menu1_obj) : ?>
                    <div class="<?php echo $menu_col_class; ?> col-md-6 text-start" style="color:<?php echo esc_attr($ftext); ?>; text-start">

                        <h5 class="fw-bold mb-3" style="color:<?php echo esc_attr($ftext); ?>;">
                            <?php echo esc_html($menu1_obj->name); ?>
                        </h5>

                        <?php
                        wp_nav_menu([
                            'theme_location' => 'footer_menu_1',
                            'container'      => false,
                            'menu_class'     => 'footer-menu list-unstyled text-start',
                            'fallback_cb'    => false,
                        ]);
                        ?>

                    </div>
                <?php endif; ?>

                <!-- Column 3: Menu 2 -->
                <?php if ($menu2_obj) : ?>
                    <div class="<?php echo $menu_col_class; ?> col-md-6 text-start" style="color:<?php echo esc_attr($ftext); ?>;">

                        <h5 class="fw-bold mb-3" style="color:<?php echo esc_attr($ftext); ?>;">
                            <?php echo esc_html($menu2_obj->name); ?>
                        </h5>

                        <?php
                        wp_nav_menu([
                            'theme_location' => 'footer_menu_2',
                            'container'      => false,
                            'menu_class'     => 'footer-menu list-unstyled text-start',
                            'fallback_cb'    => false,
                        ]);
                        ?>

                    </div>
                <?php endif; ?>

                <!-- Column 4: Contact -->
                <div class="col-lg-3 col-md-6 text-start" style="color:<?php echo esc_attr($ftext); ?>;">
                    <h5 class="fw-bold mb-3" style="color:<?php echo esc_attr($ftext); ?>;">Contact</h5>

                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <a href="mailto:<?php echo esc_attr($opt['topbar_email']); ?>" class="text-decoration-none" style="color:<?php echo esc_attr($ftext); ?>;">
                                <i class="bi bi-envelope"></i>
                                <?php echo esc_html($opt['topbar_email']); ?>
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="tel:<?php echo esc_attr($opt['topbar_phone']); ?>" class="text-decoration-none" style="color:<?php echo esc_attr($ftext); ?>;">
                                <i class="bi bi-telephone"></i>
                                <?php echo esc_html($opt['topbar_phone']); ?>
                            </a>
                        </li>
                        <li>
                            <i class="bi bi-geo-alt"></i> <?php echo esc_html($opt['footer_address']); ?>
                        </li>
                    </ul>
                </div>

            </div>

        </div>
    </div>

    <!-- Bottom Bar -->
    <div class="footer-bottom border-top border-secondary" style="background: <?php echo esc_attr($fbg); ?>; color:<?php echo esc_attr($ftext); ?>;">
        <div class="container py-3">

            <div class="row align-items-center">

                <div class="col-md-6 text-center text-md-start">
                    &copy; <?php echo date('Y'); ?>
                    <?php bloginfo('name'); ?>.
                    <?php echo esc_html($opt['copyright_text']); ?>
                </div>

                <div class="col-md-6 text-center text-md-end mt-2 mt-md-0" style="color:<?php echo esc_attr($ftext); ?>!important;">

                    <?php
                    wp_nav_menu([
                        'theme_location' => 'footer_legal',
                        'container'      => false,
                        'menu_class'     => 'footer-legal-menu list-inline mb-0',
                        'fallback_cb'    => false,
                        'link_before'    => '',
                        'link_after'     => '',
                        'depth'          => 1,
                    ]);
                    ?>

                </div>

            </div>

        </div>
    </div>

</footer>

<?php wp_footer(); ?>
<button id="backToTop" class="btn btn-primary position-fixed bottom-0 end-0 m-3 d-none">
    <i class="bi bi-arrow-up"></i>
</button>
</body>
</html>