<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <h1>Congratulations with your new account</h1>
        <p>To activate your account follow this <a href="{{ URL::to('/reset/' . $token) }}">link</a> and set your new password.
    </body>
</html>