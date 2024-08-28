(function () {
	"use strict";

	var slideMenu = $('.side-menu');

	// Toggle Sidebar
	$(document).on('click', '[data-bs-toggle="sidebar"]', function (event) {
		event.preventDefault();
		$('.app').toggleClass('sidenav-toggled');
	});
    
    responsive();


	var toggleSidebar = function () {
		var w = $(window);
		if (w.outerWidth() <= 1024) {
			$("body").addClass("sidebar-gone");
			$(document).off("click", "body").on("click", "body", function (e) {
				if ($(e.target).hasClass('sidebar-show') || $(e.target).hasClass('search-show')) {
					$("body").removeClass("sidebar-show");
					$("body").addClass("sidebar-gone");
					$("body").removeClass("search-show");
				}
			});
		} else {
			$("body").removeClass("sidebar-gone");
		}
	}
	toggleSidebar();
	$(window).resize(toggleSidebar);

	//p-scroll
	const ps1 = new PerfectScrollbar('.app-sidebar', {
		useBothWheelAxes: true,
		suppressScrollX: true,
	});



	//sticky-header
	$(window).on("scroll", function (e) {
		if ($(window).scrollTop() >= 70) {
			$('.main-header').addClass('fixed-header');
			$('.main-header').addClass('visible-title');
		}
		else {
			$('.main-header').removeClass('fixed-header');
			$('.main-header').removeClass('visible-title');
		}
	});
})();
function responsive() {
    if (window.innerWidth >= 992) {
        if (document.querySelector("body").classList.contains("sidenav-toggled") && document.querySelector("body").classList.contains("horizontal")) {
            document.querySelector("body").classList.remove("sidenav-toggled")
        }
    }
}

function hovermenu() {

	$(".app-sidebar").hover(function () {
		if ($('.app').hasClass('sidenav-toggled')) {
			$('.app').addClass('sidenav-toggled-open');
		}
	}, function () {
		if ($('.app').hasClass('sidenav-toggled')) {
			$('.app').removeClass('sidenav-toggled-open');
		}
	});
}

// ______________ICON-TEXT JS start
function icontext() {
	$(".app-sidebar").off("mouseenter mouseleave");

	$(document).on('click', ".app-sidebar", function (event) {
		if ($('body').hasClass('sidenav-toggled') == true) {
			$('body').addClass('sidenav-toggled-open');
		}
	});

	$(document).on('click', ".main-content", function (event) {
		$('body').removeClass('sidenav-toggled-open');
	});
}

//________________Horizontal js
jQuery(function () {
	'use strict';
	document.addEventListener("touchstart", function () { }, false);
	jQuery(function () {
		jQuery('body').wrapInner('<div class="horizontalMenucontainer" />');
	});
}());

// To remove expanded menu on click 'body'
$(document).on('click', '.horizontal-content', function () {
    if (window.innerWidth >= 992) {
        $(".app-sidebar li a").each(function () {
            $(this).next().slideUp(300, function () {
                $(this).next().removeClass('open');
            });
            $(this).parent("li").removeClass("is-expanded");
        })
    }
})



// ______________Active Class
var position = window.location.pathname.split('/');
$(".app-sidebar li a").each(function () {
	var $this = $(this);
	var pageUrl = $this.attr("href");

	if (pageUrl) {
        if (position[position.length - 1] == pageUrl) {
            $(this).addClass("active");
			$(this).parent().addClass("is-expanded");
			$(this).parent().parent().prev().addClass("active");
			$(this).parent().parent().addClass("open");
			$(this).parent().parent().prev().addClass("is-expanded");
			$(this).parent().parent().parent().addClass("is-expanded");
			$(this).parent().parent().parent().parent().addClass("open");
			$(this).parent().parent().parent().parent().prev().addClass("active");
			$(this).parent().parent().parent().parent().parent().addClass("is-expanded");
			return false;
		}
	}
});
if ($('.slide-item').hasClass('active')) {
	$('.app-sidebar').animate({
		scrollTop: $('a.slide-item.active').offset().top - 600
	}, 600);
}
if ($('.sub-side-menu__item').hasClass('active')) {
	$('.app-sidebar').animate({
		scrollTop: $('a.sub-side-menu__item.active').offset().top - 600
	}, 600);
}


