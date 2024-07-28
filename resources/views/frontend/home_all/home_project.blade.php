<section id="featured-services" class="featured-services section">
    @php
        $projects = App\Models\Project::inRandomOrder()->limit(3)->get();

    @endphp
    <div class="container">

        <div class="row gy-4">
            @foreach ($projects as $item)
                <div class="col-lg-4 col-md-6 service-item d-flex" data-aos="fade-up" data-aos-delay="100">
                    <div class="icon flex-shrink-0"><i class="{{ $item->project_icon }}"></i></div>
                    <div>
                        <h4 class="title">{{ $item->project_name }}</h4>
                        <p class="description">{!! $item->project_title !!}</p>
                        <a href="{{ route('home.project.details', $item->id) }}"
                            class="readmore stretched-link"><span>Learn More</span><i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
                <!-- End Service Item -->
            @endforeach



        </div>

    </div>

</section>
