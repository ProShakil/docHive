<div class="dochive-wrap">

<h1 class="dochive-title">Theme Options</h1>

<form method="post" id="dochive-form">
<?php 
    settings_fields('dochive_options_group');
    $opt = get_option('dochive_options');
?>

<div class="dochive-admin">

    <!-- LEFT SIDEBAR -->
    <div class="dochive-sidebar">
        <div class="dochive-tab active" data-tab="topbar">
            <span class="dashicons dashicons-admin-site"></span>
            <small>Top Bar</small>
        </div>
        <div class="dochive-tab" data-tab="footer">
            <span class="dashicons dashicons-editor-kitchensink"></span>
            <small>Footer</small>
        </div>
        <div class="dochive-tab" data-tab="branding">
            <span class="dashicons dashicons-format-image"></span>
            <small>Branding</small>
        </div>
        <div class="dochive-tab" data-tab="doctor">
            <span class="dashicons dashicons-heart"></span>
            <small>Doctor</small>
        </div>

        <div class="dochive-tab" data-tab="admin">
            <span class="dashicons dashicons-admin-tools"></span>
            <small>Admin Config</small>
        </div>
    </div>

    <!-- RIGHT CONTENT -->
    <div class="dochive-content">
        <!-- topbar -->
        <div class="tab-content active" id="topbar">
            <table class="form-table">

                <!-- TOGGLE -->
                <tr>
                    <th>Top Bar</th>
                    <td>
                        Enable Top Bar
                        <label class="dochive-switch">
                            <input type="checkbox"
                                id="topbar_toggle"
                                name="dochive_options[topbar_enable]"
                                value="1"
                                <?php checked($opt['topbar_enable'] ?? 0, 1); ?>>

                            <span class="dochive-slider"></span>
                        </label>
                    </td>
                </tr>

                <!-- EMAIL -->
                <tr class="topbar-fields">
                    <th>Topbar Background</th>
                    <td>
                        <?php echo dochive_field('color', [
                            'name' => 'dochive_options[topbar_bg]',
                            'value' => $opt['topbar_bg'] ?? '#0d6efd'
                        ]); ?>
                    </td>
                </tr>
                <tr class="topbar-fields">
                    <th>Topbar Text Color</th>
                    <td>
                        <?php echo dochive_field('color', [
                            'name' => 'dochive_options[topbar_text]',
                            'value' => $opt['topbar_text'] ?? '#ffffff'
                        ]); ?>
                    </td>
                </tr>
                <tr class="topbar-fields">
                    <th>Email</th>
                    <td>
                        <input type="email"
                            name="dochive_options[topbar_email]"
                            value="<?php echo esc_attr($opt['topbar_email'] ?? ''); ?>"
                            class="regular-text">
                    </td>
                </tr>

                <!-- PHONE -->
                <tr class="topbar-fields">
                    <th>Phone</th>
                    <td>
                        <input type="text"
                            name="dochive_options[topbar_phone]"
                            value="<?php echo esc_attr($opt['topbar_phone'] ?? ''); ?>"
                            class="regular-text">
                    </td>
                </tr>
                <tr class="topbar-fields"> 
                    <th>Social Media</th> 
                    <td> 
                        <div id="social-repeater"> 
                            <?php 
                                $socials = $opt['socials'] ?? []; 
                                if (empty($socials)) { 
                                    $socials[] = ['icon' => 'bi-facebook', 'link' => '']; 
                                } 
                                foreach ($socials as $index => $social) : 
                            ?> 
                            <div class="social-row"> 
                                <select name="dochive_options[socials][<?php echo $index; ?>][icon]" class="social-icon">
                                    <option value="">Select</option> 
                                    <option value="bi-facebook" <?php selected($social['icon'] ?? '', 'bi-facebook'); ?>>Facebook</option>
                                    <option value="bi-instagram" <?php selected($social['icon'] ?? '', 'bi-instagram'); ?>>Instagram</option> 
                                    <option value="bi-linkedin" <?php selected($social['icon'] ?? '', 'bi-linkedin'); ?>>LinkedIn</option>
                                    <option value="bi-twitter-x" <?php selected($social['icon'] ?? '', 'bi-twitter-x'); ?>>X (Twitter)</option> 
                                    <option value="bi-youtube" <?php selected($social['icon'] ?? '', 'bi-youtube'); ?>>YouTube</option>
                                    <option value="bi-tiktok" <?php selected($social['icon'] ?? '', 'bi-tiktok'); ?>>TikTok</option> 
                                </select> 
                                <input type="url" name="dochive_options[socials][<?php echo $index; ?>][link]" value="<?php echo esc_url($social['link'] ?? ''); ?>" placeholder="https://facebook.com/yourpage" class="regular-text"> 
                                <button type="button" class="button remove-social">
                                    <span class="dashicons dashicons-trash"></span>
                                </button> 
                            </div> 
                            <?php endforeach; ?> 
                        </div> 
                        <p> 
                            <button type="button" class="button button-secondary" id="add-social"> Add Social Media </button> 
                        </p> 
                    </td> 
                </tr>
            </table>
        </div>
        <!-- Footer -->
        <div class="tab-content" id="footer">
            <table class="form-table">
                <tr>
                    <th>Footer Background</th>
                    <td>
                        <?php echo dochive_field('color', [
                            'name' => 'dochive_options[footer_bg]',
                            'value' => $opt['footer_bg'] ?? '#0d6efd'
                        ]); ?>
                    </td>
                </tr>
                <tr>
                    <th>Footer Text Color</th>
                    <td>
                        <?php echo dochive_field('color', [
                            'name' => 'dochive_options[footer_text]',
                            'value' => $opt['footer_text'] ?? '#ffffff'
                        ]); ?>
                    </td>
                </tr>
                <tr>
                    <th>Footer Text</th>
                    <td>
                        <?php echo dochive_field('textarea', [
                            'name' => 'dochive_options[footer_desc]',
                            'value' => $opt['footer_desc'] ?? ''
                        ]); ?>
                    </td>
                </tr>
                <tr>
                    <th>Address</th>
                    <td>
                        <?php echo dochive_field('text', [
                            'name' => 'dochive_options[footer_address]',
                            'value' => $opt['footer_address'] ?? 'Dhaka'
                        ]); ?>
                    </td>
                </tr>
                <tr>
                    <th>Copyright Text</th>
                    <td>
                        <?php echo dochive_field('text', [
                            'name' => 'dochive_options[copyright_text]',
                            'value' => $opt['copyright_text'] ?? ''
                        ]); ?>
                    </td>
                </tr>
            </table>
        </div>  
        <!-- BRANDING -->
        <div class="tab-content" id="branding">

            <table class="form-table">

                <tr>
                    <th>Logo</th>
                    <td>
                        <?php echo dochive_field('media', [
                            'name' => 'dochive_options[logo]',
                            'value' => $opt['logo'] ?? ''
                        ]); ?>
                    </td>
                </tr>
                <tr>
                    <th>Footer Logo</th>
                    <td>
                        <?php echo dochive_field('media', [
                            'name' => 'dochive_options[footer_logo]',
                            'value' => $opt['footer_logo'] ?? ''
                        ]); ?>
                    </td>
                </tr>

                <tr>
                    <th>Favicon</th>
                    <td>
                        <?php echo dochive_field('media', [
                            'name' => 'dochive_options[favicon]',
                            'value' => $opt['favicon'] ?? ''
                        ]); ?>
                    </td>
                </tr>

            </table>

        </div>

        <!-- DOCTOR -->
        <div class="tab-content" id="doctor">

            <table class="form-table">

                <tr>
                    <th>Doctors Per Page</th>
                    <td>
                        <?php echo dochive_field('text', [
                            'name' => 'dochive_options[per_page]',
                            'value' => $opt['per_page'] ?? 12
                        ]); ?>
                    </td>
                </tr>

                <tr>
                    <th>Layout Style</th>
                    <td>
                        <select name="dochive_options[layout]">
                            <option value="grid" <?php selected($opt['layout'] ?? '', 'grid'); ?>>Grid</option>
                            <option value="list" <?php selected($opt['layout'] ?? '', 'list'); ?>>List</option>
                        </select>
                    </td>
                </tr>

            </table>

        </div>

        <!-- Admin Config -->
         <div class="tab-content" id="admin">
            <table class="form-table">

                <!-- TOGGLE -->
                <tr>
                    <th>Theme Login Page</th>
                    <td>
                        Enable Theme Login Page
                        <label class="dochive-switch">
                            <input type="checkbox"
                                id="login_toggle"
                                name="dochive_options[theme_login]"
                                value="1"
                                <?php checked($opt['theme_login'] ?? 0, 1); ?>>

                            <span class="dochive-slider"></span>
                        </label>
                    </td>
                </tr>
                <tr>
                    <th>Login Page Logo</th>
                    <td>
                        <?php echo dochive_field('media', [
                            'name' => 'dochive_options[login_logo]',
                            'value' => $opt['login_logo'] ?? ''
                        ]); ?>
                    </td>
                </tr>
                <tr>
                    <th>
                        Login Url
                    </th>
                    <td>
                        <?php echo dochive_field('text', [
                            'name' => 'dochive_options[admin_url]',
                            'value' => $opt['admin_url'] ?? 'wp-login'
                        ]); ?>
                    </td>
                </tr>
            </table>
        </div>

    </div>
</div>

<?php submit_button(); ?>
</form>

</div>