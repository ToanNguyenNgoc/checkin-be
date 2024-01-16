<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Checkin
 *
 * @property int $id
 * @property int $event_id
 * @property string $event_code
 * @property int|null $user_id
 * @property string $device_name
 * @property string $qrcode
 * @property string $client_name
 * @property array $params
 * @property Carbon $scan_time
 * @property string|null $note
 * @property string $type
 * @property string $status
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property User|null $user
 * @property Event $event
 *
 * @package App\Models
 */
class Checkin extends BaseModel
{
	protected $table = 'checkins';

	protected $casts = [
		'event_id' => 'int',
		'user_id' => 'int',
		'params' => 'json',
		'scan_time' => 'datetime',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'event_id',
		'event_code',
		'user_id',
		'device_name',
		'qrcode',
		'client_name',
		'params',
		'scan_time',
		'note',
		'type',
		'status',
		'created_by',
		'updated_by'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function event()
	{
		return $this->belongsTo(Event::class);
	}
}
