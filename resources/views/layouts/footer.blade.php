<footer class="main-footer">
    <div class="container">
        <div class="row">

            <!-- About Company -->
            <div class="col-lg-3 col-md-6">
                <div class="footer-widget">
                    <img src="{{ asset('img/logo.png') }}" alt="Logo" class="footer-logo">
                    <p>
                        We provide reliable and high-performance battery solutions for automotive,
                        solar, and industrial applications. Powering progress with innovation.
                    </p>
                    <div class="footer-social">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="col-lg-3 col-md-6">
                <div class="footer-widget">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li><a href="{{ url('about-us') }}">About Us</a></li>
                        <li><a href="{{ url('/') }}">Blog</a></li>
                        <li><a href="{{ url('contact-us') }}">Contact Us</a></li>
                        <li><a href="{{ url('privacy-policy') }}">Privacy Policy</a></li>
                        <li><a href="{{ url('return-policy') }}">Return Policy</a></li>
                        <li><a href="{{ url('terms-and-conditions') }}">Terms & Conditions</a></li>
                    </ul>
                </div>
            </div>

            <!-- Products -->
            <div class="col-lg-3 col-md-6">
                <div class="footer-widget">
                    <h4>Our Products</h4>
                    <ul>
                        <li><a href="{{ url('hybrid-inverter') }}">Hybrid Inverter</a></li>
                        <li><a href="{{ url('inverter-battery') }}">Inverter Battery</a></li>
                        <li><a href="{{ url('three-wheeler-battery') }}">Three Wheeler Battery</a></li>
                        <li><a href="{{ url('two-wheeler-battery') }}">Two Wheeler Battery</a></li>
                        <li><a href="{{ url('cycle-battery') }}">Cycle Battery</a></li>
                        <li><a href="{{ url('portable-power-solution') }}">Portable Power Solution</a></li>
                    </ul>
                </div>
            </div>

            <!-- Contact Info -->
            <div class="col-lg-3 col-md-6">
                <div class="footer-widget">
                    <h4>Contact Info</h4>
                    <p><i class="fas fa-map-marker-alt"></i> Plot C2, Sector A-3, TDS city, Loni, Ghaziabad, UP-200102
                    </p>
                    <p><i class="fas fa-phone"></i> +91-93116 06792</p>
                    <p><i class="fas fa-envelope"></i> sales@yukinova.com</p>

                    <div class="newsletter">
                        <input type="email" placeholder="Your Email">
                        <button type="submit">Subscribe</button>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Bottom Bar -->
    <div class="footer-bottom">
        <div class="container">
            <p>&copy; copyright Yukinova All Rights Reserved. Site Created & Maintained By <a
                    href="http://www.digilinkers.com" target="_blank" class="creator-link">Digilinkers</a></p>
        </div>
    </div>
</footer>


<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script src="{{ asset('js/main.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>