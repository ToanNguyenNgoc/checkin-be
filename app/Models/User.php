<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\LogOptions;
// use Spatie\Permission\Traits\HasPermissions;

/**
 * Class User
 *
 * @property int $id
 * @property bool $is_admin
 * @property Carbon|null $expire_date
 * @property string $name
 * @property string $username
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string $type
 * @property string|null $gate
 * @property string|null $avatar_path
 * @property string|null $note
 * @property string $status
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property User|null $user
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class User extends BaseModel
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, LogsActivity;

    protected $table = 'users';
    protected $guard_name = 'api';

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_admin'          => 'bool',
		'expire_date'       => 'datetime',
		'email_verified_at' => 'datetime',
		'created_by'        => 'int',
		'updated_by'        => 'int'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'is_admin',
		'expire_date',
		'name',
		'username',
		'email',
		'email_verified_at',
		'password',
		'type',
		'gate',
		'avatar_path',
		'note',
		'status',
		'created_by',
		'updated_by',
		'remember_token'
    ];

    protected $logAttributes = [
        'expire_date',
        'name',
		'username',
		'email',
        'type',
		'gate',
		'avatar_path',
        'note',
		'status',
		'created_by',
		'updated_by',
    ];

	public function user()
	{
		return $this->belongsTo(User::class, 'updated_by');
	}

	public function users()
	{
		return $this->hasMany(User::class, 'updated_by');
	}

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly($this->logAttributes ?? [])
            ->logOnlyDirty()
            ->useLogName(parent::getTableInfo($this->table)['log_name']);
    }

    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->description = $eventName;
        // $activity->description = "activity.logs.message.{$eventName}";
    }
}
