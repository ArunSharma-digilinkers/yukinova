@extends('layouts.main')
@section('content')

<div class="main-wrapper">
    
    <div id="carouselExampleIndicators" class="carousel slide">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ asset('img/banner2.webp') }}" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('img/banner1.webp') }}" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('img/banner3.webp') }}" class="d-block w-100" alt="...">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <div class="product-category-wrapper section-entry">
        <div class="container">
            <div class="row">
                <div class="section-title text-center mb-5">
                    <h3>Our Product Range</h3>
                    <p>Explore our wide range of reliable and high-performance energy solutions.</p>
                </div>

                <!-- RIGHT PRODUCTS -->
                <div class="product-grid" data-aos="fade-up">

                    <a href="{{ url('two-wheeler-battery') }}" class="product-card">
                        <div class="card-image">
                            <img src="{{ asset('img/two-wheeler-battery.png') }}" alt="Two Wheeler Battery">
                        </div>
                        <div class="card-content">
                            <h4>Two Wheeler</h4>
                            <span class="explore-btn">Explore →</span>
                        </div>
                    </a>

                    <a href="{{ url('three-wheeler-battery') }}" class="product-card">
                        <div class="card-image">
                            <img src="{{ asset('img/e-rickshaw.png') }}" alt="Two Wheeler Battery">
                        </div>
                        <div class="card-content">
                            <h4>Three Wheeler</h4>
                            <span class="explore-btn">Explore →</span>
                        </div>
                    </a>
                    <a href="{{ url('portable-power-solution') }}" class="product-card">
                        <div class="card-image">
                            <img src="{{ asset('img/portable-battery.png') }}" alt="Two Wheeler Battery">
                        </div>
                        <div class="card-content">
                            <h4>Portable Power</h4>
                            <span class="explore-btn">Explore →</span>
                        </div>
                    </a>

                    <a href="portable-power-solution" class="product-card">
                        <div class="card-image">
                            <img src="{{ asset('img/hybrid-inverter.png') }}" alt="Two Wheeler Battery">
                        </div>
                        <div class="card-content">
                            <h4>Hybrid Inverter</h4>
                            <span class="explore-btn">Explore →</span>
                        </div>
                    </a>

                    <a href="cycle-battery" class="product-card">
                        <div class="card-image">
                            <img src="{{ asset('img/cycle-battery.png') }}" alt="Two Wheeler Battery">
                        </div>
                        <div class="card-content">
                            <h4>Cycle Battery</h4>
                            <span class="explore-btn">Explore →</span>
                        </div>
                    </a>
                        <a href="#" class="product-card">
                        <div class="card-image">
                            <img src="{{ asset('img/inverter.png') }}" alt="Two Wheeler Battery">
                        </div>
                        <div class="card-content">
                            <h4>Inverter Battery</h4>
                            <span class="explore-btn">Explore →</span>
                        </div>
                    </a>

                </div>


            </div>
        </div>
    </div>

    <div class="new-product-wrapper section-entry">
        <div class="container">

            <div class="section-title text-center mb-5">
                <h3>New Arrivals</h3>
                <p>Explore our latest products</p>
            </div>

            <div class="new-product-grid">
       @foreach($products as $product)
                <div class="new-product-card">

                    <div class="product-image">
                        <span class="badge">NEW</span>
                        <img src="{{ asset('img/1.png') }}" alt="">
                    </div>

                    <div class="product-content">
                        <h4>{{ $product->name }}</h4>
                        <p class="price">₹ {{ $product->price }}</p>

                        <a href="{{ route('product.show', $product->slug) }}" class="btn-view">
                            View Details
                        </a>
                    </div>

                </div>
                @endforeach

            </div>

        </div>
    </div>

    <div class="expert-cta-wrapper section-entry">
        <div class="container">
            <div class="expert-cta-box">

                <div class="cta-content">
                    <h3>Need Help Choosing the Right Battery?</h3>
                    <p>Our energy experts are ready to guide you with the perfect solution.</p>
                </div>

                <div class="cta-buttons">
                    <a href="tel:+919999999999" class="cta-btn call-btn">
                        <i class="fa-solid fa-phone"></i> Call an Expert
                    </a>

                    <a href="https://wa.me/919999999999" target="_blank" class="cta-btn chat-btn">
                        <i class="fa-regular fa-comment"></i> Chat with Expert
                    </a>
                </div>

            </div>
        </div>
    </div>

    <section class="why-choose-section section-entry">
        <div class="container">

            <div class="section-title text-center mb-5">
                <h3>Why Choose Yukinova?</h3>
                <p>Powering the Future with Innovation, Quality & Reliability</p>
            </div>

            <div class="why-choose-grid">

                <!-- Item 1 -->
                <div class="why-card">
                    <div class="why-icon">
                        <i class="fas fa-microchip"></i>
                    </div>
                    <h4>Advanced Technology</h4>
                    <p>
                        We engineer every lithium phosphate battery pack and lithium EV battery
                        pack with cutting-edge innovations to ensure maximum performance and safety.
                    </p>
                </div>

                <!-- Item 2 -->
                <div class="why-card">
                    <div class="why-icon">
                        <i class="fas fa-cogs"></i>
                    </div>
                    <h4>Customization Expertise</h4>
                    <p>
                        Every project is unique. Our expert team designs battery solutions
                        tailored precisely to your requirements.
                    </p>
                </div>

                <!-- Item 3 -->
                <div class="why-card">
                    <div class="why-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h4>Superior Quality</h4>
                    <p>
                        Each lithium-ion battery undergoes strict quality testing to deliver
                        consistent power output and longer life cycles.
                    </p>
                </div>

                <!-- Item 4 -->
                <div class="why-card">
                    <div class="why-icon">
                        <i class="fas fa-leaf"></i>
                    </div>
                    <h4>Sustainable Energy Solutions</h4>
                    <p>
                        Focused on clean energy, reducing carbon footprints, and building
                        a greener tomorrow with eco-friendly battery systems.
                    </p>
                </div>

                <!-- Item 5 -->
                <div class="why-card">
                    <div class="why-icon">
                        <i class="fas fa-map-marked-alt"></i>
                    </div>
                    <h4>Pan-India Support</h4>
                    <p>
                        From industrial ESS solutions to portable solar batteries,
                        we provide complete service support across India.
                    </p>
                </div>

                <!-- Item 6 -->
                <div class="why-card">
                    <div class="why-icon">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <h4>High Performance Efficiency</h4>
                    <p>
                        Designed for superior energy density and faster charging capability,
                        our battery systems deliver reliable performance even in demanding conditions.
                    </p>
                </div>

            </div>

        </div>
    </section>
    <div class="battery-counter-wrapper section-entry">
        <div class="container">
            <div class="counter-grid">

                <div class="counter-box">
                    <h2 class="counter" data-target="25">0</h2>
                    <p>Years of Industry Experience</p>
                </div>

                <div class="counter-box">
                    <h2 class="counter" data-target="50000">0</h2>
                    <p>Batteries Installed</p>
                </div>

                <div class="counter-box">
                    <h2 class="counter" data-target="20000">0</h2>
                    <p>Happy Customers</p>
                </div>

                <div class="counter-box">
                    <h2 class="counter" data-target="120">0</h2>
                    <p>Cities Served</p>
                </div>

            </div>
        </div>
    </div>

    <section class="testimonial-section">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-titles">Client Testimonials</h2>
                <p class="section-subtitle">Trusted by Dealers & Industry Professionals</p>
            </div>

            <div class="owl-carousel testimonial-carousel">

                <!-- Item 1 -->
                <div class="testimonial-item">
                    <div class="testimonial-content">
                        <div class="testimonial-image">
                            <img src="https://i.pravatar.cc/100?img=1" alt="">
                        </div>

                        <div class="testimonial-text-area">
                            <p>
                                We have been using these batteries for over 3 years.
                                The performance and durability are excellent.
                            </p>

                            <h5>Rahul Sharma</h5>
                            <span>Automotive Dealer</span>
                        </div>
                    </div>
                </div>

                <!-- Item 2 -->
                <div class="testimonial-item">
                    <div class="testimonial-content">
                        <div class="testimonial-image">
                            <img src="https://i.pravatar.cc/100?img=2" alt="">
                        </div>

                        <div class="testimonial-text-area">
                            <p>
                                Reliable solar batteries with consistent backup.
                                Highly recommended for commercial projects.
                            </p>

                            <h5>Anita Verma</h5>
                            <span>Solar Project Manager</span>
                        </div>
                    </div>
                </div>

                <!-- Item 3 -->
                <div class="testimonial-item">
                    <div class="testimonial-content">
                        <div class="testimonial-image">
                            <img src="https://i.pravatar.cc/100?img=3" alt="">
                        </div>

                        <div class="testimonial-text-area">
                            <p>
                                Strong build quality and professional support team.
                                Great experience working with them.
                            </p>

                            <h5>Manoj Gupta</h5>
                            <span>Industrial Client</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>


</div>

@endsection