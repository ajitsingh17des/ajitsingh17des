
//search

$(".showsearch").click(function(){
  $(".full-search-panel .wrapper").addClass("active_bg");
  $(this).css("display", "none");
  $(".full-search-panel .search-data").fadeIn(500);
  $(".full-search-panel .closesearch").fadeIn(500);
  $(".full-search-panel .search-data .line").addClass("active");
  setTimeout(function(){
    $(".full-search-panel input").focus();
    $(".full-search-panel .search-data label").fadeIn(500);
    $(".full-search-panel .search-data span").fadeIn(500);
  }, 800);
});

$(".full-search-panel .closesearch").click(function(){
  $(".full-search-panel .wrapper").removeClass("active_bg");
  $(".full-search-panel .search-btn").fadeIn(800);
  $(".full-search-panel .search-data").fadeOut(500);
  $(".full-search-panel .closesearch").fadeOut(500);
  $(".full-search-panel .search-data .line").removeClass("active");
  $(".full-search-panel input").val("");
  $(".full-search-panel .search-data label").fadeOut(500);
  $(".full-search-panel .search-data span").fadeOut(500);
});


//navigation
$('.closesearch1').click(function () {
  $('.closesearch1').toggleClass('clicked');
 

$('.notification').toggleClass('hide');

});

$('.menu, .overlay').click(function () {
  $('.menu').toggleClass('clicked');
  
    $('.sideMenu').toggleClass('show');
    $('body').toggleClass('add1');
  
  });



  $('.pro-grm').click(function () {
    $('.menu1').toggleClass('clicked');
    
      $('.sideMenu1').toggleClass('show');
      $('body').toggleClass('add2');
      $('body').removeClass('add3');
      $('body').removeClass('add4');
      $('.sideMenu2').removeClass('show');
      $('.sideMenu3').removeClass('show');
    
    });

    $('.add-miss').click(function () {
      $('.menu1').toggleClass('clicked');
      
        $('.sideMenu2').toggleClass('show');
        $('body').toggleClass('add3');
        $('body').removeClass('add2');
        $('body').removeClass('add4');
        $('.sideMenu1').removeClass('show');
        $('.sideMenu3').removeClass('show');
      
      });

      $('.life-reva').click(function () {
        $('.menu1').toggleClass('clicked');
        
          $('.sideMenu3').toggleClass('show');
          $('body').toggleClass('add4');
          $('body').removeClass('add3');
          $('body').removeClass('add2');
          $('.sideMenu2').removeClass('show');
          $('.sideMenu1').removeClass('show');
        
        });


  

$('.placement-logo').owlCarousel({
  loop:true,
  items:3,
  margin:0,
  dots:false,
  nav:false,
  autoplay:true,   
  //smartSpeed: 2000, 
  autoplayTimeout:3500,
  responsive:{
      0:{
          items:2
      },
      600:{
          items:3
      },
      1000:{
          items:3
      }
  }
})


$('.home-research').owlCarousel({
  loop:true,
  items:3,
  margin:30,
  dots:false,
  nav:true,
  autoplay:true,   
  //smartSpeed: 2000, 
  autoplayTimeout:3500,
  responsive:{
      0:{
          items:1
      },
      600:{
          items:1
      },
      1000:{
          items:3
      }
  }
})





$('.mobile-happening-slider').owlCarousel({
  loop:true,
  items:1,
  margin:30,
  dots:false,
  nav:true,
  autoplay:true,   
  //smartSpeed: 2000, 
  autoplayTimeout:3500,
  responsive:{
      0:{
          items:1
      },
      600:{
          items:1
      },
      1000:{
          items:1
      }
  }
})

$('.life-academic2-slider').owlCarousel({
  loop:true,
  items:1,
  margin:0,
  dots:false,
  nav:true,
  autoplay:true,   
  //smartSpeed: 2000, 
  autoplayTimeout:3500,
  responsive:{
      0:{
          items:1
      },
      600:{
          items:1
      },
      1000:{
          items:1
      }
  }
})



$('.ece-study-slider').owlCarousel({
  loop:true,
  items:1,
  margin:0,
  dots:false,
  nav:true,
  autoplay:true,   
  //smartSpeed: 2000, 
  autoplayTimeout:3500,
  responsive:{
      0:{
          items:1
      },
      600:{
          items:1
      },
      1000:{
          items:1
      }
  }
})

$('.international-tie-up-slider').owlCarousel({
  loop:true,
  items:4,
  margin:30,
  dots:false,
  nav:true,
  autoplay:true,   
  //smartSpeed: 2000, 
  autoplayTimeout:3500,
  responsive:{
      0:{
          items:2
      },
      600:{
          items:3
      },
      1000:{
          items:4
      }
  }
})

