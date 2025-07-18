@extends('layouts.front')
@section('title', 'Privacy')
@section('content')
   
   <body>


      <!-- back to top start -->
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
                     <a href="javascript:void(0)">
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
                                       <a href="{{route('Landingpage')}}">Home</a>                                         
                                       </li>
                                       <li><a href="index.html#about">About Us</a></li>
                                       <!-- <li><a href="index.html##awards">Awards</a></li> -->
                                       <li><a href="index.html#services">Values</a></li>
                                       <li><a href="index.html#whyus">Why Us</a></li>
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
                     <a href="javascript:void(0)">
                           <img src="{{ asset('assets/images/logo/logo-black.png') }}" alt="">
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
         <section id="" class="tp-hero-inner p-relative">
            
            <div class="container">
               <div class="row">
                  <div class="col-lg-12">
                     <div class="tp-hero-content-3 p-relative">
                        <h2 class="tp-hero-title-3 wow fadeInUp" data-wow-duration="1s" data-wow-delay=".5s">Privacy Policy</h2>
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
						<p>At FinTrade Pool ("we," "our," or "us"), we recognize the importance of protecting your privacy and are committed to safeguarding your personal information. This Privacy Policy explains how we collect, use, disclose, and manage your information when you access and use our website, (“<a href="https://fintradepool.com/">https://fintradepool.com/</a>”), engage with our services, or interact with us in any other way.</p>
						<p>By using our Website and services, you acknowledge and agree to the practices described in this Privacy Policy. Please read it carefully to understand how we handle your information.</p>
						
						<h2>1. Information We Collect</h2>
						<p>We collect both personal and non-personal information from you when you visit our Website, use our services, create an account, or interact with us. The types of information we collect are as follows:</p>
						
						<p><strong>a. Personal Information:</strong></p>
						<p>Personal information is any information that can identify you as an individual or that relates to an identifiable individual. This includes:</p>
						<ul>
							<li><strong>Name:</strong> First and last name.</li>
							<li><strong>Email Address:</strong> For communication, account registration, and notifications.</li>
							<li><strong>Phone Number:</strong> For account security and customer service purposes.</li>
							<li><strong>Mailing Address:</strong> For billing, verification, and mailing documents.</li>
							<li><strong>Financial Information:</strong> Bank account details, payment card information, and other billing information necessary to process financial transactions.</li>
							<li><strong>Identification Information:</strong> Government-issued IDs (e.g., passports, driver’s licenses) for identity verification and compliance with regulatory requirements.</li>
							<li><strong>Login Credentials:</strong> Usernames, passwords, and security questions to help secure your account.</li>
						</ul>
						
						<p><strong>b. Non-Personal Information:</strong></p>
						<p>Non-personal information refers to any data that does not reveal your identity directly, such as:</p>
						<ul>
							<li><strong>Browser Information:</strong> Type and version of browser, browser settings, and plugins.</li>
							<li><strong>Device Information:</strong> Information about the device you use to access our Website, such as the operating system, hardware model, and unique device identifiers.</li>
							<li><strong>IP Address:</strong> We collect your IP address to identify your location, monitor for security risks, and improve services.</li>
							<li><strong>Website Usage Data:</strong> Pages you visited, time spent on each page, interaction with content, and click-through data.</li>
							<li><strong>Cookies:</strong> Data about your preferences and activity on our site (see section on Cookies below).</li>
						</ul>
						
						<p><strong>C. Sensitive Information:</strong></p>
						<p>We may collect sensitive information such as payment details, government identification numbers, or biometric data (e.g., fingerprint or face recognition data) only when necessary, and we will ensure this information is securely stored.</p>
						
						<h2>2. How We Collect Information</h2>
						<p>We collect information from you in several ways, including:</p>
						
						<p><strong>a. Direct Interactions:</strong></p>
						<p>When you provide information directly by filling out forms on our Website, registering for an account, subscribing to newsletters, making transactions, or contacting our support team.</p>
						
						<p><strong>b. Automated Technologies:</strong></p>
						<p>As you interact with our Website, we automatically collect technical data and usage information through cookies, web beacons, tracking pixels, and server logs.</p>
						
						<p><strong>c. Third-Party Sources:</strong></p>
						<p>We may also collect information from third-party partners, such as social media platforms, advertising networks, or analytics providers, and combine this data with what we have collected directly from you.</p>
						
						<h2>3. How We Use Your Information</h2>
						<p>We use the personal and non-personal information collected from you for a variety of legitimate business purposes. These purposes include but are not limited to:</p>
						
						<p><strong>a. Providing Services:</strong></p>
						<p>We use your information to:</p>
						<ul>
							<li>Process your registration, authenticate your identity, and manage your account.</li>
							<li>Facilitate transactions, including deposits, withdrawals, and purchases on our platform.</li>
							<li>Provide you with personalized investment options, tools, and recommendations based on your profile and preferences.</li>
						</ul>
						
						<p><strong>b. Improving User Experience:</strong></p>
						<p>We use the information to:</p>
						<ul>
							<li>Monitor and analyze Website usage, ensuring its functionality and improving user experience.</li>
							<li>Customize and enhance your experience by delivering relevant content, offers, and product recommendations.</li>
							<li>Manage performance, test features, and debug to improve service delivery.</li>
						</ul>
						
						<p><strong>c. Communications:</strong></p>
						<p>We use your email and contact information to:</p>
						<ul>
							<li>Send you transactional emails (e.g., confirmations, receipts, and billing statements).</li>
							<li>Notify you of updates, new features, promotions, and marketing messages (you can opt-out at any time).</li>
							<li>Respond to your inquiries, resolve issues, and provide customer support.</li>
						</ul>
						
						<p><strong>d. Compliance and Security:</strong></p>
						<p>We use your information to:</p>
						<ul>
							<li>Fulfill legal and regulatory obligations, including Know Your Customer (KYC) and Anti-Money Laundering (AML) requirements.</li>
							<li>Detect, prevent, and respond to fraud, unauthorized access, or security breaches.</li>
							<li>Enforce our Terms and Conditions, legal agreements, and policies.</li>
						</ul>
						
						<h2>4. How We Share Your Information</h2>
						<p>We do not sell your personal information. However, we may share your information in the following circumstances:</p>
						
						<p><strong>a. With Service Providers:</strong></p>
						<p>We may share your data with trusted third-party vendors who assist us in operating our Website, conducting our business, or providing services to you. These include:</p>
						<ul>
							<li><strong>Payment processors:</strong> To handle transactions securely.</li>
							<li><strong>Data hosting services:</strong> To store and manage your information.</li>
							<li><strong>Marketing partners:</strong> For customer outreach, promotions, and communication services.</li>
						</ul>
						<p>These service providers are contractually bound to only use your data for the agreed-upon purpose and must maintain confidentiality and security standards.</p>
						
						<p><strong>b. With Legal Authorities:</strong></p>
						<p>We may disclose your information if required by law or in response to valid legal requests from law enforcement, regulatory agencies, or courts.</p>
						
						<p><strong>c. In Business Transfers:</strong></p>
						<p>In the event of a merger, acquisition, restructuring, or sale of our business or assets, your information may be transferred as part of that transaction. We will notify you before your personal information is transferred and becomes subject to a different privacy policy.</p>
						
						<p><strong>d. With Your Consent:</strong></p>
						<p>We will share your personal data with other parties if you have given explicit consent for us to do so.</p>
						
						<h2>5. How We Protect Your Information</h2>
						<p>We take the security of your personal information seriously and implement a range of physical, technical, and administrative security measures to protect your data, including:</p>
						<ul>
							<li><strong>Encryption:</strong> We use industry-standard encryption technologies to protect sensitive data during transmission (e.g., SSL/TLS).</li>
							<li><strong>Access Control:</strong> We restrict access to personal data to authorized personnel who need it to perform their job functions.</li>
							<li><strong>Monitoring:</strong> We employ security monitoring systems to detect and respond to potential threats or suspicious activity.</li>
							<li><strong>Regular Audits:</strong> We employ security monitoring systems to detect and respond to potential threats or suspicious activity.</li>
						</ul>
						<p>Despite our best efforts, no method of data transmission or storage can guarantee absolute security. You acknowledge that you use our services at your own risk.</p>
						
						<h2>6. Your Rights Regarding Your Information</h2>
						<p>You have the following rights concerning your personal information:</p>
						<p><strong>a. Right to Access:</strong> You can request a copy of the personal information we hold about you.</p>
						<p><strong>b. Right to Correction:</strong> If any of your information is inaccurate or incomplete, you can request corrections.</p>
						<p><strong>c. Right to Deletion:</strong> You may request the deletion of your personal information, subject to legal and contractual obligations we may have.</p>
						<p><strong>d. Right to Restrict Processing:</strong> In certain circumstances, you can request that we restrict the processing of your personal data.</p>
						<p><strong>e. Right to Data Portability:</strong> You can request to receive your personal data in a structured, commonly used, and machine-readable format.</p>
						<p><strong>f. Right to Opt-Out:</strong> You have the right to opt-out of marketing communications at any time by following the unsubscribe instructions in our emails or contacting us directly.</p>
						<p>To exercise any of these rights, please contact us at <a href="mailto:info@fintradepool.com">info@fintradepool.com</a>. We will respond to your request within a reasonable timeframe.</p>
						
						<h2>7. Cookies and Tracking Technologies</h2>
						<p>We use cookies and similar technologies to collect and store information when you use our Website. Cookies are small text files placed on your device that help us remember your preferences and enhance your experience.</p>
						<p><strong>Types of Cookies We Use:</strong></p>
						<ul>
							<li><strong>Essential Cookies:</strong> Necessary for the basic functionality of our Website.</li>
							<li><strong>Performance Cookies:</strong> Help us understand how users interact with the Website by collecting usage data.</li>
							<li><strong>Functionality Cookies:</strong> Remember your preferences, such as language or region settings.</li>
							<li><strong>Targeting Cookies:</strong> Used to deliver relevant advertisements and track your behavior across the web.</li>
						</ul>
						<p>You can manage cookie settings through your browser. However, disabling cookies may limit the functionality of certain features on our Website.</p>
						
						<h2>8. Data Retention</h2>
						<p>We retain your personal information for as long as is necessary to fulfill the purposes for which it was collected or to comply with legal, regulatory, or internal policy requirements. The specific retention periods may vary depending on the type of data and the legal context. Once your information is no longer needed, we will securely delete or anonymize it.</p>
						
						<h2>9. International Data Transfers</h2>
						<p>Your personal information may be transferred to, and maintained on, computers located outside of your jurisdiction where data protection laws may differ. If you are located outside of the United Arab Emirates and choose to provide information to us, please note that your data will be transferred to the UAE and processed there.</p>
						<p>By using our Website and services, you consent to the transfer of your information in accordance with this Privacy Policy.</p>
						
						<h2>10. Children’s Privacy</h2>
						<p>Our services are not intended for individuals under the age of 18. We do not knowingly collect personal information from children. If you are a parent or guardian and believe that your child has provided us with personal information, please contact us immediately at <a href="mailto:info@fintradepool.com">info@fintradepool.com</a>. We will take steps to remove that information from our systems.</p>
						
						<h2>11. Changes to This Privacy Policy</h2>
						<p>We reserve the right to update this Privacy Policy from time to time. Any changes will be effective upon posting to our Website, and we will notify you of significant changes either by email or through prominent notice on our Website. Please review this policy periodically to stay informed of how we protect your information.</p>
						
						<h2>12. Changes to This Privacy Policy</h2>
						<p>If you have any questions, concerns, or requests regarding this Privacy Policy, please contact us:</p>
						<p><strong>Email:</strong> <a href="mailto:info@fintradepool.com">info@fintradepool.com</a></p>
						
						
					</div>
				</div><!--row-->
			</div><!--container-->
		 </section>
		
		

      </main>
      
         <!-- footer area start -->
         <footer class="tp-footer-area-3 pt-120 p-relative" data-bg-color="#0b2139">
            <div class="tp-footer-bg-shape-3">
               <img class="shape-1" src="{{ asset('assets/images/shape-1.png') }}" alt="">
               <img class="shape-2" src="assets/images/shape-2.png" alt="">
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
                        <a href="{{ route('Privacy')  }}">Privacy Policy</a>
                        <a href="{{ route('terms')  }}">Terms & Conditions</a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </footer>
         <!-- footer area end -->



      <!-- JS here -->
	
   </body>


</html>

@endsection

