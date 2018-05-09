<div id="header_wrapper">

    <div id="map" style="position:absolute !important; height:290px;width:100%;"></div>
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
            <h1 class="location_city">{{isset($location) ? $location->city : "no location found"}}</h1>
            <div class="location_label"><i class="fas fa-location-arrow"></i> current location</div>
        </div>
    </header>
</div>