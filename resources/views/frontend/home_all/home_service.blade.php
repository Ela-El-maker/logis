<section id="services" class="services section">
    @php
        $serviceCategory = App\Models\ServiceCategory::inRandomOrder()->limit(6)->get();

    @endphp
    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <span>Our Services<br></span>
        <h2>Our ServiceS</h2>
        <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
    </div><!-- End Section Title -->

    <div class="container">

        <div class="row gy-4">
            @foreach ($serviceCategory as $service)
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="card">
                        <div class="card-img">
                            <img src="{{ asset($service->service_category_image) }}" alt="" class="img-fluid">
                        </div>
                        <h3><a href="" class="stretched-link">{{ $service->service_category }}</a></h3>
                        <p>{!! Str::limit($service->service_category_description, 150) !!}</p>
                    </div>
                </div><!-- End Card Item -->
            @endforeach



        </div>

    </div>

</section>
