<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pergunta extends Model
{
    use HasFactory;

    protected $fillable = ['evento_id', 'user_id', 'texto', 'status'];

    public function evento(): BelongsTo
    {
        return $this->belongsTo(Evento::class);
    }

    # relacionamento N:1 com o usuario
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    # Ticket #010: Relacionamento N:M de votos
    public function votos(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    # Ticket #014: Relacionamento 1:N com moderações
    public function moderacoes(): HasMany
    {
        return $this->hasMany(Moderacao::class);
    }
}