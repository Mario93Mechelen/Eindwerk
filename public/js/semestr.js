<!-- toggle list & grid view -->
$(document).ready(function() {
    $('#list').click(function(event){event.preventDefault();$('.item').addClass('item-list col-xs-12 col-md-6').removeClass('item-grid col-xs-6 col-md-3');$('#list').addClass('toggle-active');$('#grid').removeClass('toggle-active');});
    $('#grid').click(function(event){event.preventDefault();$('.item').addClass('item-grid col-xs-6 col-md-3').removeClass('item-list col-xs-12 col-md-6');$('#list').removeClass('toggle-active');$('#grid').addClass('toggle-active');});
    $('#list').click(function() {

    });
});

<!-- hide search filter value when mobile -->
$(document).ready(function() {
    if(window.innerWidth < 768) {
        $(".searchButton").prop('value', '');
    } else {
        $(".searchButton").prop('value', 'search filters');
    }
});

window.onresize = function() {
    if(window.innerWidth < 768) {
        $(".searchButton").prop('value', '');
    } else {
        $(".searchButton").prop('value', 'search filters');
    }
};

<!-- show/hide dropdown menus -->
$(document).ready(function() {
    $( "#nav_chat" ).click(function() {
        $("#dropdown-menu-chat").toggle();
        $("#dropdown-menu-profile").hide();
        $( "#nav_chat" ).toggleClass("highlighted");
        $( "#nav_profile" ).removeClass("highlighted");
    });
    $( "#nav_profile" ).click(function() {
        $("#dropdown-menu-profile").toggle();
        $("#dropdown-menu-chat").hide();
        $( "#nav_profile" ).toggleClass("highlighted");
        $( "#nav_chat" ).removeClass("highlighted");
    });
});

$(document).mouseup(function (e){

    var container = $("#nav_profile");
    if (!container.is(e.target) && container.has(e.target).length === 0){
        $("#dropdown-menu-profile").hide();
        $( "#nav_profile" ).removeClass("highlighted");
    }

    var container2 = $("#nav_chat");
    if (!container2.is(e.target) && container2.has(e.target).length === 0){
        $("#dropdown-menu-chat").hide();
        $( "#nav_chat" ).removeClass("highlighted");
    }
});

<!-- toggle search filter -->
$(document).ready(function() {
    $(".searchButton").click(function() {
        $(".searchButtonOptions").toggleClass("hidden");
        $(".searchButton").toggleClass("searchButtonRadiusFix");
        $(".searchBox").toggleClass("searchBoxRadiusFix");

    });
});

/* later nog te bekijken, door absolute positioning van de searchButtonOptions div, pakt het click event daar niet op */
/*
$(document).mouseup(function (e){
    var container1 = $(".searchButton");
    var container2 = $(".searchButtonOptions");
    if (!container1.is(e.target) && !container2.is(e.target) && container1.has(e.target).length === 0){
        container2.addClass("hidden");
    }

    if(container2.is(e.target)) {
        console.log("klikkk");
    }
});
*/


<!-- interest item selection -->
$(document).ready(function() {
    $(".interest-item").click(function() {
        $(this).toggleClass("selected");
    });
});

<!-- toggle crossings map and button on profile page -->
$(document).ready(function() {
    $(".crossings-location-button-wrapper").click(function() {
        $(this).toggleClass("hidden");
        $(".crossings-hide-map-button-wrapper").toggleClass("hidden");
        $(".crossings_map").toggleClass("hidden");
    });
    $(".crossings-hide-map-button-wrapper").click(function() {
        $(this).toggleClass("hidden");
        $(".crossings-location-button-wrapper").toggleClass("hidden");
        $(".crossings_map").toggleClass("hidden");
    });

});

<!-- mobile switch between chat list and detail -->
$(document).ready(function() {
    $(".chat_to_detail").click(function(e) {
        e.preventDefault();
        $('.chat-detail').animate({left: "-100vw"}, 1000 );
    });
    $(".chat_to_list").click(function(e) {
        e.preventDefault();
        $('.chat-detail').animate({left: "0vw"}, 1000 );
    });
});

<!-- hide send message button in chat when no input in textarea -->
$(document).keyup(function (e) {

    if ($(".new_message").val()) {
        $(".send_message").show();
    }
});

<!-- keep mobile screen on chat detail on submitting of message -->
$(document).ready(function() {
    if ($(document).width() < 768) {
        $(".new_message_form").on('submit', function(e) {
            e.preventDefault();
            $('.chat-detail').css('left', "-100vw");
            $('.new_message').val('');
            console.log("woehoe");
            });
    }
});


<!-- script voor locatiebepalingen -->
$(document).ready(function(){
    var longitude;
    var latitude;
    var functionamount = 0;

    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            alert("Geolocation is not supported by this browser.");
        }
    }
    function showPosition(position) {
        latitude = position.coords.latitude;
        longitude = position.coords.longitude;
        console.log(latitude+":"+longitude)
        storeLocation(latitude, longitude, functionamount);
        functionamount++;
    }

    getLocation();
    window.setInterval(getLocation, 300000);

    function storeLocation(latitude,longitude,f){
        $.ajaxSetup({

            headers: {

                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),

            }

        });
        $.ajax({
            method:"POST",
            url:"/location/store",
            data:{
                'longitude': longitude,
                'latitude': latitude,
                'amount': f,
            }
        }).done(function(response){
            if(response.code==200) {
                if(response.res != "no results found") {
                    console.log(response.res.results[0].address_components[2].long_name);
                    $('.location_city').html(response.res.results[0].address_components[2].long_name);
                }else{
                    $('.location_city').html("seems like we couldn't find your location");
                }
            }
        });
    }
})