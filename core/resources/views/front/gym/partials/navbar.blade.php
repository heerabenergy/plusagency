@php
    $links = json_decode($menus, true);
    //  dd($links);
@endphp

<header class="finlance_header header_v1 @yield('no-breadcrumb')">
    <div class="container-fluid">
        <div class="top_header">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="top_left">
                        <span><i class="fas fa-headphones"></i><a aria-label="{{__($bs->support_phone)}}" href="tel:{{$bs->support_phone}}">{{$bs->support_phone}}</a></span>
                        <span><i class="far fa-envelope"></i><a aria-label="{{__($bs->support_email)}}" href="mailto:{{$bs->support_email}}">{{$bs->support_email}}</a></span>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="top_right d-flex align-items-center">
                        <ul class="social">
                            @foreach ($socials as $key => $social)
                                <li><a aria-label="{{__($social->name)}}" href="{{$social->url}}"><i class="{{$social->icon}}"></i></a></li>
                            @endforeach
                        </ul>

                        @if (!empty($currentLang) && count($langs) > 1)
                            <div class="dropdown">
                                <button aria-label="{{__('Toggle Language')}}" type="button" class="btn dropdown-toggle" data-toggle="dropdown"><i class="fas fa-globe"></i>{{convertUtf8($currentLang->name)}}
                                </button>
                                <div class="dropdown-menu">
                                    @foreach ($langs as $key => $lang)
                                        <a aria-label="{{__($lang->name)}}" class="dropdown-item" href='{{ route('changeLanguage', $lang->code) }}'>{{convertUtf8($lang->name)}}</a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @guest
                            @if ($bex->is_user_panel == 1)
                                <ul class="login">
                                    <li><a aria-label="{{__('Login')}}" href="{{route('user.login')}}">{{__('Login')}}</a></li>
                                </ul>
                            @endif
                        @endguest
                        @auth
                        <div class="dropdown ml-4">
                            <button aria-label="{{__('Toggle Dashboard')}}" type="button" class="btn dropdown-toggle" data-toggle="dropdown"><i class="far fa-user mr-1"></i> {{Auth::user()->username}}
                            </button>
                            <div class="dropdown-menu">
                                <a aria-label="{{__('Dashboard')}}" class="dropdown-item" href="{{route('user-dashboard')}}">{{__('Dashboard')}}</a>
                                @if ($bex->recurring_billing == 1)
                                    <a class="dropdown-item" href="{{route('user-packages')}}">{{__('Packages')}}</a>
                                @endif
                                @if ($bex->is_shop == 1 && $bex->catalog_mode == 0)
                                    <a aria-label="{{__('Product Orders')}}" class="dropdown-item" href="{{route('user-orders')}}">{{__('Product Orders')}} </a>
                                @endif
                                @if ($bex->recurring_billing == 0)
                                    <a aria-label="{{__('Package Orders')}}" class="dropdown-item" href="{{route('user-package-orders')}}">{{__('Package Orders')}} </a>
                                @endif

                                @if ($bex->is_course == 1)
                                <a aria-label="{{__('My Courses')}}" class="dropdown-item" href="{{route('user.course_orders')}}" >{{__('My Courses')}}</a>
                                @endif

                                @if ($bex->is_event == 1)
                                <a aria-label="{{__('Event Bookings')}}" class="dropdown-item" href="{{route('user-events')}}" >{{__('Event Bookings')}}</a>
                                @endif

                                @if ($bex->is_ticket == 1)
                                    <a aria-label="{{__('Support Tickets')}}" class="dropdown-item" href="{{route('user-tickets')}}">{{__('Support Tickets')}}</a>
                                @endif
                                <a aria-label="{{__('Edit Profile')}}" class="dropdown-item" href="{{route('user-profile')}}">{{__('Edit Profile')}}</a>
                                @if ($bex->is_shop == 1 && $bex->catalog_mode == 0)
                                    <a aria-label="{{__('Shipping Details')}}" class="dropdown-item" href="{{route('shpping-details')}}">{{__('Shipping Details')}}</a>
                                    <a aria-label="{{__('Billing Details')}}" class="dropdown-item" href="{{route('billing-details')}}">{{__('Billing Details')}}</a>
                                    <a aria-label="{{__('Change Password')}}" class="dropdown-item" href="{{route('user-reset')}}">{{__('Change Password')}}</a>
                                @endif
                                <a aria-label="{{__('Logout')}}" class="dropdown-item" href="{{route('user-logout')}}" target="_self">{{__('Logout')}}</a>
                            </div>
                        </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
        <div class="header_navigation">
            <div class="site_menu">
                <div class="row align-items-center">
                    <div class="col-lg-2 col-sm-12">
                        <div class="brand">
                            <a aria-label="{{__('Home')}}" href="{{route('front.index')}}"><img data-src="{{asset('assets/front/img/'.$bs->logo)}}" class="img-fluid lazy" alt="{{__('Logo')}}"></a>
                        </div>
                    </div>
                    <div class="{{$bs->is_quote == 1 ? 'col-lg-8' : 'col-lg-10'}}">
                        <div class="primary_menu">
                            <nav class="main-menu {{$bs->is_quote == 0 ? 'text-right' : ''}}">
                                @php
                                    $links = json_decode($menus, true);
                                    //  dd($links);
                                @endphp
                                <ul>

                                    @foreach ($links as $link)
                                        @php
                                            $href = getHref($link);
                                        @endphp


                                        @if (strpos($link["type"], '-megamenu') !==  false)
                                            @includeIf('front.gym.partials.mega-menu')

                                        @else

                                            @if (!array_key_exists("children",$link))
                                                {{--- Level1 links which doesn't have dropdown menus ---}}
                                                <li><a aria-label="{{__($link["text"])}}" href="{{$href}}" target="{{$link["target"]}}">{{$link["text"]}}</a></li>

                                            @else
                                                <li class="menu-item-has-children">
                                                    {{--- Level1 links which has dropdown menus ---}}
                                                    <a aria-label="{{__($link["text"])}}" href="{{$href}}" target="{{$link["target"]}}">{{$link["text"]}}</a>

                                                    <ul class="sub-menu">



                                                        {{-- START: 2nd level links --}}
                                                        @foreach ($link["children"] as $level2)
                                                            @php
                                                                $l2Href = getHref($level2);
                                                            @endphp

                                                            <li @if(array_key_exists("children", $level2)) class="submenus" @endif>
                                                                <a aria-label="{{__($level2["text"])}}" href="{{$l2Href}}" target="{{$level2["target"]}}">{{$level2["text"]}}</a>

                                                                {{-- START: 3rd Level links --}}
                                                                @php
                                                                    if (array_key_exists("children", $level2)) {
                                                                        create_menu($level2);
                                                                    }
                                                                @endphp
                                                                {{-- END: 3rd Level links --}}

                                                            </li>
                                                        @endforeach
                                                        {{-- END: 2nd level links --}}



                                                    </ul>

                                                </li>
                                            @endif


                                        @endif



                                    @endforeach
                                </ul>
                            </nav>
                        </div>
                    </div>
                    @if ($bs->is_quote == 1)
                        <div class="col-lg-2">
                            <div class="button_box">
                                <a aria-label="{{__('Get Quote')}}" href="{{route('front.quote')}}" class="finlance_btn">{{__('Get Quote')}}</a>
                            </div>
                        </div>
                    @endif
                    <div class="col-sm-12">
                        <div class="mobile_menu"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
