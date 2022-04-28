    <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
        <div class="main-menu-content">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                <li class=" nav-item"><a href="/"><i class="mbri-desktop"></i><span class="menu-title"
                            data-i18n="Dashboard">Dashboard</span></a>

                </li>
                @if (doPermitted('//subjects') || doPermitted('//events'))
                    <li class=" nav-item"><a href="#"><i class="
                        la la-bookmark-o"></i><span class="menu-title"
                                data-i18n="Pages">Enrollment</span></a>
                        <ul class="menu-content">
                            @if (doPermitted('//subjects'))
                                <li class=" nav-item"><a href="/subjects"><i class="la la-area-chart"></i><span
                                            class="menu-title" data-i18n="Apps">Subjects</span></a>

                                </li>
                            @endif

                            @if (doPermitted('//events'))
                                <li class=" nav-item"><a href="/events"><i class="la la-birthday-cake"></i><span
                                            class="menu-title" data-i18n="Apps">Events</span></a>

                                </li>
                            @endif

                             @if (doPermitted('//timetable'))
                                <li class=" nav-item"><a href="/timetable"><i class="bi bi-calendar-week"></i>                                    <span
                                            class="menu-title" data-i18n="Apps">Timetable</span></a>

                                </li>
                            @endif
                        </ul>
                    </li>

                @endif
                @if (doPermitted('//users'))
                    <li class=" nav-item"><a href="#"><i class="mbri-setting3"></i><span class="menu-title"
                                data-i18n="Pages">System</span></a>
                        <ul class="menu-content">
                            @if (doPermitted('//users'))
                                <li><a class="menu-item" href="/users"><i
                                            class="la la-user-plus"></i><span>Users</span></a>
                                </li>
                            @endif
                            @if (doPermitted('//users'))
                                <li><a class="menu-item" href="/usertypes"><i
                                            class="la la-key"></i><span>Permission Levels</span></a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif


            </ul>
        </div>
    </div>