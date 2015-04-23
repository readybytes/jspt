function xiptHandleAclResponse(json){
	if(typeof(json.aclerror) !== 'undefined' && json.aclerror == true){
		joms.popup.xiptacl(json);
		return false;
	}	
	
	joms.popup.xiptfbc.update(json);
	
	return true;
}

//  ADD EVENTS HERE, to check the acl response
joms.onAjaxReponse('events,ajaxUpdateStatus', xiptHandleAclResponse);
joms.onAjaxReponse('groups,ajaxDeleteGroup', xiptHandleAclResponse);
joms.onAjaxReponse('events,ajaxDeleteEvent', xiptHandleAclResponse);
joms.onAjaxReponse('system,ajaxShowInvitationForm', xiptHandleAclResponse);
joms.onAjaxReponse('system,ajaxStreamAddLike', xiptHandleAclResponse);
joms.onAjaxReponse('system,ajaxStreamUnlike', xiptHandleAclResponse);
joms.onAjaxReponse('system,ajaxLike', xiptHandleAclResponse);
joms.onAjaxReponse('system,ajaxUnlike', xiptHandleAclResponse);
joms.onAjaxReponse('apps,ajaxAddApp', xiptHandleAclResponse);
joms.onAjaxReponse('groups,ajaxShowLeaveGroup', xiptHandleAclResponse);
joms.onAjaxReponse('videos,ajaxAddVideo', xiptHandleAclResponse);
joms.onAjaxReponse('videos,ajaxUploadVideo', xiptHandleAclResponse);
joms.onAjaxReponse('videos,ajaxLinkVideoPreview', xiptHandleAclResponse);
joms.onAjaxReponse('profile,ajaxLinkProfileVideo', xiptHandleAclResponse);
joms.onAjaxReponse('friends,ajaxConnect', xiptHandleAclResponse);
joms.onAjaxReponse('photos,ajaxUploadPhoto', xiptHandleAclResponse);
joms.onAjaxReponse('photos,ajaxChangeCover', xiptHandleAclResponse);
joms.onAjaxReponse('inbox,ajaxDeleteMessages', xiptHandleAclResponse);
joms.onAjaxReponse('inbox,ajaxRemoveFullMessages', xiptHandleAclResponse);
joms.onAjaxReponse('inbox,ajaxRemoveMessage', xiptHandleAclResponse);
joms.onAjaxReponse('inbox,ajaxAddReply', xiptHandleAclResponse);
joms.onAjaxReponse('system,ajaxReport', xiptHandleAclResponse);
joms.onAjaxReponse('profile,ajaxRemoveLinkProfileVideo', xiptHandleAclResponse);
joms.onAjaxReponse('videos,ajaxRemoveVideo', xiptHandleAclResponse);
joms.onAjaxReponse('photos,ajaxCreateAlbum', xiptHandleAclResponse);
joms.onAjaxReponse('profile,ajaxIgnoreUser', xiptHandleAclResponse);
joms.onAjaxReponse('profile,ajaxConfirmIgnoreUser', xiptHandleAclResponse);
joms.onAjaxReponse('groups,ajaxSaveJoinGroup', xiptHandleAclResponse);
joms.onAjaxReponse('groups,ajaxJoinGroup', xiptHandleAclResponse);

joms.onAjaxReponse('connect,ajaxShowNewUserForm', function(json){
	if(typeof(json.xipt) == 'undefined'){
		return true;
	}
	
	joms.popup.xiptfbc.update(json);
    
	return false;
});



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


