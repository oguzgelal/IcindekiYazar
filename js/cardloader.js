function loadEntries(loadrule, displaytype, loadtype, limitfrom, loadcount, stackElement){
	var call = $.ajax({
		type: "POST",
		url: "/ajax/public/loader",
		async: true,
		data: { 
			'loadrule':loadrule,
			'displaytype':displaytype,
			'loadtype':loadtype,
			'limitfrom':limitfrom,
			'loadcount':loadcount,
			'loadinfo':'published'
		},
		success: function(msg){
			distributeData(msg, stackElement);
		}
	});
	return call;
}

function loadUserEntries(uid, loadrule, displaytype, loadtype, limitfrom, loadcount, stackElement, published){
	var loadinfo = "published_user";
	if (published && published=="unpublished"){ loadinfo = "unpublished_user"; }
	var call = $.ajax({
		type: "POST",
		url: "/ajax/public/loader",
		async: true,
		data: { 
			'uid':uid,
			'loadrule':loadrule,
			'displaytype':displaytype,
			'loadtype':loadtype,
			'limitfrom':limitfrom,
			'loadcount':loadcount,
			'loadinfo':loadinfo
		},
		success: function(msg){
			distributeData(msg, stackElement);
		}
	});
	return call;
}

function distributeData(data, stackElement){
	var htmlparse = $.parseHTML(data);
	$(htmlparse).each(function(index, element){
		if($(element).hasClass('postblock')){
			
			var stack = $('.container').find('.'+stackElement)[0];
			var min = $(stack).height();

			$('.container').find('.'+stackElement).each(function(){
				if ($(this).height() < min){
					min = $(this).height();
					stack = $(this);
				}
			});

			$(stack).append(element);

		}
	});
}