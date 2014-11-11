function controlTopBar(){
	var topbar = $('.topbar');
	var lastScrollTop = 0;
	if(!topbar.hasClass('locked')){
		$(window).scroll(function(event){
			var st = $(this).scrollTop();
			if (st <= 0){ if (!topbar.is(':visible')){ topbar.slideDown('fast'); } }
			else{
				if (st > lastScrollTop){ if (topbar.is(':visible')){ topbar.slideUp('fast'); } }
				else { if (!topbar.is(':visible')){ topbar.slideDown('fast'); } }
				lastScrollTop = st;
			}
		});
	}
}

// visible on essay mode
function controlRevealBar(startHeight){
	var revealbar = $('.revealbar');
	$(window).scroll(function(event){
		var st = $(this).scrollTop();
		if (st >= startHeight){
			if (!revealbar.is(':visible')){ revealbar.slideDown('fast'); }
		}
		else{
			if (revealbar.is(':visible')){ revealbar.slideUp('fast'); }
		}
	});
}


function alignHeaderElements(headerHeight){
	
	// header container top position
	var hc = $('.headercontainer');
	var hcheight = hc.height();
	var margintop = (headerHeight-hcheight)/2;
	hc.attr("style", "top: "+margintop+"px;");
	var windowsize = $(window).width();

	// title font size
	var headertitle = $('header .title');
	var habertitlelength = headertitle.text().length;
	var initfontsize = 50;
	var minfontsize = 15;
	var fontsize = Math.ceil(initfontsize-(habertitlelength/(windowsize/100)));
	fontsize = (fontsize <= minfontsize) ? minfontsize : fontsize;
	headertitle.css('font-size', fontsize+'px');
	headertitle.css('line-height', fontsize+'px');

	// desc font size
	var headerdesc = $('header .desc');
	var haberdesclength = headerdesc.text().length;
	var initfontsize = 18;
	var minfontsize = 12;
	var fontsize = Math.ceil(initfontsize-(haberdesclength/(windowsize/10)));
	fontsize = (fontsize <= minfontsize) ? minfontsize : fontsize;
	headerdesc.css('font-size', fontsize+'px');
	headerdesc.css('line-height', fontsize+'px');
}

function characterLimiter(ths, max, e){
	if($(ths).text().length > max-1) {
		if (e!=null){ e.preventDefault(); }
		$(ths).text($(ths).text().substring(0,max));
	}
}

function updateHeaderHeight(win){
	var headerHeightConst = 400;
	var headerHeight = 400;
	var sctop = win.scrollTop();
	var diff = headerHeightConst-sctop;
	if (diff < 0){ diff = 0; }
	else if (diff > headerHeightConst){ diff = headerHeightConst; }
	return diff;
}

function scrollAlign(win){
	var headerHeightConst = 400;
	headerHeight = updateHeaderHeight(win);
	if (headerHeight!=0){ alignHeaderElements(headerHeight); }
	var opacity = headerHeight/headerHeightConst;
	$('header .title').css("color", "rgba(255,255,255,"+opacity+")");
	$('header .desc').css("color", "rgba(255,255,255,"+opacity+")");
}