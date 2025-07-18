<section class="fp__offer_item mt_100 xs_mt_70 pt_95 xs_pt_65 pb_150 xs_pb_120">
    <div class="container">
        <div class="row wow fadeInUp" data-wow-duration="1s">
            <div class="col-md-8 col-lg-7 col-xl-6 m-auto text-center">
                <div class="fp__section_heading mb_50">
                    <h4>Recommended Products Just for You</h4>
                    <p>We've selected these items based on your preferences and shopping behavior</p>
                </div>
            </div>
        </div>

        <div class="row offer_item_slider wow fadeInUp" data-wow-duration="1s">
            @foreach ($dailyOffers as $product)
            <div class="col-xl-4">
                <div class="fp__offer_item_single">

                    <div class="img">
                        <img src="{{ asset($product->thumb_image) }}" alt="offer" class="img-fluid w-100">
                    </div>
                    <div class="text">
                        @if ($product->offer_price > 0)
                        <span>{{ discountInPercent($product->price, $product->offer_price) }}% off</span>

                        @endif

                        <a class="title" href="{{ route('product.show', $product->slug) }}">{!! $product->name !!}</a>
                        <p>{{ $product->short_description }}</p>
                        <ul class="d-flex flex-wrap">
                            <li><a href="javascript:;" onclick="loadProductModal('{{ $product->id }}')"><i class="fas fa-shopping-basket"></i></a></li>
                            <li><a href="#"><i class="fal fa-heart"></i></a></li>
                            <li><a href="{{ route('product.show', $product->slug) }}"><i class="far fa-eye"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</section>
