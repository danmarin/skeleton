<?php require 'header.php' ?>

<div class="container">
	<div class="rows">
		<div class="col-md-12">
			<h1>This is the membership area</h1>
			<p><a href="<?=$this->url['user_logout_url']?>">Logout</a></p>
			<pre>
			<?php print_r($_SESSION) ?>
			</pre>
		</div>
	</div>
</div>

<?php require 'footer.php' ?>