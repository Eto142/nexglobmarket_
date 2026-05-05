<!-- partial -->
<!-- Main container start -->
<div class="main-container">

  <!-- Sidebar wrapper start -->
  <nav class="sidebar-wrapper">

    <!-- Sidebar brand starts -->
    <div class="brand">
      <a href="{{url('home')}}" class="logo">
        <img src="{{asset('io.png')}}" class="d-none d-md-block me-4" alt="Rapid Admin Dashboard" />
        <img src="{{asset('io.png')}}" class="d-block d-md-none me-4" alt="Rapid Admin Dashboard" />
      </a>
    </div>
    <!-- Sidebar brand ends -->

    <!-- Sidebar menu starts -->
    <div class="sidebar-menu">
      <div class="sidebarMenuScroll">
        <ul>
          <li class="active-page-link">
            <a href="{{route('admin.dashboard')}}">
              <i class="bi bi-house"></i>
              <span class="menu-text">Dashboard</span>
            </a>
          </li>
          <li>
            <a href="{{url('admin/users')}}">
              <i class="bi bi-box"></i>
              <span class="menu-text"> Total Users</span>
            </a>
          </li>

          <li>
            <a href="{{route('admin.wallet')}}">
              <i class="bi bi-box"></i>
              <span class="menu-text">Update Wallet</span>
            </a>
          </li>



          <li>
            <a href="{{route('admin.add-traders')}}">
              <i class="bi bi-calendar4"></i>
              <span class="menu-text">Add Copy Traders</span>
            </a>
          </li>

          <li>
            <a href="{{route('admin.user.transactions')}}">
              <i class="bi bi-calendar4"></i>
              <span class="menu-text">Transactions</span>
            </a>
          </li>
          
           <li>
            <a href="{{route('admin.manage-deposit')}}">
              <i class="bi bi-calendar4"></i>
              <span class="menu-text">Total Deposits</span>
            </a>
          </li>

 <li>
            <a href="{{route('admin.manage-withdrawal')}}">
              <i class="bi bi-calendar4"></i>
              <span class="menu-text">Total Withdrawals</span>
            </a>
          </li>

          <li>
            <a href="{{route('admin.change.password')}}">
              <i class="bi bi-emoji-expressionless"></i>
              <span class="menu-text">Change Password</span>
            </a>
          </li>

          <li>
            <a href="{{route('admin.send.mail')}}">
              <i class="bi bi-code-square"></i>
              <span class="menu-text">Send Email</span>
            </a>
          </li>

          <li>
            <form method="POST" action="{{ route('admin.logout') }}" style="display:inline;">
              @csrf
              <button type="submit" style="background:none;border:none;padding:0;cursor:pointer;width:100%;text-align:left;">
                <i class="bi bi-emoji-expressionless"></i>
                <span class="menu-text">Logout</span>
              </button>
            </form>
          </li>
        </ul>
      </div>
    </div>
    <!-- Sidebar menu ends -->

  </nav>
  <!-- Sidebar wrapper end -->
  @if (session('error'))
  <div class="alert box-bdr-red alert-dismissible fade show text-red" role="alert">
    <b>Error!</b>{{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  @elseif (session('status'))
  <div class="alert box-bdr-green alert-dismissible fade show text-green" role="alert">
    <b>Success!</b> {{ session('status') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  @elseif (session('message'))
  <div class="alert box-bdr-green alert-dismissible fade show text-green" role="alert">
    <b>Success!</b> {{ session('message') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  @endif