<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
  <meta http-equiv="Content-Language" content="ru" />
  <title>Chateau Admin Panel</title>
  <?if(@$sign){?>
  <link href="/css/bootstrap.min.css" type="text/css" rel="stylesheet" />
  <?} else {?>
  <link href="/css/login.css" type="text/css" rel="stylesheet" />
  <?}?>
  <link href="/css/admin.css" type="text/css" rel="stylesheet" />
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
  <script type="text/javascript" src="/js/cprogress.js"></script>
  <script type="text/javascript">
      var cprogress={
        'obj': null,
        'start':function (procent, callback) {
            $('body').addClass('locked').append('<div id="blacksubstract"></div>');
            this.obj = $('#blacksubstract').cprogress({
                img1: '/images/admin/pb_bg.png',
                img2: '/images/admin/pb_fg.png',
                speed: 20, // speed (timeout)
                PIStep : 0.05, // every step foreground area is bigger about this val
                loop : true, //if true, no matter if limit is set, progressbar will be running
                showPercent : false, //show hide percent
                onInit: function(){$('#blacksubstract').fadeIn(120)},
                onComplete: function(p){
                    if(callback=='function') callback();
                }
            });
        },
        'stop': function (){
            $('body').removeClass('locked').find('#blacksubstract').fadeOut(120, function(){
                cprogress.obj.destroy();
                $(this).remove();
            });
        }
      }
  </script>
</head>
<body>
<?=@$topmenu?>
<?=@$content?>
</body>
</html>