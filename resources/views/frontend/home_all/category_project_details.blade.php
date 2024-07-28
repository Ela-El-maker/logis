@extends('frontend.main_master')

@section('main')

<main class="main">

    <!-- Page Title -->
    <div class="page-title dark-background" data-aos="fade" style="background-image: url({{asset($homeSlide->backgroundImage)}});">
      <div class="container position-relative">
        <h1>{{$categoryName->project_category}}</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="{{url('/')}}">Home</a></li>
            <li class="current">{{$categoryName->project_category}}</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

    <!-- Featured Services Section -->
    <section id="featured-services" class="featured-services section">

      <div class="container">

       
        <div class="row gy-4">
            @foreach ($projects as $item)
            <div class="col-lg-4 col-md-6 service-item d-flex" data-aos="fade-up" data-aos-delay="100">
                <div class="icon flex-shrink-0"><i class="{{$item->project_icon}}"></i></div>
                <div>
                    <h4 class="title">{{$item->project_name}}</h4>
                    <p class="description">{!!$item->project_title!!}</p>
                    <a href="{{route('home.project.details', $item->id)}}" class="readmore stretched-link"><span>Learn More</span><i
                            class="bi bi-arrow-right"></i></a>
                </div>
            </div>
            <!-- End Service Item -->
            @endforeach
           

          
        </div>

      </div>

    </section>
    <!-- /Featured Services Section -->

    <!-- Services Section -->
    <section id="services" class="services section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <span>{{$categoryName->project_category}} Projects<br></span>
        <h2>{{$categoryName->project_category}} Projects</h2>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="row gy-4">

      @foreach ($projectPost as $project)
      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
        <a href="{{route('home.project.details',$project->id)}}" class="card-link">
          <div class="card" style="
            background-image: url({{asset($project->project_image)}});
            background-size: cover;
            background-position: center;
            height: 100%;
            padding: 20px;
            border-radius: 5px;
            position: relative;
            transition: transform 0.3s;
            text-decoration: none;
            color: inherit;
          ">
            <h3 style="
              background: rgba(255, 255, 255, 0.8);
              padding: 10px;
              border-radius: 5px;
            ">{{$project->project_name}}</h3>
            <p style="
              background: rgba(255, 255, 255, 0.8);
              padding: 10px;
              border-radius: 5px;
            ">{!! Str::limit($project->project_title, 150)!!}</p>
          </div>
        </a>
      </div><!-- End Card Item -->
      @endforeach
     
          
          <!-- Inline CSS for hover effect -->
          <style>
            .card-link .card:hover {
              transform: scale(1.05); /* Optional: add a hover effect */
            }
          </style>
          <!-- End Card Item -->

       
        </div>

      </div>

    </section>
    <!-- /Services Section -->

    <!-- Features Section -->
    
    <!-- /Features Section -->

    <!-- Testimonials Section -->
    @include('frontend.home_all.view_feedbacks')
    <!-- /Testimonials Section -->

    <!-- Faq Section -->
    
    
    <!-- /Faq Section -->

  </main>


@endsection