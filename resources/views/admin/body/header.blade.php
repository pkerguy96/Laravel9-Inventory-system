<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="index.html" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ asset('backend/assets/images/logo-sm.png') }}" alt="logo-sm" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('backend/assets/images/logo-dark.png') }}" alt="logo-dark" height="20">
                    </span>
                </a>

                <a href="index.html" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ asset('backend/assets/images/logo-sm.png') }}" alt="logo-sm-light" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('backend/assets/images/logo-light.png') }}" alt="logo-light" height="20">
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                <i class="ri-menu-2-line align-middle"></i>
            </button>

            <!-- App Search-->
            <form class="app-search d-none d-lg-block">
                <div class="position-relative">
                    <input type="text" class="form-control" placeholder="Search...">
                    <span class="ri-search-line"></span>
                </div>
            </form>


        </div>

        <div class="d-flex">

            <!-- start -->


            <!-- <div class="flex justify-center pt-8 sm:justify-start sm:pt-0">
                @foreach($available_locales as $locale_name => $available_locale)
                @if($available_locale === $current_locale)
                <span class="ml-2 mr-2 text-gray-700">{{ $locale_name }}</span>
                @else
                <a class="ml-1 underline ml-2 mr-2" href="language/{{ $available_locale }}">
                    <span>{{ $locale_name }}</span>
                </a>
                @endif
                @endforeach
            </div> -->

            <div class="dropdown d-none d-sm-inline-block">
                @php
                $lel = app()->getLocale();
                @endphp
                <button type="button" class="btn lang-btn header-item waves-effect" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="" src="{{asset('backend/assets/images/flags/'. $lel .'.jpg')}}" alt="Header Language" height="16">
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    @foreach($available_locales as $locale_name => $available_locale)
                    @if($available_locale !== $lel)
                    <a href="{{ url('/') }}/language/{{ $available_locale }}" class="dropdown-item notify-item">
                        <img src="{{asset('backend/assets/images/flags/'. $available_locale .'.jpg')}} " alt="user-image" class="me-1" height="12"> <span class="align-middle">{{ $locale_name }}</span>
                    </a>
                    @endif
                    @endforeach
                </div>
            </div>






            <div class="dropdown d-none d-lg-inline-block ms-">
                <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                    <i class="ri-fullscreen-line"></i>
                </button>
            </div>

            @php
            $id = Auth::user()->id;

            $adminData = App\Models\User::find($id);

            @endphp




            <div class="dropdown d-inline-block user-dropdown">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="{{ (!empty($adminData->profile_image))? url('upload/admin_images/'.$adminData->profile_image):url('upload/no_image.jpg') }}" alt="Header Avatar">
                    <span class="d-none d-xl-inline-block ms-1">{{ $adminData->name }}</span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <a class="dropdown-item" href="{{ route('admin.profile') }}"><i class="ri-user-line align-middle me-1"></i> Profile</a>
                    <a class="dropdown-item" href="{{ route('change.password') }}"><i class="ri-wallet-2-line align-middle me-1"></i> Change Password</a>
                    <a class="dropdown-item d-block" href="#"><span class="badge bg-success float-end mt-1">11</span><i class="ri-settings-2-line align-middle me-1"></i> Settings</a>
                    <a class="dropdown-item" href="#"><i class="ri-lock-unlock-line align-middle me-1"></i> Lock screen</a>
                    <div class="dropdown-divider"></div>

                    <a class="dropdown-item text-danger" href="{{ route('admin.logout') }}"><i class="ri-shut-down-line align-middle me-1 text-danger"></i> Logout</a>
                </div>
            </div>



        </div>
    </div>


</header>