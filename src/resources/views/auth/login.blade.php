@extends("user::masters.public")

@section("content")

<div class="modal modal-small">

    <!-- Messages. -->
    @if(session('status') != null)
    <ul class="message message-status">
        <li>{{ session('status') }}</li>
    </ul>
    @elseif(isset($errors) && $errors->has())
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
        <div class="form_item">
            <label class="label" for="password">Password</label>
            <input class="input-text" name="password" type="password">
        </div>
        <div class="form_item">
            <label class="checkbox-label">
                <input class="input-checkbox" type="checkbox" name="remember"/>
                <span class="checkbox-label__text">Remember Me</span>
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
