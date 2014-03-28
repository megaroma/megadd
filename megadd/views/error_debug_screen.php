<style>
a.trace {
color:#000000;
text-decoration:none;
font-weight:bold;
}
.v_trace {
display:none;
}
</style>

<div><?=$type;?></div>
<div><?=$message;?></div>
<div>
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
<div id="id_v_<?=$k;?>" class="v_trace" <?php if($k==1) echo "style=\"display:block;\"";?>><?=$v;?></div>
<?php endforeach; ?>
</div>

<script>
function trace(id)
{
var trace = document.getElementsByClassName("trace");
var i = trace.length;
while(i--) {
if (i == id) {
trace[i].style.color="#FFFFFF";
trace[i].style.backgroundColor="#000000";
} else {
trace[i].style.color="#000000";
trace[i].style.backgroundColor="#FFFFFF";
} 
}

var v = document.getElementsByClassName("v_trace");
var i = trace.length;
while(i--) {
if (i == id) {
v[i].style.display="block";
} else {
v[i].style.display="none";
} 
}



}
</script>