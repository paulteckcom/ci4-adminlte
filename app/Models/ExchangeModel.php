<?php 
namespace App\Models;

use CodeIgniter\Model;

class ExchangeModel extends Model
{
	protected $table      = 'exchanges';
	protected $primaryKey = 'id';

	/**
	 * [getIdByName description]
	 * @param  [type] $exchangeName [description]
	 * @return [type]               [description]
	 */
	public function getIdByName($exchangeName) {
		$builder = $this->db->table($this->table);
		$query = $builder->getWhere(['name' => $exchangeName]);
		return $query->getResult();
	}

	/**
	 * [getIdByName description]
	 * @param  [type] $exchangeName [description]
	 * @return [type]               [description]
	 */
	public function getNameById($exchangeId) {
		$builder = $this->db->table($this->table);
		$query = $builder->getWhere(['name' => $exchangeName]);
		return $query->getResult();
	}

	/**
	 * [all description]
	 * @return [type] [description]
	 */
	public function all() {
		$builder = $this->db->table($this->table);
		$query = $builder->get();
		return $query->getResult();
	}

}