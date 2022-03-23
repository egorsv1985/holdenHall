// Cookie manipulatiions
if ($.cookie === undefined) {
  !function (a) { "function" == typeof define && define.amd ? define(["jquery"], a) : "object" == typeof exports ? a(require("jquery")) : a(jQuery) }(function (a) { function b(a) { return h.raw ? a : encodeURIComponent(a) } function c(a) { return h.raw ? a : decodeURIComponent(a) } function d(a) { return b(h.json ? JSON.stringify(a) : String(a)) } function e(a) { 0 === a.indexOf('"') && (a = a.slice(1, -1).replace(/\\"/g, '"').replace(/\\\\/g, "\\")); try { return a = decodeURIComponent(a.replace(g, " ")), h.json ? JSON.parse(a) : a } catch (b) { } } function f(b, c) { var d = h.raw ? b : e(b); return a.isFunction(c) ? c(d) : d } var g = /\+/g, h = a.cookie = function (e, g, i) { if (void 0 !== g && !a.isFunction(g)) { if (i = a.extend({}, h.defaults, i), "number" == typeof i.expires) { var j = i.expires, k = i.expires = new Date; k.setTime(+k + 864e5 * j) } return document.cookie = [b(e), "=", d(g), i.expires ? "; expires=" + i.expires.toUTCString() : "", i.path ? "; path=" + i.path : "", i.domain ? "; domain=" + i.domain : "", i.secure ? "; secure" : ""].join("") } for (var l = e ? void 0 : {}, m = document.cookie ? document.cookie.split("; ") : [], n = 0, o = m.length; o > n; n++) { var p = m[n].split("="), q = c(p.shift()), r = p.join("="); if (e && e === q) { l = f(r, g); break } e || void 0 === (r = f(r)) || (l[q] = r) } return l }; h.defaults = {}, a.removeCookie = function (b, c) { return void 0 === a.cookie(b) ? !1 : (a.cookie(b, "", a.extend({}, c, { expires: -1 })), !a.cookie(b)) } });
}

$('[data-max-pages]').each(function () {
  cur_part = $(this).attr('data-load-part');
  if (parseInt($(this).attr('data-max-pages')) > 1) {
    $('[data-load=' + cur_part + ']').show();
  }
})

jQuery(document).ready(function($){

$('[data-action=autoload]').on('change', function(){
  $(this).parents('form').trigger('submit');
});

$('[data-action="search_filter_ajax"] [data-taxonomy]').click(function () {
  if (!$(this).find('input').is(':checked')) { $(this).removeClass('active'); } else { $(this).addClass('active'); }
});

$('[data-action="reset_filter"]').click(function () {

  $('[data-action=search_filter_ajax]').trigger("reset");

  $('[data-range-slider]').each(function () {
    let field = $(this).attr('data-range-slider');
    let min_val = $('[name=min_pm_' + field + ']').attr('data-value');
    let max_val = $('[name=max_pm_' + field + ']').attr('data-value');
    $(this).slider("option", "values", [parseInt(min_val), parseInt(max_val)]);
  });

  $('[data-action=search_filter_ajax] .active').removeClass('active');

  $('[data-action=search_filter_ajax]').trigger("submit");
});

$('[data-action="search_filter_ajax"]').submit(function (e) {
  e.preventDefault();
  let cur_part = $('body').attr('data-load-current');
  let data_load = $('[data-load=' + cur_part + ']');
  let data = {
    query: query_vars,
    foo: $(this)
  };
  $('[data-action=preload]').show();
  ajaxs('filter', data, function (data) {
    if (data) {
      if (cur_part !== undefined) {
        cur_part = '=' + cur_part;
      } else {
        cur_part = '';
      }

      let parent_container = $('[data-load-part' + cur_part + ']').parent().parent();
      $('[data-load-part' + cur_part + ']').parent().remove();
      parent_container.prepend(data);

      const max_pages = parseInt($('[data-max-pages]').attr('data-max-pages'));

      if (max_pages <= 1 || isNaN(max_pages)) {
        $(data_load).hide();
      } else {
        $(data_load).show();
      }

      if (typeof (wtw_after_filter_ajax_load) === 'function') {
        wtw_after_filter_ajax_load(cur_part);
      } else {
        Webflow.destroy(); Webflow.ready();
        if (Webflow.require('ix2') !== undefined) Webflow.require('ix2').init();
      }

      $('[data-action=preload]').hide();

    } else {
      $(data_load).hide();
    }
  });
});

// $('[data-action="search_filter_ajax"]').trigger('submit');

$('[href*=\"brandjs\"],.w-webflow-badge').attr('style', 'display:none !important');

if( $('[data-load]')[0] ){

$('[data-load-part]:first').each(function(){
  $('body').attr('data-load-current', $(this).attr('data-load-part'));
});

$('[data-set-part]').click(function(){
  $('body').attr('data-load-current', $(this).attr('data-set-part'));
});

$('[data-max-pages=0]').each(function() {
  cur_part = $(this).attr('data-load-part');
  $('[data-load='+cur_part+']').hide();
})

$('[data-max-pages=1]').each(function() {
  cur_part = $(this).attr('data-load-part');
  if ($(this).attr('data-current-page') === '1'){
  $('[data-load='+cur_part+']').hide();
  }
})

$('[data-load]').click(function(){
  var part = $(this).attr('data-load'); $('body').attr('data-load-current', part);
  var max_pages = $('[data-load-part=' + part + ']:last').attr('data-max-pages');
  var current_page = $('[data-load-part=' + part + ']').last().attr('data-current-page');
  var archive = $(this).attr('data-load'); $('body').attr('data-archive', part);
  var data = {
    'query': query_vars,
    'page': current_page,
    'part': part,
    'archive': archive
  };
  if( current_page != max_pages ){
    $('[data-action=preload]').show();
    ajaxs('ajaxs_load_posts', data, function(data){
      if( data ) {
          current_page++;
          cur_part = $('body').attr('data-load-current');
          if ( cur_part !== undefined ) {
            cur_part = '='+cur_part;
          } else {
            cur_part = '';
          }
  				$('[data-load-part'+cur_part+']').last().parent().after(data);
          if (current_page == max_pages) $('[data-load'+cur_part+']').hide();
          Webflow.destroy(); Webflow.ready();
          if (Webflow.require('ix2') != undefined) Webflow.require('ix2').init();
          $('[data-action=preload]').hide();
  		} else {
  			$(data_load).hide();
  		}
    });
  }
});

if( $('body').attr('data-load-scroll') !== undefined ){
  $(window).scroll(function(){
    var scroll_offset = $('body').attr('data-load-scroll');
    var part = $(this).attr('data-load'); $('body').attr('data-load-current', part);
    var max_pages = $('[data-load-part=' + part + ']:last').attr('data-max-pages');
    var current_page = $('[data-load-part=' + part + ']').last().attr('data-current-page');
    var archive = $(this).attr('data-load'); $('body').attr('data-archive', part);
    var data = {
      'query': query_vars,
      'page': current_page,
      'part': part,
      'archive': archive
    };
    if( $(document).scrollTop() > ($(document).height() - scroll_offset) && current_page != max_pages && !$('body').hasClass('loading')){
      $('body').addClass('loading');
      ajaxs('ajaxs_load_posts', data, function(data){
        if( data ) {
          cur_part = $('body').attr('data-load-current');
          if( cur_part !== undefined ){
            data_load = '[data-load='+cur_part+']';
          }else{
            data_load = '[data-load]';
          }
          $('body').removeClass('loading');
  				$(data_load).before(data);
  				current_page++;
          if (current_page == max_pages) $(data_load).hide();
          Webflow.destroy(); Webflow.ready();
          if (Webflow.require('ix2') != undefined) Webflow.require('ix2').init();
    		}
      });
    }
  });
}
}

$('body').on('click', '[data-copy]', function(){
  params = $(this).attr('data-copy').split(' ');
  $('.'+params[1]).html($(this).parent().find('.'+params[0]).html());
  Webflow.destroy(); Webflow.ready();
  if (Webflow.require('ix2') != undefined) Webflow.require('ix2').init();
});

$('body').on('click', '[data-copy-attrs]', function () {
  params = $(this).attr('data-copy').split(' ');
  $('.' + params[1]).html($(this).parent().find('.' + params[0]).html());
  Webflow.destroy(); Webflow.ready();
  if (Webflow.require('ix2') != undefined) Webflow.require('ix2').init();
});

$('[data-object=wp_term_menu] a').each(function(){
if(document.URL === $(this).attr('href')){
  $(this).addClass('active');
	$(this).addClass('w--current');
	$(this).parents().each(function(){
		if($(this).attr('data-object') === 'wp_term_menu') return false;
    $(this).addClass('active');
    $(this).addClass('w--current');
	});
}
});

$('a').not('.w--current,.active').each(function(){
if(document.URL === $(this).attr('href')){
	$(this).addClass('w--current');
}
});

$('[data-content=term-level] .w--current').each(function () {
  $(this).parent().parent().parents('[data-content=term-level]').each(function () {
    $(this).children().first().trigger('click');
  });
});

// обработка полей фильтра
$('[name=search_filter]').submit(function(e){
  var form = $(this);
  if( $(this).attr('data-mode') !== 'ajax' ){
    if( $(this).find('[name=s]').val() === '' ){
      $(this).find('[name=s]').removeAttr('name');
    }
    $(this).find('.w-input').each(function(){
      if( $(this).attr('data-value') === $(this).val() ){
        // $(this).removeAttr('name');
      }
    });
  }
});

// слайдер диапозонов значений
$('[data-range-slider]').each( function(){
	var field = $(this).attr('data-range-slider');
	$(this).slider({
	step: parseInt($(this).attr('data-ui-slider')),
	range: true,
	min: parseInt($("[name=min_pm_"+field+"]").attr('data-value')),
	max: parseInt($("[name=max_pm_"+field+"]").attr('data-value')),
	values: [ parseInt($("[name=min_pm_"+field+"]").val()), parseInt($("[name=max_pm_"+field+"]").val()) ],
	slide: function(event, ui) {
		$("[name=min_pm_"+field+"]").val(ui.values[0]).keyup();
		$("[name=max_pm_"+field+"]").val(ui.values[1]).keyup();
	}
	});
});

});

// используется в АЯКС фильтре
function set_query_vars(query_data) {
  query_vars = query_data;
}

!function (a) { function f(a, b) { if (!(a.originalEvent.touches.length > 1)) { a.preventDefault(); var c = a.originalEvent.changedTouches[0], d = document.createEvent("MouseEvents"); d.initMouseEvent(b, !0, !0, window, 1, c.screenX, c.screenY, c.clientX, c.clientY, !1, !1, !1, !1, 0, null), a.target.dispatchEvent(d) } } if (a.support.touch = "ontouchend" in document, a.support.touch) { var e, b = a.ui.mouse.prototype, c = b._mouseInit, d = b._mouseDestroy; b._touchStart = function (a) { var b = this; !e && b._mouseCapture(a.originalEvent.changedTouches[0]) && (e = !0, b._touchMoved = !1, f(a, "mouseover"), f(a, "mousemove"), f(a, "mousedown")) }, b._touchMove = function (a) { e && (this._touchMoved = !0, f(a, "mousemove")) }, b._touchEnd = function (a) { e && (f(a, "mouseup"), f(a, "mouseout"), this._touchMoved || f(a, "click"), e = !1) }, b._mouseInit = function () { var b = this; b.element.bind({ touchstart: a.proxy(b, "_touchStart"), touchmove: a.proxy(b, "_touchMove"), touchend: a.proxy(b, "_touchEnd") }), c.call(b) }, b._mouseDestroy = function () { var b = this; b.element.unbind({ touchstart: a.proxy(b, "_touchStart"), touchmove: a.proxy(b, "_touchMove"), touchend: a.proxy(b, "_touchEnd") }), d.call(b) } } }(jQuery);

function wtw_webflow_init(){
  Webflow.destroy();
  Webflow.ready();
  WebflowIx2 = Webflow.require('ix2');
  WebflowIx2 != undefined ? WebflowIx2.init() : '';
}

function d() {
  for (var i = 0; i < arguments.length; i++) {
    console.log(arguments[i]);
  }
}

function dt() {
  for (var i = 0; i < arguments.length; i++) {
    console.table(arguments[i]);
  }
}