<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TbMuaSam
 * 
 * @property int $id
 * @property string $tentb
 * @property string $mota
 * @property int $gia
 * @property int $soluong
 * @property string $trangthai
 * @property int $idmuasam
 * 
 * @property Muasamvattu $muasamvattu
 *
 * @package App\Models
 */
class TbMuaSam extends Model
{
	protected $table = 'tb_mua_sam';
	public $timestamps = false;

	protected $casts = [
		'gia' => 'int',
		'soluong' => 'int',
		'idmuasam' => 'int'
	];

	protected $fillable = [
		'tentb',
		'mota',
		'gia',
		'soluong',
		'trangthai',
		'idmuasam'
	];

	public function muasamvattu()
	{
		return $this->belongsTo(Muasamvattu::class, 'idmuasam');
	}
}