$('.ece-faculties-slider').owlCarousel({
  loop:true,
  items:2,
  margin:20,
  dots:false,
  nav:true,
  autoplay:true,   
  //smartSpeed: 2000, 
  autoplayTimeout:3500,
  responsive:{
      0:{
          items:2
      },
      600:{
          items:2
      },
      1000:{
          items:2
      }
  }
})

$('.career-testimonial-slider').owlCarousel({
  loop:true,
  items:1,
  margin:0,
  dots:false,
  nav:true,
  autoplay:true,   
  //smartSpeed: 2000, 
  autoplayTimeout:3500,
  responsive:{
      0:{
          items:1
      },
      600:{
          items:1
      },
      1000:{
          items:1
      }
  }
})


$('.partner-slider').owlCarousel({
  loop:true,
  items:6,
  margin:20,
  dots:false,
  nav:true,
  autoplay:true,   
  //smartSpeed: 2000, 
  autoplayTimeout:3500,
  responsive:{
      0:{
          items:3
      },
      600:{
          items:3
      },
      1000:{
          items:6
      }
  }
})


$('.interslider').owlCarousel({
  loop:true,
  items:1,
  margin:20,
  dots:false,
  nav:true,
  autoplay:true,   
  //smartSpeed: 2000, 
  autoplayTimeout:3500,
  responsive:{
      0:{
          items:1
      },
      600:{
          items:1
      },
      1000:{
          items:1
      }
  }
})


  $(window).on('scroll', function () {
    if ($(window).scrollTop() > 10) {
      $('.home-panel1').addClass('fixed');
    } else {
      $('.home-panel1').removeClass('fixed');
    }
  });

  
  
  AOS.init({

    duration: 1200,
  

  })




    // Init WOW.js and get instance
    //WOW.prototype.addBox = function(element) {
    //  this.boxes.push(element);
     // };
      // Init WOW.js and get instance
      //var wow = new WOW();
      //wow.init();
      


      
      $( document ).ready(function() {

        // Carousel
      
        $(".carousel").carousel({
            interval: 3000,
            pause: true
        });
      
      
       // swipe start
      
        $(".carousel").swipe({
            swipe: function (event, direction, distance, duration, fingerCount, fingerData) {
                if (direction == 'left') $(this).carousel('next');
                if (direction == 'right') $(this).carousel('prev');
            },
            allowPageScroll: "vertical" 
        });
      
      // swipe end 
      
      });



      

      $(document).ready(function(){
        $(".career-current-opening .col-md-4").slice(0, 6).show();
        $("#loadMore").on("click", function(e){
          e.preventDefault();
          $(".career-current-opening .col-md-4:hidden").slice(0, 6).slideDown();
          if($(".career-current-opening .col-md-4:hidden").length == 0) {
            $("#loadMore").text("No Content").addClass("noContent");
          }
        });
        
  

  $('.notices-link').click(function () {
  $('.mobile-notice-panel').toggleClass('show');
  $('.close-btn').removeClass('show');
  });
  $('.close-btn').click(function () {
  $('.mobile-notice-panel').removeClass('show');
  })

  $('.course-list-section h1').click(function () {
    $('.courselist-menu').toggleClass('show');
    $('.close-btn').removeClass('show');
    });
    $('.close-btn').click(function () {
    $('.courselist-menu').removeClass('show');
    })



});


// search courses


function filterFunction(that, event) {
  let container, input, filter, li, input_val;
  container = $(that).closest(".searchable");
  input_val = container.find("input").val().toUpperCase();

  if (["ArrowDown", "ArrowUp", "Enter"].indexOf(event.key) != -1) {
      keyControl(event, container)
  } else {
      li = container.find("ul li");
      li.each(function (i, obj) {
          if ($(this).text().toUpperCase().indexOf(input_val) > -1) {
              $(this).show();
          } else {
              $(this).hide();
          }
      });

      container.find("ul li").removeClass("selected");
      setTimeout(function () {
          container.find("ul li:visible").first().addClass("selected");
      }, 100)
  }
}

