<footer class="footer">
    <div class="footer-bottom">
        <div class="container">
            <div class="row row-gap-2">
                <div class="col-md-6">
                    <div class="text-center text-md-start">
                        <p class="text-white">Copyright &copy; {{date('Y')}} Jockey Club Bright Start Project. All rights reserved.
                        </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div>
                        <ul
                            class="d-flex align-items-center justify-content-center justify-content-md-end footer-link">
                            <li><a href="{{route('page', ['page' => 'terms-and-conditions.html'])}}">Terms & Conditions</a></li>
                            <li><a href="{{route('page', ['page' => 'privacy-policy.html'])}}">Privacy Policy</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
