<?php 
namespace App\Models;

use CodeIgniter\Model;

class HomeModel extends Model
{
	/**
	 * [getFavorites description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function getFavorites($id) {
		$builder = $this->db->table('favorites');
		$builder->select('*');
		$builder->join('markets', 'favorites.market_id = markets.id', 'left');
		$query = $builder->getWhere(['user_id' => $id]);

		return $query->getResult();
	}

	/**
	 * [checkIfAdded description]
	 * @param  [type] $user_id   [description]
	 * @param  [type] $market_id [description]
	 * @return [type]            [description]
	 */
	public function checkIfAdded($user_id, $market_id) {

	}

	/**
	 * [addToFavorites description]
	 * @param [type] $user_id   [description]
	 * @param [type] $market_id [description]
	 */
	public function addToFavorites($user_id, $market_id) {

	}

	/**
	 * [getBuySellRatio description]
	 * @param  [type] $pair [description]
	 * @return [type]       [description]
	 */
	public function getBuySellRatio($ccxt, $pair) {

		$results = $ccxt->fetch_trades($pair);
        $buy = 0;
        $sell = 0;
        foreach($results as $item) 
        {
            if($item['side'] == 'buy') 
            {
                $buy += $item['info']['q'];
            }
            elseif($item['side'] == 'sell')
            {
                $sell += $item['info']['q'];
            }
        }

        $percent = number_format($buy/$sell, 4);

        return $percent;
	}
}