<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserPermission
 *
 * @property int $permission_id
 * @property string $model_type
 * @property int $model_id
 *
 * @property Permission $permission
 *
 * @package App\Models
 */
class UserPermission extends BaseModel
{
	protected $table = 'user_permissions';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'permission_id'     => 'int',
		'model_id'          => 'int'
	];

	public function permission()
	{
		return $this->belongsTo(Permission::class);
	}
}
