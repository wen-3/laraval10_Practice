<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;   // 記得引用 class
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    use HasFactory;
    use SoftDeletes;   // 使用軟刪除

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    protected $fillable = ['title', 'content'];
}

