/**
 * webskillet Javascript utilities
 * Jonathan Kissam (plus others as credited)
 * April 2012
 *
 * Table of contents:
 * 1. jQuery extensions
 * 2. wsUtil object definition
 * 3. jQuery (document).ready, (window).load and (window).smartresize functions
 */

/**
 * 1. jQuery extensions
 */

jQuery.support.placeholder = (function(){
    var i = document.createElement('input');
    return 'placeholder' in i;
})();

(function(jQuery,sr){
 
  // debouncing function from John Hann
  // http://unscriptable.com/index.php/2009/03/20/debouncing-javascript-methods/
  var debounce = function (func, threshold, execAsap) {
      var timeout;
 
      return function debounced () {
          var obj = this, args = arguments;
          function delayed () {
              if (!execAsap)
                  func.apply(obj, args);
              timeout = null; 
          };
 
          if (timeout)
              clearTimeout(timeout);
          else if (execAsap)
              func.apply(obj, args);
 
          timeout = setTimeout(delayed, threshold || 100); 
      };
  }
	// smartresize 
	jQuery.fn[sr] = function(fn){  return fn ? this.bind('resize', debounce(fn)) : this.trigger(sr); };
 
})(jQuery,'smartresize');

// Creating custom :external selector
jQuery.expr[':'].external = function(obj){
    if ((obj.href == '#') || (obj.href == '') || (obj.href == null)) { return false; }
    if(obj.href.match(/^mailto\:/)) { return false; }
    if(obj.href.match(/^javascript\:/)) { return false; }
    if ( (obj.hostname == location.hostname)
	|| ('www.'+obj.hostname == location.hostname)
	|| (obj.hostname == 'www.'+location.hostname)
	) { return false; }
    return true;
};

// Creating custom :youtube selector
jQuery.expr[':'].youtube = function(obj){
	if (obj.hostname.match(/(www\.)?youtu(be\.com|\.be)/i)) { return true; }
	return false;
}

/**
 * 2. wsUtil object definition
 */

