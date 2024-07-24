@extends('frontend.main_master')
@section('main')

<main class="main">

    <!-- Page Title -->
    <div class="page-title dark-background" data-aos="fade" style="background-image: url({{asset($homeSlide->backgroundImage)}});">
      <div class="container position-relative">
        <h1>{{$projectItems->project_name}}</h1>
        {{-- <p>Esse dolorum voluptatum ullam est sint nemo et est ipsa porro placeat quibusdam quia assumenda numquam molestias.</p> --}}
        <nav class="breadcrumbs">
          <ol>
            <li><a href="{{url('/')}}">Home</a></li>
            <li class="current">{{$projectItems->project_name}}</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

    <!-- Service Details Section -->
    <section id="service-details" class="service-details section">

      <div class="container">

        <div class="row gy-4">

          <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
            <div class="services-list">
              <a href="#" class="active">Web Design</a>
              <a href="#">Software Development</a>
              <a href="#">Product Management</a>
              <a href="#">Graphic Design</a>
              <a href="#">Marketing</a>
            </div>

            <h4>{{$projectItems->project_name}}</h4>
            <p>{{$projectItems->project_sub_title}}</p>
          </div>

          <div class="col-lg-8" data-aos="fade-up" data-aos-delay="200">
            <img src="{{asset($projectItems->project_image)}}" alt="" class="img-fluid services-img">
            <h3>{{$projectItems->project_title}}</h3>
            <p>{!!$projectItems->project_description!!}</p>
          </div>

        </div>

      </div>

    </section><!-- /Service Details Section -->

  </main>

@endsection