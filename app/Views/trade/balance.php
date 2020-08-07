<?php 
//pp($balance, true);
?>
<div class="row">
	<div class="col-md-6" style="margin: 0 auto;">
		<div class="card">
			<div class="card-body bg-info">
				<div class="row">
					<div class="col-6">
						Total Balance : <strong><?php echo number_format($total,8);?> BTC</strong>
					</div>
					<div class="col-6 text-right">
						<a href="#" class="btn btn-warning btn-xs" onclick="location.reload()"><i class="fas fa-sync-alt"></i></a>
					</div>
				</div>
			</div>
		</div>
		<div class="card">
			<div class="card-body p-0">
				<div class="table-responsive">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>Asset</th>
								<th>Free</th>
								<th>Locked</th>
								<th>Total(BTC)</th>
							</tr>
						</thead>
						<tbody>
							<?php
							if(is_array($balance) && count($balance) > 0) {
								foreach($balance as $key=>$b) {
									?>
									<tr>
										<td><strong><?php echo $b['asset'];?></strong></td>
										<td><?php echo $b['free'];?></td>
										<td><?php echo $b['locked'];?></td>
										<td><?php echo number_format($b['estbtc'], 8);?></td>
									</tr>
									<?php
								}
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>