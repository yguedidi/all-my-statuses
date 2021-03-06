AllMyStatuses.limitReached = false;
//AllMyStatuses.allStatuses = new Array();

AllMyStatuses.main = function() {
	AllMyStatuses.loadContent(true);
	
	FB.Canvas.setAutoGrow();
};

AllMyStatuses.getStatusHTML = function(status) {
	return status.replace(/\n/gi, '<br/>');
};

AllMyStatuses.FB.getStatuses = function(callback) {
	FB.api(
		'/me/feed',
		{fields: 'id,message,type,permalink_url,updated_time,comments.fields(id).limit(500),likes.fields(id).limit(500)', limit:AllMyStatuses.FB.Params.limit+1, offset:AllMyStatuses.FB.Params.offset},
		function(response) {
			if (typeof response.data == "undefined") {
                callback(false);

                return;
			}

			var fetchedStatuses = 0;
			var fetchedFeedItems = (response.data.length > AllMyStatuses.FB.Params.limit ? AllMyStatuses.FB.Params.limit : response.data.length);
			for(var i = 0; i < fetchedFeedItems; i++) {
				if(typeof response.data[i].message == "undefined") {
					continue;
				}

				if(response.data[i].type != "status") {
					continue;
				}

				fetchedStatuses++;

				$('#listStatuses').append(AllMyStatuses.getStatusElt(response.data[i]));
				//allStatuses.push(response.data[i]);
			}

			AllMyStatuses.FB.Params.offset += AllMyStatuses.FB.Params.limit;
			$('#nbStatuses').text(parseInt($('#nbStatuses').text())+fetchedStatuses);

			callback(response.data.length > AllMyStatuses.FB.Params.limit);
		}
	);
};

AllMyStatuses.getStatusElt = function(status) {
	var btnView = I18n.getText(I18n.ids.BTN_VIEW), infosClass = true;
	if((status.likes && status.likes.data && status.likes.data.length) || (status.comments && status.comments.data && status.comments.data.length)) {
		btnView = '', infosClass = true;
		if(status.comments && status.comments.data.length) {
			btnView += '<span class="comments">'+status.comments.data.length+'</span>';
		}
		if(status.likes && status.likes.data.length) {
			btnView += '<span class="likes">'+status.likes.data.length+'</span>';
		}
	}

	var date = new Date();
	date.setISO8601(status.updated_time);
	
	infosClass = infosClass ? ' infos' : '';
	return 	$('<li id="eltStatus_'+status.id+'">'+
				'<div class="status">'+AllMyStatuses.getStatusHTML(status.message)+'</div>'+
				'<div class="date">'+
					'<a id="btnShare_'+status.id+'" class="btn btnShare" href="#">'+
						'<span>'+I18n.getText(I18n.ids.BTN_SHARE)+'</span>'+
					'</a>'+
					'<a id="btnView_'+status.id+'" class="btn btnView'+infosClass+'" target="_blank" href="'+status.permalink_url+'">'+
						btnView+
					'</a>'+
					'<span>'+I18n.getDate(date)+'</span>'+
					//'<span><fb:date t="'+date.getTime()+'" format="monthname_time"></fb:date></span>'+
				'</div>'+
			'</li>').data('message', status.message).data('permalink', status.permalink_url);
};

AllMyStatuses.loadContent = function(first) {
	first = first || false;
	
	$('#btnMore').hide();
	$('#boxFooter').addClass('loading');
	
	AllMyStatuses.FB.getStatuses(function(more) {
		$('#boxFooter').removeClass('loading');
		
		if(more) {
			$('#btnMore').show();

            AllMyStatuses.loadContent();
		} else {
			$('#boxFooter').addClass('noMore');
		}
		
		FB.Canvas.setAutoGrow();
		
		if(first) {
			console.log("First Loading");
			FB.Canvas.setDoneLoading();
		}
	});
};

window.fbAsyncInit = function() {
	FB.init({
		appId: AllMyStatuses.FB.AppID,
        autoLogAppEvents: true,
		status: true,
		cookie: true,
		xfbml: true,
        version: 'v3.0'});
	
	//FB.Canvas.EarlyFlush.addResource(AllMyStatuses.Urls.home+'style.css');
	//FB.Canvas.EarlyFlush.addResource(AllMyStatuses.Urls.home+'script.js');

	FB.getLoginStatus(function(response) {
		if (response.authResponse) {
            FB.api('/me/permissions', function(response) {
                if(!response || !response.data) {
                    FB.login(function(){
                        AllMyStatuses.main();
                    }, {scope: AllMyStatuses.FB.Perms});

                	return;
                }

                var hasPermission = false;

                $.each(response.data, function(index, request) {
                    if (response.data[index].permission == 'user_posts' && response.data[index].status == 'granted') {
                        hasPermission = true;

                        AllMyStatuses.main();

                        return;
                    }
                });

                if (!hasPermission) {
                    FB.login(function(){
                        AllMyStatuses.main();
                    }, {scope: AllMyStatuses.FB.Perms, auth_type: 'rerequest'})
                }
            });
		} else {
			/*FB.login(function(response) {
				if (response.authResponse) {
					//top.location.href = fbCanvasURL;
					//fbUserID = response.authResponse.userID;
					//$('#btnMore').click();
					FB.Canvas.setAutoGrow();
				} else {
					//top.location.href = "http://www.facebook.com/";
				}
			}, {scope: fbPerms});*/
		}
	});
};

