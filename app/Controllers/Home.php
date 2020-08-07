<?php 
namespace App\Controllers;

use App\Models\HomeModel;
use App\Models\TradeModel;
use App\Models\MarketModel;
use App\Models\ExchangeModel;
use App\Models\FavoriteModel;

class Home extends BaseController
{
	public function __construct() {
		helper('form');
	}

	public function index()
	{
		// check if user logged in
		if(!checkAuth($this)) {
			return redirect()->to('login');
		}

		$apiData = $this->session->get('apiData');

		$market = new MarketModel();
		$exchange = new ExchangeModel();

		$exchangeId = $exchange->getIdByName(
			empty($apiData['exchange']) ? 'Binance' : $apiData['exchange']
		);

		$allMarkets = $market->all($exchangeId[0]->id);
		
		$data['markets'] = formatArray($allMarkets, 'id', 'pair');
		
		//$data['favorites']	= $this->renderFavorites();

		$data['jsScript'] = [
			"
			setInterval(function() {
				if($(window).width() < 768) {
					var responsive = 'yes';
				}
			    $.ajax({
			        url: '".base_url('home/favorites')."',
			        type: 'post',
			        data: {
						mobile: responsive
			        },
			        dataType: 'html',
			        success:function(response){
			        	if(responsive == 'yes') {
							\$('#listMobile').html(response);
			        	}
			        	else {
			        		\$('#coinlist').html(response);
			        	}
			            
			        }
			    });
			}, 2000);
			",
			"
			function addToFavorites() {
				$.ajax({
				    url: '".base_url('home/addToFavorites')."',
				    type: 'post',
				    data: {id: \$('#pair_id').val()},
				    dataType: 'json',
				    success:function(response){
				    	xjson = \$.parseJSON(JSON.stringify(response));

				        toastr.options = {
				            'closeButton': true,
				            'debug': false,
				            'onclick': null,
				            'positionClass': 'toast-top-full-width',
				            'showDuration': '1000',
				            'hideDuration': '1000',
				            'timeOut': '5000',
				            'extendedTimeOut': '1000',
				            'showEasing': 'swing',
				            'hideEasing': 'swing',
				            'showMethod': 'slideDown',
				            'hideMethod': 'slideUp'
				        }

				        if (xjson.status == 'true') {
				            toastr.success(xjson.message);
				        } else {
				            toastr.error(xjson.message);
				        }
				    }
				});
			}
			",
			"
			function deleteFavorite(id) {
				$.ajax({
				    url: '".base_url('home/deleteFromFavorites')."',
				    type: 'post',
				    data: {id: id},
				    dataType: 'json',
				    success:function(response){
				    	xjson = \$.parseJSON(JSON.stringify(response));

				        toastr.options = {
				            'closeButton': true,
				            'debug': false,
				            'onclick': null,
				            'positionClass': 'toast-top-full-width',
				            'showDuration': '1000',
				            'hideDuration': '1000',
				            'timeOut': '5000',
				            'extendedTimeOut': '1000',
				            'showEasing': 'swing',
				            'hideEasing': 'swing',
				            'showMethod': 'slideDown',
				            'hideMethod': 'slideUp'
				        }

				        if (xjson.status == 'true') {
				            toastr.success(xjson.message);
				        } else {
				            toastr.error(xjson.message);
				        }
				    }
				});
			}
			",
			"
			function goToTrade() {
				pair = $('#pair_id option:selected').text();
				window.location.replace('".base_url('trade')."?market=' + pair);
			}
			"
		];
		return render($this, 'home', $data);
	}

	/**
	 * [favorites description]
	 * @return [type] [description]
	 */
	public function favorites() {

		// check if user logged in
		if(!checkAuth($this)) {
			return redirect()->to('login');
		}

		$mobile = $this->request->getPost('mobile');

		$data['favorites'] = $this->renderFavorites();
		if($mobile == 'yes') {
			return view('favorites_mobile_json', $data);
		} 
		return view('favorites_json', $data);
	}

	/**
	 * [addToFavorites description]
	 */
	public function addToFavorites() {
		$market_id = $this->request->getPost('id');
		$user_id = $this->session->get('userData.id');

		$favorite = new FavoriteModel();

		$exist = $favorite->exist([
			'market_id'	=> $market_id,
			'user_id'	=> $user_id
		]);
		if(count($exist)>0) {
			$result['status'] = 'warning';
	        $result['message'] = 'Pair already added to favorites';
	        echo json_encode($result);
	        return;
		}
		else {
			$inserted = $favorite->add([
				'market_id'	=> $market_id,
				'user_id'	=> $user_id
			]);
			//var_dump($inserted);
			$result['status'] = 'true';
	        $result['message'] = 'Added new pair to favorites successful';
	        echo json_encode($result);
	        return;
		}
		
	}

	/**
	 * [deleteFromFavorites description]
	 * @return [type] [description]
	 */
	public function deleteFromFavorites() {
		$id = $this->request->getPost('id');

		$favorite = new FavoriteModel();

		$favorite->deleteFav([
			'user_id'	=> $this->session->get('userData.id'),
			'market_id'	=> $id
		]);

		$result['status'] = 'true';
        $result['message'] = 'Data has been deleted';
        echo json_encode($result);
        return;
	}

	
	private function renderFavorites() {

		// init home model
		$home = new HomeModel();

		$favorites = $home->getFavorites($this->session->get('userData.id'));
		if(is_array($favorites) && count($favorites) > 0) {
			foreach($favorites as $v) {
				$ticker = $this->ccxt->fetch_ticker($v->pair);
				if($ticker['percentage'] > 0) {
					$change['bg'] = 'bg-success';
					$change['color'] = 'text-success';
					$change['icon'] = 'fa-arrow-up';
					$change['sign']  = "+";
				}
				else {
					$change['bg'] = 'bg-danger';
					$change['color'] = 'text-danger';
					$change['icon'] = 'fa-arrow-down';
					$change['sign']  = "";
				}
				list($v1, $v2) = explode("/", $v->pair);

				// get buy/sell ratio (history)
				$ratio = $home->getBuySellRatio($this->ccxt, $v->pair);

				//$ratio = 1;
				if($ratio > 1) {
					$ratioClass = 'text-success';

				}
				else {
					$ratioClass = 'text-danger';
				}
				$ratioRes = 'text-warning';

				$favoritesData[] = [
					'marketId'	=> $v->market_id,
					'pair' 		=> $v->pair,
					'market'	=> $v2,
					'price' 	=> (float)$ticker['last'],
					'high'		=> $ticker['high'],
					'low'		=> $ticker['low'],
					'change'	=> abs($ticker['percentage']),
					'changeCss'	=> $change,
					'volume'	=> number_format($ticker['quoteVolume'], 0),
					'ratio'		=> $ratio,
					'ratioClass'	=> $ratioClass,
					'ratioRes'	=> $ratioRes

				];
			}

			return $favoritesData;
		}

		return null;
	}
	//--------------------------------------------------------------------
}
