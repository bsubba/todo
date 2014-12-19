var Template = function(){
    //-------------------------------------------------------------------
    
    this.__construct = function(){
        
    };
    
   
    // ------------------------------------------------------------------------
    
    this.todo = function(obj) {
        
        var output = '';
        if(obj.completed === 1){
            output += '<div class="todo_complete" id="todo_'+ obj.todo_id +'">';
        }else{
            output += '<div id="todo_'+ obj.todo_id +'">';
        }
        
        output += '<span>' + obj.content + '</span>';
        output += '<span class="options">';
        if(obj.completed === 1){
            output += '<a class="todo_update" data-id="'+obj.todo_id+'" data-completed=0 href="api/update_todo"><i class="icon-share-alt"></i></a>'
        }else{
            output += '<a class="todo_update" data-id="'+obj.todo_id+'" data-completed=1 href="api/update_todo"><i class="icon-ok"></i></a>'
        }
        
        output += '<a data-id="'+obj.todo_id+'" class="todo_delete" href=api/delete_todo><i class="icon-remove"></i></a>';
        output += '</span>';
        output += '</div>';
        return output;
    };
    
    // ------------------------------------------------------------------------
    
    this.note = function(obj) {
        var output = '';
        output += '<div id="'+ obj.note_id +'">';
        output += '<span><a class="note_toggle" data-id= '+obj.note_id +' id="note_title_'+obj.note_id +'" href="#">' + obj.title + '</a></span>';
        output += '<span class="options">'
        output += '<a class="note_update_display" data-id="'+obj.note_id+'" href="#"><i class="icon-pencil"></i></a>'
        output += '<a data-id="'+obj.note_id+'" class="note_delete" href=api/delete_note><i class="icon-remove"></i></a>';
        output += '<div class="note_edit_container" id="note_edit_container_'+obj.note_id+'"></div>';
        output += '<div id="note_content_'+obj.note_id+'" class="hide">'+obj.content+'</div>';        
        output += '</div>';
        output += '</span>'
        return output;
    };
    
    // ------------------------------------------------------------------------
    this.note_edit = function(note_id){
        var output = '';
        output+="<form method='post' class='note_edit_form form-horizontal' action='api/update_note'>";
        output+="<input class = 'note_id' type='hidden' name='note_id' value='"+note_id+"' />";
        
        output+='<div class="input-append">';
        output+='<input tabindex="1" class="title" type="text" name="title" placeholder="Note Title" />';
        
        output+='<input tabindex="3" type="submit" value="Update" class="btn btn-success" />';
        output+='<input type="submit" value="Cancel" class="note_edit_cancel btn" />';
        output+='</div>';
        output+='<div class="clearfix"></div>';
        output+="<textarea class ='content' name='content'></textarea>";
       
        
        
        
       
        
        output+="</form>";
        return output;
    }
    
    this.__construct();
    
};

    
    
   


