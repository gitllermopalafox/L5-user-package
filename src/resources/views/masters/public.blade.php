<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <link type="text/css" rel="stylesheet" href="{{ URL::asset('user/css/style.css') }}"/>
        <title>Atom End user package</title>
    </head>
    <body>
        <div id="page">
            <div id="page_content">
                <div id="main">
                    <div id="main_content">
                        @yield("content")
                    </div>
                </div>
            </div><!-- page_content close. -->
        </div><!-- page close. -->
    </body>
</html>