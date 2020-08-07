
<?php 
$last = number_format($ticker['last'], 8, ".", "");

$last = preg_replace("/\.?0+$/", "", $last);

//exit();

?>
<div class="row">
	<div class="col-md-6">
		<div class="card">
			<div class="card-body">
				<div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <button type="button" class="btn btn-danger"><?= $apiData['exchange'];?></button>
                  </div>
                  <!-- /btn-group -->
                  <?php echo form_dropdown('pair', $markets, $pair , 'class="form-control select2" id="pair_id" onchange="goToTrade()"');?>
                </div>
			</div>
		</div>
		<ul class="nav nav-pills mb-3 nav-justified bg-secondary rounded" id="pills-tab" role="tablist">
		  <li class="nav-item">
		    <a class="nav-link active text-white" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Buy</a>
		  </li>
		  <li class="nav-item">
		    <a class="nav-link text-white" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Sell</a>
		  </li>
		</ul>
		<div class="tab-content" id="pills-tabContent">
		  <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
		  	<div class="card">
		  		<div class="card-body">
		  			<div class="form-group">
						<select id="buy-type" class="form-control" onchange="checkType(this.value, 'buy')">
							<option value="limit">Limit Order</option>
							<option value="market">Market Order</option>
						</select>
					</div>
					<div class="" id="priceGroup-buy">
					<div class="form-group">
						<input type="number" id="buy-price" class="form-control" placeholder="Buy price" value="<?php echo $last;?>">
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-6">
								Last Price (Live)
							</div>
							<div class="col-6 text-right">
								<strong><?php echo '<span id="lastPrice-buy">' . $last . "</span> " . $market;?></strong>
							</div>
						</div>
					</div>
					</div>
					<div class="form-group">
						<input type="number" id="buy-amount" class="form-control" onkeyup="calculateValue('buy', 'amount');" placeholder="Amount<?php echo empty($symbol) ? '' : ' (' . $symbol .')';?>">
					</div>
					<div class="row form-group">
						<div class="col-3">
							<button class="btn btn-xs btn-outline-secondary" style="width: 100%;" onclick="fillPercent(25, 'buy')">25%</button></div>
						<div class="col-3">
							<button class="btn btn-xs btn-outline-secondary" style="width: 100%;" onclick="fillPercent(50, 'buy')">50%</button>
						</div>
						<div class="col-3">
							<button class="btn btn-xs btn-outline-secondary" style="width: 100%;" onclick="fillPercent(75, 'buy')">75%</button>
						</div>
						<div class="col-3">
							<button class="btn btn-xs btn-outline-secondary" style="width: 100%;" onclick="fillPercent(100, 'buy')">100%</button>
						</div>
					</div>
					<div class="form-group">
						<input type="number" id="buy-total" onkeyup="calculateValue('buy', 'total');" class="form-control" placeholder="Total<?php echo empty($market) ? '' : ' (' . $market .')';?>">
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-6">
								Available
							</div>
							<div class="col-6 text-right">
								<strong><span id="available-buy"><?php echo (!isset($balance[$market]['free']) ? 0 : $balance[$market]['free']) . "</span> " . $market;?></strong>
							</div>
						</div>
					</div>
					<button class="btn btn-success" style="width: 100%;" onclick="createOrder('buy')">Buy<?php echo empty($symbol) ? '' : ' (' . $symbol .')';?></button>
		  		</div>
		  	</div>
		  </div>
		  <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
		  	<div class="card">
		  		<div class="card-body">
		  			<div class="form-group">
						<select id="sell-type" class="form-control select2">
							<option value="limit">Limit Order</option>
							<option value="market">Market Order</option>
							<option value="stop-limit">Stop-Limit Order</option>
						</select>
					</div>
					<div class="form-group">
						<input type="number" id="sell-price" class="form-control" placeholder="Buy price" value="<?php echo $last;?>">
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-6">
								Last Price (Live)
							</div>
							<div class="col-6 text-right">
								<strong><?php echo '<span id="lastPrice-sell">' . $last . "</span> " . $market;?></strong>
							</div>
						</div>
					</div>
					<div class="form-group">
						<input type="number" id="sell-amount" onkeyup="calculateValue('sell', 'amount');" class="form-control" placeholder="Amount<?php echo empty($symbol) ? '' : ' (' . $symbol .')';?>">
					</div>
					<div class="row form-group">
						<div class="col-3">
							<button class="btn btn-xs btn-outline-secondary" style="width: 100%;" onclick="fillPercent(25, 'sell')">25%</button></div>
						<div class="col-3">
							<button class="btn btn-xs btn-outline-secondary" style="width: 100%;" onclick="fillPercent(50, 'sell')">50%</button>
						</div>
						<div class="col-3">
							<button class="btn btn-xs btn-outline-secondary" style="width: 100%;" onclick="fillPercent(75, 'sell')">75%</button>
						</div>
						<div class="col-3">
							<button class="btn btn-xs btn-outline-secondary" style="width: 100%;" onclick="fillPercent(100, 'sell')">100%</button>
						</div>
					</div>
					<div class="form-group">
						<input type="number" id="sell-total" onkeyup="calculateValue('sell', 'total');" class="form-control" placeholder="Total<?php echo empty($market) ? '' : ' (' . $market .')';?>">
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-6">
								Available
							</div>
							<div class="col-6 text-right">
								<strong><span id="available-sell"><?php echo (!isset($balance[$symbol]['free']) ? 0 : $balance[$symbol]['free']) . "</span> " . $symbol;?></strong>
							</div>
						</div>
					</div>
					<button class="btn btn-danger" style="width: 100%;" onclick="createOrder('sell')">Sell<?php echo empty($symbol) ? '' : ' (' . $symbol .')';?></button>
		  		</div>	
		  	</div>
		  </div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="card">
			<div class="card-header bg-info">
				Open Orders
			</div>
			<div class="card-body">
				<table class="table">
					<tbody>
					<?php 
					if(count($openorders) > 0) {
						foreach($openorders as $order) {
							if($order['side'] == 'buy') {
								$colorCss = ' text-success';
								$colorChart = '#28A745';
							}
							else {
								$colorCss = ' text-danger';
								$colorChart = '#DC3545';
							}
							?>
							<tr>
								<td class="text-center<?php echo $colorCss;?>">
									<?php echo ucwords($order['side'] ." ". $order['type']); ?><br />
									<input type="text" class="knob" value="<?php echo $order['filledPer'];?>" data-thickness="0.1" data-width="50" data-height="50" data-fgColor="<?php echo $colorChart;?>">
									</td>
								<td>
									<?php echo $order['symbol'];?><br />
									<span class="text-muted"><span class="pr-4">Amount</span><?php echo $order['filled'];?> / <?php echo $order['quantity'];?></span><br />
									<span class="pr-4 text-muted">Price</span><?php echo $order['price'];?>
								</td>
								<td>
									<?php echo $order['time']->format('Y-m-d H:i:s');?><br />
									<button class="btn btn-outline-warning cancelorder" data-id="<?= $order['orderId'] ?>" data-symbol="<?= $order['symbol'] ?>" data-url="<?php echo base_url('trade/cancelOrder');?>">Cancel</button>
								</td>
							</tr>
							<?php
						}
					} 
					else {
						?>
						<?php
					}
					?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
