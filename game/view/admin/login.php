<form class="login-form" method="POST">
  <h1><span class="log-in">login</span> in <span class="sign-up">chateau admin panel</span></h1>
  <? if($error){?>
  <div class="alert alert-error text-align-center">
    Login and/or password is incorrect.
  </div>
  <?}?>
  <p class="float">
    <label for="login">Username</label>
    <input type="text" name="login" id="login" placeholder="Username">
  </p>
  <p class="float">
    <label for="password">Password</label>
    <input type="password" name="password" id="password" placeholder="Password">
  </p>
  <p class="clearfix">
    <input type="submit" name="submit" value="Log in">
  </p>
</form>
<script type="text/javascript">
    $(function(){

    });
</script>