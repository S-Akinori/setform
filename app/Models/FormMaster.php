<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormMaster extends Model
{
    use HasFactory;

    protected $fillable = ['formats', 'form_key', 'answer_key', 'user_id'];

    protected $cast = [
        'formats'=>'json'
    ];
}
