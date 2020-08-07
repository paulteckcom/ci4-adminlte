<?php 
namespace App\Models;

use CodeIgniter\Model;

class CmcModel extends Model
{
	protected $table      = 'coinmarketcap';
	protected $primaryKey = 'id';

	public function insert_batch($data) {
		$builder = $this->db->table($this->table);
		//pp($data, true);
		return $builder->insertBatch($data);
	}

}