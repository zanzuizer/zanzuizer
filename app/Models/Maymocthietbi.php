<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Maymocthietbi
 * 
 * @property int $id
 * @property string $tentb
 * @property int|null $somay
 * @property string|null $maso
 * @property string|null $mota
 * @property int|null $namsd
 * @property string|null $nguongoc
 * @property string|null $donvitinh
 * @property int|null $soluong
 * @property int|null $tontai
 * @property string|null $gia
 * @property string|null $chatluong
 * @property string|null $ghichu
 * @property string|null $ghichutinhtrang
 * @property string $model
 * @property string|null $tinhtrang
 * @property int|null $matinhtrang
 * @property int|null $maphongkho
 * @property int|null $maloai
 * @property int|null $manhom
 * 
 * @property Loaimaymocthietbi|null $loaimaymocthietbi
 * @property Nhommaymocthietbi|null $nhommaymocthietbi
 * @property PhongKho|null $phong_kho
 * @property Tinhtrangthietbi|null $tinhtrangthietbi
 * @property Collection|Lichsumaymocthietbi[] $lichsumaymocthietbis
 * @property Collection|Soquanlykho[] $soquanlykhos
 *
 * @package App\Models
 */
class Maymocthietbi extends Model
{
	protected $table = 'maymocthietbi';
	public $timestamps = false;

	protected $casts = [
		'somay' => 'int',
		'namsd' => 'int',
		'soluong' => 'int',
		'tontai' => 'int',
		'matinhtrang' => 'int',
		'maphongkho' => 'int',
		'maloai' => 'int',
		'manhom' => 'int'
	];

	protected $fillable = [
		'tentb',
		'somay',
		'maso',
		'mota',
		'namsd',
		'nguongoc',
		'donvitinh',
		'soluong',
		'tontai',
		'gia',
		'chatluong',
		'ghichu',
		'ghichutinhtrang',
		'model',
		'tinhtrang',
		'matinhtrang',
		'maphongkho',
		'maloai',
		'manhom'
	];

	public function loaimaymocthietbi()
	{
		return $this->belongsTo(Loaimaymocthietbi::class, 'maloai');
	}

	public function nhommaymocthietbi()
	{
		return $this->belongsTo(Nhommaymocthietbi::class, 'manhom');
	}

	public function phong_kho()
	{
		return $this->belongsTo(PhongKho::class, 'maphongkho');
	}

	public function tinhtrangthietbi()
	{
		return $this->belongsTo(Tinhtrangthietbi::class, 'matinhtrang');
	}

	public function lichsumaymocthietbis()
	{
		return $this->hasMany(Lichsumaymocthietbi::class, 'mammtb');
	}

	public function soquanlykhos()
	{
		return $this->hasMany(Soquanlykho::class, 'matb');
	}

	public static function boot()
	{
		parent::boot();
		static::deleting(function ($maymocthietbi) {
			$maymocthietbi->lichsumaymocthietbis()->delete();
			$maymocthietbi->soquanlykhos()->delete();
		});
	}
}
