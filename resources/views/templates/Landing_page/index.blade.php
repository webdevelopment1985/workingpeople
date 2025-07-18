@extends('layouts.front')
@section('title', 'Home')
@section('content')
   
      <div class="back-to-top-wrapper">
         <button id="back_to_top" type="button" class="back-to-top-btn">
            <svg width="12" height="7" viewBox="0 0 12 7" fill="none" xmlns="http://www.w3.org/2000/svg">
               <path d="M11 6L6 1L1 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>               
         </button>
      </div>
      <!-- back to top end -->


      <!-- offcanvas area start -->
      <div class="offcanvas__area">
         <div class="offcanvas__wrapper">
            <div class="offcanvas__close">
               <button class="offcanvas__close-btn offcanvas-close-btn">
                  <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path d="M11 1L1 11" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                     <path d="M1 1L11 11" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
               </button>
            </div>
            <div class="offcanvas__content">
               <div class="offcanvas__top mb-50 d-flex justify-content-between align-items-center">
                  <div class="offcanvas__logo logo">
                     <a href="{{ route('Landingpage') }}">
                        <img src="{{ asset('assets/images/logo/logo-black.png') }}" alt="logo">
                     </a>
                  </div>
               </div>
               <div class="tp-main-menu-mobile fix d-xl-none mb-30"></div>
			   <div class="tp-header-contact d-flex align-items-center">   
				<a class="loglink" href="{{ route('login') }}">Login</a>                              
				 <div class="tp-header-btn-3">
					<a class="tp-btn" href="{{ route('register') }}">Register Now</a>
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
                  <img src="{{ asset('assets/images/logo/logo-black.png') }}" alt="">
               </a>
            </div>

            <div class="tp-header-box-main-3">
               
   
               <div class="tp-header-wrapper-3">
                  <div class="container-fluid">
                     <div class="row align-items-center">
                        <div class="col-xxl-9 col-xl-9 col-6">
                           <div class="tp-main-menu home-3 align-items-center justify-content-center d-flex">
                              <div class="tp-main-menu-logo d-block d-xl-none">
                                 <a href="javascript:void(0)">
                                    <img src="{{ asset('assets/images/logo/logo-black.png') }}" alt="">
                                 </a>
                              </div>
                              <div class="d-none d-xl-flex">
                                 <nav class="tp-main-menu-content">
                                    <ul class="tp-onepage-menu">
                                       <li>
                                          <a href="#home">Home</a>                                          
                                       </li>
                                       <li><a href="#about">About Us</a></li>
                                       <!-- <li><a href="#awards">Awards</a></li> -->
                                       <li><a href="#services">Values</a></li>
                                       <li><a href="#whyus">Why Us</a></li>
                                       <li><a href="#contact">contact Us</a></li>
                                    </ul>
                                 </nav>
                              </div>
                           </div>
                        </div>
                        <div class="col-xxl-3 col-xl-3 col-6">
                           <div class="tp-header-main-right-3 d-flex align-items-center justify-content-xl-end">
                              <div class="tp-header-contact d-xl-flex d-none align-items-center">   
								<a class="loglink" href="{{ route('login') }}">Login</a>                              
                                 <div class="tp-header-btn-3">
                                    <a class="tp-btn" href="{{ route('register') }}">Register Now</a>
                                 </div>
                              </div>
                              <div class="tp-header-main-right-hamburger-btn d-xl-none offcanvas-open-btn text-end">
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
                     <a href="{{ route('Landingpage') }}">
                           <img src="{{ asset('assets/images/logo/logo-black.png') }}" alt="">
                        </a>
                     </div>
                  </div>
                  <div class="col-lg-6 d-none d-xl-block">
                     <div class="tp-main-menu home-2 d-none d-xl-block">
                        <nav class="tp-main-menu-content">
                           <ul class="tp-onepage-menu">
                              <li>
                                          <a href="#home">Home</a>                                          
                                       </li>
                                       <li><a href="#about">About Us</a></li>
                                       <!-- <li><a href="#awards">Awards</a></li> -->
                                       <li><a href="#services">Values</a></li>
                                       <li><a href="#whyus">Why Us</a></li>
                                       <li><a href="#contact">Contact Us</a></li>
                           </ul>
                        </nav>
                     </div>
                  </div>
                  <div class="col-xl-3 col-6">
                     <div class="tp-header-main-right-2 d-flex align-items-center justify-content-xl-end">
                        <div class="tp-header-contact-2 d-flex align-items-center">
                           <div class="tp-header-contact d-xl-flex d-none align-items-center">
								<a class="loglink" href="{{ route('login') }}">Login</a>
                                 <div class="tp-header-btn-3">
                                    <a class="tp-btn" href="{{ route('register') }}">Register Now</a>
                                 </div>
                              </div>
                        </div>
                        <div class="tp-header-main-right-hamburger-btn d-xl-none offcanvas-open-btn text-end">
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
         <section id="home" class="tp-hero-area-3 tp-hero-hight-3- p-relative" data-bg-color="#0b2139">
            <!-- <div class="tp-hero-thumb-shape-3">
               <img class="shape-1" src="assets/img/banner-shape-1.png" alt="">
            </div>
            <div class="tp-hero-thumb-shape-3-two">
               <img class="shape-2" src="assets/img/banner-shape-2.png" alt="">
            </div> -->
            <div class="container">
               <div class="row align-items-center">
                  <div class="col-lg-6">
                     <div class="tp-hero-content-3 p-relative">
                        <div class="tp-hero-title-wrapper-3 p-relative z-index-1">
                           <span class="tp-hero-subtitle-3 wow fadeInUp" data-wow-duration="1s" data-wow-delay=".3s">Trading Excellence</span>
                           <h2 class="tp-hero-title-3 wow fadeInUp" data-wow-duration="1s" data-wow-delay=".5s">Expert Guidance. Committed to Your Growth.</h2>
                           <p class=" wow fadeInUp" data-wow-duration="1s" data-wow-delay=".5s">Empowering your investments with strategic insights, transparent practices, and diverse opportunities for sustainable wealth.</p>
                        </div>
                        <div class="tp-hero-button-wrapper-3 d-flex wow fadeInUp" data-wow-duration="1s" data-wow-delay=".7s">
                           <div class="tp-hero-btn-3">
                              <a class="tp-btn" href="{{ route('register') }}">Join Now</a>
                           </div>
                        </div>
                     </div>
                  </div>
				  <div class="col-lg-5">
					 <!-- <div class="tp-contact-wrapper">
                        <h3 class="tp-contact-title">Contact Us</h3>
						<p>Get support anytime, anywhere from our dedicated team of experts</p>
                        <form id="contact-form" >
                              <div class="row">
                                 <div class="col-md-12">
                                    <div class="tp-contact-input">
										<label>Name</label>
                                       <input name="name" type="text" placeholder="Enter your name" required>
                                    </div>
                                 </div>
                                 <div class="col-md-6 pr-half">
                                    <div class="tp-contact-input">
										<label>Email</label>
                                       <input name="name" type="email" placeholder="Enter your email" required>
                                    </div>
                                 </div>
								 <div class="col-md-6 pl-half">
                                    <div class="tp-contact-input">
										<label>Phone <small>(Optional)</small></label>
                                       <input name="name" type="text" placeholder="Phone Number">
                                    </div>
                                 </div>
								 <div class="col-md-12">
                                    <div class="tp-contact-input">
										<label>Message</label>
                                       <textarea placeholder="Your Message"></textarea>
                                    </div>
                                 </div>
                                 <div class="col-md-12">
                                    <div class="tp-contact-breadcrumb-btn">
                                       <button type="submit" class="tp-btn">SUBMIT</button>
                                    </div>
                                 </div>
                              </div>
                           </form>
                     </div> -->
				  </div>
               </div>
            </div>
            <div class="tp-hero-thumb-main-3">
               <div class="tp-hero-thumb-3">
                  <img src="{{ asset('assets/images/homebanner.png') }}" alt="">
               </div>
            </div>
         </section>
         <!-- hero area end -->



         <!-- about area start -->
         <section id="about" class="tp-about-area-3 p-relative pt-130 pb-160">
            <div class="container">
               <div class="row">
                  <div class="col-lg-6">
                        <div class="tp-support-thumb d-flex justify-content-center justify-content-lg-end p-relative wow fadeInLeft" data-wow-duration="1s" data-wow-delay=".3s">
                           <img class="main" src="{{ asset('assets/images/abt-img.jpg') }}" alt="">
                           <img class="shape-1" src="{{ asset('assets/images/shape-1.png') }}" alt="">
                           <img class="shape-2" src="{{ asset('assets/images/shape-2.png') }}" alt="">
                           <div class="tp-support-count text-center">
                              <div class="counter-border">
                                 <div class="circular tl-progress">
                                    <input type="text" class="knob" value="0" data-rel="98%" data-linecap="round"
                                     data-width="140" data-height="140" data-bgcolor="#98deeb" data-fgcolor="#98deeb" data-thickness="0.2" data-readonly="true" disabled/>
                                 </div>
                                 <p>Client Satisfaction Rate</p>
                                 <span>50,000+ Registered Users </span>
                              </div>
                           </div>
                        </div>
                     </div>
                  <div class="col-lg-6">
                     <div class="tp-about-wrapper-3-- tp-support-wrapper-inner">
                        <div class="tp-about-title-wrapper">
                           <span class="tp-section-title-pre">Opportunity Awaits</span>
                           <h3 class="tp-section-title">Where Strategic Investments Drive Success</h3>
                        </div>
                        <p>At FinTrade Pool, we empower investors with comprehensive solutions and expert insights. Our mission is to help you navigate dynamic financial markets, offering high-growth opportunities and personalized strategies to achieve your financial goals with ease.</p>
						<ul>
                              <li><i class="fa-regular fa-check"></i> Diverse investment options, including forex and alternative assets, designed to unlock the potential for sustainable wealth creation.</li>
                              <li><i class="fa-regular fa-check"></i> Expert market analysis and transparent advice, ensuring that every investment decision is well-informed and aligned with your financial objectives.</li>
                           </ul>
                        
                     </div>
                  </div>
               </div>
            </div>
         </section>
         <!-- about area end -->

         <!-- Award -->
         <!-- <section id="awards" class="tp-awards-area p-relative pt-50 pb-160">
			<div class="container">
				<div class="row">
                  <div class="col-lg-8 m-auto">
                     <div class="mb-40 text-center">
                        <h3 class="tp-section-title">Awards & Recognition</h3>
						<p>At Finsai Trade, we take pride in being acknowledged for our commitment to excellence, innovation, and trusted financial services. These awards reflect the strength of our platform.</p>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-lg-3 col-md-6">
                     <div class="tp-service-item-wrapper-3 p-relative wow fadeInUp" data-wow-duration="1s" data-wow-delay=".3s">
                        <div class="tp-service-item-content-3">
                           <div class="tp-service-item-icon-3">
                              <img src="{{ asset('assets/images/award1.png') }}" alt="">
                           </div>
                           <h4 class="tp-service-item-title-3"><span class="tp-section-title-pre">World Forex Award</span>The Best IB Program 2025</h4>
                           <p>We are proud and happy to receive the Best IB Program 2025 award from World Forex Award. This is a big thank you to all our partners for their trust, support, and for being a part of our journey!</p>
                        </div>
                     </div>
                  </div>
				  <div class="col-lg-3 col-md-6">
                     <div class="tp-service-item-wrapper-3 p-relative wow fadeInUp" data-wow-duration="1s" data-wow-delay=".3s">
                        <div class="tp-service-item-content-3">
                           <div class="tp-service-item-icon-3">
                              <img src="{{ asset('assets/images/award2.png') }}" alt="">
                           </div>
                           <h4 class="tp-service-item-title-3"><span class="tp-section-title-pre">World Financial Award</span>The Fastest Growing Broker 2025</h4>
                           <p>We are honored to receive the Fastest Growing Broker 2025 award from the World Financial Award. This achievement wouldn’t have been possible without the trust and support of our clients and partners, thank you for being a part of our success!</p>
                        </div>
                     </div>
                  </div>
				  <div class="col-lg-3 col-md-6">
                     <div class="tp-service-item-wrapper-3 p-relative wow fadeInUp" data-wow-duration="1s" data-wow-delay=".3s">
                        <div class="tp-service-item-content-3">
                           <div class="tp-service-item-icon-3">
                            <img src="{{ asset('assets/images/award3.png') }}" alt="">
                           </div>
                           <h4 class="tp-service-item-title-3"><span class="tp-section-title-pre">World Financial Award</span>The Most Trusted Broker 2024</h4>
                           <p>Receiving the Most Trusted Broker 2024 award from World Financial Award is a proud moment for us. We are grateful for the trust and loyalty of our clients and partners, who inspire us to keep growing stronger every day.</p>
                        </div>
                     </div>
                  </div>
				  <div class="col-lg-3 col-md-6">
                     <div class="tp-service-item-wrapper-3 p-relative wow fadeInUp" data-wow-duration="1s" data-wow-delay=".3s">
                        <div class="tp-service-item-content-3">
                           <div class="tp-service-item-icon-3">
                            <img src="{{ asset('assets/images/award4.png') }}" alt="">
                           </div>
                           <h4 class="tp-service-item-title-3"><span class="tp-section-title-pre">Iconic Finance Expo</span>The winner of Innovative Startup in Finance Award</h4>
                           <p>We are excited to be the winner of the Innovative Startup in Finance Award at the Iconic Finance Expo. This achievement reflects our team’s hard work and commitment to bringing fresh ideas and easy solutions to the world of finance.</p>
                        </div>
                     </div>
                  </div>
               </div>
			</div>
		   </section> -->
         
         <!-- service area start -->
         <section id="services" class="tp-service-area-3 pt-120 pb-90" data-bg-color="#F6F6F9">
            <div class="container">
               <div class="row">
                  <div class="col-lg-12">
                     <div class="tp-service-title-wrapper-3 mb-40 text-center">
                        <span class="tp-section-title-pre">Empower Wealth</span>
                        <h3 class="tp-section-title">Start Your Journey Today Toward a Future<br> of Sustainable Wealth</h3>
						<p>Unlock financial potential with FinTrade Pool, where we help you grow through trust, investment, and value.</p>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-lg-4 col-md-6">
                     <div class="tp-service-item-wrapper-3 p-relative mb-30 wow fadeInUp" data-wow-duration="1s" data-wow-delay=".3s">
                        <div class="tp-service-item-content-3">
                           <div class="tp-service-item-icon-3">
                              <img src="{{ asset('assets/images/icon-1.webp') }}" alt="">
                           </div>
                           <h4 class="tp-service-item-title-3"><a href="javascript:void(0)">Trust</a></h4>
                           <p>Our foundation is built on trust. We partner with you to create transparent, secure, and long-term investment strategies. </p>
                        </div>
                        <div class="tp-service-item-number">
                           <span>01</span>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-4 col-md-6">
                     <div class="tp-service-item-wrapper-3 p-relative mb-30 wow fadeInUp" data-wow-duration="1s" data-wow-delay=".5s">
                        <div class="tp-service-item-content-3">
                           <div class="tp-service-item-icon-3">
                              <img src="{{ asset('assets/images/icon-2.webp') }}" alt="">
                           </div>
                           <h4 class="tp-service-item-title-3"><a href="javascript:void(0)">Invest</a></h4>
                           <p>With expert insights and diverse opportunities, we ensure that your investments are positioned for sustainable growth and success.</p>
                        </div>
                        <div class="tp-service-item-number">
                           <span>02</span>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-4 col-md-6">
                     <div class="tp-service-item-wrapper-3 p-relative mb-30 wow fadeInUp" data-wow-duration="1s" data-wow-delay=".7s">
                        <div class="tp-service-item-content-3">
                           <div class="tp-service-item-icon-3">
                              <img src="{{ asset('assets/images/icon-3.png') }}" alt="">
                           </div>
                           <h4 class="tp-service-item-title-3"><a href="javascript:void(0)">Value</a></h4>
                           <p>At FinTrade Pool, we empower your financial journey by adding value to every investment decision, maximizing your potential wealth. </p>
                        </div>
                        <!-- <div class="tp-service-item-btn-3">
                           <a href="service-details.html">Read more</a>
                        </div> -->
                        <div class="tp-service-item-number">
                           <span>03</span>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </section>
         <!-- service area end -->
		 
		 <section id="whyus" class="tp-process-arae-2 pb-90 pt-90">
            <div class="container">
               <div class="row">
                  <div class="col-lg-12">
                     <div class="tp-process-title-wrapper-2 text-center mb-70">
                        <span class="tp-section-title-pre">Why Us</span>
                        <h3 class="tp-section-title">Empowering Investments with Trust<br> and Expertise</h3>
                     </div>
                  </div>
               </div>
               <div class="tp-process-wrapper-2 p-relative">
                  <div class="tp-process-arrows">
                     <span class="shape-1">
                       <img src="{{ asset('assets/images/arrow-1.svg') }}" alt="">
                     </span>
                     <span class="shape-2">
                       <img src="{{ asset('assets/images/arrow-1.svg') }}" alt="">
                     </span>
                     <span class="shape-3">
                       <img src="{{ asset('assets/images/arrow-1.svg') }}" alt="">
                     </span>
                  </div>
                  <div class="row">
                  <div class="col-lg-4 col-md-6 col-sm-6">
                     <div class="tp-process-item-2 text-center p-relative mb-30 wow fadeInUp" data-wow-duration="1s" data-wow-delay=".3s" style="visibility: visible; animation-duration: 1s; animation-delay: 0.3s; animation-name: fadeInUp;">
                        <div class="tp-process-item-icon-2">
                           <span>
                              <img src="{{ asset('assets/images/icon-4.webp') }}" alt="">
                              <i>01</i>
                           </span>
                        </div>
                        <div class="tp-process-item-content-2">
                           <h4 class="tp-process-title">Investment Options</h4>
                           <p>We offer diverse investment opportunities, from forex to alternative assets, designed to help you achieve high-growth financial goals.</p>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-4 col-md-6 col-sm-6">
                     <div class="tp-process-item-2 text-center p-relative mb-30 wow fadeInUp" data-wow-duration="1s" data-wow-delay=".5s" style="visibility: visible; animation-duration: 1s; animation-delay: 0.5s; animation-name: fadeInUp;">
                        <div class="tp-process-item-icon-2">
                           <span>
                              <img src="{{ asset('assets/images/icon-5.webp') }}" alt="">
                              <i>02</i>
                           </span>
                        </div>
                        <div class="tp-process-item-content-2">
                           <h4 class="tp-process-title">Expert Guidance</h4>
                           <p>Our professionals provide in-depth market analysis and strategic advice, ensuring your investment decisions are informed and aligned with your goals.</p>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-4 col-md-6 col-sm-6">
                     <div class="tp-process-item-2 text-center p-relative mb-30 wow fadeInUp" data-wow-duration="1s" data-wow-delay=".7s" style="visibility: visible; animation-duration: 1s; animation-delay: 0.7s; animation-name: fadeInUp;">
                        <div class="tp-process-item-icon-2">
                           <span>
                              <img src="{{ asset('assets/images/icon-3.webp') }}" alt="">
                              <i>03</i>
                           </span>
                        </div>
                        <div class="tp-process-item-content-2">
                           <h4 class="tp-process-title">Transparent Partnership</h4>
                           <p>We prioritize trust and integrity, creating lasting client relationships through transparent investment processes and honest communication at every step.</p>
                        </div>
                     </div>
                  </div>
                  </div>
               </div>
            </div>
         </section>
         
		<section class="tp-faq-area p-relative pt-120 pb-120" data-background="{{ asset('assets/images/bg-shape.png') }}" style="background-image: url('{{ asset('assets/images/bg-shape.png') }}');">
            <div class="tp-faq-bg"></div>
            <div class="container">
               <div class="row">
                  <div class="col-lg-12">
                     <div class="tp-faq-wrapper">
                        <div class="tp-faq-title-wrapper text-center">
                           <span class="tp-section-title-pre">Our Commitment</span>
                           <h3 class="tp-section-title">Sophisticated Solutions for Confident<br> Financial Growth</h3>
                           <p>We provide reliable investment solutions designed to simplify complex financial markets for our clients.</p>
							<p>Our mission is to empower clients with tailored tools and expertise, helping them navigate financial markets and achieve<br> their unique investment goals.</p>
                        </div>
                     </div>
                  </div>
                  
               </div>
            </div>
         </section>
		 
		 
      </main>
      
         <!-- footer area start -->
         <footer class="tp-footer-area-3 pt-120 p-relative" data-bg-color="#0b2139" id="contact">
                        
            <div class="tp-footer-main-area-3">
               <div class="container">
                  <div class="tp-footer-border">
                     <div class="row justify-content-between">
                        <div class="col-md-4">
                           <div class="tp-footer-widget tp-footer-3-col-1 mb-50">
                              <div class="tp-footer-logo mb-30">
                              <a href="{{ route('Landingpage') }}"> <img src="{{ asset('assets/images/logo/logo-black.png') }}" alt=""></a>
                              </div>
                              <div class="tp-footer-widget-content">
                                 <p>FinTrade Pool is a comprehensive investment platform dedicated to empowering clients with transparent, expert-guided investment solutions. With a focus on sustainable wealth creation, it offers diverse opportunities, including forex and alternative assets.</p>
								 <!-- <div class="tp-footer-widget-social">
									 <a href="#"><i class="fab fa-facebook-f"></i></a>
									 <a href="#"><i class="fab fa-twitter"></i></a>
									 <a href="#"><i class="fa-brands fa-instagram"></i></a>
								  </div> -->
                              </div>
                           </div>
                        </div>
                        <div class="col-md-8">
							<div class="footer-contact-wrapper">
								<h3 class="tp-contact-title text-center">Get support anytime, anywhere</h3>
								<form id="contact-form11">
									  <div class="row">
										 <div class="col-md-6 pr-half">
											<div class="tp-contact-input">
												<label>Name</label>
											   <input name="name" type="text" placeholder="Enter your name" required>
											</div>
										 </div>
										 <div class="col-md-6 pl-half">
											<div class="tp-contact-input">
												<label>Email</label>
											   <input name="email" type="email" placeholder="Enter your email" required>
											</div>
										 </div>
										 <!-- <div class="col-md-6 pl-half">
											<div class="tp-contact-input">
												<label>Phone <small>(Optional)</small></label>
											   <input name="name" type="text" placeholder="Phone Number">
											</div>
										 </div> -->
										 <div class="col-md-12">
											<div class="tp-contact-input">
												<label>Message</label>
											   <textarea name="message"  placeholder="Your Message"></textarea>
											</div>
										 </div>
										 <div class="col-md-12">
											<div class="tp-contact-breadcrumb-btn">
											   <button type="submit" class="tp-btn">SUBMIT</button>
											</div>
										 </div>
									  </div>
								   </form>
							 </div>
						</div>
                        <!-- <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
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
                        </div> -->
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
                           <a href="{{ route('Privacy') }}">Privacy Policy</a>
                           <a href="{{ route('terms') }}">Terms & Conditions</a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </footer>
         <!-- footer area end -->
        


      <!-- JS here -->
      <script src="{{ url('/assets/js/vendor/jquery.js') }}"></script>
	  <!-- SweetAlert script -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

	
@endsection
 

