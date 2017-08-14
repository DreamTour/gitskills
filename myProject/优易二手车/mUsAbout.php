<?php
include "../../library/mFunction.php";
$about = query("content","id = 'HLt60805578CF' ");
echo head("m");
?>
	<body>
		<div class="wrap">
			<div class="about">
            	<h2><?php echo $about['title'];?></h2>
            	<?php echo ArticleMx("HLt60805578CF");?>
			</div>
		</div>
	</body>
</html>