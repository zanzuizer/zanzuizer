<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class NhatkytungtbBaotri
 * 
 * @property int $id
 * @property int $matb
 * @property int $maphong
 * @property int $ma_namsd
 * @property string $ngaybaotri
 * @property string $motahuhong
 * @property string $noidungbaotri
 * @property string $nguoibaotri
 * @property string $nguoikiemtra
 * @property string $ghichu
 * @property int $matk
 * @property int $user_update
 * @property int $ngaytao
 *
 * @package App\Models
 */
class NhatkytungtbBaotri extends Model
{
	protected $table = 'nhatkytungtb_baotri';
	public $timestamps = false;

	protected $casts = [
		'matb' => 'int',
		'maphong' => 'int',
		'ma_namsd' => 'int',
		'matk' => 'int',
		'user_update' => 'int',
		'ngaytao' => 'int'
	];

	protected $fillable = [
		'matb',
		'maphong',
		'ma_namsd',
		'ngaybaotri',
		'motahuhong',
		'noidungbaotri',
		'nguoibaotri',
		'nguoikiemtra',
		'ghichu',
		'matk',
		'user_update',
		'ngaytao'
	];
}
