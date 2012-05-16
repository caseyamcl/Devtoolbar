
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

        //Variables
        devbar_started          = false;
        devbar_stageleft_pos    = 0;
        devbar_stagecenter_pos  = 0;
        devbar_slide_value      = 0;

        //Initialize
        start();

        //
        // Detail toggle
        //
        $('#devtoolbar > ul > li.tool').click(function() {
            //Get the current tool
            var currTool = $(this).attr('class').split(' ')[1];

            if ($('#devtoolbar #detailpane .' + currTool).is(':visible')) {
                hideDetails();
            }
            else {
                showDetails(currTool);
            }
        });

        //
        // Close
        //
        $('#devtoolbar li.close').click(function() {

            $('#devtoolbar, #devtoolbarbg').slideToggle('slow', function() {
                $('#devtoolbar, #devtoolbarbg').remove();
            });
        });

        //
        // Hide
        //
        $('#devtoolbar li.hide').click(function() {
            hideToolbar();
        });

        //
        // Show
        //
        $('#devtoolbar').on('click', 'li.show', function() {
            showToolbar();
        });

    });

    function start() {

        //Only run this once
        if (devbar_started == true) {
            return;
        }

        //Update positions
        setColors();
        updatePositions();

        //Add the background
        $('#devtoolbar').before("<div id='devtoolbarbg'> </div>");
        $('#devtoolbar, #devtoolbarbg').slideToggle('slow');
        updateToolbarListItemHeights();
    }

    function setColors() {
        $('#devtoolbar > ul > li.tool').each(function(k, v) {
            
            var colors = new Array(
                '660000', '666600', '663300', '336600'
            );

            if (typeof(colors[k]) != undefined) {
                var color = '#' + colors[k];
            }
            else {
                //Find the highest number its divisible with...
                var color = '#' + colors[k];
            }
            
            $(v).css('border-top-color', color);
            $(v).find('.indicator').css('color', color);

        });        
    }

    function updatePositions() {
        devbar_stagecenter_pos = ($(document).width() - $('#devtoolbar').outerWidth()) / 2;
        devbar_stageleft_pos   = 0 - $('#devtoolbar').outerWidth();
        devbar_slide_value = devbar_stagecenter_pos + $('#devtoolbar').outerWidth(); 

        if ($('#devtoolbar').hasClass('stageleft')) {
            $('#devtoolbar, #devtoolbarbg').css('margin-left', devbar_stageleft_pos);
        }
        else {
            $('#devtoolbar, #devtoolbarbg').css('margin-left', devbar_stagecenter_pos);            
        }
    }

    function showDetails(whichTool) {

        var detailItemElem = '#devtoolbar #detailpane .' + whichTool;
        var listItemElem = "#devtoolbar > ul > li.tool." + whichTool;

        //Make details visible and other details not visible
        $(detailItemElem).siblings().hide();
        $(detailItemElem).show();

        //Make border color match the tool color
        $('#devtoolbar #detailpane').css('border-top-color', $(listItemElem).css('border-top-color'));

        //Make tool list item border a generic color
        $(listItemElem).css('border-top-color', 'transparent');

        //Add active class
        $(listItemElem).addClass('active');
        $(listItemElem).siblings().removeClass('active');

        //Rest other tool item border color
        $(listItemElem).siblings().each(function(k,v) {
            $(v).css('border-top-color', $(v).find('.indicator').css('color'));
        });

        if ($('#devtoolbar #detailpane').is(':hidden')) {
            $('#devtoolbar #detailpane').slideToggle('slow');
        }
    }

    function hideDetails() {

        //Slide detail pane down
        if ($('#devtoolbar #detailpane').is(':visible')) {
            $('#devtoolbar #detailpane').slideToggle('slow');
        }

        //Reset border color on current border
        $('#devtoolbar > ul > li.tool.active').css('border-top-color', $('#devtoolbar > ul > li.tool.active').find('.indicator').css('color'));

        //Make all list items inactive
        $('#devtoolbar > ul > li.tool').removeClass('active');
    }

    function hideToolbar() {

        hideDetails();

        $('#devtoolbar, #devtoolbarbg').animate(
            { left: '-=' + devbar_slide_value }, 
            1000, function() {

            if ($(this).attr('id') == 'devtoolbar') {
                $('#devtoolbar > ul').append("<li class='show'>&raquo;</li>");
                updateToolbarListItemHeights();
            }   
        });
    }

    function showToolbar() {
        $('#devtoolbar > ul > li.show').remove();
        $('#devtoolbar, #devtoolbarbg').animate(
            { left: '+=' + devbar_slide_value },
            1000
        );
    }

    function updateToolbarListItemHeights() {
        $('#devtoolbar > ul > li').height($('#devtoolbar > ul > li.tool').height());
    }
}