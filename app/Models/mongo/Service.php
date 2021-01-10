<?php

namespace App\Models\mongo;

use App\Models\DataTableTrait;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;
use Html;

class Service extends MongoModel
{
    use SoftDeletes, DataTableTrait;

    protected $fillable = ['name', 'category_id'];
    protected $columns = ['_id', 'name', 'category_id', 'Action'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    static function dataTable()
    {
        return datatables(self::query()
            ->whereNull('deleted_at'))
            ->editColumn('category_id', function (self $data) {
                return [
                    Html::link(route('category.edit', $data->category->_id), $data->category->name, [
                        'class' => 'btn btn-xs btn-link'])
                ];
            })
            ->editColumn('Action', function (self $data) {
                return [
                    Html::link(route('services.edit', $data->_id), 'Edit', [
                        'class' => 'btn btn-xs btn-info'
                    ]),
                    Html::link('#', 'Del', [
                        'class' => 'btn btn-xs btn-danger',
                        'onClick' => sprintf('deleteData("%s")',
                            route('services.destroy', $data->_id))
                    ])
                ];
            });
    }
}
