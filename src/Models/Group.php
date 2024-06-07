<?php

declare(strict_types = 1);

namespace MrVaco\Status\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Orchid\Screen\AsSource;

class Group extends Model
{
    use AsSource;

    protected $table = 'statuses_groups';

    protected $fillable = [
        'name',
        'slug'
    ];

    public array $rules = [
        'slug' => 'unique:statuses_groups'
    ];

    public function statuses(): BelongsToMany
    {
        return $this->belongsToMany(Status::class, 'statuses_rel_groups', 'group_id', 'id');
    }
}
