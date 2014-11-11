$(document).ready(function(){

	var headertitle = $('header .title');
	var headerdesc = $('header .desc');
	var headerHeight = 400;
	var revealBarZoneDelay = 50;
	var mobilewidth = 760;

	// top bar and revealbar control
	controlTopBar();
	controlRevealBar(headerHeight+revealBarZoneDelay);

	// Trigger calls for alignHeaderElements and characterLimiter for edit page
	alignHeaderElements(headerHeight);
	setTimeout(alignHeaderElements(headerHeight),100);
	$(window).resize(function() { alignHeaderElements(headerHeight); });
	$(window).scroll(function(event) {
		var winwidth = $(window).width();
		if (winwidth > mobilewidth){ scrollAlign($(this)); }
	});

	$(document).on('click','.postblock',function(){
		var postid = $(this).attr('id');
		var type = $(this).attr('type');
		window.location = "/"+type+"/"+postid;
	});

	// tooltip posttime
	$(document).on('mouseenter', '.posttime', function(){ $(this).tooltip('show'); });

	/* Top button clicked */
	$('.topButton').click(function(){
		console.log("*");
		$("html, body").animate({ 'scrollTop':0 }, 500, function(){
		});
	});
	/* Reveal button clicked */
	$('.revButton').click(function(){
		var scrolltop = $(window).scrollTop();
		var pagereveal = 400;
		if(scrolltop == 0){ $("html, body").animate({ 'scrollTop':pagereveal }, 500, function(){}); }
		else{ $("html, body").animate({ 'scrollTop':0 }, 500, function(){}); }
	});

	/* Reveal button alignment */
	$(window).scroll(function(){
		var scrolltop = $(window).scrollTop();
		if (scrolltop > 0){ $('.revButton').addClass('rotated'); }
		else{ $('.revButton').removeClass('rotated'); }
	});

	function increaseLike(){ $('.esclike_text').text(parseInt($('.esclike_text').text())+1); }
	function decreaseLike(){ $('.esclike_text').text(parseInt($('.esclike_text').text())-1); }
	function increaseDislike(){ $('.escdislike_text').text(parseInt($('.escdislike_text').text())+1); }
	function decreaseDislike(){ $('.escdislike_text').text(parseInt($('.escdislike_text').text())-1); }
	function decreaseThis(elem){
		
	}

	/* VOTE */
	$('.esclikedislike').click(function(){
		var entryid = $(this).attr('id');
		var clicked = "";
		if (!$(this).hasClass('voted')){
			if ($(this).hasClass('esclike')){
				clicked = "like";
				if ($('.escdislike').hasClass('voted')){
					decreaseDislike();
					clicked = "like_removedislike";
				}
				increaseLike();
			}
			else if ($(this).hasClass('escdislike')){
				clicked = "dislike";
				if ($('.esclike').hasClass('voted')){
					decreaseLike()
					clicked = "dislike_removelike";
				}
				increaseDislike();
			}
			$('.esclikedislike').removeClass('voted');
			$(this).addClass('voted');
		}
		else{
			$(this).removeClass('voted');
			if ($(this).hasClass('esclike')){
				decreaseLike();
				clicked = "removelike";
			}
			else if ($(this).hasClass('escdislike')){
				decreaseDislike();
				clicked = "removedislike";
			}
		}
		console.log("*"+clicked+"*");
		$.ajax({
				type: "POST",
				url: "/ajax/public/entryvote",
				data: { 'entryid':entryid, 'vote':clicked },
				async: false,
				success: function(msg){
					var splitted = msg.split(':');
					if (splitted[0] == "E"){
						var n = noty({
							layout: 'center',
							text: splitted[1],
							type: 'error',
							dismissQueue: true,
							timeout: 2000,
							closeWith: ['button'],
							template: '<div class="noty_message"><span class="noty_text"></span><div class="noty_close"></div></div>'
						});
					}
					else if (splitted[0] == "S"){ }
					else if (splitted[0] == "I"){ }

						console.log(msg);

				}
			});

	});


	/* PUBLISH */
	$('.publishbutton').click(function(){
		var entryid = $(this).attr('id');
		if (entryid){
			$.ajax({
				type: "POST",
				url: "/ajax/public/entrypublisher",
				data: { 'entryid':entryid },
				async: false,
				success: function(msg){
					var splitted = msg.split(':');
					if (splitted[0] == "E"){
						var n = noty({
							layout: 'center',
							text: splitted[1],
							type: 'error',
							dismissQueue: true,
							timeout: 2000,
							closeWith: ['button'],
							template: '<div class="noty_message"><span class="noty_text"></span><div class="noty_close"></div></div>'
						});
					}
					else if (splitted[0] == "S"){
						var n = noty({
							layout: 'center',
							text: splitted[1],
							type: 'success',
							dismissQueue: true,
							timeout: false,
							closeWith: ['button'],
							template: '<div class="noty_message"><span class="noty_text"></span><div class="noty_close"></div></div>'
						});
						setTimeout(function(){ location.reload(); },1500);
					}
					else if (splitted[0] == "I"){
						var n = noty({
							layout: 'center',
							text: splitted[2],
							type: 'success',
							dismissQueue: true,
							timeout: false,
							closeWith: ['button'],
							template: '<div class="noty_message"><span class="noty_text"></span><div class="noty_close"></div></div>'
						});
						setTimeout(function(){ location.reload(); },1500);
					}
				}
			});
}
else{
	var n = noty({
		layout: 'center',
		text: "Lütfen yazınızı yayımlamadan önce kaydediniz.",
		type: 'error',
		dismissQueue: true,
		timeout: 2000,
		closeWith: ['button'],
		template: '<div class="noty_message"><span class="noty_text"></span><div class="noty_close"></div></div>'
	});
}
});



/* UNPUBLISH */
$('.unpublishbutton').click(function(){
	var entryid = $(this).attr('id');
	if (entryid){
		$.ajax({
			type: "POST",
			url: "/ajax/public/entryunpublisher",
			data: { 'entryid':entryid },
			async: false,
			success: function(msg){
				console.log(msg);
				var splitted = msg.split(':');
				if (splitted[0] == "E"){
					var n = noty({
						layout: 'center',
						text: splitted[1],
						type: 'error',
						dismissQueue: true,
						timeout: 2000,
						closeWith: ['button'],
						template: '<div class="noty_message"><span class="noty_text"></span><div class="noty_close"></div></div>'
					});
				}
				else if (splitted[0] == "S"){
					var n = noty({
						layout: 'center',
						text: splitted[1],
						type: 'success',
						dismissQueue: true,
						timeout: false,
						closeWith: ['button'],
						template: '<div class="noty_message"><span class="noty_text"></span><div class="noty_close"></div></div>'
					});
					setTimeout(function(){ location.reload(); },1500);
				}
				else if (splitted[0] == "I"){
					var n = noty({
						layout: 'center',
						text: splitted[2],
						type: 'success',
						dismissQueue: true,
						timeout: false,
						closeWith: ['button'],
						template: '<div class="noty_message"><span class="noty_text"></span><div class="noty_close"></div></div>'
					});
					setTimeout(function(){ location.reload(); },1500);
				}
			}
		});
}
else{
	var n = noty({
		layout: 'center',
		text: "Bilinmeyen bir hata oluştu.",
		type: 'error',
		dismissQueue: true,
		timeout: 2000,
		closeWith: ['button'],
		template: '<div class="noty_message"><span class="noty_text"></span><div class="noty_close"></div></div>'
	});
}
});

});

