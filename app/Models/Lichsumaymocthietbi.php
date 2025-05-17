<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Lichsumaymocthietbi
 * 
 * @property int $id
 * @property string $noidung
 * @property string $ngay
 * @property int $mammtb
 * 
 * @property Maymocthietbi $maymocthietbi
 *
 * @package App\Models
 */
class Lichsumaymocthietbi extends Model
{
	protected $table = 'lichsumaymocthietbi';
	public $timestamps = false;

	protected $casts = [
		'mammtb' => 'int'
	];

	protected $fillable = [
		'noidung',
		'ngay',
		'mammtb'
	];

	public function maymocthietbi()
	{
		return $this->belongsTo(Maymocthietbi::class, 'mammtb');
	}
}
