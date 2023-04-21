<header id="page-topbar">
    @php
    var_dump(Auth::check());
    @endphp

    <div class="navbar-header">
        <div class="d-flex">

            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="{{ route('dashboard') }}" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ asset('backend/assets/images/logo-sm.png') }}" alt="logo-sm" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('backend/assets/images/logo-dark.png') }}" alt="logo-dark" height="20">
                    </span>
                </a>

                <a href="{{ route('dashboard') }}" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ asset('backend/assets/images/logo-sm.png') }}" alt="logo-sm-light" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('backend/assets/images/logo.png') }}" alt="logo-light" style="height:30%; width:40%;">
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



            <div class="dropdown d-block d-sm-inline-block">
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

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="ri-notification-3-line"></i>
                    <span class="{{isset($notifications) && $notifications->count() > 0 ? 'noti-dot' : ''}}"></span>

                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-notifications-dropdown" style="">
                    <div class="p-3">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="m-0"> Notifications </h6>
                            </div>
                            <div class="col-auto">
                                <a href="{{route('notifications.all')}}" class="small"> View All</a>
                            </div>
                        </div>
                    </div>
                    <div data-simplebar="init" style="max-height: 230px;">
                        <div class="simplebar-wrapper" style="margin: 0px;">
                            <div class="simplebar-height-auto-observer-wrapper">
                                <div class="simplebar-height-auto-observer"></div>
                            </div>
                            <div class="simplebar-mask">
                                <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                                    <div class="simplebar-content-wrapper" style="height: auto; overflow: hidden;">
                                        <div class="simplebar-content" style="padding: 0px;">
                                            <a href="" class="text-reset notification-item">
                                                <div class="d-flex">

                                                    <!-- start -->
                                                    <a href="" class="text-reset notification-item w-100">

                                                        @if(isset($notifications) && $notifications->count()> 0)
                                                        @foreach($notifications as $notification)
                                                        <div class="d-flex">
                                                            <div class="{{$notifications->count() > 0?'avatar-xs me-3' : ''}}">
                                                                <span class=" avatar-title bg-primary rounded-circle font-size-16">

                                                                    <i class=" {{$notifications->count() > 0?'fas fa-exclamation-triangle' : ''}}"></i>

                                                                </span>
                                                            </div>
                                                            <div class="flex-1">

                                                                <div class="notif-div">
                                                                    <button type="button" class="btn-close" aria-label="Close" style="margin-left:98%;" data-attr-notid="{{$notification->id}}" onclick="removeNotification(event, this)"></button>
                                                                    <h6 class="mb-1 mt-n4">{{ $notification->message }}</h6>
                                                                    <div class="font-size-12 text-muted">
                                                                        <p class="mb-1">Only {{ $notification['products']['product_qte']  }} Are Left </p>
                                                                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i>{{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</p>
                                                                    </div>
                                                                </div>


                                                            </div>
                                                        </div>
                                                        @endforeach
                                                        @else
                                                        <div class=" text-center">
                                                            <div class="font-size-12 text-muted ">
                                                                <p class="mb-1">No Notifications Available. </p>

                                                            </div>
                                                        </div>
                                                        @endif

                                                    </a>

                                                </div>
                                            </a>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="simplebar-placeholder" style="width: 0px; height: 0px;"></div>
                        </div>
                        <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                            <div class="simplebar-scrollbar" style="transform: translate3d(0px, 0px, 0px); display: none;"></div>
                        </div>
                        <div class="simplebar-track simplebar-vertical" style="visibility: hidden;">
                            <div class="simplebar-scrollbar" style="transform: translate3d(0px, 0px, 0px); display: none; height: 169px;"></div>
                        </div>
                    </div>
                    <div class="p-2 border-top">
                        <div class="d-grid">
                            <a class="btn btn-sm btn-link font-size-14 text-center" href="{{route('notifications.all')}}">
                                <i class="mdi mdi-arrow-right-circle me-1"></i> View More..
                            </a>
                        </div>
                    </div>
                </div>
            </div>




            <div class="dropdown d-none d-lg-inline-block ms-">
                <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                    <i class="ri-fullscreen-line"></i>
                </button>
            </div>

            @php
            if(Auth::check()){
            $id = Auth::user()->id;
            $adminData = App\Models\User::find($id);
            }
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


                    <div class="dropdown-divider"></div>

                    <a class="dropdown-item text-danger" href="{{ route('admin.logout') }}"><i class="ri-shut-down-line align-middle me-1 text-danger"></i> Logout</a>
                </div>
            </div>



        </div>
    </div>
    <script>
        function removeNotification(event, button) {
            event.stopPropagation();
            event.preventDefault(); // prevent the button from closing the notification bar

            const notificationDiv = button.parentNode;
            const Notificationid = +button.getAttribute('data-attr-notid');
            if (!Notificationid) {
                return;
            } else {
                const url = `{{route("notification-is-read")}}?notificationid=${Notificationid}`;
                Notificationisread(url);

            }
            notificationDiv.remove();
        }
    </script>
    <script>
        async function Notificationisread(url) {
            try {
                const reponse = await fetch(url);
                const data = await reponse.json();
                $.notify(data.message, "success");

                console.log(data);
            } catch (error) {
                console.log(error);
            }



        }
    </script>

</header>