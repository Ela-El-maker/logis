@extends('frontend.main_master')
@section('main')

<main class="main">

    <!-- Page Title -->
    <div class="page-title dark-background" data-aos="fade" style="background-image: url({{asset($home_slide->backgroundImage)}});">
      <div class="container position-relative">
        <h1>Give us Feedback</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.html">Home</a></li>
            <li class="current">Give us Feedback</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

    <!-- Give us Feedback Section -->
    <section id="get-a-quote" class="get-a-quote section">

      <div class="container">

        <div class="row g-0" data-aos="fade-up" data-aos-delay="100">

          <div class="col-lg-5 quote-bg" style="background-image: url(assets/img/quote-bg.jpg);"></div>

          <div class="col-lg-7" data-aos="fade-up" data-aos-delay="200">
            <form action="{{route('store.feedback')}}" method="post" class="php-email-form">
                @csrf
              <h3>Feedback</h3>

              <div class="row gy-4">

                <div class="col-lg-12">
                  <h4>Your Personal Details</h4>
                </div>

                <div class="col-12">
                  <input type="text" name="feedback_name" class="form-control" placeholder="Full Name" required="">
                </div>

                <div class="col-12 ">
                  <input type="email" class="form-control" name="feedback_email" placeholder="Email" required="">
                </div>

                <div class="col-12">
                    <input type="text" name="feedback_company" class="form-control" placeholder="Company Name" required="">
                  </div>
                  <div class="col-12">
                    <input type="text" name="feedback_position" class="form-control" placeholder="Position" required="">
                  </div>
                <div class="col-12">
                  <input type="text" class="form-control" name="feedback_phone" placeholder="Phone" required="">
                </div>

                <div class="col-12">
                  <textarea class="form-control" name="feedback_message" rows="6" placeholder="Leave Feedback Message" required=""></textarea>
                </div>

                <div class="col-12 text-center">
                  <div class="sent-message">Your feedback request has been sent successfully. Thank you!</div>

                  <div class="loading">Loading</div>
                  <div class="error-message">Please Try Again. Something went wrong</div>

                  <button type="submit">Send</button>
                </div>

              </div>
            </form>
          </div><!-- End Quote Form -->

        </div>

      </div>

    </section><!-- /Get A Quote Section -->

  </main>
@endsection