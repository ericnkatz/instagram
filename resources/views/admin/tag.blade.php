@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">{{ $data['tag'] }} - <a href="/tag/{{ $data['tag'] }}"> view slides page</a></div>

				<div class="panel-body">
					@foreach($data['images'] as $image)
						<div class="image img-thumbnail" data-id="{{ $image['id'] }}" data-link="{{ $image['link'] }}" data-image="{{ $image['image'] }}" data-tag="{{ $data['tag'] }}" data-author-username="{{ $image['author']['username'] }}" data-author-avatar="{{ $image['author']['avatar'] }}" data-author-fullname="{{ $image['author']['full_name'] }}">
							<a href="#" class="enable">
								<img src="{{ $image['image'] }}" />
							</a>
						</div>
					@endforeach
				</div>
			</div>
		</div>
	</div>
</div>

@endsection

@section('footer')
<script>

(function( $ ) {
	'use strict';

	$('.panel-body').on('click', '.enable', function(e){

		var $parent = $(this).parent();

		console.log(JSON.stringify($parent.data()));

		$.ajax({
			type: 'get',
			url: '/admin/image',
			data: $parent.data(),
			success: function (data) {
				console.log(data);
				$parent.addClass('activated');
			}
		});

		e.preventDefault();
	});

})( jQuery );
</script>
@endsection
@endsection
