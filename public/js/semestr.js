<!-- toggle list & grid view -->
$(document).ready(function() {
    $('#products .item').addClass('list-view');
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

<!-- show selected radius filter -->
$(document).ready(function() {
    $("#radiusSlider").change(function() {
        $("#selectedRadius").html($("#radiusSlider").val() + "km");
    });
});

<!-- interest item selection -->
$(document).ready(function() {
    $(".interest-item").click(function() {
        $(this).toggleClass("selected");
    });
});