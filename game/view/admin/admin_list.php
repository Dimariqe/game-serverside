<table class="table table-striped table-bordered table-hover table-condensed">
<thead>
<tr>
  <th width="5%">ID</th>
  <th width="20%">Login</th>
  <th width="75%"></th>
</tr>
</thead>
<tbody>
<? foreach($admins as $admin){?>
<tr>
  <td><?=$admin['id']?></td>
  <td><?=$admin['login']?></td>
  <td>
    <a href="?act=admin&editor=<?=$admin['id']?>" class="btn btn-warning btn-small" title="Edit password" onclick="return (editPasswd(<?=$admin['id']?>, '<?=$admin['login']?>'))">
      <i class="icon-asterisk icon-white"></i>
    </a>
    <a href="?act=admin&delete=<?=$admin['id']?>" class="btn btn-danger btn-small" title="Remove admin">
      <i class="icon-remove icon-white"></i>
    </a>
  </td>
</tr>
<?}?>
<tr>
  <td colspan="3" align="center">
    <form style="margin:0; text-align: center;" method="POST">
      <div class="input-append input-prepend" style="display: inline-block;">
        <span class="add-on"><i class="icon-user"></i></span>
        <input type="text" placeholder="Login" name="newlogin">
        <span class="add-on"><i class="icon-asterisk"></i></span>
        <input type="password" placeholder="Password" name="newpassword">
        <input type="submit" class="btn btn-success" value="Add">
      </div>
    </form>
  </td>
</tr>
</tbody>
</table>
  <script type="text/javascript">
    function editPasswd(id, login) {
      dialog=
          '<form method="POST" class="abstract_center modal-mini"><div class="input-append input-prepend">' +
            '<span class="add-on"><i class="icon-asterisk"></i></span>' +
            '<input type="hidden" name="id" value="'+id+'">' +
            '<input type="hidden" name="login" value="'+login+'">' +
            '<input type="hidden" name="type" value="passwordchange">' +
            '<input type="password" placeholder="Password" name="passwordchange">' +
            '<input type="submit" class="btn btn-success" value="Save">' +
          '</div></form>';

      $('body').addClass('lock').append('<div id="blacksubstract"></div>').find('#blacksubstract').html(dialog).fadeIn(200, function(){
        $(this).one('click', function(e){
          if(e.target != this) return;
          $('body').removeClass('lock');
          $(this).fadeOut(200, function(){$(this).remove();})
        });
      });
      return false;
    }
  </script>