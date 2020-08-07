<?php 
namespace App\Controllers;

use App\Models\HomeModel;
use App\Models\TradeModel;
use App\Models\MarketModel;
use App\Models\ExchangeModel;
use App\Models\FavoriteModel;
use App\Models\OrderModel;
use Auth\Models\UserModel;
use DateTime;


class Trade extends BaseController
{
	public function __construct() {
		helper('form');
	}

	/**
	 * [index description]
	 * @return [type] [description]
	 */
	public function index()
	{
		// check if user logged in
		if(!checkAuth($this)) {
			return redirect()->to(site_url('login'));
		}
		// get symbol and market 
		$pair = $this->request->getGet('market');

		$ticker = $this->ticker($pair);

		if(!$ticker) {
			$sessionMsg['type'] = 'warning';
        	$sessionMsg['message'] = 'Please select pair to trade';
        	$this->session->setFlashdata('sessionMsg', $sessionMsg);
			return redirect()->to(site_url('home'));
		}
		list($v1, $v2) = explode("/", $pair);
		$apiData = $this->session->get('apiData');
		
		// check if api data not input redirect to input api data
		if(!$apiData['key']) {
			return redirect()->to(site_url('trade/api'));
		}

		// get balance of selected market

		$b = $this->getBalance();

        $keys = array_column($b, 'free');

        array_multisort($keys, SORT_DESC, $b);

        // echo "<pre>";
        // print_r($b);
        // echo "</pre>";
        // exit();
        //pp($ticker, true);

		$market = new MarketModel();
		$exchange = new ExchangeModel();

		$exchangeId = $exchange->getIdByName(
			empty($apiData['exchange']) ? 'Binance' : $apiData['exchange']
		);

		$allMarkets = $market->all($exchangeId[0]->id);
		
		$data = [
			'markets'	=> formatArray($allMarkets, 'pair', 'pair', TRUE),
			'balance'	=> $b,
			'apiData'	=> $apiData,
			'symbol'	=> $v1,
			'market'	=> $v2,
			'pair' 		=> $pair,
			'ticker'	=> $ticker,
			'openorders'=> $this->openOrders()
		];

		$data['jsScript'] =[
			"
			function calculateValue(side, type)
		    {
		      var priceTag = '#' + side + '-price';
		      var amountTag = '#' + side + '-amount';
		      var totalTag = '#' + side + '-total';
		      var price = $(priceTag).val();

		      if( price == '' || price == 0)
		      {
		        var last = $('#lastPrice').html();

		        $('#' + side + '-price').val(parseFloat(last));

		        price = parseFloat(last);
		      }



		      if(type == 'amount')
		      {
		        var total = $(amountTag).val() * price;
		        $(totalTag).val(total.toFixed(8));
		        //alert($(amountTag).val());
		      }
		      else if(type == 'total')
		      {
		        var amount = $(totalTag).val()/price;
		        $(amountTag).val(amount.toFixed(8));
		      }
		    }
		    ",
		    "
		    function checkType(type, side) {
		    	if(type == 'market') {
					$('#priceGroup-' + side).hide();
		    	}
		    	else {
					$('#priceGroup-' + side).show();
		    	}
		    }
		    ",
		    "
		    function createOrder(side)
		    {
		      var type = $('#' + side + '-type').val();
		      var pair = '". $data['pair'] ."';
		      var amount = $('#' + side + '-amount').val();
		      var price = $('#' + side + '-price').val();

		      if(type == '')
		      {
		        alert('Please select trade type');
		        $('#' + side + '-type').focus();
		        return;
		      }
		      else if(pair == '')
		      {
		        alert('Please select trading pair');
		        $('#pair_id').focus();
		        return;
		      }
		      else if(amount == '')
		      {
		        alert('Please input Amount');
		        $('#' + side + '-amount').focus();
		        return;
		      }
		      else if(price == '')
		      {
		        alert('Please input price');
		        $('#' + side + '-price').focus();
		        return;
		      }

		      $.ajax({
		        type:'POST',
		        data:{ 
		          pair: pair, 
		          price: price, 
		          amount: amount, 
		          side: side, 
		          type: type
		        },
		        dataType:'json',
		        url: '".site_url('trade/createorder')."',

		        success: function(msg){
		            msg = JSON.stringify(msg);
		            \$json = \$.parseJSON(msg);

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

		            if (\$json.status == 'true') {
		                toastr.success(\$json.message);
		                location.reload();
		            } else {
		                toastr.error(\$json.message);
		            }
		        }
		      });
		    }
		    ",
		    "
			setInterval(function() {
			    $.ajax({
			        url: '".base_url('getlast.php')."',
			        type: 'post',
			        data: {
			        	pair: '".$pair."'
			       	},
			        dataType: 'html',
			        success:function(response){
			            \$('#lastPrice-buy').html(response);
			            \$('#lastPrice-sell').html(response);
			        }
			    });
			}, 1000);
			",
			"
			function goToTrade() {
				pair = $('#pair_id option:selected').text();
				window.location.replace('".base_url('trade')."?market=' + pair);
			}
			",
			"
			function fillPercent(number, side) {
				var available = parseFloat($('#available-' + side).text());
				if(side == 'buy') {
					total = (available*number)/100;
					//alert(total.toFixed(8));
					$('#' + side + '-total').val(total.toFixed(8));
					calculateValue(side, 'total');
				}
				else {
					amount = (available*number)/100;
					$('#' + side + '-amount').val(amount.toFixed(8));
					calculateValue(side, 'amount');
				}
			}
			",
			"
			$(function () {
				$('.cancelorder').click(function(){
		            id = $(this).attr('data-id');
		            symbol = $(this).attr('data-symbol');
		            target = $(this);
		            $.ajax({
		                type:'POST',
		                data:{
		                	id: id,
		                	symbol: symbol
		                },
		                dataType:'html',
		                url:$(this).attr('data-url'),

		                success: function(msg){
		                    \$json = \$.parseJSON(msg);

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

		                    if (\$json.status == 'true') {
		                        target.parent().parent().hide('slow');
		                        toastr.success(\$json.message);
		                        location.reload();
		                    } else {
		                        toastr.error(\$json.message);
		                    }
		                }
		            });
				})
			})
			"
		];
		
		return render($this, 'trade/index', $data);
	}

