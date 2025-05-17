<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Thietbidogo
 * 
 * @property int $id
 * @property string $tentb
 * @property string|null $mota
 * @property string|null $maso
 * @property string|null $namsd
 * @property string|null $nguongoc
 * @property string|null $donvitinh
 * @property int|null $soluong
 * @property int|null $gia
 * @property int|null $chatluong
 * @property string|null $ghichu
 * @property int|null $tontai
 * @property string|null $tinhtrang
 * @property string $model
 * @property int|null $matinhtrang
 * @property int|null $maphongkho
 * @property int|null $maloai
 * 
 * @property Loaithietbidogo|null $loaithietbidogo
 * @property PhongKho|null $phong_kho
 * @property Tinhtrangthietbi|null $tinhtrangthietbi
 * @property Collection|Lichsuthietbidogo[] $lichsuthietbidogos
 *
 * @package App\Models
 */
class Thietbidogo extends Model
{
	protected $table = 'thietbidogo';
	public $timestamps = false;

	protected $casts = [
		'soluong' => 'int',
		'gia' => 'int',
		'chatluong' => 'int',
		'tontai' => 'int',
		'matinhtrang' => 'int',
		'maphongkho' => 'int',
		'maloai' => 'int'
	];

	protected $fillable = [
		'tentb',
		'mota',
		'maso',
		'namsd',
		'nguongoc',
		'donvitinh',
		'soluong',
		'gia',
		'chatluong',
		'ghichu',
		'tontai',
		'tinhtrang',
		'model',
		'matinhtrang',
		'maphongkho',
		'maloai'
	];

	public function loaithietbidogo()
	{
		return $this->belongsTo(Loaithietbidogo::class, 'maloai');
	}

	public function phong_kho()
	{
		return $this->belongsTo(PhongKho::class, 'maphongkho');
	}

	public function tinhtrangthietbi()
	{
		return $this->belongsTo(Tinhtrangthietbi::class, 'matinhtrang');
	}

	public function lichsuthietbidogos()
	{
		return $this->hasMany(Lichsuthietbidogo::class, 'matbdg');
	}

	public static function boot()
	{
		parent::boot();
		static::deleting(function ($thietbidogo) {
			$thietbidogo->lichsuthietbidogos()->delete();
		});
	}
}
