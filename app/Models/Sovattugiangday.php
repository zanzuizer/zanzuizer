<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Sovattugiangday
 * 
 * @property int $id
 * @property int|null $id_tb
 * @property string $danhmuc
 * @property int $tieuhao
 * @property string $dvt
 * @property string $ngaynhan
 * @property string $ten_gv1
 * @property int $sl_gv1
 * @property string $ngaynhan_gv1
 * @property string $ngaytra_gv1
 * @property string $ten_gv2
 * @property int $sl_gv2
 * @property string $ngaynhan_gv2
 * @property string $ngaytra_gv2
 * @property int $create_at
 * @property int $people_create
 * @property int|null $people_update
 * @property int $mahocky
 * @property string|null $ghichu
 * @property int $madonvi
 *
 * @package App\Models
 */
class Sovattugiangday extends Model
{
	protected $table = 'sovattugiangday';
	public $timestamps = false;

	protected $casts = [
		'id_tb' => 'int',
		'tieuhao' => 'int',
		'sl_gv1' => 'int',
		'sl_gv2' => 'int',
		'create_at' => 'int',
		'people_create' => 'int',
		'people_update' => 'int',
		'mahocky' => 'int',
		'madonvi' => 'int'
	];

	protected $fillable = [
		'id_tb',
		'danhmuc',
		'tieuhao',
		'dvt',
		'ngaynhan',
		'ten_gv1',
		'sl_gv1',
		'ngaynhan_gv1',
		'ngaytra_gv1',
		'ten_gv2',
		'sl_gv2',
		'ngaynhan_gv2',
		'ngaytra_gv2',
		'create_at',
		'people_create',
		'people_update',
		'mahocky',
		'ghichu',
		'madonvi'
	];
}
