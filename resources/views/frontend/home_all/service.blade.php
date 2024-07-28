@extends('frontend.main_master')
@section('main')
    <main class="main">

        <!-- Page Title -->
        <div class="page-title dark-background" data-aos="fade"
            style="background-image: url({{ asset($serviceCategory->service_category_image) }});">
            <div class="container position-relative">
                <h1>{{ $serviceItems->service_name }}</h1>
                {{-- <p>Esse dolorum voluptatum ullam est sint nemo et est ipsa porro placeat quibusdam quia assumenda numquam molestias.</p> --}}
                <nav class="breadcrumbs">
                    <ol>
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li><a
                                href="{{ route('category.service', $serviceCategory->id) }}">{{ $serviceCategory->service_category }}</a>
                        </li>
                        {{-- <li class="current">{{$serviceItems->service_name}}</li> --}}
                    </ol>
                </nav>
            </div>
        </div><!-- End Page Title -->


        <section id="service-details" class="service-details section">
            <div class="container">
                <div class="row gy-4">
                    <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                        <div class="services-list">
                            @foreach ($serviceCategories as $category)
                                <a href="{{ route('category.service', $category->id) }}"
                                    class="active">{{ $category->service_category }}</a>
                            @endforeach

                        </div>

                        <h4>{{ $serviceCategory->service_category }}</h4>
                        <p>{{ $serviceItems->service_sub_title }}</p>


                    </div>

                    <div class="col-lg-8" data-aos="fade-up" data-aos-delay="200">
                        <img src="{{ asset($serviceItems->service_image) }}" alt="" class="img-fluid services-img">
                        <h3>{{ $serviceItems->service_title }}</h3>
                        {{-- <!-- New Images Row -->
                        <div class="images-row">
                            <img src="{{ asset($serviceItems->service_image_1) }}" alt="Image 1"
                                class="img-fluid side-image">
                            <img src="{{ asset($serviceItems->service_image_2) }}" alt="Image 2"
                                class="img-fluid side-image">
                        </div> --}}
                        <p>{!! $serviceItems->service_description !!}</p>
                    </div>
                </div>
            </div>
            <style>
                .images-row {
                    display: flex;
                    gap: 10px;
                    /* Adjust the gap as needed */
                    margin-top: 15px;
                    /* Add some space above the images */
                }

                .side-image {
                    width: 100%;
                    max-width: 48%;
                    /* Adjust max-width to fit within the container */
                    height: auto;
                    border-radius: 5px;
                    /* Optional: add some border-radius for aesthetics */
                }
            </style>
        </section>


    </main>
@endsection