

    <div class="map-top">

        <div class="map-top-img">
            <div id="map" style="position:absolute !important; height:290px;width:100%;"></div>
        </div>

        <div class="search-bar">

            <div class="searchContainer">
                <div class="searchBox">
                    <i class="fa fa-search searchIcon"></i>
                    <input class="searchBox_inner" type="search" name="search" placeholder="search for users">
                </div>

                <input type="submit" value="" class="searchButton">

            </div>

            <div class="searchButtonOptions hidden">
                <div class="searchButtonOptionRadius">
                    <h6>radius</h6>
                    <div class="radiusSliderContainer">
                        <input type="range" min="1" max="9" value="9" class="slider radiusSlider" id="radiusSlider">
                    </div>
                    <div id="selectedRadius">{{($myUser->setting->distance == 'km') ? '100 km' : '60 miles'}}</div>
                </div>
                <div class="searchButtonOptionInterests">
                    <h6>interests</h6>
                    <ul>
                        <li class="interest-item selected">chinese food</li>
                        <li class="interest-item selected">tennis</li>
                        <li class="interest-item">beer</li>
                        <li class="interest-item">foreign languages</li>
                        <li class="interest-item selected">movies</li>
                        <li class="interest-item">dance music</li>
                        <li class="interest-item">video games</li>
                    </ul>
                </div>
            </div>

        </div>

    </div>