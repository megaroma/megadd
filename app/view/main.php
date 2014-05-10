<html>
<body>
head

<?php if($logged): ?>
logged as <?=$name;?>;
<form method="post">
<input type="submit" name="logout" value="Log Out">
</form>
<?php else: ?>
<form method="post">
Name:<input type="text" name="username"><br>
Pass:<input type="password" name="password"><br>
Error code:<?=$error;?><br>
<input type="submit" value="Go">
</form>
<?php endif; ?>

<hr>
<?=$content;?>
<hr>
foter
</body>
</html>