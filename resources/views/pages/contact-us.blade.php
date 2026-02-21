@extends('layouts.main')
@section('content')

<div class="main-wrapper">
    
    <section class="contact-section section-entry">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <div class="contact-card p-4 p-md-5">

                    <div class="text-center mb-4">
                        <h2 class="fw-bold">Get In Touch</h2>
                        <p>We’d love to hear from you</p>
                    </div>

                    <form>

                        <div class="row g-4">

                            <!-- Name -->
                            <div class="col-md-6">
                                <div class="form-floating custom-input">
                                    <input type="text" class="form-control" id="name" placeholder="Full Name" required>
                                    <label for="name">Full Name</label>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="col-md-6">
                                <div class="form-floating custom-input">
                                    <input type="email" class="form-control" id="email" placeholder="Email Address" required>
                                    <label for="email">Email Address</label>
                                </div>
                            </div>

                            <!-- Phone -->
                            <div class="col-md-6">
                                <div class="form-floating custom-input">
                                    <input type="tel" class="form-control" id="phone" placeholder="Phone Number" required>
                                    <label for="phone">Phone Number</label>
                                </div>
                            </div>

                            <!-- Requirement -->
                            <div class="col-md-6">
                                <div class="form-floating custom-input">
                                    <input type="text" class="form-control" id="requirement" placeholder="Requirement">
                                    <label for="requirement">Your Requirement</label>
                                </div>
                            </div>

                            <!-- Message -->
                            <div class="col-12">
                                <div class="form-floating custom-input">
                                    <textarea class="form-control" placeholder="Message" id="message" style="height: 120px" required></textarea>
                                    <label for="message">Message</label>
                                </div>
                            </div>

                            <!-- Button -->
                            <div class="col-12 text-center">
                                <button type="submit" class="btn submit-btn px-5">
                                    Send Message
                                </button>
                            </div>

                        </div>

                    </form>

                </div>

            </div>
        </div>
    </div>
</section>

<section class="contact-info-section section-entry">
    <div class="container">
        <div class="row g-4 align-items-stretch">

            <!-- Left Side - Contact Details -->
            <div class="col-lg-5">
                <div class="info-card p-4 h-100">

                    <h3 class="fw-bold mb-4 section-title">
                        Contact Information
                    </h3>

                    <div class="info-item d-flex mb-4">
                        <div class="icon-box me-3">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="contact-detail">
                            <h6 class="fw-semibold mb-1">Office Address</h6>
                            <p class="mb-0">
                               Yuki Electric India private limited NO.702 (7th FLOOR) PEARLS BUSINESS PARK, NETAJI SUBHASH PLACE, PITAM PURA, DELHI-110034.
                            </p>
                        </div>
                    </div>

                    <div class="info-item d-flex mb-4">
                        <div class="icon-box me-3">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="contact-detail">
                            <h6 class="fw-semibold mb-1">Work Address</h6>
                            <p class="mb-0">
                               Plot C2, Sector A-3, TDS city, Loni, Ghaziabad, UP-200102
                            </p>
                        </div>
                    </div>

                    <div class="info-item d-flex mb-4">
                        <div class="icon-box me-3">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <div class="contact-detail">
                            <h6 class="fw-semibold mb-1">Phone</h6>
                            <p class="mb-0">(+91)- 9205993390</p>
                        </div>
                    </div>

                    <div class="info-item d-flex mb-4">
                        <div class="icon-box me-3">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="contact-detail">
                            <h6 class="fw-semibold mb-1">Email</h6>
                            <p class="mb-0">sales@yukinova.com</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side - Google Map -->
            <div class="col-lg-7">
                <div class="map-card h-100">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d13987.2715786428!2d77.26002!3d28.784690999999995!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390cfe9593feaec7%3A0xa3a6ff3c248c3853!2sYuki%20Electric%20India%20Pvt%20Ltd!5e0!3m2!1sen!2sin!4v1770982726059!5m2!1sen!2sin"
                        width="100%" 
                        height="100%" 
                        style="border:0; min-height:400px;" 
                        allowfullscreen="" 
                        loading="lazy">
                    </iframe>
                </div>
            </div>

        </div>
    </div>
</section>




</div>

@endsection