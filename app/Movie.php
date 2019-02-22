<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;

class Movie extends Model
{
    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class);
    }

    public function getPosterAttribute(string $fileName): string
    {
        return parse_url(Storage::disk('public')->url($fileName), PHP_URL_PATH);
    }

    public function scopeFilterByGenre(Builder $query, array $args): void
    {
        $genre = $args['genre'] ?? null;

        if (null !== $genre) {
            $query->whereHas('genres', function (Builder $q) use ($genre) {
                $q->where('genres.id', $genre);
            });
        }
    }

    public function scopeSearchByTitle(Builder $query, array $args): void
    {
        $search = $args['search'] ?? null;

        if (null !== $search) {
            $query->where('title', 'like', $search . '%');
        }
    }
}
