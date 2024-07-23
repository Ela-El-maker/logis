@php
    $aboutPage = App\Models\About::find(1);
    $aboutItems = App\Models\AboutItems::inRandomOrder()->limit(4)->get();
@endphp

<section id="about" class="about section">

    <div class="container">

        <div class="row gy-4">

            <div class="col-lg-6 position-relative align-self-start order-lg-last order-first" data-aos="fade-up"
                data-aos-delay="200">
                <img src="{{ asset($aboutPage->foreground_image) }}" class="img-fluid" alt="">
                <a href="{{ $aboutPage->video_url }}" class="glightbox pulsating-play-btn"></a>
            </div>

            <div class="col-lg-6 content order-last  order-lg-first" data-aos="fade-up" data-aos-delay="100">
                <h3>{{ $aboutPage->title }}</h3>
                <p>
                    {{ $aboutPage->sub_title }}
                </p>

                <ul>

                    @foreach ($aboutItems as $item)
                        <li>
                            <i class="{{ $item->item_icon }}"></i>
                            <div>
                                <h5>{{ $item->item_title }}</h5>
                                <p>{{ $item->item_description }}</p>
                            </div>
                        </li>
                    @endforeach


                </ul>
            </div>

        </div>

    </div>

</section>
