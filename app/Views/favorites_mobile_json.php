	<?php 
  	if(is_array($favorites) && count($favorites) > 0):
  	foreach($favorites as $v):
  		$price = preg_replace("/\.?0+$/", "", 
			number_format($v['price'], 8, ".", "")
		);
  	?>
		<div class="col-lg-3 col-6">
	        <!-- small card -->
	        <div class="small-box <?php echo $v['changeCss']['bg'];?>">
	          <div class="inner">
	            <h4>
	            	<a href="<?= site_url('trade');?>?market=<?php echo $v['pair'];?>"><?php echo $v['pair'];?></a><br />
	            	<strong><?php echo $price;?></strong><br />
	            	<small><span class="mr-1"><i class="fas <?= $v['changeCss']['icon'];?>"></i></span><?php echo $v['change'];?> %</small>
	            </h4>

	            <h5>
	            	[<span class="<?php echo $v['ratioRes'];?>"><?php echo $v['ratio'];?></span>]
	          	</h5>
	          </div>
	          <div class="icon">
	            <i class="fas fa-shopping-cart"></i>
	          </div>
	          <div class="small-box-footer">
				<button class="btn btn-sm btn-danger" onclick="deleteFavorite(<?php echo $v['marketId'];?>)"><i class="fas fa-trash-alt"></i></button>
	          </div>
	        </div>
	    </div>
		<!-- /.info-box -->
    <?php
    endforeach;
    endif;
    ?>