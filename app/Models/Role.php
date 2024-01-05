<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Role
 *
 * @property int $id
 * @property string $name
 * @property string $guard_name
 * @property bool $enable
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|Permission[] $permissions
 * @property Collection|UserRole[] $user_roles
 *
 * @package App\Models
 */
class Role extends BaseModel
{
	protected $table = 'roles';

	protected $casts = [
		'enable' => 'bool'
	];

	protected $fillable = [
		'name',
		'guard_name',
		'enable'
	];

	public function permissions()
	{
		return $this->belongsToMany(Permission::class, 'role_permissions');
	}

	public function user_roles()
	{
		return $this->hasMany(UserRole::class);
	}
}
