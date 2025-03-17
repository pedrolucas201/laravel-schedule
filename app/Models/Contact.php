<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use HasFactory;
    use SoftDeletes;

    // Defina os campos que podem ser preenchidos (mass assignment)
    protected $fillable = [
        'name',
        'phone',
        'email',
        'observation',
        'user_id',
    ];

    // Relacionamento com o modelo User (um usuário pode ter muitos contatos)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
