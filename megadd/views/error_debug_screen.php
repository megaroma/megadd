<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title><?=$type;?></title>
<style>
body {
	font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
	font-size: 14px;
	line-height: 20px;
	color: #333333;
	background-color: #f5f5f5;
}
a.trace {
	color:#000000;
	text-decoration:none;
	font-weight:bold;
}
.v_trace {
	display:none;
}
.code_left {
	float:left;
	padding: 10px 10px 10px 10px;
	background-color:#FFFFFF;
	-webkit-border-top-left-radius: 10px;
	-webkit-border-bottom-left-radius: 10px;
	-moz-border-radius-topleft: 10px;
	-moz-border-radius-bottomleft: 10px;
	border-top-left-radius: 10px;
	border-bottom-left-radius: 10px;
	border: 1px solid #fbeed5;
}
.code_body {
	float:left;
	padding: 10px 10px 10px 10px;
	background-color:#FFFFFF;
	border: 1px solid #fbeed5;
}
.error_line {
	background-color:#f2dede;
}
.container {
	padding: 10px 10px 10px 10px;
}
.error_head {
	color: #b94a48;
	background-color: #f2dede;
	border: 1px solid #fbeed5;
	-webkit-border-radius: 4px;
	-moz-border-radius: 4px;
	border-radius: 4px;
	padding: 5px 5px 5px 5px;
}
.trace_body {
	padding: 5px 5px 5px 5px;
}
</style>
</head>
<body>
<div class="container">
<div class="error_head"><b><?=$type;?></b> Code:<?=$code;?>  Message:<?=$message;?></div>
<div class="trace_body">
<?php foreach($trace as $k => $v):?>
<div>
	<a id="id_<?=$k;?>" class="trace" onclick="trace(<?=$k;?>);return false;" <?php if($k==1) echo "style=\"color:#FFFFFF;background-color:#000000;\"";?> href="#">
		<?=$v['file'];?>
	</a>
</div>
<?php endforeach; ?>
</div>

<div>
<?php foreach($files as $k => $v):?>
<div id="id_v_<?=$k;?>" class="v_trace" <?php if($k==1) echo "style=\"display:block;\"";?>>

<div class="code_left">
<?php foreach ($v as $i => $data):?>
	<div><?php echo $i;?></div>
<?php endforeach; ?>
</div>
<div class="code_body">
<?php foreach ($v as $i => $data):?>
	<div class="<?php echo ($lines[$k] == $i)? "error_line":"";?>">
	<?php echo $data;?>
	</div>
<?php endforeach; ?>
</div>

</div>
<?php endforeach; ?>
</div>
</div>
<script>
function trace(id) {
	var trace = document.getElementsByClassName("trace");
	var i = trace.length;
	while(i--) {
		trace[i].style.color="#000000";
		trace[i].style.backgroundColor="#FFFFFF";
	}
	var El = document.getElementById("id_"+id);
	El.style.color="#FFFFFF";
	El.style.backgroundColor="#000000";

	trace = document.getElementsByClassName("v_trace");
	i = trace.length;
	while(i--) {
		trace[i].style.display="none";
	}
	El = document.getElementById("id_v_"+id);
	El.style.display="block";
}
</script>
</body>
</html>