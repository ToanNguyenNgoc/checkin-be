<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserRole
 *
 * @property int $role_id
 * @property string $model_type
 * @property int $model_id
 *
 * @property Role $role
 *
 * @package App\Models
 */
class UserRole extends BaseModel
{
	protected $table = 'user_roles';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'role_id' => 'int',
		'model_id' => 'int'
	];

	public function role()
	{
		return $this->belongsTo(Role::class);
	}
}
