jQuery(function ($) {
    'use strict';    
     var select_all = function(control){       
        jQuery(control).focus().select();
    };
    jQuery(".txtarea_response").click(function(){
        select_all(this);
    });
});