function keyControl(e, container) {
  if (e.key == "ArrowDown") {

      if (container.find("ul li").hasClass("selected")) {
          if (container.find("ul li:visible").index(container.find("ul li.selected")) + 1 < container.find("ul li:visible").length) {
              container.find("ul li.selected").removeClass("selected").nextAll().not('[style*="display: none"]').first().addClass("selected");
          }

      } else {
          container.find("ul li:first-child").addClass("selected");
      }

  } else if (e.key == "ArrowUp") {

      if (container.find("ul li:visible").index(container.find("ul li.selected")) > 0) {
          container.find("ul li.selected").removeClass("selected").prevAll().not('[style*="display: none"]').first().addClass("selected");
      }
  } else if (e.key == "Enter") {
      container.find("input").val(container.find("ul li.selected").text()).blur();
      onSelect(container.find("ul li.selected").text())
  }

  container.find("ul li.selected")[0].scrollIntoView({
      behavior: "smooth",
  });
}



$(".searchable input").focus(function () {
  $(this).closest(".searchable").find("ul").show();
  $(this).closest(".searchable").find("ul li").show();
});
$(".searchable input").blur(function () {
  let that = this;
  setTimeout(function () {
      $(that).closest(".searchable").find("ul").hide();
  }, 300);
});

$(document).on('click', '.searchable ul li', function () {
  $(this).closest(".searchable").find("input").val($(this).text()).blur();
  onSelect($(this).text())
});

$(".searchable ul li").hover(function () {
  $(this).closest(".searchable").find("ul li.selected").removeClass("selected");
  $(this).addClass("selected");
});




//mobile menu js



$(document).ready(function() {
  $("#accordian a").click(function() {
      var link = $(this);
      var closest_ul = link.closest("ul");
      var parallel_active_links = closest_ul.find(".active")
      var closest_li = link.closest("li");
      var link_status = closest_li.hasClass("active");
      var count = 0;

      closest_ul.find("ul").slideUp(function() {
          if (++count == closest_ul.find("ul").length)
              parallel_active_links.removeClass("active");
      });

      if (!link_status) {
          closest_li.children("ul").slideDown();
          closest_li.addClass("active");
      }
  })
})

// search full page


 $( document ).ready(function() {

        // Carousel

        $(".carousel").carousel({
            interval: 3000,
            pause: true
        });


       // swipe start

        $(".carousel").swipe({
            swipe: function (event, direction, distance, duration, fingerCount, fingerData) {
                if (direction == 'left') $(this).carousel('next');
                if (direction == 'right') $(this).carousel('prev');
            },
            allowPageScroll: "vertical"
        });

      // swipe end

      });




      !(function($) {
      	"use strict";
      	var a = {
      		accordionOn: ["xs"]
      	};
      	$.fn.responsiveTabs = function(e) {
      		var t = $.extend({}, a, e),
      			s = "";
      		return (
      			$.each(t.accordionOn, function(a, e) {
      				s += " accordion-" + e;
      			}),
      			this.each(function() {
      				var a = $(this),
      					e = a.find("> li > a"),
      					t = $(e.first().attr("href")).parent(".tab-content"),
      					i = t.children(".tab-pane");
      				a.add(t).wrapAll('<div class="responsive-tabs-container" />');
      				var n = a.parent(".responsive-tabs-container");
      				n.addClass(s),
      					e.each(function(a) {
      						var t = $(this),
      							s = t.attr("href"),
      							i = "",
      							n = "",
      							r = "";
      						t.parent("li").hasClass("active") && (i = " active"),
      							0 === a && (n = " first"),
      							a === e.length - 1 && (r = " last"),
      							t
      								.clone(!1)
      								.addClass("accordion-link" + i + n + r)
      								.insertBefore(s);
      					});
      				var r = t.children(".accordion-link");
      				e.on("click", function(a) {
      					a.preventDefault();
      					var e = $(this),
      						s = e.parent("li"),
      						n = s.siblings("li"),
      						c = e.attr("href"),
      						l = t.children('a[href="' + c + '"]');
      					s.hasClass("active") ||
      						(s.addClass("active"),
      						n.removeClass("active"),
      						i.removeClass("active"),
      						$(c).addClass("active"),
      						r.removeClass("active"),
      						l.addClass("active"));
      				}),
      					r.on("click", function(t) {
      						t.preventDefault();
      						var s = $(this),
      							n = s.attr("href"),
      							c = a.find('li > a[href="' + n + '"]').parent("li");
      						s.hasClass("active") ||
      							(r.removeClass("active"),
      							s.addClass("active"),
      							i.removeClass("active"),
      							$(n).addClass("active"),
      							e.parent("li").removeClass("active"),
      							c.addClass("active"));
      					});
      			})
      		);
      	};
      })(jQuery);

      $(".responsive-tabs").responsiveTabs({
      	accordionOn: ["xs", "sm"]
      });




      $(window).scroll(function(){
    if($(window).scrollTop() > 500){
        $(".course_overView").addClass("fixed2")
        }else{
         $(".course_overView").removeClass("fixed2")
    }

})