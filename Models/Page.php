<?php

namespace Modules\Pages\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = ['name', 'slug', 'summary', 'body', 'image', 'more_images', 'seo_title', 'meta_description', 'meta_keywords', 'menu_id'];


    public function setMoreImagesAttribute($value)
    {
        if(substr($value, -1) == ',')   
            $this->attributes['more_images'] = substr($value, 0, -1);
        else
            $this->attributes['more_images'] = $value;

    }

    public function getMoreImagesJsonAttribute()
    {
        $more_images = $this->more_images;
        if(!is_null($more_images)){
            $more_images_json = '';
            $more_images_array = explode(',',$more_images);
            foreach($more_images_array as $more_images_item){
                if(!empty($more_images_item)){
                    $path = "storage/pages/".$more_images_item;
                    $path_image = url($path);
                    $extension = pathinfo($path)['extension'];
                    
                    $data_image = getimagesize(storage_path('app/public/pages/'.$more_images_item));
                    $mime = $data_image['mime'];
                    //dd($data_image);
                    if($more_images_json!=''){
                        $more_images_json .= ',{
                            name: "'.$more_images_item.'",
                            file: "'.$path_image.'",
                            type: "image/jpg"
                        }';
                    }else{
                        $more_images_json = '{
                            name: "'.$more_images_item.'",
                            file: "'.$path_image.'",
                            type: "image/jpg"
                        }';
                    }
                }
            }
            return '['.$more_images_json.']';
        }else{
            return '';
        }
    }

}