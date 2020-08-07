<div class="card">
	<div class="card-body">
		<div class="form-row align-items-center">
		    <div class="col-auto">
		    	<?php echo form_dropdown('pair', $markets, '' , 'class="form-control select2" id="pair_id"');?>
		    </div>
			<div class="col-auto">
				<button type="submit" class="btn btn-primary" id="addButton" onclick="addToFavorites()">Add</button>
				<?php 
				if(isset($apiData['secret'])) :
				?>
				<button type="submit" class="btn btn-warning" id="tradeButton" onclick="goToTrade()">Trade</button>
				<?php 
				endif;
				?>
			</div>
		</div>
	</div>
</div>
<?php
// $html = '';
// $htmlReponsive = '';
// if(is_array($favorites) && count($favorites) > 0){
//   	foreach($favorites as $v){
// 		$price = preg_replace("/\.?0+$/", "", 
// 			number_format($v['price'], 8, ".", "")
// 		);

// 		$high = preg_replace("/\.?0+$/", "", 
// 			number_format($v['high'], 8, ".", "")
// 		);

// 		$low = preg_replace("/\.?0+$/", "", 
// 			number_format($v['low'], 8, ".", "")
// 		);

// 		$htmlReponsive .= 
// 		'
// 		<div class="col-lg-3 col-6">
// 	        <!-- small card -->
// 	        <div class="small-box '.$v['changeCss']['bg'] .'">
// 	          <div class="inner">
// 	            <h4>
// 	            	<a href="'.site_url('trade').'?market='.$v['pair'].'">'.$v['pair'].'</a><br />
// 	            	<strong>'.$price.'</strong><br />
// 	            	<small><span class="mr-1"><i class="fas '.$v['changeCss']['icon'].'"></i></span>'.$v['change'].' %</small>
// 	            </h4>

// 	            <h5>
// 	            	[<span class="'.$v['ratioRes'].'">'.$v['ratio'].'</span>]
// 	          	</h5>
// 	          </div>
// 	          <div class="icon">
// 	            <i class="fas fa-shopping-cart"></i>
// 	          </div>
// 	          <div class="small-box-footer">
// 				<button class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button>
// 	          </div>
// 	        </div>
// 	    </div>
// 		';

// 		$html .= 
// 		'
// 		<tr>
//         	<td><button class="btn btn-danger btn-xs mr-2" onclick="deleteFavorite('.$v['marketId'].')"><i class="fas fa-trash-alt"></i></button><a href="'.site_url('trade').'?market='.$v['pair'].'"><strong>'.$v['pair'].'</strong></a></td>
//         	<td>'.$price.'</td>
//         	<td class="'.$v['changeCss']['color'].'"><small class="mr-1"><i class="fas '.$v['changeCss']['icon'].'"></i></small>'.$v['change'].' %</td>
//         	<td>'.$high .'</td>
//         	<td>'.$low .'</td>
//         	<td>'.$v['volume'] . " " . $v['market'] .'</td>
//         	<td><span class="'.$v['ratioClass'].'">'.$v['ratio'].'</span></td>
//         </tr>
// 		';
// 	}
// }

?>
<div class="responsive-lists">
<div class="row" id="listMobile">
	<div class="text-center col-md-12">
      	<div class="spinner-border" role="status">
		  <span class="sr-only">Loading...</span>
		</div>
	</div>
</div>
</div>
<div class="card favorites-lists">
	<div class="card-body p-0">
		<table class="table table-striped">
          <thead>
            <tr>
              <th>Pair</th>
              <th>Last</th>
              <th>24h Change</th>
              <th>High</th>
              <th>Low</th>
              <th>Volume</th>
              <th style="width: 50px;">Buy/Sell</th>
            </tr>
          </thead>
          <tbody id="coinlist">
          	<tr>
          		<td colspan="7">
          			<div class="text-center">
			          	<div class="spinner-grow text-secondary" role="status">
						  <span class="sr-only">Loading...</span>
						</div>
						<div class="spinner-grow text-secondary" role="status">
						  <span class="sr-only">Loading...</span>
						</div>
						<div class="spinner-grow text-secondary" role="status">
						  <span class="sr-only">Loading...</span>
						</div>
					</div>
				</td>
			</tr>
          </tbody>
        </table>
	</div>
</div>