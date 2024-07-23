@php
    $homeSlide = App\Models\HomeSlide::find(1);
@endphp
<section id="hero" class="hero section dark-background">

    <img src="{{asset($homeSlide->backgroundImage)}}" alt="" class="hero-bg" data-aos="fade-in">

    <div class="container">
        <div class="row gy-4 d-flex justify-content-between">
            <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center">
                <h2 data-aos="fade-up">{{$homeSlide->title}}</h2>
                <p data-aos="fade-up" data-aos-delay="100">{!!$homeSlide->sub_title!!}</p>

                {{-- <form action="#" class="form-search d-flex align-items-stretch mb-3" data-aos="fade-up"
                    data-aos-delay="200">
                    <input type="text" class="form-control"
                        placeholder="Your ZIP code or City. e.g. New York">
                    <button type="submit" class="btn btn-primary">Search</button>
                </form> --}}

                <div class="row gy-4" data-aos="fade-up" data-aos-delay="300">

                    <div class="col-lg-3 col-6">
                        <div class="stats-item text-center w-100 h-100">
                            <span data-purecounter-start="0" data-purecounter-end="232"
                                data-purecounter-duration="0" class="purecounter">232</span>
                            <p>Clients</p>
                        </div>
                    </div><!-- End Stats Item -->

                    <div class="col-lg-3 col-6">
                        <div class="stats-item text-center w-100 h-100">
                            <span data-purecounter-start="0" data-purecounter-end="521"
                                data-purecounter-duration="0" class="purecounter">521</span>
                            <p>Projects</p>
                        </div>
                    </div><!-- End Stats Item -->

                    <div class="col-lg-3 col-6">
                        <div class="stats-item text-center w-100 h-100">
                            <span data-purecounter-start="0" data-purecounter-end="1453"
                                data-purecounter-duration="0" class="purecounter">1453</span>
                            <p>Support</p>
                        </div>
                    </div><!-- End Stats Item -->

                    <div class="col-lg-3 col-6">
                        <div class="stats-item text-center w-100 h-100">
                            <span data-purecounter-start="0" data-purecounter-end="32"
                                data-purecounter-duration="0" class="purecounter">32</span>
                            <p>Workers</p>
                        </div>
                    </div><!-- End Stats Item -->

                </div>

            </div>

            <div class="col-lg-5 order-1 order-lg-2 hero-img" data-aos="zoom-out">
                <img src="{{asset($homeSlide->foregroundImage)}}" class="img-fluid mb-3 mb-lg-0" alt="">
            </div>

        </div>
    </div>

</section>