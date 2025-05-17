<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Nhatkybaotri
 * 
 * @property int $id
 * @property int $matb
 * @property int $maphong
 * @property int $mahocky
 * @property string $ngaybaotri
 * @property string $motahuhong
 * @property string $noidungbaotri
 * @property string $nguoibaotri
 * @property string $nguoikiemtra
 * @property string|null $ghichu
 * @property int $matk
 * @property int|null $user_update
 * @property int $ngaytao
 *
 * @package App\Models
 */
class Nhatkybaotri extends Model
{
	protected $table = 'nhatkybaotri';
	public $timestamps = false;

	protected $casts = [
		'matb' => 'int',
		'maphong' => 'int',
		'mahocky' => 'int',
		'matk' => 'int',
		'user_update' => 'int',
		'ngaytao' => 'int'
	];

	protected $fillable = [
		'matb',
		'maphong',
		'mahocky',
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
