<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$title}}</title>
    @vite(['resources/css/app.scss', 'resources/js/app.js'])
    <script src="{{web_resource_url('assets/web/vendor/jquery/jquery.min.js')}}"></script>
</head>
<body>
<x-web.header/>

<section class="bg-01">
    <div class="container mx-auto">
        <div class="py-[60px]">
            <div class="row">
                <div class="col-12 mx-auto">
                    <p class="mb-4">At Arrogate Maker Limited, we are committed to protecting your privacy. This
                        policy outlines
                        how we handle your information:</p>
                    <div class="mb-4">
                        <h6 class="mb-2">Information We Collect</h6>
                        <p class="mb-1 d-flex">Data, such as your name, email address, and payment details,
                            collected during registration or purchases.</p>
                        <p class="mb-0 d-flex align-items-center">Non-personal data, including device information,
                            browser type, and usage patterns, to improve user experience.</p>
                    </div>
                    <div class="mb-4">
                        <h6 class="mb-2">How We Use Your Information</h6>
                        <p class="mb-1 d-flex">To provide access to courses and services.</p>
                        <p class="mb-1 d-flex">To process payments securely.</p>
                        <p class="mb-1 d-flex">To deliver personalized content and updates.</p>
                        <p class="mb-0 d-flex align-items-center">For research, analytics, and marketing (with your
                            consent when required).</p>
                    </div>
                    <div class="mb-4">
                        <h6 class="mb-2">Data Protection</h6>
                        <p class="mb-1 d-flex">We implement technical and organizational measures to safeguard your
                            data.</p>
                        <p class="mb-0 d-flex align-items-center">Your information is not sold or shared with third
                            parties except for essential service providers (e.g., payment processors) or legal
                            obligations.</p>
                    </div>
                    <div class="mb-4">
                        <h6 class="mb-2">Third-Party Links</h6>
                        <p class="mb-1 d-flex">Our platform may include links to external websites.</p>
                        <p class="mb-0 d-flex align-items-center">We are not responsible for their privacy
                            practices, and you should review their policies.</p>
                    </div>
                    <div class="mb-4">
                        <h6 class="mb-2">Your Rights</h6>
                        <p class="mb-0">Access, update, or delete your personal information by contacting us at
                            [Insert Contact Information].</p>
                    </div>
                    <div class="mb-0">
                        <h6 class="mb-2">Policy Updates</h6>
                        <p class="mb-1">We may update this policy and notify you of significant changes through our
                            platform or email.</p>
                        <p class="mb-0">For any questions or concerns about this Privacy Policy, contact us at <a
                                href="javascript:void(0);" target="_blank"><span
                                    class="__cf_email__">eric@arrogatemaker.com</span></a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<x-web.v1.footer/>
</body>

</html>
