<section id="features" class="features section">
    @php
        $features = App\Models\Features::inRandomorder()->limit(3)->get();
    @endphp
        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <span>Features</span>
            <h2>Features</h2>
        </div><!-- End Section Title -->
    
        <div class="container">
    
            @foreach ($features as $item)
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