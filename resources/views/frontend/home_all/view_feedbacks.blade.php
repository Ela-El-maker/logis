<section id="testimonials" class="testimonials section dark-background">
    @php
        $allfeedbacks = App\Models\CustomerFeedback::inrandomorder()->get();
        $backgroundImage = App\Models\Homeslide::find(1);
    @endphp
    <img src="{{asset($backgroundImage->foregroundImage)}}" class="testimonials-bg" alt="">

    <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="swiper init-swiper">
            <script type="application/json" class="swiper-config">
    {
      "loop": true,
      "speed": 600,
      "autoplay": {
        "delay": 5000
      },
      "slidesPerView": "auto",
      "pagination": {
        "el": ".swiper-pagination",
        "type": "bullets",
        "clickable": true
      }
    }
  </script>
            <div class="swiper-wrapper">
                @foreach ($allfeedbacks as $feed)
                     <div class="swiper-slide">
                    <div class="testimonial-item">
                        {{-- <img src="assets/img/testimonials/testimonials-1.jpg" class="testimonial-img" alt=""> --}}
                        <h3>{{$feed->feedback_name}}</h3>
                        <h4>{{$feed->feedback_position}}</h4>
                        {{-- <div class="stars">
                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                class="bi bi-star-fill"></i>
                        </div> --}}
                        <p>
                            <i class="bi bi-quote quote-icon-left"></i>
                            <span>{{$feed->feedback_message}}</span>
                            <i class="bi bi-quote quote-icon-right"></i>
                        </p>
                    </div>
                </div><!-- End testimonial item -->

                @endforeach
               
                
            </div>
            <div class="swiper-pagination"></div>
        </div>

    </div>

</section>
