function xiptHandleAclResponse(json){
	if(typeof(json.aclerror) !== 'undefined' && json.aclerror == true){
		joms.popup.xiptacl(json);
		return false;
	}	
	
	return true;
}

//  ADD EVENTS HERE, to check the acl response
joms.onAjaxReponse('events,ajaxUpdateStatus', xiptHandleAclResponse);
joms.onAjaxReponse('groups,ajaxDeleteGroup', xiptHandleAclResponse);
joms.onAjaxReponse('events,ajaxDeleteEvent', xiptHandleAclResponse);


(function( root, $, factory ) {

    joms.popup || (joms.popup = {});
    joms.popup.xiptacl = factory( root, $ );

    return joms.popup.xiptacl;

})( window, joms.jQuery, function( window, $ ) {

var popup, elem, _json;

function render( _popup, json ) {
    if ( elem ) elem.off();
    popup = _popup;
  
    popup.items[0] = {
        type: 'inline',
        src: buildHtml( json )
    };

    popup.updateItemHTML();

    elem = popup.contentContainer;

    if(typeof(_json.redirect) != 'undefined' && _json.redirect){
    	elem.on( 'click', 'button', redirect );
    	setTimeout(redirect, 5000);
    }
}

function redirect(){
	window.location.href = _json.redirect;
}

function buildHtml( json ) {
    json || (json = {});
    
    var actionhtml = '';
    if(json.redirect){
    	actionhtml += '<button class="joms-button--neutral joms-button--small joms-left joms-js--button-cancel">' + json.btnCancel + '</button> &nbsp;';
    }
    
    return [
        '<div class="joms-popup joms-popup--whiteblock joms-popup--500">',
        '<div class="joms-popup__title"><button class="mfp-close" type="button" title="Close (Esc)">×</button>', json.title, '</div>',
        '<div class="joms-js--step1">',
	    	'<div class="joms-popup__content">',
	            json.html,
	        '</div>',
	        '<div class="joms-popup__action">',
	        	actionhtml,	
	        	'<br/><br/>',
	        '</div>',
	    '</div>',        
        '<div class="joms-js--step2', ( json.error ? '' : ' joms-popup__hide' ), '">',
            '<div class="joms-popup__content joms-popup__content--single">', ( json.error || '' ), '</div>',
        '</div>',
        '</div>'
    ].join('');
}

// Exports.
return function( json ) {
	_json = json;
    joms.util.popup.prepare(function( mfp ) {
        render( mfp, json);
    });
};

});

