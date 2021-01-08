<?php

namespace App\Models\mongo;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

/**
 * An Eloquent Model
 * @method static Builder
 * @property string _id
 */
class MongoModel extends Eloquent
{
    public static function n()
    {
        return get_called_class();
    }

    static function createFromRequest($request)
    {
        $modelName = self::n();
        $model = new $modelName();
        foreach ($model->getFillable() as $field) {
            $model->{$field} = $request->get($field);
        }
        $model->save();
        return $model;
    }

}
