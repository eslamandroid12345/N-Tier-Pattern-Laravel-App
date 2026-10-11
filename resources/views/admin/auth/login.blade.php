<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>تسجيل الدخول - منشأة</title>

    <!-- Bootstrap RTL -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">

    <!-- Google Font Cairo -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    <link rel="stylesheet" href="{{asset('css/admin/toast.css')}}" />
    <link rel="stylesheet" href="{{asset('css/admin/login.css')}}" />

    <style>

    </style>
</head>

<body>

<!-- Main UI -->
<div class="login-shell">
    <div class="login-card">

        <!-- LEFT: Branding -->
        <section class="brand-side">
            <div>
                <div class="brand-top">
                    <div class="brand-logo">
                        <i class="fa-solid fa-building"></i>
                    </div>
                    <div>
                        <div class="brand-name">لوحة التحكم</div>
                        <div class="brand-sub">إدارة أعمالك بكل سهولة وذكاء</div>
                    </div>
                </div>

                <div class="brand-mid">
                    <h2>مرحباً بعودتك 👋</h2>
                    <p>
                        قم بتسجيل الدخول للوصول إلى لوحة التحكم المتقدمة. أدر أعمالك، عملاءك، وتقاريرك المالية والإدارية بشكل سريع وموثوق.
                    </p>

                    <div class="brand-illustration">
                        <div class="mini-stat"><div class="v"><i class="fa-solid fa-chart-line"></i></div><div class="t">لوحة المؤشرات</div></div>
                        <div class="mini-stat"><div class="v"><i class="fa-solid fa-users"></i></div><div class="t">المستخدمين</div></div>
                        <div class="mini-stat"><div class="v"><i class="fa-solid fa-shield-halved"></i></div><div class="t">الصلاحيات والأمان</div></div>
                        <div class="mini-stat"><div class="v"><i class="fa-solid fa-file-invoice-dollar"></i></div><div class="t">الفواتير والمالية</div></div>
                        <div class="mini-stat"><div class="v"><i class="fa-solid fa-chart-pie"></i></div><div class="t">التقارير والإحصائيات</div></div>
                        <div class="mini-stat"><div class="v"><i class="fa-solid fa-bell"></i></div><div class="t">الإشعارات الفورية</div></div>
                        <div class="mini-stat"><div class="v"><i class="fa-solid fa-gears"></i></div><div class="t">إعدادات النظام</div></div>
                        <div class="mini-stat"><div class="v"><i class="fa-solid fa-database"></i></div><div class="t">النسخ الاحتياطي</div></div>
                        <div class="mini-stat"><div class="v"><i class="fa-solid fa-headset"></i></div><div class="t">الدعم الفني</div></div>
                    </div>
                </div>
            </div>

            <div class="brand-footer">
                © <span id="y"></span> جميع الحقوق محفوظة
            </div>
        </section>

        <!-- RIGHT: Form -->
        <section class="form-side">
            <div class="form-title">
                <h1>تسجيل الدخول</h1>
                <p>أدخل بياناتك للوصول إلى لوحة التحكم</p>
            </div>

            <!-- form -->
            <form action="{{route('admin.auth.login')}}" method="POST" autocomplete="off">
                @csrf
                <div class="field">
                    <label class="form-label">البريد الالكتروني</label>
                    <div class="input-wrap">
                        <i class="fa-solid fa-user prefix"></i>
                        <input
                            class="form-control custom @error('email') is-invalid @enderror"
                            type="text"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="البريد الالكتروني"
                            required>
                    </div>
                    @error('email')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label class="form-label">كلمة المرور</label>
                    <div class="input-wrap">
                        <i class="fa-solid fa-lock prefix"></i>
                        <input
                            class="form-control custom @error('password') is-invalid @enderror"
                            id="password"
                            type="password"
                            name="password"
                            placeholder="أدخل كلمة المرور"
                            required>

                        <button type="button" class="toggle-pass" id="togglePass" aria-label="إظهار كلمة المرور">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                    </div>
                    @error('password')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <button id="btnLogin" class="btn btn-primary w-100 btn-login" type="submit">
                    <span class="btn-text">تسجيل الدخول</span>
                    <span class="btn-spinner d-none">
                        <span class="spinner-border spinner-border-sm" style="margin-left: 8px;"></span>
                        جاري تسجيل الدخول...
                    </span>
                </button>

                <div class="divider">أو</div>

                <div class="help">
                    قم بتسجيل الدخول للوصول إلى لوحة التحكم المتقدمة.
                </div>
            </form>
        </section>

    </div>
</div>

@if(session('login_failed'))
    <div id="loginSuccessBar" class="login-success-bar show" style="background: #ef4444;">
        <i class="fa-solid fa-circle-check" style="margin-left: 5px;"></i>
        {{ session('login_failed') }}
    </div>
@endif

@if(session('login_error'))
    <div id="loginSuccessBar" class="login-success-bar show" style="background: #ef4444;">
        <i class="fa-solid fa-circle-check" style="margin-left: 5px;"></i>
        {{ session('login_error') }}
    </div>
@endif

@if(session('logout'))
    <div id="loginSuccessBar" class="login-success-bar show">
        <i class="fa-solid fa-circle-check" style="margin-left: 5px;"></i>
        {{ session('logout') }}
    </div>
@endif

<script>
    // System Year
    document.getElementById("y").textContent = new Date().getFullYear();

    // Show/Hide Password functionality
    const pass = document.getElementById("password");
    const toggle = document.getElementById("togglePass");
    toggle.addEventListener("click", () => {
        const isPass = pass.type === "password";
        pass.type = isPass ? "text" : "password";
        toggle.innerHTML = isPass
            ? '<i class="fa-regular fa-eye-slash"></i>'
            : '<i class="fa-regular fa-eye"></i>';
    });

    // Form submission animation handling
    const form = document.querySelector('form');
    const btnLogin = document.getElementById('btnLogin');
    const btnDemo = document.getElementById('btnDemo');

    function activateButtonLoader(button){
        const text = button.querySelector('.btn-text');
        const spinner = button.querySelector('.btn-spinner');

        text.classList.add('d-none');
        spinner.classList.remove('d-none');

        // Prevent double submit safely visually
        button.style.pointerEvents = 'none';
        button.style.opacity = '0.85';
    }

    form.addEventListener('submit', function () {
        activateButtonLoader(btnLogin);
    });

    btnDemo.addEventListener('click', function () {
        activateButtonLoader(btnDemo);
    });

    // Handle splash screen animation
    const splashLogo = document.querySelector('#splash img');
    if(splashLogo) {
        splashLogo.addEventListener('animationend', function () {
            document.getElementById("splash").style.display = "none";
        });
    }

    // Auto-hide alert messages after a few seconds
    setTimeout(() => {
        const bar = document.getElementById("loginSuccessBar");
        if(bar) {
            bar.style.opacity = '0';
            setTimeout(() => bar.style.display = 'none', 300);
        }
    }, 5000);
</script>

@include('admin.layouts.toast')

</body>
</html>