let slideLeft = document.querySelector(".slide-left");
let slideRight = document.querySelector(".slide-right");
slideLeft.addEventListener("click", () => {
    slideClick()
}, true)
slideRight.addEventListener("click", () => { slideClick() }, true)

// used to remove is-expanded class and remove class on clicking arrow buttons
function slideClick() {
    let slide = document.querySelectorAll(".slide");
    let slideMenu = document.querySelectorAll(".slide-menu");
    slide.forEach((element, index) => {
        if (element.classList.contains("is-expanded") == true) {
            element.classList.remove("is-expanded")
        }
    });
    slideMenu.forEach((element, index) => {
        if (element.classList.contains("open") == true) {
            element.classList.remove("open");
            element.style.display = "none";
        }
    });
}

// horizontal arrows
var sideMenu = $(".side-menu");
var slide = "100px";
let prevWidth = [window.innerWidth]

let menuWidth = document.querySelector('.horizontal-main')
let menuItems = document.querySelector('.side-menu')

$(window).resize(
    () => {
        let menuWidth = document.querySelector('.horizontal-main');
        let menuItems = document.querySelector('.side-menu');
        let mainSidemenuWidth = document.querySelector('.main-sidemenu');
        let menuContainerWidth = menuWidth?.offsetWidth - mainSidemenuWidth?.offsetWidth;
        let marginLeftValue = Math.ceil(window.getComputedStyle(menuItems).marginLeft.split('px')[0]);
        let marginRightValue = Math.ceil(window.getComputedStyle(menuItems).marginRight.split('px')[0]);
        let check = menuItems.scrollWidth + (0 - menuWidth?.offsetWidth) + menuContainerWidth;
        // to check and adjst the menu on screen size change
        if ($('body').hasClass('ltr')) {
            if (marginLeftValue > -check == false && (menuWidth?.offsetWidth - menuContainerWidth) < menuItems.scrollWidth) {
                sideMenu.stop(false, true).animate({
                    marginLeft: -check
                }, {
                    duration: 400
                })
            }
            else {
                sideMenu.stop(false, true).animate({
                    marginLeft: 0
                }, {
                    duration: 400
                })
            }
        }
        else {
            if (marginRightValue > -check == false && menuWidth?.offsetWidth < menuItems.scrollWidth) {
                sideMenu.stop(false, true).animate({
                    marginRight: -check
                }, {
                    duration: 400
                })
            }
            else {
                sideMenu.stop(false, true).animate({
                    marginRight: 0
                }, {
                    duration: 400
                })
            }
        }
        checkHoriMenu();
        responsive();
        HorizontalHovermenu();


        prevWidth.push(window.innerWidth)
        if(prevWidth.length > 3){
            prevWidth.shift()
        }
        let prevValue = prevWidth[prevWidth.length-2];
        if (window.innerWidth >= 992 && prevValue < 992) {
			if (document.querySelector('body').classList.contains('horizontal')) {
				var animationSpeed = 300;
				// first level
				var parent = $("[data-bs-toggle='sub-slide']").parents('ul');
                var ul = parent.find('ul:visible').slideUp(animationSpeed);
                ul.removeClass('open');
                var parent1 = $("[data-bs-toggle='sub-slide2']").parents('ul');
                var ul1 = parent1.find('ul:visible').slideUp(animationSpeed);
                ul1.removeClass('open');
			}
		}
		else {
			ActiveSubmenu()
		}
    }
)

function ActiveSubmenu(){

    var position = window.location.pathname.split('/');
    $(".side-menu li a").each(function () {
        var $this = $(this);
        var pageUrl = $this.attr("href");
        setTimeout(() => {
            if (window.innerWidth < 992 || document.querySelector('body').classList.contains('horizontal') != true){
                if (pageUrl) {
                    if (position[position.length - 1] == pageUrl) {
                        $(this).addClass("active");
                        $(this).parent().addClass("is-expanded");
                        $(this).parent().parent().prev().addClass("active");
                        $(this).parent().parent().addClass("open");
                        $(this).parent().parent().prev().addClass("is-expanded");
                        $(this).parent().parent().parent().addClass("is-expanded");
                        $(this).parent().parent().parent().parent().addClass("open");
                        $(this).parent().parent().parent().parent().prev().addClass("active");
                        $(this).parent().parent().parent().parent().parent().addClass("is-expanded");
                        $(this).next().slideDown(300, function () {});
                        $(this).parent().parent().slideDown(300, function (){
                            $(this).parent().parent().addClass("open");
                        });
                        $(this).parent().parent().parent().parent().slideDown(300, function (){
                            $(this).parent().parent().parent().parent().addClass("open");
                        });
                        return false;
                    }
                }
            } 
        }, 100); 
    });
}

