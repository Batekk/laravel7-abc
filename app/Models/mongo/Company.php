<?php

namespace App\Models\mongo;

use App\Models\DataTableTrait;
use App\User;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;
use Html;

class Company extends MongoModel
{
    use SoftDeletes, DataTableTrait;

    protected $fillable = ['name', 'user_ids'];
    protected $columns = ['_id', 'name', 'user_ids', 'Action'];

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function category()
    {
        return $this->hasMany(Category::class);
    }

    static function dataTable()
    {
        return datatables(self::query()
            ->whereNull('deleted_at'))
            ->editColumn('Action', function (self $data) {
                return [
                    Html::link(route('companies.edit', $data->_id), 'Edit', [
                        'class' => 'btn btn-xs btn-info'
                    ]),
                    Html::link('#', 'Del', [
                        'class' => 'btn btn-xs btn-danger',
                        'onClick' => sprintf('deleteData("%s")',
                            route('companies.destroy', $data->_id))
                    ])
                ];
            })
            ->editColumn('user_ids', function (self $data) {
                return count($data->user_ids);
            });
    }
}
