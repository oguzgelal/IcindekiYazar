$(document).ready(function(){

	var uid = $('body').attr('id');
	var currentPost_pub = 0;
	var loadNew_pub = 3;
	var currentPost_unpub = 0;
	var loadNew_unpub = 3;
	
	loadUserEntries(uid, "latest", "card", "any", currentPost_pub, loadNew_pub, "userstack#published", "published");
	loadUserEntries(uid, "latest", "card", "any", currentPost_unpub, loadNew_unpub, "userstack#unpublished", "unpublished");

	$(document).on('click', '.loadmorebutton#published', function(){
		var prevhtml = $('.loadmore#published').html();
		$('.loadmore#published').html("<img src='/app/img/loader_black.gif' class='loadmore_loader' style='margin-top:20px; width:20px; height:auto;'>");
		currentPost_pub += loadNew_pub;
		var returned = loadUserEntries(uid, "latest", "card", "any", currentPost_pub, loadNew_pub, "userstack#published", "published");
		
		returned.done(function(msg){
			$('.loadmore').html(prevhtml);
			if (msg.length <= 0){
				$('.loadmorebutton#published').attr('disabled', 'disabled');
				$('.loadmorebutton#published').text("Son...");
			}
		});
	});

	$(document).on('click', '.loadmorebutton#unpublished', function(){
		var prevhtml = $('.loadmore#unpublished').html();
		$('.loadmore#unpublished').html("<img src='/app/img/loader_black.gif' class='loadmore_loader' style='margin-top:20px; width:20px; height:auto;'>");
		currentPost_unpub += loadNew_unpub;
		var returned = loadUserEntries(uid, "latest", "card", "any", currentPost_unpub, loadNew_unpub, "userstack#unpublished", "unpublished");
		
		returned.done(function(msg){
			$('.loadmore#unpublished').html(prevhtml);
			if (msg.length <= 0){
				$('.loadmorebutton#unpublished').attr('disabled', 'disabled');
				$('.loadmorebutton#unpublished').text("Son...");
			}
		});
	});

});