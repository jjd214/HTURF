<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ get_settings()->site_name }}</title>
    <link rel="stylesheet" href="./index.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="/front/index.css" />

</head>

<body>
    <header>
        <nav>
            <img src="/images/front/images/white_logo.png" alt="" class="logo" />
            <ul>
                <li><a href="{{ route('consignor.login') }}" id="loginButton">Log In</a></li>
                <li><a href="{{ route('consignor.register') }}" id="signupButton">Sign Up</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="first_section">
            <div>
                <img src="/images/front/images/white_shoes.png" alt="" />
            </div>
            <div>
                <p class="gray main_text">Declutter, Consign</p>
                <p class="main_text">Simplify Selling Today!</p>
                <p class="desc_text">
                    Turn your pre-loved items into cash with ease! Our app simplifies
                    consigning,<br />
                    connecting you with buyers while we handle the hard work. Declutter,
                    earn, and <br />make space for what’s next!
                </p>
            </div>
        </section>

        <div class="brands_container">
            <img src="/images/front/images/adidas_logo.png" alt="" />
            <img src="/images/front/images/nike_logo.png" alt="" />
            <img src="/images/front/images/puma_logo.png" alt="" />
            <img src="/images/front/images/converse_logo.png" alt="" />
        </div>
    </main>
</body>

</html>
