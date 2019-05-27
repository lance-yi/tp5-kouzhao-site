{__NOLAYOUT__}<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport"
          content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <script src="__JS__/Admin/jquery.min.js"></script>
    <script src="__JS__/layer/layer.js"></script>
    <title>跳转提示</title>
</head>
<body>
<script type="text/javascript">
    (function () {
        var msg = '<?php echo(strip_tags($msg));?>';
        var href = '<?php echo($url);?>';
        var wait = '<?php echo($wait);?>';
        <?php switch ($code) { case 1:?>
            layer.msg(msg, {
                icon: 6,
                shade: 0.1
            });
        <?php break; case 0:?>
            layer.msg(msg, {
                icon: 5,
                shade: 0.1
            });
        <?php break;}?>
        setTimeout(function () {
            location.href = href;
        }, 1000)
    })();
</script>
</body>
</html>
