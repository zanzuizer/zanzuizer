<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LuutruTaptin
 * 
 * @property int $id
 * @property string $ten_file
 * @property string $loai_file
 * @property int $id_nguoidung
 * @property int $id_denghi
 * 
 * @property DeNghi $de_nghi
 * @property Taikhoan $taikhoan
 *
 * @package App\Models
 */
class LuutruTaptin extends Model
{
	protected $table = 'luutru_taptin';
	public $timestamps = false;

	protected $casts = [
		'id_nguoidung' => 'int',
		'id_denghi' => 'int'
	];

	protected $fillable = [
		'ten_file',
		'loai_file',
		'id_nguoidung',
		'id_denghi'
	];

	public function de_nghi()
	{
		return $this->belongsTo(DeNghi::class, 'id_denghi');
	}

	public function taikhoan()
	{
		return $this->belongsTo(Taikhoan::class, 'id_nguoidung');
	}
}
