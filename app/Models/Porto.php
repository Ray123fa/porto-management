<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Porto extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'image',
        'tags',
        'url'
    ];

    /**
     * Deletes a file from the specified file path.
     *
     * @param string $filePath The path of the file to be deleted.
     * @return bool True if the file is successfully deleted, false otherwise.
     */
    public function deleteFile($filePath)
    {
        if ($filePath) {
            Storage::disk('public')->delete($filePath);
        }
    }

    protected static function boot()
    {
        parent::boot();

        /**
         * Registers a callback to be executed when a Porto model is being deleted.
         *
         * @param  \Closure  $callback
         * @return void
         */
        static::deleting(function ($model) {
            $model->deleteFile($model->image);
        });

        /**
         * Register a updating model event with the given callback.
         *
         * @param  \Closure  $callback
         * @return void
         */
        static::updating(function ($model) {
            /**
             * Checks if the 'image' attribute of the model has been modified.
             *
             * @param  Illuminate\Database\Eloquent\Model  $model  The model instance being checked.
             * @return bool  Returns true if the 'image' attribute has been modified, false otherwise.
             */
            if ($model->isDirty('image')) {
                $model->deleteFile($model->getOriginal('image'));
            }
        });
    }
}