	/**
	 * [api description]
	 * @return [type] [description]
	 */
	public function api() {
		// check if user logged in
		if (!checkAuth($this)) {
			return redirect()->to(site_url('login'));
		}

		if($this->session->get('apiData')) {
			return redirect()->to(site_url('home'));
		}

		if($this->request->getPost('submitBtn')) {
			return $this->saveApiData();
		}
		$exchange = new ExchangeModel();

		// get all exchange and format to array
		$data['exchange'] = formatArray($exchange->all(), 'name', 'name', TRUE);
		return render($this, 'trade/api', $data);
	}

	public function createOrder() {
		// $type = $this->request->getGet('type');
		// $pair = $this->request->getGet('pair');
		// $amount = $this->request->getGet('amount');
		// $price = $this->request->getGet('price');
		// $side = $this->request->getGet('side');
		
		$type = $this->request->getPost('type');
		$pair = $this->request->getPost('pair');
		$amount = $this->request->getPost('amount');
		$price = $this->request->getPost('price');
		$side = $this->request->getPost('side');

		$error = FALSE;

		try {
			$order = $this->ccxt->create_order($pair, $type, $side, $amount, $price, ['recvWindow' => 50000]);
		
		}catch (\ccxt\NetworkError $e) {
		    $error = TRUE;
		} catch (\ccxt\ExchangeError $e) {
		    $error = TRUE;
		} catch (Exception $e) {
		    $error = TRUE;
		}
		if(!$error){
			$result['status'] = 'true';
            $result['message'] = 'Order has been created';
            echo json_encode($result);
        }
        else {
        	$result['status'] = 'warning';
            $result['message'] = 'Something go wrong, Cannot create order';
            echo json_encode($result);
        }
	}

