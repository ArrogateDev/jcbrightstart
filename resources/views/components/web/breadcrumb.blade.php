@props(['title' => '', 'subtitle' => ''])
<section class="section page-heading js-parallax-scroll" style="background-image: url('{{web_resource_url('assets/web/images/bg-heading-001.png')}}');">
    <div class="container">
        <div class="page-heading-inner">
            <div class="section-heading section-heading-1 section-heading-1--tiny text-left">
                <h2 class="section-heading__title">{!! $title !!}</h2>
            </div>
        </div>
    </div>
</section>
<style>
    @media (max-width: 1400px) {
        .page-heading {
            background-size: 100%;
            background-position: 100% 20%;
            padding-top: 320px;
        }
    }

    @media (max-width: 700px) {
        .page-heading {
            padding-top: 260px;
        }
    }
</style>