(function( root, $, factory ) {

    joms.popup || (joms.popup = {});
    joms.popup.xiptfbc || (joms.popup.xiptfbc = {});
    joms.popup.xiptfbc.update = factory( root, $ );

   
        return joms.popup.xiptfbc.update;   

})( window, joms.jQuery, function() {

var popup, elem, isMember, data, profileId;

function render( _popup , json) {
	
	data = json['profileType'];
	
    if ( elem ) elem.off();
    popup = _popup;
    popup.items[0] = {
        type: 'inline',
        src: buildHtml( json )
    };

     popup.updateItemHTML();

     elem = popup.contentContainer;
     
     
     elem.on( 'click', '.joms-js--button-xiptnext', next );
     elem.on( 'click', '.joms-js--button-back2', back2 );
     elem.on( 'click', '.joms-js--button-xiptnext2', next2 );
     elem.on( 'click', '.joms-js--button-back3', back3 );
}

function next() {
    var tnc, error;
   
    tnc = elem.find('#joms-js--fbc-tnc-checkbox');
    if ( !tnc.length ) {
        connectNewUser(); 
        
    } else {
        tnc = tnc[0];
        error = elem.find('.joms-js--fbc-tnc-error');
        if ( tnc.checked ) {
            error.hide();
            connectNewUser();
        } else {
            error.show();
        }
    }
}

function back2() {
    elem.find('.joms-js--step2').hide();
    elem.find('.joms-js--step3').hide();
    elem.find('.joms-js--step1').show();
}

function next2() {
    if ( isMember ) {
        validateMember();
    } else {
        validateNewUser();
    }
}

function connectNewUser() {
	profileId=eval(data);
    joms.ajax({
        func: 'connect,ajaxShowNewUserForm',
        data: [ profileId ],
        callback: function( json ) {
            var div;
            
            elem.find('.joms-js--step1').hide();

            div = elem.find('.joms-js--step2');
            div.find('.joms-popup__content').html( json.html );
            div.find('.joms-js--button-back2').html( json.btnBack );
            div.find('.joms-js--button-next2').html( json.btnCreate );
            div.show();
        }
    });
}

function validateNewUser() {
    var div = elem.find('.joms-js--step2'),
        name = div.find('[name=name]').val(),
        user = div.find('[name=username]').val(),
        email = div.find('[name=email]').val(),
        types = div.find('[name=profiletype]'),
        profileType = '';

    if ( types.length ) {
        profileType = types.filter(':checked').val();
    }
    
    joms.ajax({
        func: 'connect,ajaxCreateNewAccount',
        data: [ name, user, email, profileType ],
        callback: function( json ) {
            var div;

            if ( json.error ) {
                elem.find('.joms-js--step2').hide();

                div = elem.find('.joms-js--step3');
                div.find('.joms-popup__content').html( json.error );
                div.find('.joms-js--button-back3').html( json.btnBack );
                div.show();
                return;
            }

            elem.off();
            popup.close();
            joms.popup.fbc.update();
        }
    });
}

function back3() {
    elem.find('.joms-js--step3').hide();
    elem.find('.joms-js--step1').hide();
    elem.find('.joms-js--step2').show();
}

function buildHtml( json ) {
    json || (json = {});

    return [
        '<div class="joms-popup joms-popup--whiteblock">',
        '<div class="joms-popup__title"><button class="mfp-close" type="button" title="Close (Esc)">×</button>', json.title, '</div>',
        '<div class="joms-js--step1">',
            '<div class="joms-popup__content ', ( json.btnNext ? '' : 'joms-popup__content--single' ), '">', ( json.error || json.html || '' ), '</div>',
            ( json.btnNext ? '<div class="joms-popup__action">' : '' ),
            ( json.btnNext ? '<button class="joms-button--primary joms-button--small joms-js--button-xiptnext">' + json.btnNext + '</button>' : '' ),
            ( json.btnNext ? '</div>' : '' ),
        '</div>',
        '<div class="joms-js--step2 joms-popup__hide">',
            '<div class="joms-popup__content"></div>',
            '<div class="joms-popup__action">',
                '<button class="joms-button--neutral joms-button--small joms-left joms-js--button-back2"></button>',
                '<button class="joms-button--primary joms-button--small joms-js--button-xiptnext2">'+ json.btnNext +'</button>',
            '</div>',
        '</div>',
        '<div class="joms-js--step3 joms-popup__hide">',
            '<div class="joms-popup__content joms-popup__content--single"></div>',
            '<div class="joms-popup__action">',
                '<button class="joms-button--neutral joms-button--small joms-left joms-js--button-back3"></button>',
            '</div>',
        '</div>',
        '</div>'
    ].join('');
}

// Exports.
return function(json) {
	_json = json;
    joms.util.popup.prepare(function( mfp ) {
        render( mfp , json);
    });
};

});

