@extends('frontend.main_master')
@section('main')

<main class="main">

    <!-- Page Title -->
    <div class="page-title dark-background" data-aos="fade" style="background-image: url({{asset($homeSlide->backgroundImage)}});">
      <div class="container position-relative">
        <h1>Our Features </h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.html">Home</a></li>
            <li class="current">Features</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

    <!-- Starter Section Section -->
    <section id="starter-section" class="starter-section section">

      <!-- Section Title -->
      <section id="features" class="features section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <span>Our Features</span>
            <h2>Our Features</h2>
        </div><!-- End Section Title -->

        <div class="container">
    
            @foreach ($allFeatures as $item)
            <div class="row gy-4 align-items-center features-item">
                <div class="col-md-5 d-flex align-items-center" data-aos="zoom-out" data-aos-delay="100">
                    <img src="{{asset($item->feature_image)}}" class="img-fluid" alt="">
                </div>
                <div class="col-md-7" data-aos="fade-up" data-aos-delay="100">
                    <h3>{{$item->feature_title}}</h3>
                    <p class="fst-italic">
                        {!!$item->feature_description!!}
                    </p>
                    
                </div>
            </div><!-- Features Item -->
    
            @endforeach
         
           
        </div>

    </section>
      <!-- End Section Title -->

      

    </section><!-- /Starter Section Section -->

  </main>
@endsection