$(function() {
	(function() {
		var s = document.getElementsByTagName('script')[0];
		
		// Facebook
		var fb = document.createElement('script');
		fb.async = true;
		if (AllMyStatuses.FB.Debug) {
            fb.src = document.location.protocol + '//connect.facebook.net/en_US/sdk/debug.js';
		} else {
            fb.src = document.location.protocol + '//connect.facebook.net/'+AllMyStatuses.FB.Locale+'/all.js';
		}
		s.parentNode.insertBefore(fb, s);
	})();

	$('#btnMore').click(function(e) {
		AllMyStatuses.loadContent();
		
		e.preventDefault();
	});
	
	$('#listStatuses').delegate('.btnShare', 'click', function(e) {
		$e = $(e.currentTarget);
		var postId = $e.attr('id').replace(/^btnShare_/, '');
		var postLink = $('#eltStatus_'+postId).data('permalink');
		$e.addClass('loading');
		
		FB.ui(
			{
				method: 'share',
				href: postLink
			},
			function(response) {
                $e.removeClass('loading');
			}
		);
	});
	 $('#listStatuses').delegate('.closeError', 'click', function(e) {
		$e.parent().slideUp(500, function() {
			$(this).remove();
		});
	});
});

/*
 * Date Object
 */
Date.prototype.setISO8601 = function (string) {
	var regexp = 	"([0-9]{4})(-([0-9]{2})(-([0-9]{2})" +
					"(T([0-9]{2}):([0-9]{2})(:([0-9]{2})(\.([0-9]+))?)?" +
					"(Z|(([-+])([0-9]{2}):([0-9]{2})))?)?)?)?";
	var d = string.match(new RegExp(regexp));
	
	var offset = 0;
	var date = new Date(d[1], 0, 1);
	
	if (d[3]) { date.setMonth(d[3] - 1); }
	if (d[5]) { date.setDate(d[5]); }
	if (d[7]) { date.setHours(d[7]); }
	if (d[8]) { date.setMinutes(d[8]); }
	if (d[10]) { date.setSeconds(d[10]); }
	if (d[12]) { date.setMilliseconds(Number("0." + d[12]) * 1000); }
	if (d[14]) {
		offset = (Number(d[16]) * 60) + Number(d[17]);
		offset *= ((d[15] == '-') ? 1 : -1);
	}
	
	offset -= date.getTimezoneOffset();
	time = (Number(date) + (offset * 60 * 1000));
	this.setTime(Number(time));
};
Date.prototype.getWeek = function() {
	var determinedate = new Date();
	determinedate.setFullYear(this.getFullYear(), this.getMonth(), this.getDate());
	var D = determinedate.getDay();
	if(D == 0) D = 7;
	determinedate.setDate(determinedate.getDate() + (4 - D));
	var YN = determinedate.getFullYear();
	var ZBDoCY = Math.floor((determinedate.getTime() - new Date(YN, 0, 1, -6)) / 86400000);
	var WN = 1 + Math.floor(ZBDoCY / 7);
	return WN;
};

/*
 * Array Object
 */
Array.prototype.unique = function() {
	var a = this.slice(0);
	this.splice(0, this.length);
	for(var i = 0; i < a.length; i++) {
		if(!this.isIn(a[i]))
			this.push(a[i]);
	}
};

Array.prototype.isIn = function(value, strict) {
	if(typeof(strict) == 'undefined') strict = false;
	for(var i = 0; i < this.length; i++) {
		if((strict && this[i] === value) || (!strict && this[i] == value))
			return true;
	}
	return false;
};

/*
 * I18n Object
 */
I18n.getText = function(id, params) {
	if(!params) {
		return I18n.texts[I18n.currentLanguage][id];
	} else {
		var str = I18n.texts[I18n.currentLanguage][id];
		$.each(params, function(token, value) {
			str = str.replace(new RegExp('{#'+token+'#}', 'g'), value);
		});
		return str;
	}
};

I18n.getToday = function(d) {
	return I18n.getText(I18n.ids.DATE_TODAY);
};

I18n.getYesterday = function(d) {
	return I18n.getText(I18n.ids.DATE_YESTERDAY);
};

I18n.getDay = function(d) {
	var days = I18n.getText(I18n.ids.DATE_DAYS);
	return days[d];
};

I18n.getMonth = function(m) {
	var months = I18n.getText(I18n.ids.DATE_MONTHS);
	return months[m];
};

I18n.getDate = function(objDate) {
	var strDate = '';
	var now = new Date();
	if(now.getWeek() == objDate.getWeek()) {
		if(now.getDate() == objDate.getDate()) {
			strDate += I18n.getToday();
		} else if(now.getDate() == objDate.getDate()+1) {
			strDate += I18n.getYesterday();
		} else {
			strDate += I18n.getDay(objDate.getDay());
		}
	} else {
		strDate += Tools.pad(objDate.getDate())+' '+I18n.getMonth(objDate.getMonth());
		if(now.getFullYear() != objDate.getFullYear()) {
			strDate += ' '+objDate.getFullYear();
		}
	}
	
	var strTime = Tools.pad(objDate.getHours())+':'+Tools.pad(objDate.getMinutes());
	
	return I18n.getText(I18n.ids.DATETIME_FORMAT, {date: strDate, time: strTime});
};

/*
 * Tools Object
 */
Tools.pad = function(n) {
	return n > 9 ? n : '0'+n;
};
