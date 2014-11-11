$(document).ready(function(){

	var currentbg = $('#currentheaderimg').val();

	var headertitle = $('header .title');
	var headerdesc = $('header .desc');
	var headerHeight = 400;
	var revealBarZoneDelay = 50;
	var headertitle_defaulttext = "Başlık giriniz...";
	var headerdesc_defaulttext = "Açıklama giriniz...";
	var maxTitle = 250;
	var maxDesc = 600;

	$(window).scroll(function(event){
		headerHeight = updateHeaderHeight($(this));
	});

	// Vars
	if (headertitle.text()==""){ headertitle.text(headertitle_defaulttext); }
	if (headerdesc.text()==""){ headerdesc.text(headerdesc_defaulttext); }

	// Trigger calls for alignHeaderElements and characterLimiter for edit page
	$(window).keydown(function() { alignHeaderElements(headerHeight); });
	headertitle.keypress(function(e) {
		if ($(this).attr('contenteditable')){
			alignHeaderElements(headerHeight);
			characterLimiter($(this), 250, e);
		}
	});
	headerdesc.keypress(function(e) {
		if ($(this).attr('contenteditable')){
			alignHeaderElements(headerHeight);
			characterLimiter($(this), 600, e);
		}
	});
	headertitle.focusout(function(){ characterLimiter($(this), maxTitle, null); alignHeaderElements(headerHeight); });
	headerdesc.focusout(function(){ characterLimiter($(this), maxDesc, null); alignHeaderElements(headerHeight); });
	
	// placeHolder effect
	headertitle.focus(function(){ if ($(this).text()==headertitle_defaulttext){ $(this).text(""); } });
	headerdesc.focus(function(){ if ($(this).text()==headerdesc_defaulttext){ $(this).text(""); } });
	headertitle.focusout(function(){ 
		if ($(this).text() == ""){ $(this).text(headertitle_defaulttext); }
		$(this).text($(this).text().replace(/(\r\n|\n|\r)/gm,""));
		alignHeaderElements(headerHeight);
	});
	headerdesc.focusout(function(){
		if ($(this).text() == ""){ $(this).text(headerdesc_defaulttext); }
		$(this).text($(this).text().replace(/(\r\n|\n|\r)/gm,""));
		alignHeaderElements(headerHeight);
	});

	// Header bg change
	$(document).on("click", ".imgbutton", function(){
		currentbg = $(this).find('img').attr('src');
		updateHeaderBg(currentbg);
	});

	// Add new image
	$('.addnewimagebutton').click(function(){
		noty({
			text: "<input type='text' class='imgurl form-control' placeholder='Eklemek istediğiniz resmin linkini girin...'>",
			layout: 'center',
			buttons: [
			{
				addClass: 'btn btn-success',
				text: 'Ekle',
				onClick: function($noty) {
					var imgurl = $('.imgurl').val();
					var ext_parts = imgurl.split(".");
					var ext = $.trim(ext_parts[ext_parts.length-1].toLowerCase());
					if (ext!="jpg" && ext!="jpeg" && ext!="png" && ext!="bmp" && ext!="tiff"){
						$noty.close();
						noty({text: 'Girdiğiniz resim formata uygun değil.', type: 'error', layout: 'center'});
					}
					else{
						currentbg = imgurl;
						var imgiconhtml = "<li class='imgbutton'><img src='"+currentbg+"'></li>";
						$('.headerimgs ul').prepend(imgiconhtml);
						updateHeaderBg(currentbg);
						$noty.close();
					}
				}
			},
			{
				addClass: 'btn btn-danger',
				text: 'İptal',
				onClick: function($noty) { $noty.close(); }
			}]
		});

	});
	
	/* SAVE */
	$('.savebutton').click(function(){
		saveEntry(function(msg){
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
					timeout: 2000,
					closeWith: ['button'],
					template: '<div class="noty_message"><span class="noty_text"></span><div class="noty_close"></div></div>'
				});
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
				setTimeout(function(){ window.location = "/edit/"+splitted[1]; },1500);
			}
		});
});
/* UPDATE */
$('.updatebutton').click(function(){
	updateEntry(function(msg){
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
				timeout: 2000,
				closeWith: ['button'],
				template: '<div class="noty_message"><span class="noty_text"></span><div class="noty_close"></div></div>'
			});
		}
		else if (splitted[0] == "I"){
			var n = noty({
				layout: 'center',
				text: splitted[2],
				type: 'success',
				dismissQueue: true,
				timeout: 2000,
				closeWith: ['button'],
				template: '<div class="noty_message"><span class="noty_text"></span><div class="noty_close"></div></div>'
			});
		}
	});
});
/* PREVIEV - unsaved */
$('.previewbutton.prevsave').click(function(){
	saveEntry(function(msg){
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
		if (splitted[0] == "I"){
			window.location = "/essay/"+splitted[1];
		}
	});
});
/* PREVIEV - saved */
$('.previewbutton.prevupdate').click(function(){
	var pid = $('body').attr('id');
	updateEntry(function(msg){
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
		else if (splitted[0] == "S" || splitted[0] == "I"){
			window.location = "/essay/"+pid;
		}
	});
});



function saveEntry(completefn){
	var title = headertitle.text();
	var desc = headerdesc.text();
	var htmlcontent = CKEDITOR.instances.ckeditor.getData();
	var image = currentbg;
	$.ajax({
		type: "POST",
		url: "/ajax/public/essaysaver",
		data: { 'htmlcontent':htmlcontent, 'title':title, 'desc':desc, 'image':image },
		async: false,
		success: function(msg){
			completefn(msg);
		}
	});
}

function updateEntry(completefn){
	var pid = $('body').attr('id');
	var title = headertitle.text();
	var desc = headerdesc.text();
	var htmlcontent = CKEDITOR.instances.ckeditor.getData();
	var image = currentbg;
	$.ajax({
		type: "POST",
		url: "/ajax/public/essayupdater",
		data: { 'pid':pid, 'htmlcontent':htmlcontent, 'title':title, 'desc':desc, 'image':image },
		async: false,
		success: function(msg){
			completefn(msg);
		}
	});
}

function updateHeaderBg(img){
	$('header').css('background', 'url('+img+')');
	$('header').css('background-size', 'cover');
	$('header').css('background-position', '0 50%');
}



});
