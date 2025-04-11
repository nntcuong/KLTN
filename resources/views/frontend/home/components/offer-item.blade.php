<section class="fp__offer_item mt_100 xs_mt_70 pt_95 xs_pt_65 pb_150 xs_pb_120">
    <div class="container">
        <div class="row wow fadeInUp" data-wow-duration="1s">
            <div class="col-md-8 col-lg-7 col-xl-6 m-auto text-center">
                <div class="fp__section_heading mb_50">
                    <h4>{!! @$sectionTitles['daily_offer_top_title'] !!}</h4>
                    <h2>{!! @$sectionTitles['daily_offer_main_title'] !!}</h2>
                    <span>
                        <img src="{{ asset('frontend/images/heading_shapes.png') }}" alt="shapes" class="img-fluid w-100">
                    </span>
                    <p>{!! @$sectionTitles['daily_offer_sub_title'] !!}</p>
                </div>
            </div>
        </div>

        <div class="row offer_item_slider wow fadeInUp" data-wow-duration="1s">
            @foreach ($dailyOffers as $product)
            <div class="col-xl-4">
                <div class="fp__offer_item_single">
                   
                    <div class="text">
                        
                        <h1>{{ $product->sku }}</h1>

                      

                    
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</section>
