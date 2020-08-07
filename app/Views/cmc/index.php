<?php
//pp($items, true); 
?>
<h2 class="text-center pb-4" style="width: 100%;">Coinmarketcap Top 100</h2>

<div class="card favorites-lists">
	<div class="card-body p-0">

		<table class="table table-striped">
      <thead>
        <tr>
          <th style="width: 5px;" class="text-center">Rank</th>
          <th>Name</th>
          <th>Market Cap</th>
          <th>Price</th>
          <th>Volume(24h)</th>
          <th>Circulating Supply</th>
          <th>Change(24h)</th>
          <th class="text-right">Price Graph(7d)</th>
        </tr>
      </thead>
      <tbody>
        <?php 
        if($items) {
          $i=1;
          foreach($items as $item) {
            if($item->quote->USD->price < 1) {
              $price = preg_replace("/\.?0+$/", "", number_format($item->quote->USD->price, 8, ".", ""));
            }
            else {
              $price = number_format($item->quote->USD->price, 2);
            }

            if($item->quote->USD->percent_change_24h > 0) {
              $colorCss = "text-success";
            }
            else {
              $colorCss = "text-danger";
            }
            ?>
            <tr>  
              <td class="text-center"><strong><?= $i; ?></strong></td>
              <td><img class="rounded-circle" src="<?= $coinData[$item->symbol]['logo'];?>" height="16px" /> <a href="https://coinmarketcap.com/currencies/<?=$coinData[$item->symbol]['slug'];?>/" target=_blank><span style="font-weight: 600;font-size: 15px;"><?=$item->name;?></span></a></td>
              <td>$<?= number_format($item->quote->USD->market_cap, 0);?></td>
              <td>$<?=$price;?></td>
              <td>$<?=number_format($item->quote->USD->volume_24h, 0);?></td>
              <td><?=number_format($item->circulating_supply, 0);?> <?=$item->symbol;?></td>
              <td><span class="<?=$colorCss;?>"><?=$item->quote->USD->percent_change_24h;?>%</span></td>
              <td><img src="https://s2.coinmarketcap.com/generated/sparklines/web/7d/usd/<?=$coinData[$item->symbol]['cmc_id'];?>.png" /></td>
            </tr>
            <?php
            $i++;
          }
        }
        ?>
      </tbody>
    </table>
  </div>
</div>
