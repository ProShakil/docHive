<?php
/* Template Name: Doctor Login */

if (is_user_logged_in()) {
    wp_safe_redirect(admin_url());
    exit;
}

$error_message = '';

if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
    && isset($_POST['log'])
) {

    if (
        !isset($_POST['_wpnonce']) ||
        !wp_verify_nonce($_POST['_wpnonce'], 'dochive_login_nonce')
    ) {

        $error_message = 'Security verification failed.';

    } else {

        $creds = [
            'user_login'    => sanitize_user($_POST['log']),
            'user_password' => $_POST['pwd'],
            'remember'      => !empty($_POST['rememberme'])
        ];

        $user = wp_signon($creds, false);

        if (is_wp_error($user)) {

            $error_message = 'Invalid username or password.';

        } else {

            if (in_array('doctor', (array) $user->roles)) {

                wp_safe_redirect(
                    admin_url('edit.php?post_type=doctor')
                );

            } else {

                wp_safe_redirect(admin_url());

            }

            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>

<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">

<?php wp_head(); ?>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<style>

:root{
    --primary:#0ea5e9;
    --secondary:#2563eb;
    --dark:#0f172a;
    --text:#64748b;
    --white:#ffffff;
}

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

/* body{
    font-family:'Inter',sans-serif;
    min-height:100vh;
    overflow-x:hidden;
    background:
    radial-gradient(circle at top left,#38bdf8 0%,transparent 35%),
    radial-gradient(circle at bottom right,#2563eb 0%,transparent 35%),
    linear-gradient(135deg,#0f172a,#1e293b);
} */
body {
    margin: 0;
    overflow-x: hidden;
    position: relative;
}

body::before {
    content: "";
    position: fixed;
    inset: 0;
    z-index: -1;

    background:
        radial-gradient(circle at top left,#38bdf8 0%,transparent 35%),
        radial-gradient(circle at bottom right,#2563eb 0%,transparent 35%),
        linear-gradient(135deg,#0f172a,#1e293b);
}
.login-page{
    min-height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:30px;
}

.login-wrapper{
    width:1100px;
    max-width:100%;
    min-height:650px;
    display:flex;
    border-radius:30px;
    overflow:hidden;

    background:rgba(255,255,255,.08);

    backdrop-filter:blur(20px);

    border:1px solid rgba(255,255,255,.15);

    box-shadow:0 25px 80px rgba(0,0,0,.25);
}

/* LEFT SIDE */

.login-left{
    flex:1;
    color:#fff;
    padding:70px;
    position:relative;
    overflow:hidden;
}

.login-left::before{
    content:"";
    position:absolute;
    width:450px;
    height:450px;
    background:rgba(255,255,255,.08);
    border-radius:50%;
    top:-180px;
    right:-120px;
}

.login-left::after{
    content:"";
    position:absolute;
    width:250px;
    height:250px;
    background:rgba(255,255,255,.05);
    border-radius:50%;
    bottom:-80px;
    left:-60px;
}

.brand{
    display:flex;
    align-items:center;
    gap:15px;
    margin-bottom:50px;
}

.logo-box{
    width:65px;
    height:65px;
    border-radius:18px;
    background:rgba(255,255,255,.15);
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:32px;
}

.brand h2{
    font-size:36px;
    font-weight:800;
}

.brand span{
    color:#7dd3fc;
}

.login-left h1{
    font-size:56px;
    line-height:1.1;
    font-weight:800;
    margin-bottom:20px;
}

.login-left p{
    font-size:17px;
    color:rgba(255,255,255,.8);
    line-height:1.8;
    max-width:520px;
}

.features{
    margin-top:40px;
}

.features li{
    list-style:none;
    margin-bottom:18px;
    font-size:16px;
    display:flex;
    align-items:center;
    gap:12px;
}

.features li i{
    width:32px;
    height:32px;
    border-radius:50%;
    background:rgba(255,255,255,.12);
    display:flex;
    align-items:center;
    justify-content:center;
}

/* RIGHT */

.login-right{
    width:450px;
    background:#fff;
    padding:60px;
    display:flex;
    flex-direction:column;
    justify-content:center;
}

.login-right h3{
    font-size:34px;
    font-weight:800;
    color:var(--dark);
    margin-bottom:8px;
}

.login-right p{
    color:#64748b;
    margin-bottom:35px;
}

.form-group{
    margin-bottom:18px;
}

.form-group label{
    display:block;
    font-size:14px;
    font-weight:600;
    margin-bottom:8px;
    color:#334155;
}

.form-control{
    width:100%;
    height:56px;
    border:1px solid #e2e8f0;
    border-radius:14px;
    padding:0 18px;
    font-size:15px;
    transition:.3s;
}

.form-control:focus{
    outline:none;
    border-color:var(--primary);
    box-shadow:0 0 0 4px rgba(14,165,233,.15);
}

.password-wrap{
    position:relative;
}

.password-toggle{
    position:absolute;
    right:16px;
    top:50%;
    transform:translateY(-50%);
    cursor:pointer;
    color:#94a3b8;
    font-size:14px;
}

.remember{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
}

.remember label{
    display:flex;
    gap:8px;
    align-items:center;
    font-size:14px;
}

.login-btn{
    width:100%;
    height:58px;
    border:none;
    border-radius:14px;
    background:linear-gradient(
    135deg,
    var(--primary),
    var(--secondary)
    );

    color:#fff;
    font-size:16px;
    font-weight:700;
    cursor:pointer;
    transition:.3s;
}

.login-btn:hover{
    transform:translateY(-2px);
}

.footer-text{
    margin-top:20px;
    text-align:center;
    color:#94a3b8;
    font-size:13px;
}

/* MOBILE */

@media(max-width:991px){

    .login-wrapper{
        flex-direction:column;
    }

    .login-left{
        padding:40px;
    }

    .login-right{
        width:100%;
        padding:40px;
    }

    .login-left h1{
        font-size:38px;
    }

}

@media(max-width:576px){

    .login-page{
        padding:15px;
    }

    .login-left,
    .login-right{
        padding:30px;
    }

    .brand h2{
        font-size:28px;
    }

    .login-left h1{
        font-size:30px;
    }

}

.login-error{
    background:#fef2f2;
    border:1px solid #fecaca;
    color:#dc2626;
    padding:14px 16px;
    border-radius:12px;
    margin-bottom:20px;
    font-size:14px;
    font-weight:500;
}

.forgot-link{
    color:#2563eb;
    text-decoration:none;
    font-size:14px;
    font-weight:600;
}

.forgot-link:hover{
    text-decoration:underline;
}

</style>

</head>

<body>

<div class="login-page">

    <div class="login-wrapper">

        <div class="login-left">

            <div class="brand">

                <div class="logo-box">
                    🩺
                </div>

                <h2>
                    Doc<span>Hive</span>
                </h2>

            </div>

            <h1>
                Doctor Directory Portal
            </h1>

            <p>
                Secure doctor management system with multiple chambers,
                specialties, profile management and directory control.
            </p>

            <ul class="features">

                <li>
                    <i>✓</i>
                    Manage Doctor Profiles
                </li>

                <li>
                    <i>✓</i>
                    Multiple Chamber Support
                </li>

                <li>
                    <i>✓</i>
                    speciality Directory
                </li>

                <li>
                    <i>✓</i>
                    Secure Dashboard Access
                </li>

            </ul>

        </div>

        <div class="login-right">

            <?php if (!is_user_logged_in()) : ?>

            <h3>
                Welcome Back
            </h3>

            <p>
                Login to access your dashboard
            </p>

            <form method="post">
                <?php wp_nonce_field('dochive_login_nonce'); ?>

                <?php if (!empty($error_message)) : ?>

                <div class="login-error">
                    <?php echo esc_html($error_message); ?>
                </div>

                <?php endif; ?>

                <div class="form-group">

                    <label>Username</label>

                    <input
                        type="text"
                        name="log"
                        class="form-control"
                        required>

                </div>

                <div class="form-group">

                    <label>Password</label>

                    <div class="password-wrap">

                        <input
                            type="password"
                            name="pwd"
                            id="password"
                            class="form-control"
                            required>

                        <span
                            class="password-toggle"
                            onclick="togglePassword()">
                            Show
                        </span>

                    </div>

                </div>

                <div class="remember">

                    <label>
                        <input type="checkbox" name="rememberme">
                        Remember me
                    </label>

                    <a
                        href="<?php echo esc_url(wp_lostpassword_url()); ?>"
                        class="forgot-link">

                        Lost Password?

                    </a>

                </div>

                <button
                    type="submit"
                    class="login-btn">

                    Login Now

                </button>

            </form>

            <?php else : ?>

                <h3>
                    Already Logged In
                </h3>

                <p>
                    You are already authenticated.
                </p>

                <a
                    href="<?php echo esc_url(admin_url()); ?>"
                    class="login-btn"
                    style="display:flex;align-items:center;justify-content:center;text-decoration:none;">
                    Go To Dashboard
                </a>

            <?php endif; ?>

            <div class="footer-text">
                © <?php echo date('Y'); ?> DocHive
            </div>

        </div>

    </div>

</div>

<script>

function togglePassword(){

    const field = document.getElementById('password');
    const btn = document.querySelector('.password-toggle');

    if(field.type === 'password'){

        field.type = 'text';
        btn.innerHTML = 'Hide';

    }else{

        field.type = 'password';
        btn.innerHTML = 'Show';

    }

}

</script>

<?php wp_footer(); ?>

</body>
</html>