<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id', 'template_name', 'preview_url', 'thumbnail_url', 'desktop_thumbnail_url', 'tablet_thumbnail_url',
        'mobile_thumbnail_url', 'external_template_id'
    ];

    /*
     * Create or Update Templates
     * */
    public function createOrUpdate($templates){
        foreach($templates as $template){
            $insertData = collect($template)
                ->put('category_id', 1)
                ->keyBy(function ($template, $key) {
                    if ($key == 'template_id') {
                        return 'external_template_id';
                    } else {
                        return $key;
                    }
                })
                ->toArray();

            $templateExist = $this->where('external_template_id')
                ->first();

            if(!$templateExist){
                $this->create($insertData);
            }else{
                $templateExist->update($insertData);
            }
        }
    }
}
