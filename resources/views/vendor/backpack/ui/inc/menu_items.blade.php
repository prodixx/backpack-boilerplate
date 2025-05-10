{{-- This file is used for menu items by any Backpack v6 theme --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

<x-backpack::menu-dropdown title="Sistem" icon="la la-puzzle-piece">
    <x-backpack::menu-dropdown-header title="Autentificare" />
    <x-backpack::menu-dropdown-item title="Administratori" icon="la la-user" :link="backpack_url('user')" />
    <x-backpack::menu-dropdown-item title="Roluri" icon="la la-group" :link="backpack_url('role')" />
    <x-backpack::menu-dropdown-item title="Permisiuni" icon="la la-key" :link="backpack_url('permission')" />
    <x-backpack::menu-dropdown-header title="Sistem" />
    <x-backpack::menu-dropdown-item title="Backup" icon="la la-hdd-o" :link="backpack_url('backup')" />
    <x-backpack::menu-dropdown-item title="Log-uri" icon="la la-terminal" :link="backpack_url('log')" />
    <x-backpack::menu-dropdown-item title="Setari" icon="la la-cog" :link="backpack_url('setting')" />
</x-backpack::menu-dropdown>
