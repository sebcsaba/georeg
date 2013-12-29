function decodeString(input) {
	if (/^=\?UTF-8\?Q\?(.*)\?\=/.test(input)) {
		return decodeURIComponent(input.substring(10,input.length-2).replace(/=/g,'%'));
	} else {
		return input;
	}
}

function myAjax(data, realSuccess, method) {
	if (!method) method='get';
	$.ajax('index.php',{
		type: method,
		data: data,
		success: function(data, status, xhr) {
			if (xhr.getResponseHeader("X-Location")) {
				document.location = xhr.getResponseHeader("X-Location");
			} else if (xhr.getResponseHeader("X-Error")) {
				alert(decodeString(xhr.getResponseHeader("X-Error")));
			} else {
				realSuccess(data);
				var callJsFunction = xhr.getResponseHeader("X-Call-Javascript");
				if (callJsFunction) {
					eval(decodeString(callJsFunction)+'()');
				}
			}
		},
		error: function(xhr, textStatus, errorThrown) {
			alert('error: '+xhr.statusText);
		}
	});
}

function openPage(page,paramData,skipShowPrefix) {
	if (!paramData) paramData = {};
	if (!skipShowPrefix) {
		page = 'Show'+page;
	}
	paramData['do'] = page;
	openPageData(paramData);
}

function openPageData(paramData) {
	myAjax(paramData,function(data){
		$('#maincontent').html(data);
	});
}

function submitForm(form) {
	myAjax(form.serialize(), function(data){
		$('#maincontent').html(data);
	},'post');
}

function reloadLeftMenu(){
	myAjax({'do':'ShowLeftMenu'},function(data){
		$('#leftmenu').html(data);
	});
}
