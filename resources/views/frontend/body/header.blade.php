<header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

        <a href="index.html" class="logo d-flex align-items-center me-auto">
            <!-- Uncomment the line below if you also wish to use an image logo -->
            <!-- <img src="assets/img/logo.png" alt=""> -->
            <h1 class="sitename">Logis</h1>
        </a>

        <nav id="navmenu" class="navmenu">
            <ul>
                <li><a href="{{url('/')}}" class="active">Home<br></a></li>
                <li><a href="{{route('home.about')}}">About</a></li>
                <li><a href="{{route('projects.page')}}">Projects</a></li>
                <li><a href="{{route('services.page')}}">Services</a></li>
                <li><a href="{{route('features.page')}}">Features</a></li>

                <li><a href="{{route('feedback.us')}}">Feedbacks</a></li>
                
            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

        <a class="btn-getstarted" href="{{route('contact.us')}}">Contact Us</a>

    </div>
</header>