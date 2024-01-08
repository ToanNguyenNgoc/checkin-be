<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Event
 *
 * @property int $id
 * @property int $company_id
 * @property bool $is_default
 * @property string $code
 * @property string $name
 * @property string $description
 * @property string $logo_path
 * @property string $location
 * @property bool $encrypt_file_link
 * @property Carbon $from_date
 * @property Carbon $end_date
 * @property array $main_field_template
 * @property array $custom_field_template
 * @property array $languages
 * @property string $contact_name
 * @property string $contact_email
 * @property string $contact_phone
 * @property string $note
 * @property string $status
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Company $company
 * @property User|null $user
 * @property Collection|Checkin[] $checkins
 * @property Collection|Client[] $clients
 * @property Collection|EventAsset[] $event_assets
 * @property Collection|EventSetting[] $event_settings
 * @property Collection|ExportLog[] $export_logs
 * @property Collection|LanguageDefine[] $language_defines
 * @property Collection|Organizer[] $organizers
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class Event extends BaseModel
{
	protected $table = 'events';

	protected $casts = [
		'company_id'            => 'int',
		'is_default'            => 'bool',
		'encrypt_file_link'     => 'bool',
		'from_date'             => 'datetime',
		'end_date'              => 'datetime',
		'main_field_template'   => 'json',
		'custom_field_template' => 'json',
		'languages'             => 'json',
		'created_by'            => 'int',
		'updated_by'            => 'int'
	];

	protected $fillable = [
		'company_id',
		'is_default',
		'code',
		'name',
		'description',
		'logo_path',
		'location',
		'encrypt_file_link',
		'from_date',
		'end_date',
		'main_field_template',
		'custom_field_template',
		'languages',
		'contact_name',
		'contact_email',
		'contact_phone',
		'note',
		'status',
		'created_by',
		'updated_by'
	];

	public function company()
	{
		return $this->belongsTo(Company::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'updated_by');
	}

	public function checkins()
	{
		return $this->hasMany(Checkin::class);
	}

	public function clients()
	{
		return $this->hasMany(Client::class);
	}

	public function event_assets()
	{
		return $this->hasMany(EventAsset::class);
	}

	public function event_settings()
	{
		return $this->hasMany(EventSetting::class);
	}

	public function export_logs()
	{
		return $this->hasMany(ExportLog::class);
	}

	public function language_defines()
	{
		return $this->hasMany(LanguageDefine::class);
	}

	public function organizers()
	{
		return $this->hasMany(Organizer::class);
	}

	public function users()
	{
		return $this->hasMany(User::class);
	}
}
