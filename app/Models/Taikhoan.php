<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

/**
 * Class Taikhoan
 * 
 * @property int $id
 * @property string $hoten
 * @property string|null $cmnd
 * @property string $matkhau
 * @property string $email
 * @property string|null $chucvu
 * @property int $maloaitk
 * @property int|null $madonvi
 * @property string|null $hinhanh
 * 
 * @property Donvi|null $donvi
 * @property Loaitaikhoan $loaitaikhoan
 * @property Collection|Capphat[] $capphats
 * @property Collection|DeNghi[] $de_nghis
 * @property Collection|Kiemke[] $kiemkes
 * @property Collection|LogTinhtrang[] $log_tinhtrangs
 * @property Collection|LuutruTaptin[] $luutru_taptins
 * @property Collection|Nhatkyphongmay[] $nhatkyphongmays
 * @property Collection|Nhatkyqlphong[] $nhatkyqlphongs
 * @property Collection|Nhatkytungtb[] $nhatkytungtbs
 * @property Collection|PhongKho[] $phong_khos
 * @property Collection|Soquanlykho[] $soquanlykhos
 *
 * @package App\Models
 */
class Taikhoan extends Authenticatable implements JWTSubject
{
	use HasFactory;
	protected $table = 'taikhoan';
	public $timestamps = false;

	protected $casts = [
		'maloaitk' => 'int',
		'madonvi' => 'int'
	];

	protected $fillable = [
		'hoten',
		'cmnd',
		'email',
		'matkhau',
		'chucvu',
		'maloaitk',
		'madonvi',
		'hinhanh'
	];

	protected $hidden = [
		'matkhau'
	];
	public function getAuthPassword()
	{
		return $this->matkhau;
	}

	public function donvi()
	{
		return $this->belongsTo(Donvi::class, 'madonvi');
	}

	public function loaitaikhoan()
	{
		return $this->belongsTo(Loaitaikhoan::class, 'maloaitk');
	}

	public function capphats()
	{
		return $this->hasMany(Capphat::class, 'id_gv');
	}

	public function de_nghis()
	{
		return $this->hasMany(DeNghi::class, 'id_nguoitao');
	}

	public function kiemkes()
	{
		return $this->hasMany(Kiemke::class, 'id_nguoitao');
	}

	public function log_tinhtrangs()
	{
		return $this->hasMany(LogTinhtrang::class, 'matk');
	}

	public function luutru_taptins()
	{
		return $this->hasMany(LuutruTaptin::class, 'id_nguoidung');
	}

	public function nhatkyphongmays()
	{
		return $this->hasMany(Nhatkyphongmay::class, 'matk');
	}

	public function nhatkyqlphongs()
	{
		return $this->hasMany(Nhatkyqlphong::class, 'magvql');
	}

	public function nhatkytungtbs()
	{
		return $this->hasMany(Nhatkytungtb::class, 'matk');
	}

	public function phong_khos()
	{
		return $this->hasMany(PhongKho::class, 'magvql');
	}

	public function soquanlykhos()
	{
		return $this->hasMany(Soquanlykho::class, 'matk');
	}

	/**
	 * Get the identifier that will be stored in the subject claim of the JWT.
	 *
	 * @return mixed
	 */
	public function getJWTIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Return a key value array, containing any custom claims to be added to the JWT.
	 *
	 * @return array
	 */
	public function getJWTCustomClaims()
	{
		return [];
	}

	public static function boot()
	{
		parent::boot();
		static::deleting(function ($taikhoan) {
			$taikhoan->capphats()->delete();
			$taikhoan->de_nghis()->delete();
			$taikhoan->kiemkes()->delete();
			$taikhoan->log_tinhtrangs()->delete();
			$taikhoan->luutru_taptins()->delete();
			$taikhoan->nhatkyphongmays()->delete();
			$taikhoan->nhatkyqlphongs()->delete();
			$taikhoan->nhatkytungtbs()->delete();
			$taikhoan->phong_khos()->delete();
			$taikhoan->soquanlykhos()->delete();
		});
	}
}
