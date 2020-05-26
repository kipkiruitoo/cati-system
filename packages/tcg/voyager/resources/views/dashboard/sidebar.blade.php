<div class="side-menu sidebar-inverse">
    <nav class="navbar navbar-default" role="navigation">
        <div class="side-menu-container">
            <div class="navbar-header">
                <a class="navbar-brand" href="{{ route('voyager.dashboard') }}">
                    <div class="logo-icon-container">
                        <?php $admin_logo_img = Voyager::setting('admin.icon_image', ''); ?>
                        @if($admin_logo_img == '')
                            <img src="{{ voyager_asset('images/logo-icon-light.png') }}" alt="Logo Icon">
                        @else
                            <img src="{{ Voyager::image($admin_logo_img) }}" alt="Logo Icon">
                        @endif
                    </div>
                    <div class="title">{{Voyager::setting('admin.title', 'Panel Management')}}</div>
                </a>
            </div><!-- .navbar-header -->

            <div class="panel widget center bgimage"
                 style="background-image:url({{ Voyager::image( Voyager::setting('admin.bg_image'), voyager_asset('images/bg.jpg') ) }}); background-size: cover; background-position: 0px;">
                <div class="dimmer"></div>
                <div class="panel-content">
                    <img src="{{ $user_avatar }}" class="avatar" alt="{{ Auth::user()->name }} avatar">
                    <h4>{{ ucwords(Auth::user()->name) }}</h4>
                    <p>{{ Auth::user()->email }}</p>

                    <a href="{{ route('voyager.profile') }}" class="btn btn-primary">{{ __('voyager::generic.profile') }}</a>
                    <div style="clear:both"></div>
                </div>
            </div>

        </div>
        @if(Auth::user()->role_id == 2 )
         <div id="adminmenu">
            <admin-menu :items="{{ menu('agents', '_json') }}"></admin-menu>
        </div>
        @elseif(Auth::user()->role_id == 4)
        <div id="adminmenu">
            <admin-menu :items="{{ menu('scripters', '_json') }}"></admin-menu>
        </div>
        @elseif( Auth::user()->role_id == 1 || Auth::user()->role_id == 3 )

         <div id="adminmenu">
            <admin-menu :items="{{ menu('admin', '_json') }}"></admin-menu>
        </div>
        @elseif(Auth::user()->role_id == 7 )

         <div id="adminmenu">
            <admin-menu :items="{{ menu('client', '_json') }}"></admin-menu>
        </div>


        @elseif(Auth::user()->role_id == 5 )

         <div id="adminmenu">
            <admin-menu :items="{{ menu('supervisor', '_json') }}"></admin-menu>
        </div>
        @elseif(Auth::user()->role_id == 6 )

         <div id="adminmenu">
            <admin-menu :items="{{ menu('qc', '_json') }}"></admin-menu>
        </div>
        @endif
    </nav>
</div>
