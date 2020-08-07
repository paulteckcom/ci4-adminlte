<?php 
namespace App\Controllers;

use App\Models\HomeModel;
use App\Models\TradeModel;
use App\Models\MarketModel;
use App\Models\ExchangeModel;
use App\Models\FavoriteModel;
use App\Models\OrderModel;
use Auth\Models\UserModel;
use App\Models\CmcModel;
use CoinMarketCap as CoinMarketCap2;
use DateTime;


class Coinmarketcap extends BaseController
{
	public function __construct() {
		helper('form');
	}

	public function index() {

		$items = $this->cmc->cryptocurrency()->listingsLatest(['limit' => 100, 'convert' => 'USD']);
		
		//$response = $this->cmc->cryptocurrency()->info(['symbol' => 'BTC,ETH']);
		
		$cmc = new CmcModel();

		$coins = $cmc->findAll();

		foreach($coins as $coin) {
			$coinData[$coin['symbol']] = $coin;
		}

		$coinmarketcap = new CoinMarketCap2\Api('472dd506-b714-46f3-87f8-911f68ac3afc');

		$global = $coinmarketcap->globalMetrics()->quotesLatest(['convert' => 'USD']);
		//$global = $this->cmc->globalMetrics()->quotesLatest(['convert' => 'USD']);

		//pp($global, true);

		$data = [
			'items' 	=> $items->data,
			'coinData'	=> $coinData,
			'global'	=> $global->data
		];

		return render($this, 'cmc/index', $data);
	}

	public function update() {
		$latest = $this->cmc->cryptocurrency()->listingsLatest(['limit' => 200, 'convert' => 'USD']);
		foreach($latest->data as $item) {
			$array[] = $item->symbol;
		}

		$symbol = $this->cmc->cryptocurrency()->info(['symbol' => implode(",", $array)]);

		//pp($symbol, true);
		foreach($symbol->data as $item) {
			//pp($item, true);
			$insertData[] = [
				'name'  	=> $item->name,
				'cmc_id'	=> $item->id,
				'logo'		=> $item->logo,
				'symbol'	=> $item->symbol,
				'website'	=> $item->urls->website[0],
				'slug'		=> $item->slug,
				'category'	=> $item->category,
				'description'	=> $item->description,
			];
		}

		$cmc = new CmcModel();

		$cmc->truncate();
		$insert = $cmc->insert_batch($insertData);
		echo "Coinmarketcap databse update with latest 200 coin";
		//var_dump($insertData);
	}
}