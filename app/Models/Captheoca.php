<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Captheoca
 * 
 * @property int $id
 * @property string $ma_hoc_phan
 * @property string $ma_lop
 * @property string $ten_hoc_phan
 * @property int $si_so
 * @property string $giao_vien
 * @property int $ca_cp
 * @property string $thiet_bi
 * @property Carbon $created_at
 * @property int $hoc_ky
 * @property string|null $file_cap
 * @property int|null $cap_phat_id
 * @property string|null $file_xacnhan
 * 
 * @property CapPhat|null $cap_phat
 *
 * @package App\Models
 */
class Captheoca extends Model
{
	protected $table = 'captheoca';
	public $timestamps = false;

	protected $casts = [
		'si_so' => 'int',
		'ca_cp' => 'int',
		'hoc_ky' => 'int',
		'cap_phat_id' => 'int'
	];

	protected $fillable = [
		'ma_hoc_phan',
		'ma_lop',
		'ten_hoc_phan',
		'si_so',
		'giao_vien',
		'ca_cp',
		'thiet_bi',
		'hoc_ky',
		'file_cap',
		'cap_phat_id',
		'file_xacnhan'
	];

	public function cap_phat()
	{
		return $this->belongsTo(CapPhat::class);
	}
}
