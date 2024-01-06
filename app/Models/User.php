<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\LogOptions;
// use Spatie\Permission\Traits\HasPermissions;
// use Illuminate\Contracts\Auth\MustVerifyEmail;

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
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, LogsActivity;

    protected $table = 'users';
    protected $guard_name = 'api';

    const TYPE_SYSTEM_ADMIN         = 'SYSTEM_ADMIN';
    const TYPE_ADMIN                = 'ADMIN';
    const TYPE_USER_APP             = 'USER_APP';
    const TYPE_DEVICE_MOBILE        = 'DEVICE_MOBILE';
    const TYPE_DEVICE_PC            = 'DEVICE_PC';

    const TYPES = [
        self::TYPE_SYSTEM_ADMIN     => 'System Admin',
        self::TYPE_ADMIN            => 'Admin',
        self::TYPE_USER_APP         => 'App',
        self::TYPE_DEVICE_MOBILE    => 'Mobile',
        self::TYPE_DEVICE_PC        => 'PC',
    ];

    const STATUS_NEW                = 'NEW';
    const STATUS_ACTIVE             = 'ACTIVE';
    const STATUS_INACTIVE           = 'INACTIVE';
    const STATUS_DELETED            = 'DELETED';

    const STATUES = [
        self::STATUS_NEW            => 'New',
        self::STATUS_ACTIVE         => 'Active',
        self::STATUS_INACTIVE       => 'In-Active',
        self::STATUS_DELETED        => 'Deleted',
    ];

    const STATUES_VALID = [
        self::STATUS_NEW        => 'New',
        self::STATUS_ACTIVE     => 'Active',
        self::STATUS_INACTIVE   => 'In-Active',
        self::STATUS_DELETED    => 'Deleted',
    ];

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
		'updated_by'        => 'int',
		'last_login_at'     => 'datetime',
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
		'remember_token',
		'last_login_at'
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

    /* RELATIONSHIP */

	public function user()
	{
		return $this->belongsTo(User::class, 'updated_by');
	}

	public function users()
	{
		return $this->hasMany(User::class, 'updated_by');
	}

    /* CONST FUNCTIONS */

    static public function getStatues()
    {
        return self::STATUES;
    }

    public function getStatusText()
    {
        return self::STATUES[$this->status];
    }

    static public function getStatuesValid()
    {
        return self::STATUES_VALID;
    }

    static public function getTypes()
    {
        return self::TYPES;
    }

    public function getTypeText()
    {
        return self::TYPES[$this->status];
    }

    public function isNew()
    {
        return empty($this->id) ? true : false;
    }

    /* ACTIVITY LOG */

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly($this->logAttributes ?? [])
            ->logOnlyDirty()
            ->useLogName(parent::getTable());
            // ->useLogName(parent::getTableInfo($this->table)['log_name']);
    }

    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->description = $eventName;
        // $activity->description = "activity.logs.message.{$eventName}";
    }
}
