<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; 
class Album extends Model
{
public function artist (): BelongsTo 
{ 
    return $this->belongsTo (Artist :: class ); 
}

public function jsonSerialize(): mixed
{
    return [
        'id' => intval($this->id),
        'name' => $this->name,
        'author' => $this->artist->name,
        // 'genre' => ($this->genre ? $this->genre->name : ''), sadaļa
        'streams' => number_format($this->streams),
        'year' => intval($this->year),
        'image' => asset('images/' . $this->image),
    ];
}


}


