var Result = function(){
    //-------------------------------------------------------------------
    
    this.__construct = function(){
        
        
    };
   
    // ------------------------------------------------------------------------
    
    this.success = function(msg){
        if(typeof msg === 'undefined'){
            $('#success').html('Success').fadeIn();
            return false;
        }
        $('#success').html(msg).fadeIn();
        setTimeout(function(){
           $('#success').fadeOut();
       },5000);
    };
    // ------------------------------------------------------------------------
    
    this.error = function(msg){
        if(typeof msg === 'undefined'){
           $('#error').html('Error').fadeIn();        
        }
       if(typeof msg === 'object'){
           var output = '<ul>';
           for (var key in msg){
               output += '<li>'+ msg[key] + '</li>';
           }
           output += '</ul>';
           $('#error').html(output).fadeIn();
            $('#success').fadeOut();
       }else{
            $('#error').html(msg).fadeIn();
       }
       setTimeout(function(){
           $('#error').fadeOut();
       },5000);
    };
    this.__construct();
    
};

    
    
   