wsUtil = {

	// variables
	FBappid : 0,
	FBstatus : 0, // 0 = not logged into FB, 1 = logged in but not authorized, 2 = logged in, authorized
	FBuserid : null,
	FBaccessToken : null,

	// functions
	init : function() {
		var self = wsUtil;
		self.populateInputs();
		self.prepareRollStates();
	},

	setCookie : function(c_name,value,exdays) {
		var exdate=new Date();
		exdate.setDate(exdate.getDate() + exdays);
		var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
		document.cookie=c_name + "=" + c_value;
	},

	getCookie : function (c_name) {
		var i,x,y,ARRcookies=document.cookie.split(";");
		for (i=0;i<ARRcookies.length;i++) {
			x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
			y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
			x=x.replace(/^\s+|\s+$/g,"");
			if (x==c_name) {
				return unescape(y);
			}
		}
	},

	// populate inputs with the value of their labels
	populateInputs : function() {
		jQuery('input.populate').each(function() {
			var populate_text = jQuery('label[for="' + jQuery(this).attr('id') + '"]').text();
			if (populate_text) {
				if (jQuery.support.placeholder) {
					jQuery(this).attr('placeholder',populate_text);
				} else {
					jQuery(this).val(populate_text).data('populate_text', populate_text);
					jQuery(this).addClass('populated');				
					jQuery(this).focus(function() {
						if (jQuery(this).val() == jQuery(this).data('populate_text')) {
							jQuery(this).val('');
							jQuery(this).removeClass('populated');
						}
					});
					jQuery(this).blur(function() {
						if (jQuery(this).val() == '') {
							jQuery(this).val(jQuery(this).data('populate_text'));
							jQuery(this).addClass('populated');
						}
					});
				}
			}
		});
	},

	// set up roll states for submit buttons and images
	prepareRollStates : function() {
		var i = new Image();
		jQuery('.roll-image').each(function() {
			i.src = jQuery(this).attr('src').replace(/\.png/, '-on.png');
		});
		jQuery('.roll-image').hover(function() {
			jQuery(this).attr('src', jQuery(this).attr('src').replace(/\.png/, '-on.png'));
		}, function() {
			jQuery(this).attr('src', jQuery(this).attr('src').replace(/-on\.png/, '.png'));
		});
	},

	// open pop-up windows on particular links, by selector
	preparePopUps : function(sel,w,h) {
		jQuery(sel).click(function(event){
			var left = (screen.width - w)/2;
			var top = (screen.height - h)/2;
			top = (top < 50) ? 50 : top;
			var attr = 'height='+h+',width='+w+',left='+left+',top='+top+',location=0,menubar=0,status=0';
			window.open(jQuery(this).attr('href'),'popup',attr);
			event.preventDefault();
		});
	},

	// prepare external links
	prepareExternalLinks : function(exceptions) {
		var sel;
		if (exceptions instanceof Array) {
			sel = exceptions.join()
		} else {
			sel = exceptions;
		}
		jQuery('a:external').addClass('external');
		jQuery(sel).removeClass('external');
		jQuery('a:youtube').removeClass('external'); // comment out if not using YTLinks function
		jQuery('a.external').each(function(){
			var href = jQuery(this).attr('href');
			var title = jQuery(this).attr('title') ? jQuery(this).attr('title') : '';
			title += (title.length > 0) ? ' ' : '';
			title += '(opens in a new window)';
			jQuery(this).attr('title',title);
			jQuery(this).click(function(event){
				window.open(href,'external','');
				event.preventDefault();
			});
		});
	},

	prepareMenuToggle : function() {
		jQuery('.menu-toggle').addClass('collapsed').siblings('.nav-menu, .menu-main-menu-container').addClass('collapsed');
		jQuery('.menu-toggle').click(function(){
			if (jQuery(this).hasClass('collapsed')) {
				jQuery(this).removeClass('collapsed').addClass('expanded');
				jQuery(this).siblings('.nav-menu, .menu-main-menu-container').removeClass('collapsed').addClass('expanded');
			} else {
				jQuery(this).removeClass('expanded').addClass('collapsed');
				jQuery(this).siblings('.nav-menu, .menu-main-menu-container').removeClass('expanded').addClass('collapsed');
			}
		});
	},

	preloadImages : function() {
		var img = new Image();
		for (i=0; i<arguments.length; i++) {
			img.src = arguments[i];
		}
	},

	// load FB SDK
	initFB : function(appId) {
		wsUtil.FBappid = appId;
		window.fbAsyncInit = function() {
			FB.init({
				appId      : appId,
				status     : true, 
				cookie     : true,
				xfbml      : true,
				oauth      : true
			});
			FB.getLoginStatus(wsUtil.checkFB);
			FB.Event.subscribe('auth.statusChange', wsUtil.checkFB);
		};
		(function(d){
			var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
			js = d.createElement('script'); js.id = id; js.async = true;
			js.src = "//connect.facebook.net/en_US/all.js";
			d.getElementsByTagName('head')[0].appendChild(js);
		}(document));
	},

	checkFB : function(response) {
		if (response.status === 'connected') {
			wsUtil.FBuserid = response.authResponse.userID;
			wsUtil.FBaccessToken = response.authResponse.accessToken;
			wsUtil.FBstatus = 2;
		} else if (response.status === 'not_authorized') {
			wsUtil.FBstatus = 1;
		} else {
			wsUtil.FBstatus = 0;
		}
		// code elsewhere can bind to this event to ensure it's not run until after FB asynch init is run
		jQuery(window).trigger('checkFB.wsUtil');
	},

	// wrapper for functions that require FB authorization
	wrapFBaction : function(fn, fbscope) {
		if (wsUtil.FBstatus == 2) {
			fn();
		} else {
			FB.login(function(response){
				if(response.authResponse) {
					fn();
				}
			}, {scope : fbscope});
		}
	},

	loadTwitterScript : function() {
		var js, s = 'script', d = document, id='twitter-wjs', fjs=d.getElementsByTagName(s)[0];
		if(!d.getElementById(id)){
			js=d.createElement(s);
			js.id=id;
			js.src="//platform.twitter.com/widgets.js";
			fjs.parentNode.insertBefore(js,fjs);
		}
	},

	fixOnScroll : function(sel, maxScroll, addBottomMarginTo) {
		wsUtil.fixOnScrollObj = jQuery(sel);
		wsUtil.fixOnScrollHeight = wsUtil.fixOnScrollObj.outerHeight(true);
		wsUtil.fixOnScrollAMT = jQuery(addBottomMarginTo);
		jQuery(window).scroll(function(){
			var pos = jQuery(window).scrollTop();
			if (pos > maxScroll) {
				wsUtil.fixOnScrollObj.addClass('fixed');
				if (wsUtil.fixOnScrollAMT) { wsUtil.fixOnScrollAMT.css('margin-bottom', wsUtil.fixOnScrollHeight+'px'); }
			} else {
				wsUtil.fixOnScrollObj.removeClass('fixed');
				if (wsUtil.fixOnScrollAMT) { wsUtil.fixOnScrollAMT.css('margin-bottom', '0px'); }
			}
		});
	},

	// fixes footer to bottom of the page if the content is not long enough
	// add to ready, load AND resize functions
	fixFooter : function() {
		var $footer = jQuery('#footer');
		var heightOfPage = jQuery(window).height();
		if ($footer.hasClass('fixed')) {
			var totalHeight = jQuery('#header').outerHeight()+jQuery('#wrapper-main').outerHeight()+$footer.outerHeight(); // note: might need to add height to account for top and bottom margins
			if (totalHeight > heightOfPage) { $footer.removeClass('fixed'); }
		} else {
			var bottomOfFooter = $footer.offset().top + $footer.outerHeight();
			if (bottomOfFooter < heightOfPage) { $footer.addClass('fixed'); }
		}
	},

	// finds links which contain URLs as their text (likely to be long, and break layout on phones)
	// and replaces their inner text with (link)
	fixLongUrls : function() {
		jQuery('a:contains("http"), a:contains("www")').text('(link)');
	},

	equalizeHeight : function(sel) {
		var h = 0;
		jQuery(sel).css('height','auto').removeClass('fixed-height');
		if (jQuery(window).width() < 768) { return; }
		jQuery(sel).each(function(){
			var thisH = jQuery(this).outerHeight();
			// console.log('#'+jQuery(this).attr('id')+' height: '+thisH);
			if (thisH > h) { h = thisH; }
		});
		jQuery(sel).css('height',h+'px').addClass('fixed-height');
	},

	prepareSectionNavigation : function(sel, offset) {
		var $ = jQuery;
		$(sel).click(function(event){
			newTop = $($(this).attr('href')).offset().top;
			if (offset) { newTop += offset; }
			$('html, body').stop().animate({
				scrollTop: newTop
			}, 500);
			event.preventDefault();
			if ($($(this).attr('href')+' input').length) {
				$($(this).attr('href')+' input').focus();
			}
		});
	},

}



/**
 * 3.1 jQuery(document).ready
 */

jQuery(document).ready(function($){
	wsUtil.init();
	wsUtil.prepareMenuToggle();

	$('.actionsite_share_widget .share_button').click(function(event){
		event.preventDefault();
		var href = $(this).attr('href');
		window.open(href,'share','width=450,height=300,left='+(screen.availWidth/2-375)+',top='+(screen.availHeight/2-150)+'');
	});

	if (jQuery(window).width() < 768) {
		wsUtil.fixLongUrls();
	}

	jQuery('h1.entry-title').each(function(){
		if (jQuery(this).height() < 30) {
			jQuery(this).css('padding-top','10px');
		}
	});

});

jQuery(document).ajaxComplete(function() {
	var d = new Date();
	jQuery('.actionSiteTimestamp').val(d.toISOString());
});

/**
 * 3.2 jQuery(window).load
 */

jQuery(window).load(function(){

});

/**
 * 3.3 jQuery(window).smartresize
 */

jQuery(window).smartresize(function(){
	if (jQuery(window).width() < 768) {
		wsUtil.fixLongUrls();
	}
});
