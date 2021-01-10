<?php

namespace App\Models\mongo;

use App\Models\DataTableTrait;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;
use Html;

class Category extends MongoModel
{
    use SoftDeletes, DataTableTrait;

    protected $fillable = ['name', 'company_id', 'service_ids'];
    protected $columns = ['_id', 'name', 'company_id', 'service_ids', 'Action'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    static function dataTable()
    {
        return datatables(self::query()
            ->whereNull('deleted_at'))
            ->editColumn('company_id', function (self $data) {
                return [
                    Html::link(route('companies.edit', $data->company->_id), $data->company->name, [
                        'class' => 'btn btn-xs btn-link'])
                ];
            })
            ->editColumn('Action', function (self $data) {
                return [
                    Html::link(route('category.edit', $data->_id), 'Edit', [
                        'class' => 'btn btn-xs btn-info'
                    ]),
                    Html::link('#', 'Del', [
                        'class' => 'btn btn-xs btn-danger',
                        'onClick' => sprintf('deleteData("%s")',
                            route('category.destroy', $data->_id))
                    ])
                ];
            });
    }
}
