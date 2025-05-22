<!-- Footer (desktop only) -->
<footer class="footer mt-4 bg-dark text-light py-5 d-none d-md-block">
    <div class="container">
        <div class="row">
            <!-- Navigation Links -->
            <div class="col-md-4 mb-3">
                <h5>Navigation Links</h5>
                <ul class="list-unstyled">
                    <li><a href="" class="text-light">Site Map</a></li>
                    <li><a href="{{route('about')}}" class="text-light">About us</a></li>
                    <li><a href="{{route('contact') }}" class="text-light">Contact Us</a></li>
                    <li><a href="#" class="text-light">Privacy Policy</a></li>
                    <li><a href="#" class="text-light">FAQs</a></li>
                    <li><a href="#" class="text-light">Terms of Service</a></li>
                    <li><a href="#" class="text-light">Subscribe</a></li>
                </ul>
            </div>

            <!-- Office Hours and Logo -->
            <div class="col-md-4  mb-3">
                <button class="btn btn-danger mb-3">GET A QUOTE</button>
                <div class="office-hours">
                    <h5>Office Hours</h5>
                    <p>Monday - Friday (EST)<br>8am - 5pm</p>
                    <p>Saturday (EST, Seasonally)<br>8am - 1pm</p>
                </div>
            </div>

            <!-- Contact and Social Media Links -->
            <div class="col-md-4 mb-3">
                <h5>Contact Us</h5>
                <p><i class="bi bi-envelope"></i> info@academyfence.com</p>
                <p><i class="bi bi-telephone-fill"></i> (973) 674-0600</p>
                <p><i class="bi bi-geo-alt-fill"></i>Headquarters:<br>119 N Day Street, Orange, NJ</p>
                <p class="btn-direction">
                    <a href="https://www.google.com/maps/dir//Academy+Fence+Company+Inc/data=!4m6!4m5!1m1!4e2!1m2!1m1!1s0x89c3ab30c593349f:0x8f5a4fd1e023b46c?sa=X&ved=1t:3061&ictx=111"
                        target="_blank">
                        <i class="bi bi-arrow-return-right"></i> Get Directions
                    </a>
                </p>
                <div class="social mt-3">
                    <h5>Follow Us</h5>
                    <a href="#" class="text-light me-2"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="text-light me-2"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="text-light"><i class="bi bi-twitter"></i></a>
                </div>
            </div>
        </div>

        <!-- Footer Bottom Text -->
        <div class="d-flex align-items-center row">
            <div class="col-md-4 mt-4">
                <p>&copy; {{ date('Y') }} Academy Fence Company Inc.<br> All rights reserved.</p>
            </div>
            <div class="col-md-4 mt-4">
                <img src="{{ url('/resources/images/logo.png') }}" alt="Academy Fence Company Logo"
                    class="footer-logo mt-3">
            </div>
        </div>
    </div>
</footer>



<!-- Mobile version -->
<footer class="footer mt-4 bg-dark text-light py-5 d-block d-md-none">
    <div class="container">

        <div class="footer__header">
            <div class="d-flex align-items-center justify-content-center gap-3 py-3 text-white flex-wrap">
                <!-- Logo -->
                <img src="{{ url('/resources/images/logo.png') }}" alt="Academy Fence Company Logo" class="footer-logo">

                <!-- Tagline -->
                <h3 class=" tagline__footer text-center">The Original<br>Fence Superstore</h3>

                <!-- Button -->
                <button class="btn quote-btn">GET A QUOTE</button>
            </div>
        </div>


        <div class="row">
            <!-- Navigation Links -->
            <div class="row">
                <!-- Navigation Links -->
                <div class="col-6">
                    <h5 class="fw-bold">Navigation Links:</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-light">Site Map</a></li>
                        <li><a href="{{ route('about') }}" class="text-light">About us</a></li>
                        <li><a href="{{ route('contact') }}" class="text-light">Contact Us</a></li>
                        <li><a href="#" class="text-light">Privacy Policy</a></li>
                        <li><a href="#" class="text-light">FAQs</a></li>
                        <li><a href="#" class="text-light">Terms of Service</a></li>
                        <li><a href="#" class="text-light">Subscribe</a></li>
                    </ul>
                </div>

                <!-- Office Hours -->
                <div class="col-6">
                    <h5 class="fw-bold">Office hours:</h5>
                    <p class="mb-1"><strong>Monday - Friday (EST)</strong><br>8am - 5pm</p>
                    <p class="mb-0"><strong>Saturday (EST, Seasonally)</strong><br>8am - 1pm</p>
                </div>
            </div>


            <!-- Contact Info + Social -->
            <div class="col-12 mb-3">
                <h5>Contact Us</h5>
                <p><i class="bi bi-envelope"></i> info@academyfence.com</p>
                <p><i class="bi bi-telephone-fill"></i> (973) 674-0600</p>
                <p><i class="bi bi-geo-alt-fill"></i> Headquarters:<br> 119 N Day Street, Orange, NJ</p>
                <p class="btn-direction">
                    <a href="https://www.google.com/maps/dir//Academy+Fence+Company+Inc/" target="_blank">
                        <i class="bi bi-arrow-return-right"></i> Get Directions
                    </a>
                </p>
                <div class="social mt-3">
                    <h5>Follow Us</h5>
                    <a href="#" class="text-light me-2"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="text-light me-2"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="text-light"><i class="bi bi-twitter"></i></a>
                </div>
            </div>
        </div>

        <!-- Footer Bottom Text -->
        <div class="text-center mt-4">
            <p>&copy; {{ date('Y') }} Academy Fence Company Inc.<br>All rights reserved.</p>
        </div>
    </div>
    <!-- Toast Container -->
<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="cartToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-success">
            <strong class="me-auto">Cart Notification</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            Item added to the cart successfully!
        </div>
    </div>
</div>
</footer>