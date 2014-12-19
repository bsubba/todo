<div class="row">
    <div class="span6 offset2">
        <div id="register_form_error" class="alert alert-error"><! Dynamic Content --></div>
        <form id="register_form" class="form-horizontal" method="post" action="<?= site_url('api/register')?>">
            <h3 class="text-center">Register</h3>
            <div class="control-group">
                <label class="control-label">Login</label>
                <div class="controls">
                    <input type="text" class="input-xlarge" name="login" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Email</label>
                <div class="controls">
                    <input type="text" class="input-xlarge" name="email" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Password</label>
                <div class="controls">
                    <input type="password" class="input-xlarge" name="password" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Confirm Password</label>
                <div class="controls">
                    <input type="password" class="input-xlarge" name="confirm-password" />
                </div>
            </div>
            <div class="control-group">

                <div class="controls">
                    <input type="submit" class="btn btn-primary" value="Register" />
                    <a class="btn" href="<?=  site_url('/') ?>">Cancel</a>
                </div>
            </div>
        </form>
        
    </div>
</div>
<script type="text/javascript">
    $(function(){
        $("#register_form_error").hide();
        $('#register_form').submit(function(evt){
            evt.preventDefault();
            var url = $(this).attr('action');
            var postData = $(this).serialize();
            $.post(url,postData,function(o){
                if(o.result == 1){
                    window.location.href = '<?=site_url('dashboard')?>';
                }else{
                   $("#register_form_error").show();
                   var output = "<ul>";
                   for(var key in o.error){
                       output += '<li>'+ key + ":" + o.error[key] +'</li>';
                   }
                   output += "</ul>";
                   $("#register_form_error").html(output);
                }
            },'json'); 
            
        });
    });
</script>
    


