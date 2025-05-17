<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Donvitinh
 * 
 * @property int $id
 * @property string|null $tendonvi
 *
 * @package App\Models
 */
class Donvitinh extends Model
{
	protected $table = 'donvitinh';
	public $timestamps = false;

	protected $fillable = [
		'tendonvi'
	];
}
