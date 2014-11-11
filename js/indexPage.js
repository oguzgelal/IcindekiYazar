$(document).ready(function(){

	var currentPost = 0;
	var loadNew = 6;

	loadStacks();
	loadEntries("latest", "card", "any", currentPost, loadNew, "mainstack");

	var id;
	$(window).resize(function(){
		clearTimeout(id);
		id = setTimeout(function(){
			var currenthtmlcontent = "";
			$('.stackscontainer').find('.mainstack').each(function(){ currenthtmlcontent += $(this).html(); });
			loadStacks();
			distributeData(currenthtmlcontent, "mainstack");
			console.log("*");
		}, 500);
	});

	$(document).on('click', '.loadmorebutton', function(){
		var prevhtml = $('.loadmore').html();
		$('.loadmore').html("<img src='/app/img/loader_black.gif' class='loadmore_loader' style='margin-top:20px; width:20px; height:auto;'>");
		currentPost += loadNew;
		var returned = loadEntries("latest", "card", "any", currentPost, loadNew, "mainstack");
		
		returned.done(function(msg){
			$('.loadmore').html(prevhtml);
			if (msg.length <= 0){
				$('.loadmorebutton').attr('disabled', 'disabled');
				$('.loadmorebutton').text("Son...");
			}
		});
	});


});

function loadStacks(){
	var winwidth = $(document).width();
	var mincolsize = 350;
	var numcols = Math.floor(winwidth/mincolsize);
	var widthpercent = Math.floor(100/numcols);
	var stackhtml = "<div class='stack mainstack' style='width:"+widthpercent+"%;'></div>";
	$('.stackscontainer').html("");
	for(var i = 0; i < numcols; i++){
		$('.stackscontainer').append(stackhtml);	
	}
}