function checkHoriMenu() {

    let menuWidth = document.querySelector('.horizontal-main')
    let menuItems = document.querySelector('.side-menu')
    let mainSidemenuWidth = document.querySelector('.main-sidemenu')
    let menuContainerWidth = menuWidth?.offsetWidth - mainSidemenuWidth?.offsetWidth
    let marginLeftValue = Math.ceil(window.getComputedStyle(menuItems).marginLeft.split('px')[0]);
    let marginRightValue = Math.ceil(window.getComputedStyle(menuItems).marginRight.split('px')[0]);
    let check = menuItems.scrollWidth + (0 - menuWidth?.offsetWidth) + menuContainerWidth;

    if ($('body').hasClass('ltr')) {
        menuItems.style.marginRight = 0
    }
    else {
        menuItems.style.marginLeft = 0;
    }

    setTimeout(()=>{
        if (menuItems.scrollWidth - 2 < (menuWidth?.offsetWidth - menuContainerWidth)) {
            $("#slide-right").addClass("d-none");
            $("#slide-left").addClass("d-none");
        }
        else if (marginLeftValue != 0) {
            $("#slide-left").removeClass("d-none");
        }
        else if (marginLeftValue != -check) {
            $("#slide-right").removeClass("d-none");
        }
        else if (marginRightValue != 0) {
            $("#slide-left").removeClass("d-none");
        }
        else if (marginRightValue != -check) {
            $("#slide-right").removeClass("d-none");
        }
        
        if(marginLeftValue == 0 || marginRightValue == 0){
            $("#slide-left").addClass("d-none");
            $("#slide-right").removeClass("d-none");
        }
    },200)
    
}
checkHoriMenu();
$(document).on("click", ".ltr #slide-left", function () {
    let menuWidth = document.querySelector('.horizontal-main')
    let menuItems = document.querySelector('.side-menu')
    let mainSidemenuWidth = document.querySelector('.main-sidemenu')
    let menuContainerWidth = menuWidth?.offsetWidth - mainSidemenuWidth?.offsetWidth
    let marginLeftValue = Math.ceil(window.getComputedStyle(menuItems).marginLeft.split('px')[0]) + 100;

    if (marginLeftValue < 0) {
        sideMenu.stop(false, true).animate({
            // marginRight : 0,
            marginLeft: "+=" + slide
        }, {
            duration: 400
        })
        if ((menuWidth?.offsetWidth - menuContainerWidth) < menuItems.scrollWidth) {
            $("#slide-right").removeClass("d-none");
        }
    }
    else {
        $("#slide-left").addClass("d-none");
    }

    if (marginLeftValue >= 0) {
        sideMenu.stop(false, true).animate({
            // marginRight : 0,
            marginLeft: 0
        }, {
            duration: 400
        })

        if (menuWidth?.offsetWidth < menuItems.scrollWidth) {
            // $("#slide-left").addClass("d-none");
        }
    }
    // to remove dropdown when clicking arrows in horizontal menu
    let subNavSub = document.querySelectorAll('.sub-nav-sub');
    subNavSub.forEach((e) => {
        e.style.display = '';
    })
    let subNav = document.querySelectorAll('.nav-sub')
    subNav.forEach((e) => {
        e.style.display = '';
    })
    //
});
$(document).on("click", ".ltr #slide-right", function () {
    let menuWidth = document.querySelector('.app-sidebar')
    let menuItems = document.querySelector('.side-menu')
    let mainSidemenuWidth = document.querySelector('.main-sidemenu')
    let menuContainerWidth = menuWidth?.offsetWidth - mainSidemenuWidth?.offsetWidth
    let marginLeftValue = Math.ceil(window.getComputedStyle(menuItems).marginLeft.split('px')[0]) - 100;
    let check = menuItems.scrollWidth + (0 - menuWidth?.offsetWidth) + menuContainerWidth;
    if (marginLeftValue > -check) {
        sideMenu.stop(false, true).animate({
            // marginLeft : 0,
            marginLeft: "-=" + slide,
            marginRight: 0,
        }, {
            duration: 400
        })
    }
    else {
        sideMenu.stop(false, true).animate({
            // marginLeft : 0,
            marginRight: 0,
            marginLeft: -check
        }, {
            duration: 400
        });

        $("#slide-right").addClass("d-none");
    }
    if (marginLeftValue != 0) {
        $("#slide-left").removeClass("d-none");
    }
    // to remove dropdown when clicking arrows in horizontal menu
    let subNavSub = document.querySelectorAll('.sub-nav-sub');
    subNavSub.forEach((e) => {
        e.style.display = '';
    })
    let subNav = document.querySelectorAll('.nav-sub')
    subNav.forEach((e) => {
        e.style.display = '';
    })
    //
});

