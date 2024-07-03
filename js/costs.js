$(function() {
    let prepare = {
        "@context": "https://schema.org",
        "@type": "FAQPage",
        "mainEntity": []
    }

    var faq_items = document.getElementsByClassName("faq");
    if(faq_items.length > 0) {
        for (var i = 0; i < faq_items.length; i++) {
            let question = faq_items.item(i).children[0].textContent.trim();
            let answer = faq_items.item(i).children[2].textContent.trim();
            prepare.mainEntity.push({
                "@type": "Question",
                "name": question,
                "acceptedAnswer": [{
                    "@type": "Answer",
                    "text": answer
                }]
            });
        }

        let script = document.createElement("script");
        script.type = "application/ld+json";
        script.innerHTML = JSON.stringify(prepare);
        document.head.appendChild(script);
    }

    $('.table-of-contents a[href*=#]:not([href=#])').click(function() {
        var sticky_header_height = document.getElementById('sticky-costheader').clientHeight;

        if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
            if (target.length) {

                $('html,body').animate({ scrollTop: target.offset().top+1-sticky_header_height }, 500);

                return false;
            }
        }
    });
    $('.table-of-contents-main a[href*=#]:not([href=#])').click(function() {
        var sticky_header_height = document.getElementById('sticky-costheader').clientHeight;

        if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
            if (target.length) {

                $('html,body').animate({ scrollTop: target.offset().top+1-sticky_header_height }, 500);

                return false;
            }
        }
    });

    /* CALCULATE DISTANCE FROM TABLE OF CONTENTS TO 20PX BELOW THE STICKY HEADER */
    var sticky_header_height = document.getElementById('sticky-costheader').clientHeight;
    var top_to_contents = $('.table-of-contents').offset().top-20;

    var table_of_contents = function(){

        /* CURRENT SCROLL DISTANCE FROM TOP OF PAGE PLUS HEIGHT OF STICKY HEADER */
        var scroll_top = $(window).scrollTop() + sticky_header_height;

        /* CALCULATE MAX-HEIGHT OF THE SCROLLABLE DIV WITHIN THE TABLE OF CONTENTS */
        var m = $(window).height(); /* SCREEN HEIGHT */
        var n = document.getElementById('toc-h2-height').clientHeight; /* HEIGHT OF H2 IN TABLE OF CONTENTS */
        var max_toc_height = m-n-40-sticky_header_height; /* CALCULATION - SCREEN HEIGHT MINUS H2 HEIGHT, MINUS THE HEIGHT OF THE STICKY HEADER, AND MINUS 40PX SO WE CAN HAVE 20PX MARGIN TOP AND BOTTOM. */
        $('.table-of-contents div').css('max-height',max_toc_height); /* APPLY THE MAX-HEIGHT */

        /* CALCULATE POINT AT WHICH TABLE OF CONTENTS SHOULD STOP SCROLLING */
        var y = document.getElementById('toc-height').clientHeight; /* HEIGHT OF TABLE OF CONTENTS */
        var a = $('.mjq-newhome.cost-guides-v2 .about-container.main-cost').offset().top; /* DISTANCE FROM TOP OF MAIN CONTENT DIV */
        var b = document.getElementById('main-cost-height').clientHeight; /* HEIGHT OF MAIN CONTENT DIV */
        var stop_scroll = a + b - y; /* CALCULATION - DISTANCE TO THE TOP OF TABLE OF CONTENTS FROM THE TOP OF PAGE THAT WE SHOULD STOP THE FIXED BEHAVIOUR */

        var z = document.getElementById('sidebar-width').clientWidth; /* TO BE USED TO KEEP THE WIDTH THE SAME WHEN TABLE OF CONTENTS BECOMES FIXED */

        if ((scroll_top > top_to_contents ) ){
            if ((scroll_top + 20 < stop_scroll ) ){
                $('.table-of-contents').css('position','fixed');
                $('.table-of-contents').css('top',sticky_header_height+20);
                $('.table-of-contents').css('width',z);
            }
            else {
                $('.table-of-contents').css('position','absolute');
                $('.table-of-contents').css('top',stop_scroll-a);
                $('.table-of-contents').css('width',z);
            }
        } else {
            $('.table-of-contents').css('position','static');
        }
    };

    table_of_contents();

    $(window).scroll(function() {
        table_of_contents();
    });

    var cost_header = function(){
        var current_distance_fromtop = $(window).scrollTop();
        var top_to_postajob = $('.cost-sidebar .postajob').offset().top;
        var postajob_height = document.getElementById('postajob-sidebar-height').clientHeight;
        var sticky_start = top_to_postajob + postajob_height;
        var screen_width = $(window).width();


        if ((screen_width < 1000 ) ){
            if ((current_distance_fromtop > 200 ) ){
                $('.sticky-cost-header-bar').css('top','0');
            } else {
                $('.sticky-cost-header-bar').css('top','-100%');
            }
        }

        else {
            if ( $('.mjq-newhome.cost-guides-v2').hasClass('one-column') ) {
                if ((current_distance_fromtop > 200 ) ){
                    $('.sticky-cost-header-bar').css('top','0');
                } else {
                    $('.sticky-cost-header-bar').css('top','-100%');
                }
            }
            else {
                if ((current_distance_fromtop > sticky_start ) ){
                    $('.sticky-cost-header-bar').css('top','0');
                } else {
                    $('.sticky-cost-header-bar').css('top','-100%');
                }
            }
        }
    };

    cost_header();

    $(window).scroll(function() {
        cost_header();
    });
});