@extends('layouts.master')

@section('content')

		<div id="col_2" role="main">
			
			<!-- Sadly needs to exist twice to accommodate the design -->
<div class="theme_related theme_related_wider_screen">
	<h4 class="theme_related_heading">Related Products</h4>

	<ul class="grid_container theme_related_grid_container">
		<li class="grid_item theme_related_grid_item w50_at_373 w33_at_960 w25_at_1200 w100_at_1400">
	<a href="#" class="theme_related_item">
		<img class="theme_related_image" src="/front/images/content/browse-theme_twitrcovers.jpg" width="320" height="242" alt="TwitrCovers" />
		<p class="theme_related_title">TwitrCovers</p>
		
	</a>
</li>
		<li class="grid_item theme_related_grid_item w50_at_373 w33_at_960 w25_at_1200 w100_at_1400">
	<a href="#" class="theme_related_item">
		<img class="theme_related_image" src="/front/images/content/browse-theme_balance.jpg" width="320" height="242" alt="Balance Theme" />
		<p class="theme_related_title">Balance Theme</p>
		
		<span class="theme_is_sponsored theme_related_is_sponsored">Sponsored</span>
		
	</a>
</li>
		<li class="grid_item theme_related_grid_item w50_at_373 w33_at_960 w25_at_1200 w100_at_1400">
	<a href="#" class="theme_related_item">
		<img class="theme_related_image" src="/front/images/content/browse-theme_amped.jpg" width="320" height="242" alt="Amped Theme" />
		<p class="theme_related_title">Amped Theme</p>
		
	</a>
</li>
		<li class="grid_item theme_related_grid_item w50_at_373 w33_at_960 w25_at_1200 w100_at_1400">
	<a href="#" class="theme_related_item">
		<img class="theme_related_image" src="/front/images/content/browse-theme_agency.jpg" width="320" height="242" alt="Agency Theme Collection" />
		<p class="theme_related_title">Agency Theme Collection</p>
		
	</a>
</li>
	</ul>
</div>
			
			<div class="theme_detail">
				
				<div class="theme_detail_info">

@if ($theme->price_type == 'free')
	<a href="{{ $theme->link_purchase }}" class="btn theme_detail_btn_price">Free Download</a>
@elseif ($theme->price_type == 'fixed')
	<a href="{{ $theme->link_purchase }}" class="btn theme_detail_btn_price">Buy ${{ $theme->price }}</a>
@elseif ($theme->price_type == 'membership')
	<a href="{{ $theme->link_purchase }}" class="btn theme_detail_btn_price">Join ${{ $theme->price }}<span class="per">/m</span></a>
@endif

	<a href="{{ route('themes.demo', $theme->hash) }}" class="btn theme_detail_btn_demo">View Demo</a>

	<div class="theme_detail_likes_to_rate">
        <p class="likes theme_detail_likes">
            @if ($me != NULL)
                Likes <a href="{{ url('theme/'. $theme->hash . '/like') }}" id="btn-like">
    <span class="icon-heart" style="{{ $like != NULL ? 'color:#e24f3d' : '' }}"></span></a> {{ $theme->likes_count }}
            @else
                Likes <span class="icon-heart"></span> {{ $theme->likes_count }}
            @endif
            @foreach($theme->likedByUsers as $user)
                <span class="avatar"><img src="{{ $user->present()->avatar(25) }}" /></span>
            @endforeach
		</p>

	</div>

	<h3 class="hidden">Share this theme on</h3>
	<div class="theme_detail_share">
		<ul class="grid_container">
			<li class="grid_item theme_detail_share_grid_item w25"><a href="#"><span class="icon icon-facebook"></span><span class="hidden">Facebook</span></a></li>
			<li class="grid_item theme_detail_share_grid_item w25"><a href="#"><span class="icon icon-twitter"></span><span class="hidden">Twitter</span></a></li>
			<li class="grid_item theme_detail_share_grid_item w25"><a href="#"><span class="icon icon-gplus"></span><span class="hidden">Google+</span></a></li>
			<li class="grid_item theme_detail_share_grid_item w25"><a href="#"><span class="icon icon-pinterest"></span><span class="hidden">Pinterest</span></a></li>
		</ul>
	</div>
