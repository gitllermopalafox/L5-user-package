@extends("user::masters.public")

@section("content")

<div class="modal modal-small">
    <!-- Messages. -->
    @if($errors->has())
    <ul class="alert alert-error">
    @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
    @endforeach
    </ul>
    @endif

    <!-- Form. -->
    <form class="clearfix modal--form" method="post">
        {!! csrf_field() !!}
        <div class="form_item">
            <label for="email">Email</label>
            <input class="text_input" name="email" type="text" value="{{ Input::old('email') }}">
        </div>
        <div class="form_item">
            <label for="password">Password</label>
            <input class="text_input" name="password" type="password">
        </div>
        <div class="form_item">
            <label>
                <input type="checkbox" name="remember"/> Remember Me
            </label>
        </div>
        <div class="button_wrapper clearfix">
            <div class="button_wrapper_content">
                <input class="button" type="submit" value="login">
            </div>
        </div>
    </form>
</div>

@stop