	private function saveApiData() {
		$data = [
			'exchange' 	=> $this->request->getPost('exchange'),
			'key'		=> $this->request->getPost('apikey'),
			'secret'	=> $this->request->getPost('secret')
		];

		//var_dump($data); exit();

		$this->session->set('apiData', $data);

		return redirect()->to(site_url('trade'));
	}


	private function getBalance($asset = null)
    {
        //pp($this->exchange, 1);
        //var_dump($this->exchange); exit();
        $balance = $this->ccxt->fetch_balance(array('recvWindow'=> 50000));

        //pp($balance);
        //
        //var_dump($balance); exit();

        $array = [];
        foreach($balance['info']['balances'] as $b)
        {
            if($b['free'] > 0)
            {
                if($asset && $b['asset'] === $asset)
                {
                    return $b;
                }

                //if($b['asset'] != 'BTC' )
                // $b['market'] = $this->getMarket($b['asset']);
                $array[$b['asset']] = $b;
            }
        }

        return $array;
    }

    public function orderBook() {
    	$pair = $this->request->getGet('pair');
    	$results = $this->ccxt->fetch_trades($pair);

    	//pp($results, TRUE);
    	$buyHtml = '';
    	$sellHtml = '';

    	if($results) {
    		for($i=0; $i<count($results);$i++) {
    			if($results[$i]['side'] == 'sell') {
    				//echo $results[$i]['price']; exit();
    				echo $results[$i]['price']. "<br />";
    				$sell[(string)$results[$i]['price']][] =  $results[$i]['amount'];
    			}
    			else {
    				//echo $results[$i]['price']. "<br />";
    				$buy[(string)$results[$i]['price']][] =  $results[$i]['amount'];
    			}
    			// if($results[$i]['side'] == 'sell') {
    			// 	$sellHtml .= '
    			// 	<tr>
    			// 		<td>'.$results[$i]['amount'].'</td>
    			// 		<td class="text-right text-danger">'.$results[$i]['price'].'</td>
    			// 	</tr>
    			// 	';
    			// }
    			// else {
    			// 	$buyHtml .= '
    			// 	<tr>
    			// 		<td>'.$results[$i]['amount'].'</td>
    			// 		<td class="text-right text-success">'.$results[$i]['price'].'</td>
    			// 	</tr>
    			// 	';
    			// }
    		}

    		// echo "<pre>";
    		// print_r($sell);
    		// echo "</pre>"; 	
    		// exit();
    		//ksort($buy, SORT_STRING);
    		ksort($sell, SORT_STRING);
    		
    		//pp($sell, true);
    		

    		foreach($sell as $key=>$value) {
    			$sellHtml .= '
				<tr>
					<td>'.array_sum($value).'</td>
					<td class="text-right text-danger">'.$key.'</td>
				</tr>
				';
    		}

    		foreach($buy as $key=>$value) {
    			$buyHtml .= '
				<tr>
					<td>'.array_sum($value).'</td>
					<td class="text-right text-success">'.$key.'</td>
				</tr>
				';
    		}

    		return '
    			<div class="row">
    				<div class="col-6">
    					<table class="table">
    					'.$buyHtml.'
    					</table>
    				</div>
    				<div class="col-6">
    					<table class="table">
    					'.$sellHtml.'
    					</table>
    				</div>
    			</div>
    		';
    	}
    }

    private function ticker($pair = '')
    {
        if(empty($pair)) 
        {
            return FALSE;
        }

        try {
            return $this->ccxt->fetch_ticker($pair);
        }catch (\ccxt\NetworkError $e) {
            return FALSE;
        } catch (\ccxt\ExchangeError $e) {
            return FALSE;
        } catch (Exception $e) {
            return FALSE;
        }

        
    }

