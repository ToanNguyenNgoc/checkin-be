<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Country
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property bool $is_default
 * @property string|null $description
 * @property string|null $flag_link
 * @property string|null $alt
 * @property string $status
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property User|null $user
 * @property Collection|Client[] $clients
 * @property Collection|Organizer[] $organizers
 *
 * @package App\Models
 */
class Country extends BaseModel
{
	protected $table = 'countrys';

	protected $casts = [
		'is_default' => 'bool',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'code',
		'name',
		'is_default',
		'description',
		'flag_link',
		'alt',
		'status',
		'created_by',
		'updated_by'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'updated_by');
	}

	public function clients()
	{
		return $this->hasMany(Client::class);
	}

	public function organizers()
	{
		return $this->hasMany(Organizer::class);
	}
}
