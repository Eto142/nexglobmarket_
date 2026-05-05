<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Register | Nexglobmarket</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="{{ asset('favicon.ico') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; }
    body {
      font-family: 'Inter', sans-serif;
      margin: 0;
      padding: 0;
      min-height: 100vh;
      background: url('{{ asset('stock.jpg') }}') center center / cover no-repeat fixed;
    }
    .page-overlay {
      min-height: 100vh;
      background: linear-gradient(135deg, rgba(10,20,60,.78) 0%, rgba(13,110,253,.55) 100%);
      display: flex;
      align-items: flex-start;
      justify-content: center;
      padding: 48px 16px 48px;
    }
    .reg-wrap {
      width: 100%;
      max-width: 520px;
    }

    /* ── CARD ── */
    .reg-card {
      background: #fff;
      border-radius: 20px;
      box-shadow: 0 20px 60px rgba(0,0,0,.22);
      width: 100%;
      position: relative;
    }

    .card-top-bar {
      height: 5px;
      border-radius: 20px 20px 0 0;
      background: linear-gradient(90deg, #0d6efd, #6610f2, #0d6efd);
      background-size: 200% 100%;
      animation: barMove 3s linear infinite;
    }

    @keyframes barMove {
      0%   { background-position: 200% 0; }
      100% { background-position: -200% 0; }
    }

    .card-body-inner {
      padding: 36px 40px 32px;
    }

    @media (max-width: 480px) {
      .card-body-inner { padding: 28px 22px 24px; }
      .page-overlay { padding: 24px 12px 32px; }
    }

    /* ── HEADER ── */
    .reg-header {
      text-align: center;
      margin-bottom: 28px;
    }

    .reg-header a { display: inline-block; margin-bottom: 16px; }

    .reg-header img {
      height: 50px;
      width: auto;
      object-fit: contain;
    }

    .reg-header h2 {
      font-size: 1.5rem;
      font-weight: 800;
      color: #111827;
      margin: 0 0 6px;
      letter-spacing: -.3px;
    }

    .reg-header p {
      font-size: .875rem;
      color: #6b7280;
      margin: 0;
    }

    /* ── STEP INDICATOR ── */
    .step-track {
      display: flex;
      align-items: flex-start;
      justify-content: center;
      margin-bottom: 28px;
    }

    .step-node {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 6px;
    }

    .step-circle {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: .85rem;
      font-weight: 700;
      background: #f3f4f6;
      color: #9ca3af;
      border: 2px solid #e5e7eb;
      transition: all .3s ease;
    }

    .step-circle.active {
      background: #0d6efd;
      color: #fff;
      border-color: #0d6efd;
      box-shadow: 0 0 0 4px rgba(13,110,253,.15);
    }

    .step-circle.done {
      background: #16a34a;
      color: #fff;
      border-color: #16a34a;
      box-shadow: 0 0 0 4px rgba(22,163,74,.12);
    }

    .step-text {
      font-size: .7rem;
      font-weight: 700;
      letter-spacing: .6px;
      text-transform: uppercase;
      color: #9ca3af;
      transition: color .3s;
    }

    .step-text.active { color: #0d6efd; }
    .step-text.done   { color: #16a34a; }

    .step-line {
      flex: 1;
      height: 2px;
      max-width: 80px;
      background: #e5e7eb;
      margin: 20px 8px 0;
      border-radius: 2px;
      transition: background .4s ease;
    }

    .step-line.done { background: #16a34a; }

    /* ── FORM STEPS ── */
    .form-step { display: none; }

    .form-step.active {
      display: block;
      animation: fadeSlide .28s ease both;
    }

    .form-step.go-back {
      animation: fadeBack .28s ease both;
    }

    @keyframes fadeSlide {
      from { opacity: 0; transform: translateX(22px); }
      to   { opacity: 1; transform: translateX(0); }
    }

    @keyframes fadeBack {
      from { opacity: 0; transform: translateX(-22px); }
      to   { opacity: 1; transform: translateX(0); }
    }

    /* ── SECTION LABEL ── */
    .section-label {
      font-size: .7rem;
      font-weight: 700;
      letter-spacing: 1px;
      text-transform: uppercase;
      color: #9ca3af;
      margin: 20px 0 14px;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .section-label::before,
    .section-label::after {
      content: ';
      flex: 1;
      height: 1px;
      background: #f0f0f0;
    }

    /* ── FIELDS ── */
    .field-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 14px;
    }

    @media (max-width: 400px) {
      .field-grid { grid-template-columns: 1fr; }
    }

    .field-group { margin-bottom: 14px; }

    .field-group label {
      display: block;
      font-size: .8rem;
      font-weight: 600;
      color: #374151;
      margin-bottom: 7px;
    }

    .optional-note {
      font-weight: 400;
      color: #9ca3af;
      font-size: .74rem;
      margin-left: 3px;
    }

    .input-box { position: relative; }

    .input-box .ico {
      position: absolute;
      left: 12px;
      top: 50%;
      transform: translateY(-50%);
      color: #9ca3af;
      font-size: .8rem;
      pointer-events: none;
      transition: color .2s;
    }

    .input-box input,
    .input-box select {
      width: 100%;
      padding: 11px 12px 11px 36px;
      border: 1.5px solid #e5e7eb;
      border-radius: 10px;
      font-size: .875rem;
      font-family: 'Inter', sans-serif;
      color: #111827;
      background: #fafafa;
      outline: none;
      transition: border-color .2s, box-shadow .2s, background .2s;
      -webkit-appearance: none;
      appearance: none;
    }

    .input-box input::placeholder { color: #c4c9d4; }

    .input-box input:focus,
    .input-box select:focus {
      border-color: #0d6efd;
      box-shadow: 0 0 0 3px rgba(13,110,253,.1);
      background: #fff;
    }

    .input-box input:focus ~ .ico,
    .input-box select:focus ~ .ico { color: #0d6efd; }

    .input-box input.is-invalid,
    .input-box select.is-invalid {
      border-color: #ef4444;
      box-shadow: 0 0 0 3px rgba(239,68,68,.08);
      background: #fff;
    }

    .field-error {
      font-size: .75rem;
      color: #dc2626;
      margin-top: 4px;
      display: flex;
      align-items: center;
      gap: 4px;
    }

    /* show/hide password */
    .pwd-toggle {
      display: flex;
      align-items: center;
      gap: 6px;
      margin-top: 7px;
    }

    .pwd-toggle input[type=checkbox] {
      width: 14px;
      height: 14px;
      accent-color: #0d6efd;
      cursor: pointer;
    }

    .pwd-toggle label {
      font-size: .76rem;
      color: #6b7280;
      cursor: pointer;
      margin: 0;
      user-select: none;
    }

    /* ── ERROR ALERT ── */
    .error-alert {
      background: #fef2f2;
      border: 1px solid #fecaca;
      border-radius: 10px;
      padding: 12px 16px;
      margin-bottom: 20px;
      font-size: .81rem;
      color: #991b1b;
    }

    .error-alert ul { margin: 0; padding-left: 18px; }

    /* ── TERMS BOX ── */
    .terms-box {
      display: flex;
      align-items: flex-start;
      gap: 10px;
      background: #f9fafb;
      border: 1px solid #e5e7eb;
      border-radius: 10px;
      padding: 12px 14px;
      margin-bottom: 18px;
      margin-top: 4px;
    }

    .terms-box input[type=checkbox] {
      width: 15px;
      height: 15px;
      accent-color: #16a34a;
      cursor: pointer;
      margin-top: 2px;
      flex-shrink: 0;
    }

    .terms-box label {
      font-size: .79rem;
      color: #4b5563;
      line-height: 1.55;
      cursor: pointer;
    }

    .terms-box a {
      color: #0d6efd;
      font-weight: 600;
      text-decoration: none;
    }

    .terms-box a:hover { text-decoration: underline; }

    /* ── BUTTONS ── */
    .btn-next {
      width: 100%;
      padding: 13px 20px;
      background: #0d6efd;
      color: #fff;
      border: none;
      border-radius: 11px;
      font-size: .94rem;
      font-weight: 700;
      font-family: 'Inter', sans-serif;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      transition: background .2s, transform .15s, box-shadow .2s;
      box-shadow: 0 4px 16px rgba(13,110,253,.3);
      margin-top: 8px;
    }

    .btn-next:hover {
      background: #0b5ed7;
      transform: translateY(-1px);
      box-shadow: 0 6px 22px rgba(13,110,253,.38);
    }

    .btn-next:active { transform: translateY(0); }

    .btn-row { display: flex; gap: 10px; margin-top: 4px; }

    .btn-back {
      flex: 1;
      padding: 12px;
      background: #fff;
      color: #374151;
      border: 1.5px solid #e5e7eb;
      border-radius: 11px;
      font-size: .875rem;
      font-weight: 600;
      font-family: 'Inter', sans-serif;
      cursor: pointer;
      transition: all .2s;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 6px;
    }

    .btn-back:hover {
      border-color: #0d6efd;
      color: #0d6efd;
      background: #eff6ff;
    }

    .btn-create {
      flex: 2;
      padding: 13px;
      background: #16a34a;
      color: #fff;
      border: none;
      border-radius: 11px;
      font-size: .94rem;
      font-weight: 700;
      font-family: 'Inter', sans-serif;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      transition: background .2s, transform .15s, box-shadow .2s;
      box-shadow: 0 4px 16px rgba(22,163,74,.28);
    }

    .btn-create:hover {
      background: #15803d;
      transform: translateY(-1px);
      box-shadow: 0 6px 22px rgba(22,163,74,.36);
    }

    .btn-create:active { transform: translateY(0); }

    @media (max-width: 360px) {
      .btn-row { flex-direction: column; }
      .btn-back, .btn-create { flex: none; width: 100%; }
    }

    /* ── CARD FOOTER ── */
    .card-footer-area {
      border-top: 1px solid #f3f4f6;
      padding: 18px 40px 22px;
      text-align: center;
    }

    @media (max-width: 480px) {
      .card-footer-area { padding: 16px 22px 20px; }
    }

    .card-footer-area .login-cta {
      font-size: .875rem;
      color: #6b7280;
    }

    .card-footer-area .login-cta a {
      color: #0d6efd;
      font-weight: 700;
      text-decoration: none;
    }

    .card-footer-area .login-cta a:hover { text-decoration: underline; }

    .trust-row {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 20px;
      flex-wrap: wrap;
      margin-top: 12px;
    }

    .trust-item {
      display: flex;
      align-items: center;
      gap: 5px;
      font-size: .72rem;
      color: #9ca3af;
      font-weight: 500;
    }

    .trust-item i { color: #0d6efd; font-size: .75rem; }
  </style>
</head>

<!-- Smartsupp Live Chat script -->
<script type="text/javascript">
var _smartsupp = _smartsupp || {};
_smartsupp.key = 'a98c137f3b62e868be7986e2c1a66dfa6fc4449d';
window.smartsupp||(function(d) {
  var s,c,o=smartsupp=function(){ o._.push(arguments)};o._=[];
  s=d.getElementsByTagName('script')[0];c=d.createElement('script');
  c.type='text/javascript';c.charset='utf-8';c.async=true;
  c.src='https://www.smartsuppchat.com/loader.js?';s.parentNode.insertBefore(c,s);
})(document);
</script>
<noscript> Powered by <a href="https://www.smartsupp.com" target="_blank">Smartsupp</a></noscript>

<body>
<div class="page-overlay">
  <div class="reg-wrap">

    <div class="reg-card">
      <div class="card-top-bar"></div>

      <div class="card-body-inner">

        <!-- Header -->
        <div class="reg-header">
          <a href="/"><img src="{{ asset('logo.png') }}" alt="Nexglobmarket Logo"></a>
          <h2>Create your account</h2>
          <p>Join <strong>Nexglobmarket</strong> — smart trading &amp; global investing.</p>
        </div>

        <form method="POST" action="{{ route('register') }}" id="registerForm">
          @csrf

          @if ($errors->any())
            <div class="error-alert">
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <!-- Step Indicator -->
          <div class="step-track">
            <div class="step-node">
              <div class="step-circle active" id="bubble1">1</div>
              <div class="step-text active" id="label1">Account</div>
            </div>
            <div class="step-line" id="line1"></div>
            <div class="step-node">
              <div class="step-circle" id="bubble2">2</div>
              <div class="step-text" id="label2">Personal</div>
            </div>
          </div>

          <!-- ══ STEP 1 ══ -->
          <div class="form-step active" id="step1">

            <div class="field-grid">
              <div class="field-group">
                <label>First Name</label>
                <div class="input-box">
                  <input type="text" name="name" id="name"
                    class="{{ $errors->has('name') ? 'is-invalid' : '' }}"
                    placeholder="John" value="{{ old('name') }}"
                    required autocomplete="given-name">
                  <i class="fa fa-user ico"></i>
                </div>
                @error('name')<div class="field-error"><i class="fa fa-circle-exclamation"></i>{{ $message }}</div>@enderror
              </div>
              <div class="field-group">
                <label>Last Name</label>
                <div class="input-box">
                  <input type="text" name="lname" id="lname"
                    class="{{ $errors->has('lname') ? 'is-invalid' : '' }}"
                    placeholder="Doe" value="{{ old('lname') }}"
                    required autocomplete="family-name">
                  <i class="fa fa-user ico"></i>
                </div>
                @error('lname')<div class="field-error"><i class="fa fa-circle-exclamation"></i>{{ $message }}</div>@enderror
              </div>
            </div>

            <div class="field-group">
              <label>Email Address</label>
              <div class="input-box">
                <input type="email" name="email" id="email"
                  class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
                  placeholder="john@example.com" value="{{ old('email') }}"
                  required autocomplete="email">
                <i class="fa fa-envelope ico"></i>
              </div>
              @error('email')<div class="field-error"><i class="fa fa-circle-exclamation"></i>{{ $message }}</div>@enderror
            </div>

            <div class="section-label">Security</div>

            <div class="field-group">
              <label>Password</label>
              <div class="input-box">
                <input type="password" name="password" id="passwordInput"
                  class="{{ $errors->has('password') ? 'is-invalid' : '' }}"
                  placeholder="At least 8 characters" required autocomplete="new-password">
                <i class="fa fa-lock ico"></i>
              </div>
              @error('password')<div class="field-error"><i class="fa fa-circle-exclamation"></i>{{ $message }}</div>@enderror
              <div class="pwd-toggle">
                <input type="checkbox" id="showPassword" onclick="togglePassword()">
                <label for="showPassword">Show password</label>
              </div>
            </div>

            <div class="field-group">
              <label>Confirm Password</label>
              <div class="input-box">
                <input type="password" name="password_confirmation" id="confirmPassword"
                  placeholder="Re-enter password" required autocomplete="new-password">
                <i class="fa fa-lock ico"></i>
              </div>
              <div class="pwd-toggle">
                <input type="checkbox" id="showConfirmPassword" onclick="toggleConfirmPassword()">
                <label for="showConfirmPassword">Show password</label>
              </div>
            </div>

            <div class="section-label">Preferences</div>

            <div class="field-group">
              <label>Preferred Currency</label>
              <div class="input-box">
                <select name="currency" required>
                  <option value="$"  {{ old('currency') == '$'  ? 'selected' : '' }}>USD — US Dollar ($)</option>
                  <option value="£"  {{ old('currency') == '£'  ? 'selected' : '' }}>GBP — British Pound (£)</option>
                  <option value="€"  {{ old('currency') == '€'  ? 'selected' : '' }}>EUR — Euro (€)</option>
                  <option value="A$" {{ old('currency') == 'A$' ? 'selected' : '' }}>AUD — Australian Dollar (A$)</option>
                </select>
                <i class="fa fa-coins ico"></i>
              </div>
            </div>

            <button type="button" class="btn-next" onclick="goToStep2()">
              Next — Personal Info &nbsp;<i class="fa fa-arrow-right"></i>
            </button>
          </div>

          <!-- ══ STEP 2 ══ -->
          <div class="form-step" id="step2">

            <div class="field-grid">
              <div class="field-group">
                <label>Phone Number</label>
                <div class="input-box">
                  <input type="tel" name="phone" id="phone"
                    class="{{ $errors->has('phone') ? 'is-invalid' : '' }}"
                    placeholder="+1 555 0000" value="{{ old('phone') }}" autocomplete="tel">
                  <i class="fa fa-phone ico"></i>
                </div>
                @error('phone')<div class="field-error"><i class="fa fa-circle-exclamation"></i>{{ $message }}</div>@enderror
              </div>
              <div class="field-group">
                <label>State / Province</label>
                <div class="input-box">
                  <input type="text" name="state" id="state"
                    class="{{ $errors->has('state') ? 'is-invalid' : '' }}"
                    placeholder="e.g. California" value="{{ old('state') }}" autocomplete="address-level1">
                  <i class="fa fa-map-pin ico"></i>
                </div>
                @error('state')<div class="field-error"><i class="fa fa-circle-exclamation"></i>{{ $message }}</div>@enderror
              </div>
            </div>

            <div class="field-group">
              <label>Country</label>
              <div class="input-box">
                <select name="country" id="country"
                  class="{{ $errors->has('country') ? 'is-invalid' : '' }}" autocomplete="country">
                  <option value="">— Select your country —</option>
                  @foreach([
                    'United States','United Kingdom','Canada','Australia','Germany','France',
                    'Netherlands','Spain','Italy','Sweden','Norway','Denmark','Switzerland',
                    'New Zealand','Singapore','South Africa','Nigeria','India','Other'
                  ] as $c)
                    <option value="{{ $c }}" {{ old('country') == $c ? 'selected' : '' }}>{{ $c }}</option>
                  @endforeach
                </select>
                <i class="fa fa-globe ico"></i>
              </div>
              @error('country')<div class="field-error"><i class="fa fa-circle-exclamation"></i>{{ $message }}</div>@enderror
            </div>

            <div class="field-group">
              <label>Street Address <span class="optional-note">(optional)</span></label>
              <div class="input-box">
                <input type="text" name="address" id="address"
                  placeholder="123 Main Street" value="{{ old('address') }}" autocomplete="street-address">
                <i class="fa fa-location-dot ico"></i>
              </div>
            </div>

            <div class="terms-box">
              <input type="checkbox" id="terms" required>
              <label for="terms">
                I confirm I am 18 years or older and agree to the
                <a href="{{ url('terms') }}">Terms &amp; Conditions</a> and
                <a href="{{ url('privacy') }}">Privacy Policy</a>.
              </label>
            </div>

            <div class="btn-row">
              <button type="button" class="btn-back" onclick="goToStep1()">
                <i class="fa fa-arrow-left"></i> Back
              </button>
              <button type="submit" class="btn-create">
                <i class="fa fa-check"></i> Create Account
              </button>
            </div>
          </div>

        </form>
      </div><!-- /.card-body-inner -->

      <div class="card-footer-area">
        <p class="login-cta">Already have an account? <a href="{{ route('login') }}">Sign in here</a></p>
        <div class="trust-row">
          <div class="trust-item"><i class="fa fa-shield-halved"></i> SSL Secured</div>
          <div class="trust-item"><i class="fa fa-lock"></i> 256-bit Encrypted</div>
          <div class="trust-item"><i class="fa fa-user-shield"></i> Privacy Protected</div>
        </div>
      </div>
    </div><!-- /.reg-card -->

  </div><!-- /.reg-wrap -->
</div><!-- /.page-overlay -->

<script>
  function togglePassword() {
    const i = document.getElementById('passwordInput');
    i.type = i.type === 'password' ? 'text' : 'password';
  }
  function toggleConfirmPassword() {
    const i = document.getElementById('confirmPassword');
    i.type = i.type === 'password' ? 'text' : 'password';
  }

  function setStep(n) {
    const b1 = document.getElementById('bubble1');
    const b2 = document.getElementById('bubble2');
    const l1 = document.getElementById('label1');
    const l2 = document.getElementById('label2');
    const ln = document.getElementById('line1');
    const s1 = document.getElementById('step1');
    const s2 = document.getElementById('step2');

    if (n === 2) {
      s1.classList.remove('active');
      s2.classList.add('active');
      b1.className = 'step-circle done';
      b1.innerHTML = '<i class="fa fa-check" style="font-size:.75rem"></i>';
      l1.className = 'step-text done';
      b2.className = 'step-circle active';
      l2.className = 'step-text active';
      ln.classList.add('done');
    } else {
      s2.classList.remove('active');
      s1.classList.add('active', 'go-back');
      setTimeout(() => s1.classList.remove('go-back'), 300);
      b1.className = 'step-circle active';
      b1.innerHTML = '1';
      l1.className = 'step-text active';
      b2.className = 'step-circle';
      l2.className = 'step-text';
      ln.classList.remove('done');
    }

    window.scrollTo({ top: 0, behavior: 'smooth' });
  }

  function goToStep2() {
    const name     = document.getElementById('name');
    const lname    = document.getElementById('lname');
    const email    = document.getElementById('email');
    const password = document.getElementById('passwordInput');
    const confirm  = document.getElementById('confirmPassword');

    if (!name.value.trim() || !lname.value.trim()) { name.focus(); return; }
    if (!email.value.trim() || !email.validity.valid) { email.focus(); return; }
    if (password.value.length < 8) { password.focus(); return; }
    if (password.value !== confirm.value) { confirm.focus(); return; }

    setStep(2);
  }

  function goToStep1() { setStep(1); }

  @if ($errors->hasAny(['phone', 'country', 'state']))
    window.addEventListener('DOMContentLoaded', () => setStep(2));
  @endif
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>