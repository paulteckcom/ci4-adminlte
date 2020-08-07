<?php 
namespace App\Models;

use CodeIgniter\Model;

class MarketModel extends Model
{
	protected $table      = 'markets';
	protected $primaryKey = 'id';

	/**
	 * get all market by exchange
	 * @return [type] [description]
	 */
	public function all($exchangeId) {
		$builder = $this->db->table($this->table);
		$query = $builder->getWhere(['exchange' => $exchangeId]);
		return $query->getResult();
	}

}