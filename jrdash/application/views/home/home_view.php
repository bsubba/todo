<div class="row">
    <div class="span6 offset2">
        <form id="login_form" class="form-horizontal" method="post" action="<?= site_url('api/login')?>">
            <h3 class="text-center">Login</h3>
            <div class="control-group">
                <label class="control-label">Login</label>
                <div class="controls">
                    <input type="text" class="input-xlarge" name="login" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Password</label>
                <div class="controls">
                    <input type="password" class="input-xlarge" name="password" />
                </div>
            </div>
            <div class="control-group">

                <div class="controls">
                    <input type="submit" class="btn btn-primary" value="Login" />
                    <a class="btn" href="<?= site_url('home/register') ?>">Register</a>
                </div>
            </div>
        </form>
        
    </div>
</div>
<script type="text/javascript">
    $(function(){
        $('#login_form').submit(function(evt){
            evt.preventDefault();
            var url = $(this).attr('action');
            var postData = $(this).serialize();
            $.post(url,postData,function(o){
                if(o.result == 1){
                    window.location.href = '<?=site_url('dashboard')?>';
                }else{
                    alert('Invalid Login');
                }
            },'json'); 
            
        });
    });
</script>
    


