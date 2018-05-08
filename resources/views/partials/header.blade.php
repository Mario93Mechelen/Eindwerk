<div id="header_wrapper">
    <header>
        <nav>
            <ul>
                <li><a href="#">SEMESTR</a></li>
                <li><a href="#" class="active">around me</a></li>
                <li><a href="#">crossings</a></li>
                <li><a href="#">settings</a></li>
                <li class="nav_profile"><a href="#">{{$myUser->avatar}}</a></li>
            </ul>
        </nav>

        <div class="location">
            <h1 class="location_city">{{$location ? $location->city : "no location found"}}</h1>
            <div class="location_label">current location</div>
        </div>
    </header>
</div>