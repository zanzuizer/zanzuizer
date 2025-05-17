<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PhongKho
 * 
 * @property int $id
 * @property string $maphong
 * @property string|null $tenphong
 * @property string|null $khu
 * @property int|null $lau
 * @property int|null $sophong
 * @property int $magvql
 * @property int|null $madonvi
 * 
 * @property Donvi|null $donvi
 * @property Taikhoan $taikhoan
 * @property Collection|Kiemke[] $kiemkes
 * @property Collection|Maymocthietbi[] $maymocthietbis
 * @property Collection|Nhatkyphongmay[] $nhatkyphongmays
 * @property Collection|Nhatkyqlphong[] $nhatkyqlphongs
 * @property Collection|Nhatkytungtb[] $nhatkytungtbs
 * @property Collection|Soquanlykho[] $soquanlykhos
 * @property Collection|Thietbidogo[] $thietbidogos
 * @property Collection|Thongkedogo[] $thongkedogos
 *
 * @package App\Models
 */
class PhongKho extends Model
{
	protected $table = 'phong_kho';
	public $timestamps = false;

	protected $casts = [
		'lau' => 'int',
		'sophong' => 'int',
		'magvql' => 'int',
		'madonvi' => 'int'
	];

	protected $fillable = [
		'maphong',
		'tenphong',
		'khu',
		'lau',
		'sophong',
		'magvql',
		'madonvi'
	];

	public function donvi()
	{
		return $this->belongsTo(Donvi::class, 'madonvi');
	}

	public function taikhoan()
	{
		return $this->belongsTo(Taikhoan::class, 'magvql');
	}

	public function kiemkes()
	{
		return $this->hasMany(Kiemke::class, 'id_phong');
	}

	public function maymocthietbis()
	{
		return $this->hasMany(Maymocthietbi::class, 'maphongkho');
	}

	public function nhatkyphongmays()
	{
		return $this->hasMany(Nhatkyphongmay::class, 'maphong');
	}

	public function nhatkyqlphongs()
	{
		return $this->hasMany(Nhatkyqlphong::class, 'maphong');
	}

	public function nhatkytungtbs()
	{
		return $this->hasMany(Nhatkytungtb::class, 'maphong');
	}

	public function soquanlykhos()
	{
		return $this->hasMany(Soquanlykho::class, 'maphong');
	}

	public function thietbidogos()
	{
		return $this->hasMany(Thietbidogo::class, 'maphongkho');
	}

	public function thongkedogos()
	{
		return $this->hasMany(Thongkedogo::class, 'maphongkho');
	}

	public static function boot()
	{
		parent::boot();
		static::deleting(function ($phongKho) {
			$phongKho->kiemkes()->delete();
			$phongKho->maymocthietbis()->delete();
			$phongKho->nhatkyphongmays()->delete();
			$phongKho->nhatkyqlphongs()->delete();
			$phongKho->nhatkytungtbs()->delete();
			$phongKho->soquanlykhos()->delete();
			$phongKho->thietbidogos()->delete();
			$phongKho->thongkedogos()->delete();
		});
	}
}
