<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

        @yield('link')
        @yield('title')

        <script>
            var navFixed = true

            window.addEventListener('scroll', () => {
                if (window.scrollY == 0)
                    document.querySelector('nav').style.display = 'flex'
                else if (navFixed)
                    document.querySelector('nav').style.display = 'none'
            })

            document.addEventListener('mousemove', e => {
                if (window.scrollY > 0) {
                    if (e.clientY <= 80)
                        document.querySelector('nav').style.display = 'flex'
                    else if (navFixed)
                        document.querySelector('nav').style.display = 'none'
                }
            })
        </script>
    </head>

    <body>
        <nav style="display: flex;">
            @yield('nav')
        </nav>
        @yield('icon')

        <div class="content">
            <div class="container">
                @yield('content')
            </div>
        </div>

        @yield('script')
    </body>
</html>