    public function getLast() {

    	$pair = $this->request->getPost('pair');
    	if(empty($pair)) 
        {
            echo '';
            return;
        }

        try {
            $ticker = $this->ccxt->fetch_ticker($pair);


			$last = number_format($ticker['last'], 8);
			

			echo preg_replace("/\.?0+$/", "", $last);

        }catch (\ccxt\NetworkError $e) {
            echo '';
        } catch (\ccxt\ExchangeError $e) {
            echo '';
        } catch (Exception $e) {
            echo '';
        }
    }

    public function openOrders()
    {
    	$pair = $this->request->getGet('market');
    	if(!empty($pair)) {
    		$openorders = $this->ccxt->fetch_open_orders($pair, NULL, NULL, ['recvWindow' => 50000]);
    		//pp($openorders, true);
    		if(count($openorders) > 0) {
    			foreach($openorders as $order) {
    				$filledPercent = number_format($order['filled']/$order['info']['origQty'], 0);
    				$array[] = [
    					'orderId' 	=> $order['info']['orderId'],
    					'symbol'	=> $order['symbol'],
    					'quantity'	=> $order['amount'],
    					'price'		=> $order['price'],
    					'filled'	=> $order['filled'],
    					'filledPer' => $filledPercent,
    					'time'		=> new DateTime($order['datetime']),
    					'type'		=> $order['type'],
    					'side'		=> $order['side']
    				];
    			}
    			return $array;
    			//pp($array, true);
    		}
    		return [];
    	}
    	else {
    		return [];
    	}
    }

    public function cancelOrder()
    {
        $orderId = $this->request->getPost('id');
        $symbol = $this->request->getPost('symbol');

        $cancel = $this->ccxt->cancel_order($orderId, $symbol, ['recvWindow' => 50000]);
        
        //$order = new OrderModel();
        if($cancel)
        {
            //$order->delete($orderId);
            $result['status'] = 'true';
            $result['message'] = 'Order '. $orderId .' has been cancelled';
            echo json_encode($result);
            return;
        }
        else
        {
            $result['status'] = 'warning';
            $result['message'] = 'Something go wrong, Cannot cancel order '. $orderId;
            echo json_encode($result);
            return;
        }
    }

    public function balance() {
    	$balance = $this->getBalance();

    // 	if(is_array($balance) && count($balance) > 0) {
    // 		foreach($balance as $key=>$value) {
    			

    // 			try
				// {
				//     $info = $this->cmc->cryptocurrency()->info(['symbol' => $key]);
				// }
				// catch (\Exception $e)
				// {
				//     echo$e->getMessage());
				// }
    // 			//pp($info->data->{$key}->logo, true);
    // 			$array[$key] = $value;
    // 			$array[$key]['logo'] = $info->data->{$key}->logo;
    // 			$array[$key]['name'] = $info->data->{$key}->name;
    // 		}
    // 	}
    	$totalBtc  = 0;
    	if(is_array($balance) && count($balance) > 0) {
    		foreach($balance as $key=>$value) {
    			if(!in_array($key, ['BTC', 'USDT'])) {
    				$ticker = $this->ticker($key . "/BTC");
	    			if($ticker) {
	    				
	    				$value['estbtc'] = $ticker['last']*($value['free'] + $value['locked']);
	    				$array[] = $value;
	    				$totalBtc += $ticker['last']*($value['free'] + $value['locked']);
	    			}
	    		} elseif ($key == 'USDT') {
	    			$ticker = $this->ticker("BTC/". $key);
	    			$value['estbtc'] = ($value['free'] + $value['locked'])/$ticker['last'];
	    			$array[] = $value;
	    			$totalBtc += ($value['free'] + $value['locked'])/$ticker['last'];

	    		} elseif($key == 'BTC') {
	    			$value['estbtc'] = $value['free'] + $value['locked'];
	    			$array[] = $value;
	    			$totalBtc += $value['free'] + $value['locked'];
	    		}
    			
    		}

    		$keys = array_column($array, 'estbtc');

            array_multisort($keys, SORT_DESC, $array);
    	}

    	$data = [
    		'balance'	=> $array,
    		'total'		=> $totalBtc
    	];
    	return render($this, 'trade/balance', $data);
    }
	//--------------------------------------------------------------------
}
