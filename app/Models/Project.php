<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'status',
        'start_date',
        'end_date',
        'client_id',
        'company_id'
        //can be extended with multiple project related fields
    ];

    protected $dates = [
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public static $rules = [
        'title' => 'required|min:1|max:255',
        'status' => 'required',
        'start_date' => 'required',
        'end_date' => 'required',
        'client_id' => 'integer|prohibited_unless:company_id,null|required_without:company_id|exists:clients,id',
        'company_id' => 'integer|prohibited_unless:client_id,null|required_without:client_id|exists:companies,id'
    ];

    /**
     * @return BelongsTo
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * @return BelongsTo
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * @return HasMany
     */
    public function tasks(): HasMany
    {
        return $this->HasMany(Task::class);
    }

}
