@extends("user::masters.public")

@section("content")

<div class="modal modal-small">

	<!-- Messages. -->
    @if($errors->has())
		<ul class="message message-error">
		@foreach ($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
		</ul>
	@endif

	<!-- Form. -->
	<form class="modal--form" method="post">
		{!! csrf_field() !!}
		<div class="form_item">
			<label class="label" for="email">Email</label>
			<input class="input-text" name="email" type="text" value="{{ Input::old('email') }}">
		</div>
		<div class="button_wrapper clearfix">
			<div class="button_wrapper_content">
				<input class="button" type="submit">
			</div>
		</div>
	</form>

</div>
@stop
