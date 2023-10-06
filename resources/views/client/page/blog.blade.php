@extends("client.layouts.client")
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('client/styles/blog.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('client/styles/blog_responsive.css')}}">
@endsection
@section("content")
<div class="home">
	<div class="background_image" style='background-image:url("{{asset('client/images/booking.jpg')}}")'></div>
	<div class="home_container">
		<div class="container">
			<div class="row">
				<div class="col">
					<div class="home_content text-center">
						<div class="home_title">Blog</div>
						@include("client.component.bookingform")
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Blog -->

<div class="blog">
	<div class="container">
		<div class="row">
			
			<!-- Blog Posts -->
			<div class="col-lg-9">
				<div class="blog_posts">
					@foreach ($blogs as $item)
					<!-- Blog Post -->
						<div class="blog_post">
							<div class="blog_post_image">
								<img src="{{$item->image->url}}" alt="">
								<div class="blog_post_date"><a href="#">{{$item->created_at->format('M d, y')}}</a></div>
							</div>
							<div class="blog_post_content">
								<div class="blog_post_title"><a href="{{route('client.blog.detail',$item->slug)}}">{{$item->name}}</a></div>
								<div class="blog_post_info">
									<ul class="d-flex flex-row align-items-start justify-content-start flex-wrap">
										<li class="d-flex flex-row align-items-center justify-content-start">
											<img src="{{asset('client/images/icon_4.png')}}" alt="">
											<a href="#">News</a>
										</li>
										<li class="d-flex flex-row align-items-center justify-content-start">
											<img src="{{asset('client/images/icon_5.png')}}" alt="">
											<a href="#">21 Likes</a>
										</li>
										<li class="d-flex flex-row align-items-center justify-content-start">
											<img src="{{asset('client/images/icon_6.png')}}" alt="">
											<a href="#">602 views</a>
										</li>
										<li class="d-flex flex-row align-items-center justify-content-start">
											<img src="{{asset('client/images/icon_7.png')}}" alt="">
											<a href="#">1 min</a>
										</li>
										<li class="d-flex flex-row align-items-center justify-content-start">
											<img src="{{asset('client/images/icon_8.png')}}" alt="">
											<a href="#">3 comments</a>
										</li>
									</ul>
								</div>
								<div class="blog_post_text">
									<p>{{$item->short_description}}</p>
								</div>
								<div class="button blog_post_button"><a href="{{route('client.blog.detail',$item->slug)}}">Read More</a></div>
							</div>
						</div>
					@endforeach
					<!-- Page Nav -->
					<div class="page_nav">
						<ul class="d-flex flex-row align-items-center justify-content-center">
							@foreach (($blogs->links()["elements"][0]) as $key=>$value)
								<li class="{{(request()->query('page') == $key) ? 'active' : ''}}"><a href="{{$value}}">0{{$key}}.</a></li>
							@endforeach
						</ul>
					</div>
				</div>
			</div>

			<!-- Sidebar -->
			<div class="col-lg-3">
				<div class="sidebar">
					
					<!-- Search -->
					<div class="sidebar_search">
						<form action="{{route('client.blog.index')}}" class="sidebar_search_form" id="sidebar_saerch_form" method="GET">
							<input type="text" class="sidebar_search_input" name="keyword" placeholder="Keyword" required="required">
							<button type="submit" class="sidebar_search_button">Search</button>
						</form>
					</div>

					<!-- Recent Posts -->
					<div class="recent_posts">
						<div class="sidebar_title"><h4>Recent Posts</h4></div>
						<div class="sidebar_list">
							<ul>
								<li><a href="#">Featured Product</a></li>
								<li><a href="#">Standard Post</a></li>
								<li><a href="#">Gallery Post</a></li>
								<li><a href="#">Video Post</a></li>
								<li><a href="#">Audio Post</a></li>
							</ul>
						</div>
					</div>

					<!-- Categories -->
					<div class="categories">
						<div class="sidebar_title"><h4>Categories</h4></div>
						<div class="sidebar_list">
							<ul>
								@foreach ($category as $item)
									<li><a href="{{route('client.blog.index',['category'=>$item->slug])}}">{{$item->name}}</a></li>
								@endforeach
							</ul>
						</div>
					</div>

					<!-- Tags -->
					<div class="tags">
						<div class="sidebar_title"><h4>Tags</h4></div>
						<div class="tags_container">
							<ul class="d-flex flex-row align-items-start justify-content-start flex-wrap">
								<li><a href="#">news</a></li>
								<li><a href="#">hotel</a></li>
								<li><a href="#">vacation</a></li>
								<li><a href="#">reservation</a></li>
								<li><a href="#">booking</a></li>
								<li><a href="#">video</a></li>
								<li><a href="#">clients</a></li>
								<li><a href="#">reviews</a></li>
								<li><a href="#">destinations</a></li>
								<li><a href="#">swimming pool</a></li>
							</ul>
						</div>
					</div>

					<!-- Special Offer -->
					<div class="special_offer">
						<div class="background_image" style='background-image:url("{{asset('client/images/special_offer.jpg')}}"'></div>
						<div class="special_offer_container text-center">
							<div class="special_offer_title">Special Offer</div>
							<div class="special_offer_subtitle">Family Room</div>
							<div class="button special_offer_button"><a href="{{route('client.booking.room.index')}}">Book now</a></div>
						</div>
					</div>

				</div>
			</div>

		</div>
	</div>
</div>
@endsection
@section('js')
<script src="{{asset('client/js/blog.js')}}"></script>
@endsection