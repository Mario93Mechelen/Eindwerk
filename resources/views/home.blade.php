<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Semestr</title>
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="/css/main.css">
</head>
<body>

    <div id="header_wrapper">
        <header>
            <nav>
                <ul>
                    <li><a href="#">SEMESTR</a></li>
                    <li><a href="#" class="active">around me</a></li>
                    <li><a href="#">crossings</a></li>
                    <li><a href="#">settings</a></li>
                    <li class="nav_profile"><a href="#">profile</a></li>
                </ul>
            </nav>

            <div class="location">
                <h1 class="location_city">New York</h1>
                <div class="location_label">current location</div>
            </div>
    </header>
    </div>

    <div class="main">

        <section class="content aroundme">
            <h2 class="content_title">Around me</h2>

            <!-- nu placeholders, later loopen we hier de users uit de omgeving uit en vullen we de juiste zaken in  -->
            <div class="aroundme_item main_item">
                <img class="aroundme_item_image" src="{{url('img/profile_pic_default.jpg')}}">
                <div class="aroundme_item_right aroundme_item_name">Amber Heard</div>
                <div class="aroundme_item_right aroundme_item_detail">
                    <div class="aroundme_item_school">student at NYU</div>
                    <div class="aroundme_item_age">27 years</div>
                    <div class="aroundme_item_country">United Kingdom</div>
                </div>
                <div class="aroundme_item_right aroundme_item_intro">Lorem ipsum dolor sit amet, consectetur adipiscing elit sed.</div>
            </div>

            <div class="aroundme_item main_item">
                <img class="aroundme_item_image" src="{{url('img/profile_pic_default.jpg')}}">
                <div class="aroundme_item_right aroundme_item_name">Amber Heard</div>
                <div class="aroundme_item_right aroundme_item_detail">
                    <div class="aroundme_item_school">student at NYU</div>
                    <div class="aroundme_item_age">27 years</div>
                    <div class="aroundme_item_country">United Kingdom</div>
                </div>
                <div class="aroundme_item_right aroundme_item_intro">Lorem ipsum dolor sit amet, consectetur adipiscing elit sed.</div>
            </div>

            <div class="aroundme_item main_item">
                <img class="aroundme_item_image" src="{{url('img/profile_pic_default.jpg')}}">
                <div class="aroundme_item_right aroundme_item_name">Amber Heard</div>
                <div class="aroundme_item_right aroundme_item_detail">
                    <div class="aroundme_item_school">student at NYU</div>
                    <div class="aroundme_item_age">27 years</div>
                    <div class="aroundme_item_country">United Kingdom</div>
                </div>
                <div class="aroundme_item_right aroundme_item_intro">Lorem ipsum dolor sit amet, consectetur adipiscing elit sed.</div>
            </div>

        </section>

        <section class="sidebar chat">
            <h3 class="sidebar_title">Chat</h3>

            <!-- nu placeholders, later loopen we hier chat items uit en vullen we de juiste zaken in uit de database -->
            <div class="chat_item sidebar_item">
                <img class="chat_item_image" src="{{url('img/profile_pic_default.jpg')}}">
                <div class="chat_item_name">Amber Heard</div>
                <div class="chat_item_text">Lorem ipsum dolor sit amet, consectetur adipiscing elit sed.</div>
            </div>

            <div class="chat_item sidebar_item">
                <img class="chat_item_image" src="{{url('img/profile_pic_default.jpg')}}">
                <div class="chat_item_name">Amber Heard</div>
                <div class="chat_item_text">Lorem ipsum dolor sit amet, consectetur adipiscing elit sed.</div>
            </div>

            <div class="chat_item sidebar_item">
                <img class="chat_item_image" src="{{url('img/profile_pic_default.jpg')}}">
                <div class="chat_item_name">Amber Heard</div>
                <div class="chat_item_text">Lorem ipsum dolor sit amet, consectetur adipiscing elit sed.</div>
            </div>
        </section>

    </div>

    <footer>

    </footer>

</body>
</html>