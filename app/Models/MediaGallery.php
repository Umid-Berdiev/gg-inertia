<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaGallery extends Model implements HasMedia
{
  use HasFactory, InteractsWithMedia;

  public function region()
  {
    return $this->belongsTo(UzRegion::class, 'region_id', 'regionid')->select('regionid', 'nameRu', 'nameUz');
  }

  // public function registerMediaConversions(Media $media = null): void
  // {
  //   $this->addMediaConversion('thumb')
  //     ->width(368)
  //     ->height(232);
  // }

  public function registerMediaCollections(): void
  {
    $this
      ->addMediaCollection('media')
      ->registerMediaConversions(function (Media $media) {
        $this
          ->addMediaConversion('thumb')
          ->width(300)
          ->height(200);
      });
  }
}
