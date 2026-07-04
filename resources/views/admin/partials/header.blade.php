<div class="header d-flex justify-content-between align-items-center">

    <h5 class="mb-0">
        @yield('page-title', 'Dashboard')
    </h5>

    <div class="dropdown">

        <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle"
           data-bs-toggle="dropdown" aria-expanded="false">
            @auth
            @php
                $user = auth()->user();
            @endphp
                {{-- @dd($user->profile_image) --}}
            <img src="{{ asset('uploads/' . $user->profile_image) }}"
                 alt="profile"
                 width="40"
                 height="40"
                 class="rounded-circle me-2"
                 style="object-fit: cover; border:2px solid #0ea5e9;">

            <strong>{{ $user->name }}</strong>
            @endauth
        </a>

        <ul class="dropdown-menu dropdown-menu-end shadow">
            <li>
                <a class="dropdown-item" href="#">
                    <i class="fa fa-user me-2"></i> Profile
                </a>
            </li>

            <li>
                <a class="dropdown-item" href="#">
                    <i class="fa fa-cog me-2"></i> Settings
                </a>
            </li>

            <li><hr class="dropdown-divider"></li>

            <li>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item text-danger">
                        <i class="fa fa-sign-out-alt me-2"></i> Logout
                    </button>
                </form>
            </li>
        </ul>

    </div>

</div>
