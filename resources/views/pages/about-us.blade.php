@extends('layouts.main')
@section('content')

<div class="main-wrapper">

    <div class="about-info-wrapper section-entry">
        <div class="container">
            <div class="row align-items-center">

                <!-- Left Image -->
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="about-image">
                        <img src="{{ asset('img/ab-img.webp') }}" alt="About Yukinova" class="img-fluid">
                    </div>
                </div>

                <!-- Right Content -->
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="about-content">
                        <h2>Know more about our company</h2>

                        <p>
                            We are one of the leading lithium ion battery manufacturers in India. We offer high quality
                            batteries for vehicular and inverter applications.
                            Yukinova was incorporated in 2021 and we are committed to stay a leader in the development
                            and manufacturing of high-quality lithium-ion batteries. We have state of the art facilities
                            and a fantastic production department producing 500+ battery packs a day. Our lithium ion
                            batteries are used in various applications in various sectors such as residential,
                            transports, renewable energy sector, offices etc. Our lithium-ion batteries offer a cleaner
                            and more efficient alternative to traditional power sources reducing greenhouse gas
                            emissions.
                        </p>

                        <p>
                            At our company, we pride ourselves on our customer-centric approach. Our team is committed
                            to providing exceptional customer service, from product design and development to
                            manufacturing and after-sales support. We work closely with our clients and customers to
                            understand their needs and requirements. We are dedicated to sustainability and are
                            passionate about creating products that help to reduce our carbon footprint and promote a
                            greener future.
                        </p>

                        <a href="#" class="btn-about">Explore Our Products</a>
                    </div>
                </div>

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

    <div class="why-us-wrapper section-entry py-5">
        <div class="container">

            <!-- Section Heading -->
            <div class="text-center mb-5">
                <h2>Why We Are The Best</h3>
                    <p class="mx-auto" style="max-width: 750px;">
                        Delivering advanced, reliable, and sustainable lithium-ion battery solutions
                        powered by innovation, expertise, and environmental responsibility.
                    </p>
            </div>

            <div class="row g-4">

                <!-- Card 1 -->
                <div class="col-lg-4 col-md-6">
                    <div class="why-card h-100 text-center p-4 shadow-sm rounded">
                        <div class="icon-box mb-3">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                        <h5 class="fw-bold">Expert Team</h5>
                        <p>
                            Our team of engineers, scientists, and electro-chemists bring vast
                            industry experience and technical expertise to design world-class
                            power storage solutions.
                        </p>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="col-lg-4 col-md-6">
                    <div class="why-card h-100 text-center p-4 shadow-sm rounded">
                        <div class="icon-box mb-3">
                            <i class="fas fa-battery-full fa-2x"></i>
                        </div>
                        <h5 class="fw-bold">Advanced Lithium Technology</h5>
                        <p>
                            We develop long-lasting, efficient, and safe lithium-ion batteries
                            suitable for diverse energy applications with superior performance
                            and durability.
                        </p>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="col-lg-4 col-md-6">
                    <div class="why-card h-100 text-center p-4 shadow-sm rounded">
                        <div class="icon-box mb-3">
                            <i class="fas fa-industry fa-2x"></i>
                        </div>
                        <h5 class="fw-bold">Modern Manufacturing</h5>
                        <p>
                            Our 100 sqm ISO 14001 certified manufacturing unit builds up to
                            1000 customized battery modules with rapid prototyping and
                            advanced testing capabilities.
                        </p>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="col-lg-6 col-md-6">
                    <div class="why-card h-100 text-center p-4 shadow-sm rounded">
                        <div class="icon-box mb-3">
                            <i class="fas fa-shield-alt fa-2x"></i>
                        </div>
                        <h5 class="fw-bold">Quality & Safety First</h5>
                        <p>
                            Every product undergoes strict quality checks to ensure maximum
                            efficiency, safety, and long-term reliability.
                        </p>
                    </div>
                </div>

                <!-- Card 5 -->
                <div class="col-lg-6 col-md-6">
                    <div class="why-card h-100 text-center p-4 shadow-sm rounded">
                        <div class="icon-box mb-3">
                            <i class="fas fa-leaf fa-2x"></i>
                        </div>
                        <h5 class="fw-bold">Committed to a Greener Future</h5>
                        <p>
                            We are dedicated to reducing carbon footprints and fighting climate
                            change by manufacturing environmentally friendly renewable energy
                            battery solutions.
                        </p>
                    </div>
                </div>

            </div>

        </div>
    </div>

</div>

@endsection