$(document).on("click", ".rtl #slide-left", function () {
    let menuWidth = document.querySelector('.horizontal-main')
    let menuItems = document.querySelector('.side-menu')
    let mainSidemenuWidth = document.querySelector('.main-sidemenu')
    let menuContainerWidth = menuWidth?.offsetWidth - mainSidemenuWidth?.offsetWidth
    let marginRightValue = Math.ceil(window.getComputedStyle(menuItems).marginRight.split('px')[0]) + 100;

    if (marginRightValue < 0) {
        sideMenu.stop(false, true).animate({
            // marginRight : 0,
            marginLeft: 0,
            marginRight: "+=" + slide
        }, {
            duration: 400
        })
        if ((menuWidth?.offsetWidth - menuContainerWidth) < menuItems.scrollWidth) {
            $("#slide-right").removeClass("d-none");
        }
    }
    else {
        $("#slide-left").addClass("d-none");
    }

    if (marginRightValue >= 0) {
        $("#slide-left").addClass("d-none");
        sideMenu.stop(false, true).animate({
            // marginRight : 0,
            marginLeft: 0
        }, {
            duration: 400
        })
    }
    // to remove dropdown when clicking arrows in horizontal menu
    let subNavSub = document.querySelectorAll('.sub-nav-sub');
    subNavSub.forEach((e) => {
        e.style.display = '';
    })
    let subNav = document.querySelectorAll('.nav-sub')
    subNav.forEach((e) => {
        e.style.display = '';
    })
    //
});
$(document).on("click", ".rtl #slide-right", function () {
    let menuWidth = document.querySelector('.app-sidebar')
    let menuItems = document.querySelector('.side-menu')
    let mainSidemenuWidth = document.querySelector('.main-sidemenu')
    let menuContainerWidth = menuWidth?.offsetWidth - mainSidemenuWidth?.offsetWidth
    let marginRightValue = Math.ceil(window.getComputedStyle(menuItems).marginRight.split('px')[0]) - 100;
    let check = menuItems.scrollWidth + (0 - menuWidth?.offsetWidth) + menuContainerWidth;
    if (marginRightValue > -check) {
        sideMenu.stop(false, true).animate({
            // marginLeft : 0,
            marginLeft: 0,
            marginRight: "-=" + slide
        }, {
            duration: 400
        })

    }
    else {
        sideMenu.stop(false, true).animate({
            // marginLeft : 0,
            marginLeft: 0,
            marginRight: -check
        }, {
            duration: 400
        })
        $("#slide-right").addClass("d-none");
    }

    if (marginRightValue != 0) {
        $("#slide-left").removeClass("d-none");
    }
    // to remove dropdown when clicking arrows in horizontal menu
    let subNavSub = document.querySelectorAll('.sub-nav-sub');
    subNavSub.forEach((e) => {
        e.style.display = '';
    })
    let subNav = document.querySelectorAll('.nav-sub')
    subNav.forEach((e) => {
        e.style.display = '';
    })
});

	
function menuClick() {	
	$("[data-bs-toggle='slide']").off('click');	
	$("[data-bs-toggle='sub-slide']").off('click')	
	$("[data-bs-toggle='sub-slide2']").off('click')	
	$("[data-bs-toggle='slide']").on('click', function (e) {	
		var $this = $(this);	
		var checkElement = $this.next();	
		var animationSpeed = 300,	
			slideMenuSelector = '.slide-menu';	
		if (checkElement.is(slideMenuSelector) && checkElement.is(':visible')) {	
			checkElement.slideUp(animationSpeed, function () {	
				checkElement.removeClass('open');	
			});	
			checkElement.parent("li").removeClass("is-expanded");	
		}	
		else if ((checkElement.is(slideMenuSelector)) && (!checkElement.is(':visible'))) {	
			var parent = $this.parents('ul').first();	
			var ul = parent.find('ul:visible').slideUp(animationSpeed);	
			ul.removeClass('open');	
			var parent_li = $this.parent("li");	
			checkElement.slideDown(animationSpeed, function () {	
				checkElement.addClass('open');	
				parent.find('li.is-expanded').removeClass('is-expanded');	
				parent_li.addClass('is-expanded');	
			});	
		}	
		if (checkElement.is(slideMenuSelector)) {	
			e.preventDefault();	
		}	
	});	
	// Activate sidebar slide toggle	
	$("[data-bs-toggle='sub-slide']").on('click', function (e) {	
		var $this = $(this);	
		var checkElement = $this.next();	
		var animationSpeed = 300,	
			slideMenuSelector = '.sub-slide-menu';	
		if (checkElement.is(slideMenuSelector) && checkElement.is(':visible')) {	
			checkElement.slideUp(animationSpeed, function () {	
				checkElement.removeClass('open');	
			});	
			checkElement.parent("li").removeClass("is-expanded");	
		}	
		else if ((checkElement.is(slideMenuSelector)) && (!checkElement.is(':visible'))) {	
			var parent = $this.parents('ul').first();	
			var ul = parent.find('ul:visible').slideUp(animationSpeed);	
			ul.removeClass('open');	
			var parent_li = $this.parent("li");	
			checkElement.slideDown(animationSpeed, function () {	
				checkElement.addClass('open');	
				parent.find('li.is-expanded').removeClass('is-expanded');	
				parent_li.addClass('is-expanded');	
			});	
		}	
		if (checkElement.is(slideMenuSelector)) {	
			e.preventDefault();	
		}	
	});	
	// Activate sidebar slide toggle	
	$("[data-bs-toggle='sub-slide2']").on('click', function (e) {	
		var $this = $(this);	
		var checkElement = $this.next();	
		var animationSpeed = 300,	
			slideMenuSelector = '.sub-slide-menu1';	
		if (checkElement.is(slideMenuSelector) && checkElement.is(':visible')) {	
			checkElement.slideUp(animationSpeed, function () {	
				checkElement.removeClass('open');	
			});	
			checkElement.parent("li").removeClass("is-expanded");	
		}	
		else if ((checkElement.is(slideMenuSelector)) && (!checkElement.is(':visible'))) {	
			var parent = $this.parents('ul').first();	
			var ul = parent.find('ul:visible').slideUp(animationSpeed);	
			ul.removeClass('open');	
			var parent_li = $this.parent("li");	
			checkElement.slideDown(animationSpeed, function () {	
				checkElement.addClass('open');	
				parent.find('li.is-expanded').removeClass('is-expanded');	
				parent_li.addClass('is-expanded');	
			});	
		}	
		if (checkElement.is(slideMenuSelector)) {	
			e.preventDefault();	
		}	
	});	
}	
function HorizontalHovermenu() {	
	let value = document.querySelector('body').classList.contains('horizontal-hover')	
	if (value && window.innerWidth >= 992) {	
		$("[data-bs-toggle='slide']").off('click');	
		$("[data-bs-toggle='sub-slide']").off('click')	
		$("[data-bs-toggle='sub-slide2']").off('click')	
		slideClick()	
	}	
	else {	
		menuClick();	
	}	
}	
HorizontalHovermenu();	
// for Icon-text Menu	
//icontext(); 	
// default layout	
hovermenu();