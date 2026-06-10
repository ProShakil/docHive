<?php get_header(); ?>
<style>
    .medical-404{
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    padding:40px 20px;
    position:relative;
    overflow:hidden;
    background:linear-gradient(
        135deg,
        #f8fbff 0%,
        #eef7ff 50%,
        #f3fffd 100%
    );
}

.medical-bg{
    position:absolute;
    width:700px;
    height:700px;
    border-radius:50%;
    background:rgba(37,99,235,.08);
    filter:blur(100px);
    top:-200px;
    right:-200px;
}

.error-card{
    width:100%;
    max-width:850px;
    background:rgba(255,255,255,.85);
    backdrop-filter:blur(20px);
    border:1px solid rgba(255,255,255,.6);
    border-radius:30px;
    padding:60px;
    text-align:center;
    box-shadow:0 25px 60px rgba(0,0,0,.08);
    position:relative;
    z-index:2;
}

.error-badge{
    display:inline-flex;
    width:90px;
    height:90px;
    align-items:center;
    justify-content:center;
    border-radius:50%;
    background:#2563eb;
    color:#fff;
    font-size:32px;
    font-weight:800;
    margin-bottom:15px;
}

.error-icon{
    font-size:50px;
    margin-bottom:15px;
}

.error-card h1{
    font-size:42px;
    font-weight:800;
    color:#0f172a;
    margin-bottom:15px;
}

.error-card p{
    max-width:650px;
    margin:auto;
    color:#64748b;
    font-size:18px;
    line-height:1.8;
}

.doctor-search-box{
    margin-top:35px;
    display:flex;
    gap:12px;
}

.doctor-search-box input{
    flex:1;
    height:62px;
    border:none;
    border-radius:16px;
    background:#f8fafc;
    padding:0 24px;
    font-size:16px;
    box-shadow:inset 0 0 0 1px #dbeafe;
}

.doctor-search-box button{
    height:62px;
    padding:0 30px;
    border:none;
    border-radius:16px;
    background:#2563eb;
    color:white;
    font-weight:700;
    cursor:pointer;
}

.quick-links{
    margin-top:45px;
}

.quick-links h3{
    margin-bottom:20px;
    color:#334155;
}

.specialty-grid{
    display:flex;
    flex-wrap:wrap;
    justify-content:center;
    gap:12px;
}

.specialty-grid a{
    text-decoration:none;
    color:#2563eb;
    background:#fff;
    padding:12px 18px;
    border-radius:999px;
    border:1px solid #dbeafe;
    transition:.3s;
}

.specialty-grid a:hover{
    background:#2563eb;
    color:#fff;
}

.action-buttons{
    display:flex;
    justify-content:center;
    gap:15px;
    margin-top:40px;
}

.btn-home{
    padding:16px 28px;
    border-radius:14px;
    background:#10b981;
    color:#fff;
    text-decoration:none;
    font-weight:700;
}

.btn-outline{
    padding:16px 28px;
    border-radius:14px;
    background:#fff;
    color:#2563eb;
    border:1px solid #dbeafe;
    text-decoration:none;
    font-weight:700;
}

@media(max-width:768px){

    .error-card{
        padding:35px 25px;
    }

    .error-card h1{
        font-size:30px;
    }

    .doctor-search-box{
        flex-direction:column;
    }

    .doctor-search-box button{
        width:100%;
    }

    .action-buttons{
        flex-direction:column;
    }
}
</style>
<section class="medical-404">
    <div class="medical-bg"></div>

    <div class="error-card">

        <div class="error-badge">
            <span>404</span>
        </div>

        <div class="error-icon">
            🩺
        </div>

        <h1>We Couldn't Find That Page</h1>

        <p>
            The doctor profile, clinic page, or resource you're looking for
            may have been moved or no longer exists.
        </p>

        <form role="search"
              method="get"
              action="<?php echo esc_url(home_url('/')); ?>"
              class="doctor-search-box">

            <input
                type="search"
                name="s"
                placeholder="Search doctors, hospitals, specialties..."
                required>

            <button type="submit">
                Search
            </button>
        </form>

        <div class="quick-links">

            <h3>Popular Specialties</h3>

            <div class="specialty-grid">

                <a href="/specialty/cardiology">
                    ❤️ Cardiology
                </a>

                <a href="/specialty/dermatology">
                    ✨ Dermatology
                </a>

                <a href="/specialty/neurology">
                    🧠 Neurology
                </a>

                <a href="/specialty/pediatrics">
                    👶 Pediatrics
                </a>

                <a href="/specialty/orthopedics">
                    🦴 Orthopedics
                </a>

                <a href="/specialty/gynecology">
                    👩‍⚕️ Gynecology
                </a>

            </div>
        </div>

        <div class="action-buttons">

            <a href="<?php echo home_url(); ?>" class="btn-home">
                Find a Doctor
            </a>

            <a href="/hospitals" class="btn-outline">
                Browse Hospitals
            </a>

        </div>

    </div>
</section>

<?php get_footer(); ?>