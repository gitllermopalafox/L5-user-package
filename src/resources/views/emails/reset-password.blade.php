<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <h1>A password reset was requested for this e-mail</h1>
        <p>To reset your password follow this <a href="{{ URL::to('/reset/' . $token) }}">link</a> and set your new password.
    </body>
</html>