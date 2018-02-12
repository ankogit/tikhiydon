$(document).ready(function() {
var slides = $(".place_for_slider #slider").children(".single_slide");
for (j=0;j<slides.length;j++) {
	if (j==0) {
		    $(".place_for_slider .navigation").append("<div class='dot active'></div>");
	}
	else
		{
		    $(".place_for_slider .navigation").append("<div class='dot'></div>");
	}
}

var dots = $(".place_for_slider .navigation").children(".dot");
var i=0;

$(".place_for_slider .navigation .dot").click(function() {
	reset();
	$(".place_for_slider  .navigation .active").removeClass("active");
	$(this).addClass("active");
	i=$(this).index();
	slides[i].style.opacity='1';
		for (z=0; z<slides.length;z++) {
			if (z!=i) { slides[z].style.opacity='0'; }
		}
});


$(".place_for_slider #nab .navposl").click(function next() {
	reset();
	var k=$(".place_for_slider .navigation .active").index();
	slides[k].style.opacity='0';
	$(".place_for_slider .navigation .active").removeClass("active");
		if (k==3) {
	$(dots[0]).addClass("active");
	slides[0].style.opacity='1';
		}
		else { 
	$(dots[++k]).addClass("active");
	slides[k++].style.opacity='1';
		}
});


$(".place_for_slider #nab .navpred").click(function() {
	reset();
	var k=$(".place_for_slider .navigation .active").index();
	slides[k].style.opacity='0';
	$(".place_for_slider .navigation .active").removeClass("active");
		if (k==0) {
	$(dots[3]).addClass("active");
	slides[3].style.opacity='1';
		}
		else {
	$(dots[--k]).addClass("active");
	slides[k--].style.opacity='1';
		}
});


});


/* 11111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111 */


var interval=false;
function next() {
	var slides=$(".place_for_slider #slider").children(".single_slide");
	var dots = $(".place_for_slider .navigation").children(".dot");
	var k=$(".place_for_slider .navigation .active").index();
	slides[k].style.opacity='0';
	$(".place_for_slider .navigation .active").removeClass("active");
		if (k==3) {
	$(dots[0]).addClass("active");
	slides[0].style.opacity='1';
		}
		else { 
	$(dots[++k]).addClass("active");
	slides[k++].style.opacity='1';
		}

}

function reset() {
function startInterval(){
if(interval) {
	stopInterval();
	}
	interval=setInterval(next,20000);
}

function stopInterval() {
if(interval) {
clearInterval(interval);
}
interval=false;
}
startInterval();
}

interval=setInterval(next,20000);


			
			
				