</div>
				
				<div class="theme_detail_gallery">
</div>
				
<div class="theme_detail_content dbl_mb">
	<div class="theme_detail_heading">
		<h1>{{ $theme->title }}</h1>
@if($saved == NULL)
		<a href="{{ url('/themes/save/'. $theme->id) }}" class="save_theme theme_detail_heading_save js_save_theme" data-theme-is-saved="false"><span class="icon-pin"></span> Save</a>
@else
		<a href="{{ url('/themes/remove/'. $theme->id) }}" class="save_theme theme_detail_heading_save js_save_theme" data-theme-is-saved="true"><span class="icon-pin-down"></span> Saved</a>
@endif
	</div>

    <div class="theme_detail_body">
        <div class="theme-gallery">
            <img src="/shots/{{$theme->screenshot}}-800x600.png" />
        </div>
        {{ $theme->notes }}
    </div>

</div>
				
				<div class="js_accordion std_mb theme_detail_meta_accordion" data-multiple="true">
	<ul class="reset_lazy">
		<li>
			<a class="accordion_toggler accordion_toggler_btn  theme_detail_meta_accordion_toggler_btn" href="#pane-details"><h3>Details</h3></a>
			<div class="accordion_content theme_detail_meta" id="pane-details">
				<ul class="reset_lazy">
					<li class="theme_detail_meta_item">
						<h3 class="theme_detail_meta_item_heading">Vendor</h3>
						<p class="theme_detail_meta_item_value">{{ $theme->vendor->name }}</p>
					</li>
					<li class="theme_detail_meta_item">
						<h3 class="theme_detail_meta_item_heading">Requirements</h3>
						<p class="theme_detail_meta_item_value">{{ $theme->requirement->name }}</p>
					</li>
					<li class="theme_detail_meta_item">
						<h3 class="theme_detail_meta_item_heading">Platform</h3>
						<p class="theme_detail_meta_item_value">{{ $theme->platform->name }}</p>
					</li>
					<li class="theme_detail_meta_item">
						<h3 class="theme_detail_meta_item_heading">Licence</h3>
						<p class="theme_detail_meta_item_value">{{ $theme->licence->name }}</p>
					</li>
					<li class="theme_detail_meta_item">
						<h3 class="theme_detail_meta_item_heading">Layout/s</h3>
						<ul class="theme_detail_meta_item_value">
                        @foreach ($theme->layouts as $layout)
							<li>{{ $layout->name }}</li>
                        @endforeach
						</ul>
					</li>
					<li class="theme_detail_meta_item">
						<h3 class="theme_detail_meta_item_heading">Responsive</h3>
						<p class="theme_detail_meta_item_value">{{ ucfirst($theme->responsive) }}</p>
					</li>
					<li class="theme_detail_meta_item">
						<h3 class="theme_detail_meta_item_heading">Style</h3>
						<p class="theme_detail_meta_item_value">{{ $theme->style->name }}</p>
					</li>
					<li class="theme_detail_meta_item">
						<h3 class="theme_detail_meta_item_heading">Genre</h3>
						<p class="theme_detail_meta_item_value">{{ $theme->genre->name }}</p>
					</li>
					<li class="theme_detail_meta_item">
						<h3 class="theme_detail_meta_item_heading">Theme Performance</h3>
						<p class="theme_detail_meta_item_value"><span class="btn theme_detail_meta_item_value_btn">{{ $theme->level_overall }}/10</span> <a class="btn btn_subdued theme_detail_meta_item_value_btn"><span class="hidden">What does this mean</span>?</a></p>

						<ul class="list_style_none theme_detail_meta_item_performance">
							<li><b class="performance_metric">HTTP Requests</b> <span class="performance_rating" data-performance-rating="{{ $theme->level_http_requests }}"></span><span class="hidden">{{ $theme->level_http_requests }}</span></li>
							<li><b class="performance_metric">Page Weight</b> <span class="performance_rating" data-performance-rating="{{ $theme->level_page_weight }}"></span><span class="hidden">{{ $theme->level_page_weight }}</span></li>
							<li><b class="performance_metric">Render speed</b> <span class="performance_rating" data-performance-rating="{{ $theme->level_render_speed }}"></span><span class="hidden">{{ $theme->level_render_speed }}</span></li>
							<li><b class="performance_metric">Code Placement</b> <span class="performance_rating" data-performance-rating="{{ $theme->level_code_placement }}"></span><span class="hidden">{{ $theme->level_code_placement }}</span></li>
							<li><b class="performance_metric">Compression</b> <span class="performance_rating" data-performance-rating="{{ $theme->level_compression }}"></span><span class="hidden">{{ $theme->level_compression }}</span></li>
						</ul>
					</li>
					<li class="theme_detail_meta_item">
						<h3 class="theme_detail_meta_item_heading">Tags</h3>
						<ul class="theme_detail_meta_item_value">
							<li><a href="#" class="btn theme_detail_meta_item_value_btn">Compression</a></li>
							<li><a href="#" class="btn theme_detail_meta_item_value_btn">Agency</a></li>
							<li><a href="#" class="btn theme_detail_meta_item_value_btn">Another Tag</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</li>
	</ul>
