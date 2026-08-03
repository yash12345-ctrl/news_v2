@extends('templates.base', ['title' => 'Akhbar-e-mashriq | Guldastah', 'ltr' => true])

@section('content')
<section class="section e-papers-section bg-primary">
	<div class="container">
		<div class="section-wrapper">
			<div class="e-papers-thumbnails">
				<div class="e-papers-thumbnails-wrapper">
					@foreach($guldastah_pages as $guldastah_page )
					<a href="#" class="e-papers-thumbnail">
						<div class="e-papers-thumbnail-poster">
							<img class="e-papers-thumbnail-poster-image is-active" src="{{$guldastah_page->page_url}}" alt="Guldastah Thumbnail" loading="lazy">
						</div>
						<span class="e-papers-thumbnail-page is-active">Page {{$guldastah_page->page_number}}</span>
					</a>
					@endforeach
				</div>
			</div>
			<div class="e-paper-single-poster">
				<img class="e-paper-single-poster-image" src="{{$guldastah->image_url}}" alt="Guldastah images" loading="lazy">
			</div>
			<div class="e-papers-thumbnails">
				<div class="e-papers-thumbnails-wrapper">
					@foreach($guldastah_pages as $guldastah_page )
					<a href="#" class="e-papers-thumbnail">
						<div class="e-papers-thumbnail-poster">
							<img class="e-papers-thumbnail-poster-image is-active" src="{{$guldastah_page->page_url}}" alt="Guldastah Thumbnail" loading="lazy">
						</div>
						<span class="e-papers-thumbnail-page is-active">Page {{$guldastah_page->page_number}}</span>
					</a>
					@endforeach
				</div>
			</div>
		</div>
	</div>
</section>
@endsection