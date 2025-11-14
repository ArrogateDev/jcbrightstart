<!DOCTYPE html>
<html lang="en">

<x-web.head/>

<body>

<!-- Main Wrapper -->
<div class="main-wrapper">

    <x-web.user.header/>

    <!-- Breadcrumb -->
    <div class="breadcrumb-bar text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-12">
                    <h2 class="breadcrumb-title mb-2">FAQ</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center mb-0">
                            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">FAQ</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- /Breadcrumb -->

    <div class="content">
        <div class="container">
            <h2 class="main-title mb-1">Most frequently asked questions</h2>
            <p class="mb-4">Here are the most frequently asked questions you may check before getting started</p>
            <div class="row">
                <div class="col-lg-6">

                    <!-- Faq -->
                    <div class="faq-card">
                        <h6 class="faq-title">
                            <a class="collapsed" data-bs-toggle="collapse" href="#faqone" aria-expanded="false">Is
                                there a 14-days trial?</a>
                        </h6>
                        <div id="faqone" class="collapse">
                            <div class="faq-detail">
                                <p>No, we currently do not offer a 14-day trial. However, you can explore our
                                    platform through free demo courses or contact our team for a personalized
                                    walkthrough of the features.</p>
                            </div>
                        </div>
                    </div>


                    <div class="faq-card">
                        <h6 class="faq-title">
                            <a class="collapsed" data-bs-toggle="collapse" href="#faqtwo" aria-expanded="false">How
                                much time I will need to learn this app?</a>
                        </h6>
                        <div id="faqtwo" class="collapse">
                            <div class="faq-detail">
                                <p>No, we currently do not offer a 14-day trial. However, you can explore our
                                    platform through free demo courses or contact our team for a personalized
                                    walkthrough of the features.</p>
                            </div>
                        </div>
                    </div>


                    <div class="faq-card">
                        <h6 class="faq-title">
                            <a class="collapsed" data-bs-toggle="collapse" href="#faqthree" aria-expanded="false">Is
                                there a month-to-month payment option?</a>
                        </h6>
                        <div id="faqthree" class="collapse">
                            <div class="faq-detail">
                                <p>No, we currently do not offer a 14-day trial. However, you can explore our
                                    platform through free demo courses or contact our team for a personalized
                                    walkthrough of the features.</p>
                            </div>
                        </div>
                    </div>
                    <!-- /Faq -->

                </div>

                <div class="col-lg-6">

                    <!-- Faq -->
                    <div class="faq-card">
                        <h6 class="faq-title">
                            <a class="collapsed" data-bs-toggle="collapse" href="#faqfour"
                               aria-expanded="false">What’s the benefits of the Premium Membership?</a>
                        </h6>
                        <div id="faqfour" class="collapse">
                            <div class="faq-detail">
                                <p>No, we currently do not offer a 14-day trial. However, you can explore our
                                    platform through free demo courses or contact our team for a personalized
                                    walkthrough of the features.</p>
                            </div>
                        </div>
                    </div>


                    <div class="faq-card">
                        <h6 class="faq-title">
                            <a class="collapsed" data-bs-toggle="collapse" href="#faqfive" aria-expanded="false">Are
                                there any free tutorials available?</a>
                        </h6>
                        <div id="faqfive" class="collapse">
                            <div class="faq-detail">
                                <p>No, we currently do not offer a 14-day trial. However, you can explore our
                                    platform through free demo courses or contact our team for a personalized
                                    walkthrough of the features.</p>
                            </div>
                        </div>
                    </div>


                    <div class="faq-card">
                        <h6 class="faq-title">
                            <a class="collapsed" data-bs-toggle="collapse" href="#faqsix" aria-expanded="false">How
                                can I cancel my subscription plan?</a>
                        </h6>
                        <div id="faqsix" class="collapse">
                            <div class="faq-detail">
                                <p>No, we currently do not offer a 14-day trial. However, you can explore our
                                    platform through free demo courses or contact our team for a personalized
                                    walkthrough of the features.</p>
                            </div>
                        </div>
                    </div>
                    <!-- /Faq -->

                </div>
            </div>

            <div class="bg-light border rounded p-4 p-sm-5 mt-4">

                <div class="row">
                    <!-- Title and inputs -->
                    <div class="col-lg-7 text-center mx-auto">
                        <!-- Avatar group -->


                        <!-- Title -->
                        <h4 class="mb-2">Still have a question?</h4>
                        <p class="mb-4">We'd be happy to help you with any questions you have! Please let us know
                            what you're looking for, and we'll do our best to assist you.</p>

                        <!-- Button -->
                        <a href="{{route('page', ['page' => 'contact-us.html'])}}" class="btn btn-lg btn-dark mb-0">Contact us</a>
                    </div>
                </div> <!-- Row END -->
            </div>
        </div>
    </div>

    <x-web.footer/>

</div>

</body>

</html>