</div>
				
				<div class="theme_detail_reviews">
	<div class="js_accordion std_mb theme_detail_reviews_accordion" data-multiple="true">
		<ul class="reset_lazy">
			<li>
				<a class="accordion_toggler accordion_toggler_btn theme_detail_reviews_accordion_toggler_btn" href="#pane-reviews"><h3>Reviews</h3></a>
				<div class="accordion_content theme_detail_reviews" id="pane-reviews">
					<ul class="list_style_none">
@foreach ($reviews as $review)
						<li class="theme_detail_reviews_item">
							<div class="theme_detail_reviews_meta">
								<span class="theme_detail_reviews_avatar">
									<img src="{{ $review->user->present()->avatar(50) }}" width="50" height="50" alt="{{ $review->user->nicename }} avatar" />
								</span>
								<p class="theme_detail_reviews_user">{{ $review->user->nicename }} - <span class="theme_detail_reviews_date">{{ $review->created_at }}</span></p>
							</div>
							
							<div class="content_area theme_detail_reviews_content_area">
                                <p>{{ e($review->comment) }}</p>
							</div>
						</li>
@endforeach
						<!-- Logged in state -->
@if (Auth::check())
						<li class="theme_detail_reviews_item">
                            <form class="theme_detail_reviews_form"
                                action="{{ url('theme/'. $theme->hash. '/rating') }}" method="post">
								<fieldset>
									<legend>Leave a review</legend>
									
									<div class="theme_detail_reviews_meta">
										<span class="theme_detail_reviews_avatar">
											<img src="{{ Auth::user()->present()->avatar(50) }}" width="50" height="50" alt="{{ Auth::user()->nicename }} avatar" />
										</span>
										<p class="theme_detail_reviews_user theme_detail_reviews_signin">You are signed in as <a href="#">{{ Auth::user()->nicename }}</a></p>
									</div>
									
									<div class="content_area theme_detail_reviews_content_area">
										<div class="f_row block">
											<label for="themeReview" class="hidden">Comment</label>
											<textarea name="themeReview" id="themeReview" placeholder="Review this theme"></textarea>
										</div>
										<button type="submit" class="btn">Submit Review</button>
									</div>
								</fieldset>
							</form>
						</li>
