<?php require_once(APPPATH . "Views/Template/header_v.php"); ?>

<div class='container'>
	<div class='row'>
		<div class='col'>







			<div class="container">
				<h3>Welcome to <?= $identity->identity_name; ?></h3>
				<p>>>></p>
				<?= session()->get("user_name"); ?>
			</div>


			<!-- <script>
				$(document).ready(function() {
					toast('INFO >>>', 'ddddd');
				});
			</script> -->


		</div>
	</div>
</div>

<?php require_once(APPPATH . "Views/Template/footer_v.php"); ?>