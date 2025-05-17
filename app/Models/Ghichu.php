<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Ghichu
 * 
 * @property int $id
 * @property string $mota
 *
 * @package App\Models
 */
class Ghichu extends Model
{
	protected $table = 'ghichu';
	public $timestamps = false;

	protected $fillable = [
		'mota'
	];
}
