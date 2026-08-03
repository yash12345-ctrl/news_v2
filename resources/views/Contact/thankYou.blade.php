@extends('templates.base', ['title' => 'Akhbar-e-mashriq | Thank you', 'ltr' => true])

@section('content')
<section class="section">
  <div class="container"> 
    <div class="page-box-wrapper">
      <div class="page-box">
        <div class="section-form">
          <div class="section-form-wrapper">
            <form class="contact-form">
              <div class="contact-form-wrapper width-900 mx-auto">
                <div class="thankyou-wrapper">
                  <div class="thankyou-poster">
                    <img class="thankyou-poster-banner" src="/assets/img/thankyou.webp">
                  </div>
                  <div class="thankyou-texts">
                    <h2 class="thankyou-texts-title">Your request has been received.</h2>
                    <h2 class="thankyou-texts-subtitle">Our team will review it and get back to you shortly.</h2>
                  </div>
                  <a href="/" class="button-hero button-hover is-fill">Back to Home</a>
                </div>
              </div>
            </form>
          </div>
        </div>
        </div>
    </div>
  </div>
</section>
@endsection