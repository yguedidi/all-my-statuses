AllMyStatuses.currentStatus = null;
AllMyStatuses.limitReached = false;
//AllMyStatuses.allStatuses = new Array();

AllMyStatuses.main = function() {
	AllMyStatuses.FB.getNbStatuses();
	
	AllMyStatuses.loadContent(true);
	
	FB.Canvas.setAutoGrow();
};

AllMyStatuses.getStatusHTML = function(status) {
	return status.replace(/\n/gi, '<br/>');
};

AllMyStatuses.getStatusText = function(status) {
	return status.replace(/<br\/?>/gi, '\n');
};

AllMyStatuses.FB.getNbStatuses = function() {
	FB.api('/me/feed',
			{fields: 'id', limit: 500},
			function(response) {
				if(response && response.data) {
					$('#nbStatusesTotal').text('/ '+response.data.length);
			}
	});
};

AllMyStatuses.FB.clearRequests = function(callback) {
	if(typeof(callback) != 'function') { callback = function() {};}
	
	FB.api('/me/apprequests', function(response) {
		if(response && response.data) {
			$.each(response.data, function(index, request) {
				FB.api('/'+request.id, 'delete');
			});
			
			callback();
		}
	});
};

AllMyStatuses.FB.sendInviteRequests = function(successCallback, cancelCallback) {
	if(typeof(successCallback) != 'function') successCallback = function(){};
	if(typeof(cancelCallback) != 'function') cancelCallback = function(){};
	
	FB.ui({
		method: 'apprequests',
		filters: ['app_non_users'],
		title: I18n.getText(I18n.ids.REQUEST_INVITE_TITLE),
		message: I18n.getText(I18n.ids.REQUEST_INVITE_BODY),
		data: {type: 'req_invite'}/*,
		max_recipients: 20*/},
		function(response) {
			if(response && response.request_ids && response.request_ids.length > 0) {
				successCallback(response.request_ids);
			} else {
				cancelCallback();
			}
		}
	);
};

AllMyStatuses.FB.sendReuseRequests = function(friends, successCallback, cancelCallback) {
	if(typeof(successCallback) != 'function') successCallback = function(){};
	if(typeof(cancelCallback) != 'function') cancelCallback = function(){};
	
	var f = [];
	if(friends.liked.length) {
		f.push({name: I18n.getText(I18n.ids.REQUEST_REUSE_FILTER_LIKED), user_ids: friends.liked});
	}
	if(friends.commented.length) {
		f.push({name: I18n.getText(I18n.ids.REQUEST_REUSE_FILTER_COMMENTED), user_ids: friends.commented});
	}
	if(f.length) {
		if(f.length === 2) {
			f.unshift({name: I18n.getText(I18n.ids.REQUEST_REUSE_FILTER_ALL), user_ids: friends.all});
		}
		
		FB.ui({
			method: 'apprequests',
			filters: f,
			title: I18n.getText(I18n.ids.REQUEST_REUSE_TITLE),
			message: I18n.getText(I18n.ids.REQUEST_REUSE_BODY),
			data: {type: 'req_reuse'}},
			function(response) {
				if(response && response.request_ids && response.request_ids.length > 0) {
					successCallback(response.request_ids);
				} else {
					cancelCallback();
				}
			}
		);
	} else {
		successCallback();
	}
};

AllMyStatuses.FB.getStatuses = function(callback) {
	FB.api(
		'/me/feed',
		{fields: 'id,message,type,permalink_url,updated_time', limit:AllMyStatuses.FB.Params.limit+1, offset:AllMyStatuses.FB.Params.offset},
		function(response) {
			var fetchedStatuses = 0;
			var fetchedFeedItems = (response.data.length > AllMyStatuses.FB.Params.limit ? AllMyStatuses.FB.Params.limit : response.data.length);
			for(var i = 0; i < fetchedFeedItems; i++) {
				if(typeof response.data[i].message == "undefined") {
					continue;
				}

				if(response.data[i].type != "status") {
					continue;
				}

				if(AllMyStatuses.currentStatus == null) {
					AllMyStatuses.currentStatus = response.data[i].message;
				}

				fetchedStatuses++;

				$('#listStatuses').append(AllMyStatuses.getStatusElt(response.data[i], response.data[i].message != AllMyStatuses.currentStatus && !AllMyStatuses.limitReached));
				//allStatuses.push(response.data[i]);
			}

			AllMyStatuses.FB.Params.offset += AllMyStatuses.FB.Params.limit;
			$('#nbStatuses').text(parseInt($('#nbStatuses').text())+fetchedStatuses);

			callback(response.data.length > AllMyStatuses.FB.Params.limit);
		}
	);
};

