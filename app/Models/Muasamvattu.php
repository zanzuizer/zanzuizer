<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Muasamvattu
 * 
 * @property int $id
 * @property string $tendenghi
 * @property string|null $veviecdenghi
 * @property string|null $noidungdenghi
 * @property string $tentaptin
 * @property string $tinhtrang
 * @property int $giatri
 * @property int $giaonhan
 * @property int $thanhtoan
 * @property int $idhk
 * @property int $create_at
 * @property int $magv
 * 
 * @property Collection|TbMuaSam[] $tb_mua_sams
 *
 * @package App\Models
 */
class Muasamvattu extends Model
{
	protected $table = 'muasamvattu';
	public $timestamps = false;

	protected $casts = [
		'giatri' => 'int',
		'giaonhan' => 'int',
		'thanhtoan' => 'int',
		'idhk' => 'int',
		'create_at' => 'int',
		'magv' => 'int'
	];

	protected $fillable = [
		'tendenghi',
		'veviecdenghi',
		'noidungdenghi',
		'tentaptin',
		'tinhtrang',
		'giatri',
		'giaonhan',
		'thanhtoan',
		'idhk',
		'create_at',
		'magv'
	];

	public function tb_mua_sams()
	{
		return $this->hasMany(TbMuaSam::class, 'idmuasam');
	}

	public static function boot()
	{
		parent::boot();
		static::deleting(function ($muasamvattu) {
			$muasamvattu->tb_mua_sams()->delete();
		});
	}
}
