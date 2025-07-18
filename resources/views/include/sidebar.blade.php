@php
    $current = "bg-gray-50 text-indigo-700 hover:text-indigo-700 hover:bg-white";
    $default = "text-gray-900 hover:text-gray-900 hover:bg-gray-50"
@endphp
<aside class="py-6 px-2 sm:px-6 lg:py-0 lg:px-0 lg:col-span-3">
    <nav class="space-y-1">

        <a href="{{ url('ums') }}"
           class="{{ (Request::segment(1) == 'ums'  && empty( Request::segment(2))) ? $current : $default  }} group rounded-md px-3 py-2 flex items-center text-sm font-medium"
           aria-current="page">
            <span class="truncate">
          My Profile
        </span>
        </a>


        <a href="{{ url('ums/change-password') }}"
           class="{{ (Request::segment(1) == 'ums'  &&  Request::segment(2) == 'change-password' ) ? $current : $default  }} group rounded-md px-3 py-2 flex items-center text-sm font-medium"
           aria-current="page">
            <span class="truncate">
          Change Password
        </span>
        </a>


        {{-- @if(isset(auth()->user()['2fa']))
          <a href="{{ url('ums/2fa') }}"
            class="{{ (Request::segment(1) == 'ums'  &&  Request::segment(2) == '2fa' ) ? $current : $default  }} group rounded-md px-3 py-2 flex items-center text-sm font-medium"
            aria-current="page">
            <span class="truncate">
              Google 2FA
            </span>
          </a>
        @endif --}}

        <a href="{{ url('ums/users') }}"
           class="{{ (Request::segment(1) == 'ums'  &&  Request::segment(2) == 'users' ) ? $current : $default  }} group rounded-md px-3 py-2 flex items-center text-sm font-medium"
           aria-current="page">
            <span class="truncate">
          Users
        </span>
        </a>

        @can('1.manage-role')
        <a href="{{ url('ums/manage-roles') }}"
           class="{{ (Request::segment(1) == 'ums'  &&  (Request::segment(2) == 'manage-roles' || Request::segment(3) == 'assign-permissions')) ? $current : $default  }} group rounded-md px-3 py-2 flex items-center text-sm font-medium"
           aria-current="page">
            <span class="truncate">
          Manage Roles
        </span>
        </a>
        @endcan

        <a href="{{ url('ums/permissions-list') }}"
           class="{{ (Request::segment(1) == 'ums'  &&  (Request::segment(2) == 'permissions-list' || Request::segment(2) == 'permission-detail') ) ? $current : $default  }} group rounded-md px-3 py-2 flex items-center text-sm font-medium"
           aria-current="page">
            <span class="truncate">
          Permissions
        </span>
        </a>

        <a href="{{ url('ums/user-activity') }}"
           class="{{ (Request::segment(1) == 'ums'  &&  (Request::segment(2) == 'user-activity' || Request::segment(2) == 'activity-details') ) ? $current : $default  }} group rounded-md px-3 py-2 flex items-center text-sm font-medium"
           aria-current="page">
            <span class="truncate">
          User Activity
        </span>
        </a>


    </nav>
</aside>
