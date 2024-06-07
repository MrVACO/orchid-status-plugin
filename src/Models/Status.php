<?php

namespace MrVaco\Status\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Orchid\Screen\AsSource;

class Status extends Model
{
    use AsSource;

    protected $fillable = [
        'name',
        'color',
        'active',
        'disabled',
        'draft',
    ];

    public function group(): BelongsToMany
    {
        return $this->belongsToMany(Group::class, 'statuses_rel_groups', 'id', 'group_id');
    }
}
