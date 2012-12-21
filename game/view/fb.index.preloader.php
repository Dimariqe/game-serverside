<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script src="//connect.facebook.net/<?=$locale?>/all.js"></script>
    <script src="<?=$servers["static"]?>/js/external-libs.min.js" type="text/javascript"></script>
    <link href='<?=$servers["static"]?>/css/button-<?=$locale?>.css' type='text/css' rel='stylesheet' />
    <link href="<?=$servers["static"]?>/css/style-fb.css?v=1.2.5" type="text/css" rel="stylesheet" />
    <!--[if IE]>
	<style type="text/css">
		.container-nav span a { font: 12px; padding: .5em 1em .2em 1em; }
		.tab-friends .dialog-friends-container-top { margin: 0; }
		.tab-friends .dialog-friends-container-bottom { margin: 0; }
		.tab-friends .dialog-friends-container { margin: 0; }
	</style>
    <![endif]-->
    <style type="text/css">
        body {margin: 0;}
        .six-waves-banner { text-align: center; display: block; margin-top: 10px; }
        .main-container-wrapper { width: 100%; text-align: center; }
        #fb-like { height: 30px; margin-top: 10px; }
        #flash_player_container { margin-top: 10px; }
    </style>
    <script>
        static_files   = "<?=$servers["static"]?>";

        $(document).ready(function() {
            FB.init({appId: "<?=$config['id']?>", status: true, cookie: true, xfbml: false, oauth : true});

            swfobject.embedSWF(
                    static_files + "/swf/intro.swf",
                    "flash_player_container",
                    "730",
                    "590",
                    "9.0.0",
                    static_files + "/swf/expressInstall.swf",
                    {Lang: '<?=$locale?>'},
                    { allowfullscreen: "true", allownetworking: "all", allowscriptaccess: "always", wmode: "direct" },
                    {}
            );
        });

        function callPermissions() {
            top.location.href = "<?=$http_scheme?>://www.facebook.com/dialog/oauth?client_id=<?=$config['id']?>&redirect_uri=<?=$http_scheme?>://apps.facebook.com/<?=$config['alias']?>&scope=email,publish_actions";
        }
    </script>
</head>
<body>
<div class="main-container-wrapper">
    <div id="fb-root"></div>
    <div id="fb-like">
        <div style="width: 600px; display: inline-block;">
            <div class="fb-fanpage"><a class="text-container" href="https://www.facebook.com/ChateauComm" target="_blank">Fan Page</a></div>
            <iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2FChateauComm&amp;send=false&amp;layout=standard&amp;width=500&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=35&amp;appId=366006733451548" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:500px; height:35px;" allowTransparency="true"></iframe>
        </div>
    </div>

    <div id="flash_player_container"></div>

    <div class="six-waves-banner">
        <a href="http://6wav.es/pubby6w" target="_blank"> <img style="border:0px;width:213px;height:26px;" src="//img.6waves.com/published-by-6waves.gif" /></a><br>
        <a href="http://arvara.net/" target="_blank" style="position: relative; top: 9px;"><img src="<?=$servers["static"]?>/images/logo.gif" class="logo" border="0"></a> |
        <a href="<?=$servers["static"]?>/information/privacy_policy.htm" target="_blank">Privacy Policy</a> |
        <a href="<?=$servers["static"]?>/information/terms_of_service.htm" target="_blank">Terms of Service</a>
    </div>

</div>
</body>
</html>