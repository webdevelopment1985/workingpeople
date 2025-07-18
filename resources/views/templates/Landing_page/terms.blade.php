@extends('layouts.front')
@section('title', 'Terms&Condition')
@section('content')
<body>
    <!-- back to top start -->
    <div class="back-to-top-wrapper">
      <button id="back_to_top" type="button" class="back-to-top-btn">
        <svg
          width="12"
          height="7"
          viewBox="0 0 12 7"
          fill="none"
          xmlns="http://www.w3.org/2000/svg">
          <path
            d="M11 6L6 1L1 6"
            stroke="currentColor"
            stroke-width="1.5"
            stroke-linecap="round"
            stroke-linejoin="round" />
        </svg>
      </button>
    </div>
    <!-- back to top end -->

    <!-- offcanvas area start -->
    <div class="offcanvas__area">
      <div class="offcanvas__wrapper">
        <div class="offcanvas__close">
          <button class="offcanvas__close-btn offcanvas-close-btn">
            <svg
              width="12"
              height="12"
              viewBox="0 0 12 12"
              fill="none"
              xmlns="http://www.w3.org/2000/svg">
              <path
                d="M11 1L1 11"
                stroke="currentColor"
                stroke-width="1.5"
                stroke-linecap="round"
                stroke-linejoin="round" />
              <path
                d="M1 1L11 11"
                stroke="currentColor"
                stroke-width="1.5"
                stroke-linecap="round"
                stroke-linejoin="round" />
            </svg>
          </button>
        </div>
        <div class="offcanvas__content">
          <div
            class="offcanvas__top mb-50 d-flex justify-content-between align-items-center">
            <div class="offcanvas__logo logo">
              <a href="javascript:void(0)">
                <img src="{{ asset('assets/images/logo/logo-black.png') }}" alt="logo" />
              </a>
            </div>
          </div>
          <div class="tp-main-menu-mobile fix d-xl-none mb-30"></div>
		  <div class="tp-header-contact d-flex align-items-center">   
				<a class="loglink"  href="{{ route('login') }}">Login</a>                              
				 <div class="tp-header-btn-3">
					<a class="tp-btn"  href="{{ route('register') }}">Register Now</a>
				 </div>
			  </div>
        </div>
      </div>
    </div>
    <div class="body-overlay"></div>
    <!-- offcanvas area end -->

    <!-- header area start -->
    <header class="tp-header-area-3 p-relative">
      <div class="tp-header-box-3">
        <div class="tp-header-logo-3 d-none d-xl-block">
          <a href="javascript:void(0)">
            <img src="{{ asset('assets/images/logo/logo-black.png') }}" alt="" />
          </a>
        </div>

        <div class="tp-header-box-main-3">
          <div class="tp-header-wrapper-3">
            <div class="container-fluid">
              <div class="row align-items-center">
                <div class="col-xxl-9 col-xl-9 col-6">
                  <div
                    class="tp-main-menu home-3 align-items-center justify-content-center d-flex">
                    <div class="tp-main-menu-logo d-block d-xl-none">
                      <a href="javascript:void(0)">
                        <img src="{{ asset('assets/images/logo/logo-black.png') }}" alt="" />
                      </a>
                    </div>
                    <div class="d-none d-xl-flex">
                      <nav class="tp-main-menu-content">
                        <ul class="tp-onepage-menu">
                          <li>
                            <a href="{{route('Landingpage')}}">Home</a>
                          </li>
                          <li><a href="index.html#about">About Us</a></li>
                           <!-- <li><a href="index.html#awards">Awards</a></li> -->
                          <li><a href="index.html#services">Values</a></li>
                          <li><a href="index.html#whyus">Why Us</a></li>
                        </ul>
                      </nav>
                    </div>
                  </div>
                </div>
                <div class="col-xxl-3 col-xl-3 col-6">
                  <div
                    class="tp-header-main-right-3 d-flex align-items-center justify-content-xl-end">
                    <div
                      class="tp-header-contact d-xl-flex d-none align-items-center">
					  <a class="loglink" href="{{route('login')}}">Login</a>
                      <div class="tp-header-btn-3">
                        <a
                          class="tp-btn"
                          href="{{route('register')}}"
                          >Register Now</a
                        >
                      </div>
                    </div>
                    <div
                      class="tp-header-main-right-hamburger-btn d-xl-none offcanvas-open-btn text-end">
                      <button class="hamburger-btn">
                        <span></span>
                        <span></span>
                        <span></span>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </header>
    <!-- header area end -->

    <!-- sticky header start -->
    <header id="header-sticky" class="tp-header-main-sticky p-relative">
      <div class="tp-header-space-2">
        <div class="container-fluid">
          <div class="row align-items-center">
            <div class="col-xl-3 col-6">
              <div class="tp-header-logo-2 p-relative">
                <a href="javascript:void(0)">
                  <img src="{{ asset('assets/images/logo/logo-black.png') }}" alt="" />
                </a>
              </div>
            </div>
            <div class="col-lg-6 d-none d-xl-block">
              <div class="tp-main-menu home-2 d-none d-xl-block">
                <nav class="tp-main-menu-content">
                  <ul class="tp-onepage-menu">
                    <li>
                      <a href="{{route('Landingpage')}}">Home</a>
                    </li>
                    <li><a href="index.html#about">About Us</a></li>
                     <!-- <li><a href="index.html#awards">Awards</a></li> -->
                    <li><a href="index.html#services">Values</a></li>
                    <li><a href="index.html#whyus">Why Us</a></li>
                  </ul>
                </nav>
              </div>
            </div>
            <div class="col-xl-3 col-6">
              <div
                class="tp-header-main-right-2 d-flex align-items-center justify-content-xl-end">
                <div class="tp-header-contact-2 d-flex align-items-center">
                  <div
                    class="tp-header-contact d-xl-flex d-none align-items-center">
					<a class="loglink" href="{{route('login')}}">Login</a>
                    <div class="tp-header-btn-3">
                      <a
                        class="tp-btn"
                        href="{{route('register')}}"
                        >Register Now</a
                      >
                    </div>
                  </div>
                </div>
                <div
                  class="tp-header-main-right-hamburger-btn d-xl-none offcanvas-open-btn text-end">
                  <button class="hamburger-btn">
                    <span></span>
                    <span></span>
                    <span></span>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </header>
    <!-- sticky header end -->
    <main>
      <!-- hero area start -->
      <section id="" class="tp-hero-inner p-relative">
        <div class="container">
          <div class="row">
            <div class="col-lg-12">
              <div class="tp-hero-content-3 p-relative">
                <h2
                  class="tp-hero-title-3 wow fadeInUp"
                  data-wow-duration="1s"
                  data-wow-delay=".5s">
                  Terms and Conditions
                </h2>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- hero area end -->

      <section class="inner-content">
        <div class="container">
          <div class="row">
            <div class="col-lg-12">
              <h2 class="mt-0">Terms and Conditions</h2>
              <p>
                Welcome to <b>FinTrade Pool</b>(“<b>we</b>,” “<b>us</b>,” or
                “<b>our</b>”). By accessing or using our website, located at
                (“<b><a href="https://fintradepool.com/">https://fintradepool.com/</a></b>”), and any services provided through the
                Website (collectively referred to as the “ <b>Services</b>), you
                agree to be bound by these Terms and Conditions (“<b>Terms</b>).
                If you do not agree with any part of these Terms, you must not
                use our Services.
              </p>

              <h2>1. Acceptance of Terms</h2>
              <p>
                By using our Services, you confirm that you are at least 18
                years old or the legal age of majority in your jurisdiction. If
                you are using the Services on behalf of an organization, you
                represent and warrant that you have the authority to bind that
                organization to these Terms.
              </p>
              <h2>2. Changes to Terms</h2>
              <p>
                We reserve the right to modify these Terms at any time. Any
                changes will be effective immediately upon posting the revised
                Terms on the Website. Your continued use of the Services after
                the posting of changes constitutes your acceptance of the new
                Terms. We recommend that you periodically review these Terms for
                updates.
              </p>
              <h2>3. Registration and Account Management</h2>

              <p><strong>a. Account Creation: </strong></p>
              <p>
                To access certain features of our Services, you may be required
                to create an account. You agree to provide accurate, complete,
                and current information during the registration process and to
                update such information to keep it accurate, complete, and
                current.
              </p>

              <p><strong>b. Account Security: </strong></p>
              <p>
                You are responsible for maintaining the confidentiality of your
                account credentials and for all activities that occur under your
                account. You agree to notify us immediately of any unauthorized
                use of your account or any other breach of security.
              </p>
              <p><strong>c. Account Termination: </strong></p>
              <p>
                We reserve the right to suspend or terminate your account and
                access to our Services at our sole discretion, without notice,
                for any conduct that we believe violates these Terms or is
                harmful to other users, our business, or our Services.
              </p>

              <h2>4. Use of Services</h2>
              <p>
                You agree to use our Services in compliance with all applicable
                laws and regulations. You are prohibited from using the Services
                for any unlawful or fraudulent purposes, including but not
                limited to:
              </p>

              <ul>
                <li>
                  Engaging in any activity that interferes with or disrupts the
                  Services or the servers and networks connected to the
                  Services.
                </li>
                <li>
                  Attempting to gain unauthorized access to any portion of the
                  Services or any other systems or networks connected to the
                  Services.
                </li>
                <li>
                  Impersonating any person or entity or falsely stating or
                  misrepresenting your affiliation with a person or entity.
                </li>
              </ul>
              <h2>5. User Content</h2>
              <p><strong>a. Responsibility for Content: </strong></p>
              <p>
                You are solely responsible for any content you submit, post, or
                otherwise make available through our Services (“
                <b>User Content</b>”). You retain all rights in your User
                Content but grant us a worldwide, non-exclusive, royalty-free,
                perpetual, and irrevocable license to use, reproduce, modify,
                publish, and distribute such content in connection with our
                Services.
              </p>
              <p><strong>b. Content Guidelines: </strong></p>
              <p>
                You agree not to post User Content that is unlawful, defamatory,
                obscene, infringing, or otherwise objectionable. We reserve the
                right to remove any User Content that violates these Terms or
                that we find otherwise objectionable.
              </p>
              <h2>6. Intellectual Property</h2>
              <p>
                The content, features, and functionality of our Services,
                including but not limited to text, graphics, logos, and
                software, are owned by <b>FinTrade Pool</b> or its licensors and
                are protected by copyright, trademark, and other intellectual
                property laws. You may not use, reproduce, distribute, or create
                derivative works of any part of our Services without our express
                written consent.
              </p>

              <h2>7. Disclaimers</h2>
              <p><strong>a. No Investment Advice:</strong></p>
              <p>
                The information provided on our Website and through our Services
                is for informational purposes only and should not be construed
                as investment advice. We do not guarantee any specific results
                from your use of our Services.
              </p>
              <p><strong>b. Risk Disclosure: </strong></p>
              <p>
                Trading in financial instruments involves a significant risk of
                loss. You should only trade with money that you can afford to
                lose. Past performance is not indicative of future results.
              </p>
              <h2>8. Limitation of Liability</h2>
              <p>
                To the fullest extent permitted by law, <b>FinTrade Pool</b>,
                its affiliates, and their respective officers, directors,
                employees, agents, and licensors shall not be liable for any
                direct, indirect, incidental, special, consequential, or
                punitive damages arising from your use of, or inability to use,
                the Services, including but not limited to loss of profits,
                data, or goodwill, even if we have been advised of the
                possibility of such damages.
              </p>
              <h2>9. Indemnification</h2>
              <p>
                You agree to indemnify, defend, and hold harmless
                <b>FinTrade Pool</b>, its affiliates, and their respective
                officers, directors, employees, agents, and licensors from and
                against any and all claims, liabilities, damages, losses, costs,
                or expenses (including reasonable attorneys' fees) arising from
                your use of the Services, your violation of these Terms, or your
                violation of any rights of another party.
              </p>
              <h2>10. Miscellaneous</h2>
              <p><strong>a. Entire Agreement:</strong></p>
              <p>
                These Terms constitute the entire agreement between you and
                <b>FinTrade Pool</b> regarding your use of the Services and
                supersede any prior agreements or understandings.
              </p>
              <p><strong>b. Severability:</strong></p>
              <p>
                If any provision of these Terms is found to be invalid or
                unenforceable, the remaining provisions shall remain in full
                force and effect.
              </p>
              <p><strong>c. Waiver: </strong></p>
              <p>
                No waiver of any term or condition of these Terms shall be
                deemed a further or continuing waiver of such term or condition
                or any other term or condition.
              </p>
              <h2>11. Contact Information</h2>
              <p>
                If you have any questions about these Terms, please contact us
                at:
              </p>
              <p>
                <strong>Email:</strong>
                <a href="mailto:info@fintradepool.com"
                  >info@fintradepool.com</a
                >
              </p>
            </div>
          </div>
          <!--row-->
        </div>
        <!--container-->
      </section>

    </main>

         <!-- footer area start -->
         <footer class="tp-footer-area-3 pt-120 p-relative" data-bg-color="#0b2139">
            <div class="tp-footer-bg-shape-3">
               <img class="shape-1" src="{{ asset('assets/images/shape-1.png') }}" alt="">
               <img class="shape-2" src="{{ asset('assets/images/shape-2.png') }}" alt="">
            </div>
           
            <div class="tp-footer-main-area-3">
               <div class="container">
                  <div class="tp-footer-border">
                     <div class="row">
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                           <div class="tp-footer-widget tp-footer-3-col-1 mb-50">
                              <div class="tp-footer-logo mb-30">
                              <a href="javascript:void(0)"> <img src="{{ asset('assets/images/logo/logo-black.png') }}" alt=""></a>
                              </div>
                              <div class="tp-footer-widget-content">
                                 <p>Let's GROW TOGETHER, work together.</p>
								 <!-- <div class="tp-footer-widget-social">
									 <a href="#"><i class="fab fa-facebook-f"></i></a>
									 <a href="#"><i class="fab fa-twitter"></i></a>
									 <a href="#"><i class="fa-brands fa-instagram"></i></a>
								  </div> -->
                              </div>
                           </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                           <div class="tp-footer-widget tp-footer-3-col-2 mb-50">
                              <h3 class="tp-footer-widget-title">Contact Us</h3>
                                 <div class="tp-footer-info">
									<div class="tp-footer-info-call">
                                       <a href="#"><i class="fa-solid fa-location-dot"></i> Business Bay, Dubai, UAE</a>
                                    </div>
                                    <div class="tp-footer-info-call">
                                       <a href="telto:5550129"><i class="fa-solid fa-phone"></i>(629) 555-0129</a>
                                    </div>
                                <div class="tp-footer-info-mail">
                                       <a href="mailto:info@fintradepool.com"><i class="fa-solid fa-envelope"></i><span class="__cf_email__">info@fintradepool.com</span></a>
                                    </div>
                                 </div>
                              
                           </div> 
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                           <div class="tp-footer-widget tp-footer-2-col-4 mb-50">
							   <h3 class="tp-footer-widget-title">Newsletter</h3>
							   <div class="tp-footer-widget-content">
								  <p>Join FinTrade Pool Today Unlock your potential.</p>
								  <div class="tp-footer-content-email">
									 <input type="email" placeholder="Email Address">
									 <button> <span><i class="fa-solid fa-paper-plane"></i></span></button>
								  </div>
							   </div>
							</div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="tp-footer-copyright-area p-relative">
               <div class="container">
                  <div class="row">
                     <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="tp-footer-copyright-inner">
                           <p>© FinTrade Pool 2024 | All Rights Reserved</p>
                        </div>
                     </div>
                     <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="tp-footer-copyright-inner text-lg-end">
                           <a href="{{route('Privacy')}}">Privacy Policy</a>
                           <a href="{{route('terms')}}">Terms & Conditions</a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </footer>
         <!-- footer area end -->



      <!-- JS here -->
		
   </body>

   @endsection