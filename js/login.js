$(document).ready(function(){
	$('.signinup').click(function(){
		loginscreen();
	});
	$('.logoutbtn').click(function(){
		$.ajax({
			type: "POST",
			url: "/ajax/public/logout",
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
					setTimeout(function(){ location.reload(); },1000);
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
					setTimeout(function(){ location.reload(); },1000);
				}
			}
		});
});
});


function loginscreen(){

	$.get('/loginoverlay', function(html){
		$('body').append(html);
		var loginpage = $('.login-overlay');
		loginpage.fadeIn('fast');
		
		// quit click
		$('.login-quit').click(function(){
			loginpage.fadeOut('fast', function(){
				$('body').find('.login-overlay').remove();
			});
		});

		// socials soon
		$('.login-social').mouseenter(function(){
			var soon = "Çok yakında...";
			var innertext = $(this).find('.login-innertext');
			var text = $(innertext).text();
			$(innertext).text(soon);
			$(this).mouseleave(function(){
				$(innertext).text(text);	
			});
		});

		// login click
		$('.login-submitbtn').click(function(){
			var cantbeblank = "Bu alan boş bırakılamaz...";
			var email = $('.login-email').val();
			var password = $('.login-password').val();
			var remember = $('.login-remembercheck').is(':checked') ? "true" : "false";
			var ok = 1;
			if (email.length == 0){ textboxalert($('.login-email'), cantbeblank); ok = 0; }
			if (password.length == 0){ textboxalert($('.login-password'), cantbeblank); ok = 0; }
			if (ok == 1){
				$.ajax({
					type: "POST",
					url: "/ajax/public/login",
					data: { 'email':email, 'password':password, 'rememberme':remember },
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
							setTimeout(function(){ location.reload(); },1000);
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
							setTimeout(function(){ location.reload(); },1000);
						}
					}
				});
}
});
});

}

function textboxalert(textbox, message){
	var oldbg = textbox.css('background-color');
	var prevtext = textbox.attr('placeholder');
	textbox.css('background-color','#f2dede');
	textbox.attr('placeholder',message);
	setTimeout(function(){ 
		textbox.attr('placeholder', prevtext);
		textbox.css('background-color', oldbg);	
	}, 2000);
}