<?php require_once(APPPATH . "Views/Template/header_v.php"); ?>

<div class='container'>
	<div class='row'>
		<div class='col'>


			<div class="row">
				<div class="col-12 alert alert-success mt-3">
					<h3>Welcome to <?= $identity->identity_name; ?></h3>
					<p class="alert alert-warning">Selamat Datang : <span class="text-success bold"><?= strtoupper(session()->get("user_name")); ?></span></p>
				</div>
				<div class="col-6">
					<div class="alert alert-warning text-center text-primary">
						<span class="text-dark">Member :</span>
						<?php $member = $this->db->table("user")
							->where("position_id", "0")
							->where("schools_id", session()->get("schools_id"))
							->get()
							->getNumRows();
						echo $member;
						?>

						orang
					</div>
				</div>
				<div class="col-6">
					<div class="alert alert-warning text-center text-primary">
						<span class="text-dark">Sisa Tagihan :</span>
						<?php 
						$tagihan = $this->db->table("tagihan")
							->select("SUM(tagihan_nominal)AS ttagihan")
							->where("schools_id", session()->get("schools_id"))
							->get();
						$totaltagihan = 0;
						foreach ($tagihan->getResult() as $row) {
							$totaltagihan = $row->ttagihan;
						}
						$pay = $this->db->table("pay")
							->select("SUM(pay_nominal)AS tpay")
							->where("schools_id", session()->get("schools_id"))
							->get();
						$totalpay = 0;
						foreach ($pay->getResult() as $row) {
							$totalpay = $row->tpay;
						}
						$sisa= $totaltagihan-$totalpay;						
						?>
						Rp. <?= number_format($sisa,0,",",".");?>,-

						
					</div>
				</div>
				<div class="col-12 mt-3 p-0">
					<img src="<?=session()->get("schools_logo");?>" style="width:100%; height:auto;"/>
				</div>
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