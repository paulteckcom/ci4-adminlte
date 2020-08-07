<?php 
if(is_array($favorites) && count($favorites) > 0):
foreach($favorites as $v):
	$price = preg_replace("/\.?0+$/", "", 
		number_format($v['price'], 8, ".", "")
	);

	$high = preg_replace("/\.?0+$/", "", 
		number_format($v['high'], 8, ".", "")
	);

	$low = preg_replace("/\.?0+$/", "", 
		number_format($v['low'], 8, ".", "")
	);
?>
<tr>
	<td><button class="btn btn-danger btn-xs mr-2" onclick="deleteFavorite(<?php echo $v['marketId'];?>)"><i class="fas fa-trash-alt"></i></button><a href="<?= site_url('trade');?>?market=<?php echo $v['pair'];?>"><strong><?php echo $v['pair'];?></strong></a></td>
	<td><?php echo $price;?></td>
	<td class="<?php echo $v['changeCss']['color'];?>"><small class="mr-1"><i class="fas <?= $v['changeCss']['icon'];?>"></i></small><?php echo $v['change'];?> %</td>
	<td><?php echo $high;?></td>
	<td><?php echo $low;?></td>
	<td><?php echo $v['volume'] . " " . $v['market'];?></td>
	<td><span class="<?php echo $v['ratioClass'];?>"><?php echo $v['ratio'];?></span></td>
</tr>
<?php
endforeach;
endif;
?>