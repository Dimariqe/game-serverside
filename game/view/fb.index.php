<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script src="//connect.facebook.net/<?=$locale?>/all.js"></script>
    <script src="<?=$servers["static"]?>/js/external-libs.min.js" type="text/javascript"></script>
    <link href="<?=$servers["static"]?>/css/style-fb.css?v=1.2.5" type="text/css" rel="stylesheet" />
    <link href="<?=$servers["static"]?>/css/button-<?=$locale?>.css?v=1.2.5" type="text/css" rel="stylesheet" />
    <style type="text/css">
			body {margin: 0;}
			#nav-tab-5 a { color: #ffff77; font-weight: bold; }
    </style>
    <script>
        flash_loaded = false;
        function onFlashLoaded() {
						flash_loaded = true;
				}

        $(document).ready(function() {
            FB.init({appId: "<?=$config['id']?>", status: true, cookie: true, oauth: true});

            initShatoSwf();
            $('#flash_player_container').live('mouseenter', function(){
                $(this).focus();
            });
        });

        function initShatoSwf() {
            var flash_cache = "?rnd=" + Math.random();
            var IE = false;
            if ($.browser.msie) {
                IE = true;
                flash_cache = "?ie=" + Math.random();
            }

            var flashvars = {
                is_ie: IE,
                Lang: "<?=$locale?>",
                UID: "<?=$uid?>",
                AppID: "<?=$appid?>",
                Social: "<?=$social?>",
                Token: "<?=$token?>",
                DebugPid: 2
            };
            swfobject.embedSWF(
									"<?=$config['swf']?>" + flash_cache,
									"flash_player_container",
									"100%",
									"620",
									"9.0.0",
									"<?=$servers["static"]?>/swf/expressInstall.swf",
									flashvars,
									{ allowfullscreen: "true", allownetworking: "all", allowscriptaccess: "always", wmode: "direct" },
									{}
            );
            FB.Canvas.setSize();
				}
    </script>
</head>
<body class="overflow:hidden;">
<div class="main-container-wrapper">

<div id="fb-root"></div>
	<div id="fb-like">
			<div style="width: 600px; display: inline-block;">
					<div class="fb-fanpage"><a class="text-container" href="https://www.facebook.com/ChateauComm" target="_blank">Fan Page</a></div>
					<iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2FChateauComm&amp;send=false&amp;layout=standard&amp;width=500&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=35&amp;appId=366006733451548" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:500px; height:35px;" allowTransparency="true"></iframe>
			</div>
	</div>


<div id="flash_player_container"></div>
<div class="ui-image container-bottom"></div>
<div class="six-waves-banner">
    <a href="http://6wav.es/pubby6w" target="_blank"> <img style="border:0px;width:213px;height:26px;" src="//img.6waves.com/published-by-6waves.gif" /></a><br>
    <a href="http://arvara.net/" target="_blank" style="position: relative; top: 9px;"><img src="<?=$servers["static"]?>/images/logo.gif" class="logo" border="0"></a> |
    <a href="<?=$servers["static"]?>/information/privacy_policy.htm" target="_blank">Privacy Policy</a> |
    <a href="<?=$servers["static"]?>/information/terms_of_service.htm" target="_blank">Terms of Service</a>
</div>
</div>
</body>
</html>