AllMyStatuses.getStatusElt = function(status, usable) {
	var friends = {all: [], liked: [], commented: []};
	var hideClass = usable ? '' : ' hide';
	var btnView = I18n.getText(I18n.ids.BTN_VIEW), infosClass = true;
	if((status.likes && status.likes.data && status.likes.data.length) || (status.comments && status.comments.data && status.comments.data.length)) {
		btnView = '', infosClass = true;
		if(status.comments && status.comments.data.length) {
			btnView += '<span class="comments">'+status.comments.data.length+'</span>';
			for(var i = 0; i < status.comments.data.length; i++) {
				if(status.comments.data[i].from && status.comments.data[i].from.id && status.comments.data[i].from.id != AllMyStatuses.FB.UserID) {
					friends.all.push(status.comments.data[i].from.id);
					friends.commented.push(status.comments.data[i].from.id);
				}
			}
		}
		if(status.likes && status.likes.data.length) {
			btnView += '<span class="likes">'+status.likes.data.length+'</span>';
			for(var i = 0; i < status.likes.data.length; i++) {
				if(status.likes.data[i].id) {
					friends.all.push(status.likes.data[i].id && status.likes.data[i].id != AllMyStatuses.FB.UserID);
					friends.liked.push(status.likes.data[i].id);
				}
			}
		}
	}
	friends.all.unique();

	var date = new Date();
	date.setISO8601(status.updated_time);
	
	infosClass = infosClass ? ' infos' : '';
	return 	$('<li id="eltStatus_'+status.id+'">'+
				'<div class="status">'+AllMyStatuses.getStatusHTML(status.message)+'</div>'+
				'<div class="date">'+
					'<a id="btnReuse_'+status.id+'" class="btn btnReuse'+hideClass+'" href="#">'+
						'<span>'+I18n.getText(I18n.ids.BTN_REUSE)+'</span>'+
					'</a>'+
					'<a id="btnView_'+status.id+'" class="btn btnView'+infosClass+'" target="_blank" href="'+status.permalink_url+'">'+
						btnView+
					'</a>'+
					'<span>'+I18n.getDate(date)+'</span>'+
					//'<span><fb:date t="'+date.getTime()+'" format="monthname_time"></fb:date></span>'+
				'</div>'+
			'</li>').data('message', status.message).data('friends', friends);
};

AllMyStatuses.updateUseBtn = function($elt) {
	if($elt.data('message') == AllMyStatuses.currentStatus) {
		$('div.date .btnReuse', $elt).addClass('hide');
	} else {
		$('div.date .btnReuse', $elt).removeClass('hide');
	}
};

