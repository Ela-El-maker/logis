<footer id="footer" class="footer dark-background">

    @php
    $serviceCategories = App\Models\ServiceCategory::orderBy('service_category','ASC')->get();
    $sections = App\Models\SectionSetting::find(1);

    $footerInfo = App\Models\FooterInfo::find(1);
    $usefulLinks = App\Models\UsefulLinks::all();
    $helpLinks = App\Models\HelpLinks::all();
    $socials = App\Models\SocialLinks::all();



    @endphp
    <div class="container footer-top">
        <div class="row gy-4">
            <div class="col-lg-5 col-md-12 footer-about">
                <a href="index.html" class="logo d-flex align-items-center">
                    <span class="sitename">{{$footerInfo->info_title}}</span>
                </a>
                <p>{!!$footerInfo->info_description!!}</p>
                <div class="social-links d-flex mt-4">
                    @foreach ($socials as $link)
                        <a href="{{$link->social_url}}"><i class="{{$link->social_icon}}"></i></a>
                    @endforeach
                    
                    
                </div>
            </div>

            <div class="col-lg-2 col-6 footer-links">
                <h4>Useful Links</h4>
                <ul>
                    @foreach ($usefulLinks as $link)
                        <li><a href="{{$link->useful_url}}">{{$link->useful_title}}</a></li>
                    
                    @endforeach

                    @foreach ($helpLinks as $link)
                        <li><a href="{{$link->help_url}}">{{$link->help_title}}</a></li>
                    
                    @endforeach
                    
                
                </ul>
            </div>

            <div class="col-lg-2 col-6 footer-links">
                <h4>Our Services</h4>
                <ul>
                    @foreach ($serviceCategories as $category)
                    <li><a href="{{ route('home.service.details', $category->id) }}">{{$category->service_category}}</a></li>
                        
                    @endforeach
                    
                </ul>
            </div>

            <div class="col-lg-3 col-md-12 footer-contact text-center text-md-start">
                <h4>Contact Us</h4>
                <p>{{$sections->contact_us_address}}</p>
                <p class="mt-4"><strong>Phone:</strong> <span>{{$sections->contact_us_call}}</span></p>
                <p><strong>Email:</strong> <span>{{$sections->contact_us_email}}</span></p>
            </div>

        </div>
    </div>

    <div class="container copyright text-center mt-4">
        <p>© <span>Copyright</span> <strong class="px-1 sitename">Ela</strong> <span>All Rights Reserved</span>
        </p>
        <div class="credits">
         
            Designed by <a href="https://example.com">Ela@Kali</a>
        </div>
    </div>

</footer>