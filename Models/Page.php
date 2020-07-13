<?php

namespace Modules\Pages\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = ['name', 'slug', 'summary', 'body', 'image', 'more_images', 'seo_title', 'meta_description', 'meta_keywords'];
}