<footer>
    <div class="clearfix">
        <div class="pull-left">
            <img src="{{ asset('images/dms.png') }}" alt="{{ config('app.name') }}" id="footer-logo">
        </div>
        <div class="pull-left">
            <h4>Data Management System</h4>
            <ul>
                <li>
                    <a href="{name: 'about'}">
                        About us
                    </a>
                </li>
                <li>
                    <a href="{name: 'home'}">
                        Terms and Conditions
                    </a>
                </li>
                <li>
                    <a href="{name: 'home'}">
                        Privacy Policy
                    </a>
                </li>
            </ul>
        </div>
        <div class="pull-left">
            <h4>Contact Us</h4>
            <ul>
                <li>
                    <a href="tel:0728273020">
                        <i class="lnr lnr-phone-handset"></i>
                        &nbsp;
                        +254 72020202020
                    </a>
                </li>
                <li>
                    <a href="mailto:info@alamihomefashions.com">
                        <i class="lnr lnr-envelope"></i>
                        &nbsp;
                        info@dms.com
                    </a>
                </li>
            </ul>
        </div>
        <div class="pull-left">
            <h4>Location</h4>
            <ul>
                <li>
                    Narok <br>  Kenya
                </li>
                <li>
                    <a href="https://www.google.com/maps/place/Alami+Home+Fashions/@-1.2871149,36.8401515,14z/data=!4m5!3m4!1s0x0:0xa53a953fcb4ae4c8!8m2!3d-1.2780406!4d36.8499791" target="_blank">
                        <i class="lnr lnr-map-marker"></i>
                        Open in Google Maps
                    </a>
                </li>
            </ul>
        </div>
        <!-- <div class="pull-left">
            <h4>Payment methods</h4>
            <img src="{{ asset('images/mpesa.png') }}" alt="M-Pesa payment provider" class="footer-payment-icon">
        </div> -->
    </div>
    <p id="copyright" class="clearfix">
        <span class="pull-left">
            &copy; {{ date('Y') }} JGPMC. All rights reserved.
        </span>
        <span class="pull-left" id="brand-designers">
            Made by
            <a href="https://www.facebook.com/gorobrands/" target="_blank">
                <strong>SIMI Technologies</strong>
            </a>
        </span>
    </p>
</footer>