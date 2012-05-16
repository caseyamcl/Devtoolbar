
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
        devbar_started = false;

        //Initialize
        start();

        // --------------------------------------------------------------

        //
        // Detail Toggle Action 
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
        // Close or Show Action (depending on context)
        //
        $('#devtoolbar li.close').click(function() {

            if ($('#devtoolbar').hasClass('stageleft')) {
                showToolbar();
            }
            else {
                $('#devtoolbar').slideToggle('slow', function() {
                    $('#devtoolbar').remove();
                });
            }
        });

        //
        // Hide Action
        //
        $('#devtoolbar li.hide').click(function() {
            hideToolbar();
        });
    });

    // --------------------------------------------------------------

    function start() {

        //Only run this once
        if (devbar_started == true) {
            return;
        }

        //Update positions
        setColors();

        //Toggle it on
        $('#devtoolbar').slideToggle('slow');

        //Fix the detail pane width
        $('#devtoolbar #detailpane').width($('#devtoolbar').innerWidth());

    }

    // --------------------------------------------------------------

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

    // --------------------------------------------------------------

   function showDetails(whichTool) {

        var detailItemElem = '#devtoolbar #detailpane .' + whichTool;
        var listItemElem = "#devtoolbar > ul > li.tool." + whichTool;

        //Make details visible and other details not visible
        $(detailItemElem).siblings().hide();
        $(detailItemElem).show();

        //Make border color match the tool color
        $('#devtoolbar #detailpane').css('border-top-color', $(listItemElem).css('border-top-color'));

        //Make tool list item border a generic color
        $(listItemElem).css({
            'border-top-color':   'transparent',
            'border-left-color':  $(listItemElem).css('border-top-color'),
            'border-right-color': $(listItemElem).css('border-top-color')
        });

        //Add active class
        $(listItemElem).addClass('active');
        $(listItemElem).siblings().removeClass('active').css({
            'border-left-color':  '#CCC',
            'border-right-color': '#CCC'            
        });

        //Rest other tool item border color
        $(listItemElem).siblings().each(function(k,v) {
            $(v).css('border-top-color', $(v).find('.indicator').css('color'));
        });

        if ($('#devtoolbar #detailpane').is(':hidden')) {
            $('#devtoolbar #detailpane').slideToggle('slow');
        }
    }

    // --------------------------------------------------------------

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

    // --------------------------------------------------------------

    function hideToolbar() {

        hideDetails();

        $('#devtoolbar').animate(
            { left: '-=98%' }, 
            1000, function() {

                $('#devtoolbar').addClass('stageleft');
        });
    }

    // --------------------------------------------------------------

    function showToolbar() {
        $('#devtoolbar > ul > li.show').remove();
        $('#devtoolbar').animate(
            { left: '+=98%' },
            1000, function() {
                $('#devtoolbar').removeClass('stageleft');
        });
    }
}