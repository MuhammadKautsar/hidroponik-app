@auth()
    @include('layouts.back.inc.navbars.navs.auth')
@endauth
    
@guest()
    @include('layouts.back.inc.navbars.navs.guest')
@endguest