@else
						<!-- Logged out state -->
						<li class="theme_detail_reviews_item">
							<form class="theme_detail_reviews_form" action="#" method="get">
								<fieldset>
									<legend>Leave a review</legend>
									
									<div class="theme_detail_reviews_meta">
										<span class="theme_detail_reviews_avatar">
											<img src="/front/images/site/review-avatar-anonymous.png" width="50" height="50" alt="" />
										</span>
										<p class="theme_detail_reviews_user theme_detail_reviews_signin">Please <a href="#">Sign In</a> to rate and review this theme</p>
										<div class="theme_detail_reviews_rating">
											<fieldset class="rating form_rating">
												<legend>Rate this theme</legend>
												<input type="radio" id="star5" name="rating" value="5" disabled /> <label for="star5"><span class="icon-star rating_unrated"></span><span class="icon-star rating_rated"></span><span class="hidden">5 stars</span></label>
												<input type="radio" id="star4" name="rating" value="4" disabled /> <label for="star4"><span class="icon-star rating_unrated"></span><span class="icon-star rating_rated"></span><span class="hidden">4 stars</span></label>
												<input type="radio" id="star3" name="rating" value="3" disabled /> <label for="star3"><span class="icon-star rating_unrated"></span><span class="icon-star rating_rated"></span><span class="hidden">3 stars</span></label>
												<input type="radio" id="star2" name="rating" value="2" disabled /> <label for="star2"><span class="icon-star rating_unrated"></span><span class="icon-star rating_rated"></span><span class="hidden">2 stars</span></label>
												<input type="radio" id="star1" name="rating" value="1" disabled /> <label for="star1"><span class="icon-star rating_unrated"></span><span class="icon-star rating_rated"></span><span class="hidden">1 star</span></label>
											</fieldset>
											Rate this theme
										</div>
									</div>
									
									<div class="content_area theme_detail_reviews_content_area">
										<div class="f_row block">
											<label for="themeReview" class="hidden">Comment</label>
											<textarea name="themeReview" id="themeReview" placeholder="Review this theme" disabled></textarea>
										</div>
										<button type="submit" class="btn" disabled>Submit Review</button>
									</div>
								</fieldset>
							</form>
						</li>
@endif
					</ul>
				</div>
			</li>
		</ul>
	</div>
</div>
			</div>
			
			<!-- Sadly needs to exist twice to accommodate the design -->
<div class="theme_related theme_related_smaller_screen">
	<h4 class="theme_related_heading">Related Products</h4>

	<ul class="grid_container theme_related_grid_container">
		<li class="grid_item theme_related_grid_item w50_at_373 w33_at_960 w25_at_1200 w100_at_1400">
	<a href="#" class="theme_related_item">
		<img class="theme_related_image" src="/front/images/content/browse-theme_twitrcovers.jpg" width="320" height="242" alt="TwitrCovers" />
		<p class="theme_related_title">TwitrCovers</p>
		
	</a>
</li>
		<li class="grid_item theme_related_grid_item w50_at_373 w33_at_960 w25_at_1200 w100_at_1400">
	<a href="#" class="theme_related_item">
		<img class="theme_related_image" src="/front/images/content/browse-theme_balance.jpg" width="320" height="242" alt="Balance Theme" />
		<p class="theme_related_title">Balance Theme</p>
		
		<span class="theme_is_sponsored theme_related_is_sponsored">Sponsored</span>
		
	</a>
</li>
		<li class="grid_item theme_related_grid_item w50_at_373 w33_at_960 w25_at_1200 w100_at_1400">
	<a href="#" class="theme_related_item">
		<img class="theme_related_image" src="/front/images/content/browse-theme_amped.jpg" width="320" height="242" alt="Amped Theme" />
		<p class="theme_related_title">Amped Theme</p>
		
	</a>
</li>
		<li class="grid_item theme_related_grid_item w50_at_373 w33_at_960 w25_at_1200 w100_at_1400">
	<a href="#" class="theme_related_item">
		<img class="theme_related_image" src="/front/images/content/browse-theme_agency.jpg" width="320" height="242" alt="Agency Theme Collection" />
		<p class="theme_related_title">Agency Theme Collection</p>
		
	</a>
</li>
	</ul>
</div>
			
        </div><!-- #col_2 -->

@stop
