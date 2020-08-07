<?php 
namespace App\Models;

use CodeIgniter\Model;

class FavoriteModel extends Model
{
	/**
	 * [$table description]
	 * @var string
	 */
	protected $table 	= 'favorites';
	protected $primaryKey = 'id';

	/**
	 * [all description]
	 * @return [type] [description]
	 */
	public function all() {

	}

	/**
	 * [exist description]
	 * @return [type] [description]
	 */
	public function exist($data) {
		$builder = $this->db->table($this->table);
		$query = $builder->getWhere($data);
		return $query->getResult();
	}

	/**
	 * [find description]
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	// public function find($id = null) {
	// 	$builder = $this->db->table($this->table);
	// 	$query = $builder->getWhere(['id' => $id]);
	// 	return $query->getResult();
	// }

	/**
	 * [add description]
	 */
	public function add($data) {
		$builder = $this->db->table($this->table);
		return $builder->insert($data);
	}

	/**
	 * [edit description]
	 * @return [type] [description]
	 */
	// public function edit() {

	// }

	/**
	 * [delete description]
	 * @return [type] [description]
	 */
	public function deleteFav($data) {
		$builder = $this->db->table($this->table);
		$builder->where($data);
		$builder->delete();
	}
}