AllMyStatuses.loadContent = function(first) {
	first = first || false;
	
	$('#btnMore').hide();
	$('#boxFooter').addClass('loading');
	
	AllMyStatuses.FB.getStatuses(function(more) {
		$('#boxFooter').removeClass('loading');
		
		if(more) {
			$('#btnMore').show();
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

AllMyStatuses.entryPoint = function() {
    //fbUserID = response.authResponse.userID;

    AllMyStatuses.FB.clearRequests(
        AllMyStatuses.main
    );

    FB.Event.subscribe('edge.create',
        function(response) {
            _gaq.push(['_trackSocial', 'Facebook', 'Like', AllMyStatuses.Urls.canvas]);
            $.ajax({
                type: 'POST',
                url: AllMyStatuses.Urls.ajax,
                data: {p: 0, uid: AllMyStatuses.FB.UserID}
            });
        }
    );

    FB.Event.subscribe('edge.remove',
        function(response) {
            _gaq.push(['_trackSocial', 'Facebook', 'Unlike', AllMyStatuses.Urls.canvas]);
            $.ajax({
                type: 'POST',
                url: AllMyStatuses.Urls.ajax,
                data: {p: 1, uid: AllMyStatuses.FB.UserID}
            });
        }
    );
};

var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-36615191-1']);
_gaq.push(['_trackPageview']);

window.fbAsyncInit = function() {
	FB.init({
		appId: AllMyStatuses.FB.AppID,
		status: true,
		cookie: true,
		xfbml: true,
		oauth: true,
        version: 'v2.4',
		channelUrl: AllMyStatuses.Urls.channel});
	
	//FB.Canvas.EarlyFlush.addResource(AllMyStatuses.Urls.home+'style.css');
	//FB.Canvas.EarlyFlush.addResource(AllMyStatuses.Urls.home+'script.js');

	FB.getLoginStatus(function(response) {
		if (response.authResponse) {
            FB.api('/me/permissions', function(response) {
                if(!response || !response.data) {
                    FB.login(function(){
                        AllMyStatuses.entryPoint();
                    }, {scope: AllMyStatuses.FB.Perms});

                	return;
                }

                var hasPermission = false;

                $.each(response.data, function(index, request) {
                    if (response.data[index].permission == 'user_posts' && response.data[index].status == 'granted') {
                        hasPermission = true;

                        AllMyStatuses.entryPoint();

                        return;
                    }
                });

                if (!hasPermission) {
                    FB.login(function(){
                        AllMyStatuses.entryPoint();
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
		
		// Google Analytics
		var ga = document.createElement('script');
		ga.type = 'text/javascript';
		ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		s.parentNode.insertBefore(ga, s);
	})();

	//Adk.ShowAd('adk-1483', { pid: 394340,  appid: 219665, plid: 15965, placement: 1483, adsize: '728x90' });
	//Adk.ShowAd('adk-1484', { pid: 394340,  appid: 219665, plid: 15965, placement: 1484, adsize: '728x90' });

	$('#inviteBox').delegate('.closeInvite', 'click', function(e) {
		$e = $(e.currentTarget);
		$('#inviteBox').slideUp(500, function() {
			$(this).remove();
		});
		
		e.preventDefault();
	});
	$('#inviteBox').delegate('#btnInvite', 'click', function(e) {
		AllMyStatuses.FB.sendInviteRequests(function() {
			//$('#inviteBox').remove();
		});
		
		e.preventDefault();
	});
	
	$('#btnMore').click(function(e) {
		AllMyStatuses.loadContent();
		
		e.preventDefault();
	});
	
	$('#listStatuses').delegate('.btnReuse', 'click', function(e) {
		$e = $(e.currentTarget);
		var postId = $e.attr('id').split('_', 2)[1];
		var postMessage = $('#eltStatus_'+postId).data('message');
		$e.addClass('loading');
		
		FB.api(
			'/me/feed',
			'post',
			{'message': AllMyStatuses.getStatusText(postMessage)},
			function(response) {
				if (!response || response.error) {
					if(response.error) {
						switch(response.error.type) {
						case 'OAuthException':
							if(response.error.message.search(/^\(#341\)/) != -1) {
								limitReached = true;
								
								$e.parent()
									.parent()
										.after('<li class="error"><a href="#" class="closeError">'+I18n.getText(I18n.ids.ERROR_CLOSE)+'</a><span>'+I18n.getText(I18n.ids.ERROR_TITLE)+' :</span> '+I18n.getText(I18n.ids.ERROR_DESC)+'</li>')
										.next()
										.hide()
										.slideDown(500, function() {
											$e.removeClass('loading');
										});
								
								$('#listStatuses li').each(function() {
									$('div.date .btnReuse', $(this)).addClass('hide');
								});
							} else {
								console.error(response);
							}
							break;
						default:
							//
							break;
						}
					} else {
						console.error('Facebook API Call : No reponse !');
					}
				} else {
					FB.api(
						'/'+response.id.split('_', 2)[1],
						{fields: 'id,message,type,permalink_url,updated_time'},
						function(response) {
							AllMyStatuses.currentStatus = response.message;
							$('#listStatuses').prepend(AllMyStatuses.getStatusElt(response, response.message != AllMyStatuses.currentStatus));
							
							$('#listStatuses li').each(function() {
								AllMyStatuses.updateUseBtn($(this));
							});
							
							$e.removeClass('loading');
							
							AllMyStatuses.FB.sendReuseRequests($('#eltStatus_'+postId).data('friends'));
						}
					);
				}
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
