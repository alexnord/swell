<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li>
	<a href="{{ backpack_url('dashboard') }}"><i class="fa fa-dashboard"></i> <span>{{ trans('backpack::base.dashboard') }}</span></a>
</li>

<li>
	<a href="{{ backpack_url('elfinder') }}"><i class="fa fa-files-o"></i> <span>{{ trans('backpack::crud.file_manager') }}</span></a>
</li>

<!-- Swell Data -->
<li class="treeview">
	<a href="#"><i class="fa fa-group"></i> <span>Swell Data</span> <i class="fa fa-angle-left pull-right"></i></a>
	<ul class="treeview-menu">
		<li>
			<a href='{{ backpack_url('buoy') }}'><i class='fa fa-tag'></i> <span>Buoys</span></a>
		</li>
	</ul>
</li>


<!-- Users, Roles Permissions -->
<li class="treeview">
<a href="#"><i class="fa fa-group"></i> <span>System</span> <i class="fa fa-angle-left pull-right"></i></a>
<ul class="treeview-menu">
  <li>
  	<a href="{{ backpack_url('user') }}"><i class="fa fa-user"></i> <span>Users</span></a>
  </li>
  <li>
  	<a href="{{ backpack_url('role') }}"><i class="fa fa-group"></i> <span>Roles</span></a>
  </li>
  <li>
  	<a href="{{ backpack_url('permission') }}"><i class="fa fa-key"></i> <span>Permissions</span></a>
  </li>
</ul>
</li>
<li><a href='{{ backpack_url('noaaStation') }}'><i class='fa fa-tag'></i> <span>Noaa Stations</span></a></li>