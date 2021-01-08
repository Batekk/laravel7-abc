<?php

namespace App;

use App\Models\DataTableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Jenssegers\Mongodb\Auth\User as Auth;
use Html;

class User extends Auth
{
    use  Notifiable, SoftDeletes, DataTableTrait;

    protected $fillable = ['name', 'email', 'company_ids'];
    protected $hidden = ['password', 'remember_token'];
    protected $casts = ['email_verified_at' => 'datetime'];
    protected $columns = ['_id', 'name', 'email', 'Action', '😏'];

//'company_ids'

    public function companies()
    {
        return $this->belongsToMany(Company::class, null, 'user_ids', 'company_ids');
    }

    static function dataTable()
    {
        return datatables(self::query()
            ->whereNull('deleted_at'))
            ->editColumn('Action', function (self $data) {
                return [
                    Html::link(route('users.edit', $data->_id), 'Edit', [
                        'class' => 'btn btn-xs btn-info'
                    ]),
                    Html::link('#', 'Del', [
                        'class' => 'btn btn-xs btn-danger',
                        'onClick' => sprintf('deleteData("%s")',
                            route('users.destroy', $data->_id))
                    ])
                ];
            })
            ->editColumn('😏',
                function (self $data) {
                    return [
                        Html::link('#', 'Login', [
                            'class' => 'btn btn-xs btn-primary',
                            'onClick' => sprintf('loginUser("%s")',
                                route('users.login', $data->_id))
                        ])
                    ];
                });
    }
}
