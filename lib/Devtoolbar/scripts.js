
//Load Jquery if undefined
if (typeof jQuery === "undefined") {
    var script_tag = document.createElement('script');
    script_tag.setAttribute("type","text/javascript");
    script_tag.setAttribute("src", "http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js")
    script_tag.onload = devtoolbar; // Run main() once jQuery has loaded
    script_tag.onreadystatechange = function() { // Same thing but for IE
      if (this.readyState == 'complete' || this.readyState == 'loaded') main();
    }
    document.getElementsByTagName("head")[0].appendChild(script_tag);
} else {
    devtoolbar();
}

function devtoolbar() {
    $('document').ready(function() {

        //
        // Position and Display
        //
        fixBarPosition();
        $('#devtoolbar, #devtoolbarbg').slideToggle();
        $(window).resize(fixBarPosition);

        //
        // Bar Top Colors
        //
        $('#devtoolbar > ul > li').each(function(k, v) {
            
            $(v).css('border-top-color', 'blue');
        });
    });

    function fixBarPosition() {
        var window_width = $(document).width();
        var bar_width = $('#devtoolbar').outerWidth();
        var horizMargin = (window_width - bar_width) / 2;
        $('#devtoolbarbg').width($('#devtoolbar').outerWidth() - 13).height($('#devtoolbar').outerHeight());
        $('#devtoolbar, #devtoolbarbg').css('margin-left', horizMargin);
    }    
}