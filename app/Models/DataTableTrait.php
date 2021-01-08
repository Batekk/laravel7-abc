<?php

namespace App\Models;

trait DataTableTrait
{
    public function html()
    {
        app('datatables.html')->postAjax(url()->current());
        return app('datatables.html')
            ->columns($this->getColumns())
            ->parameters([
                'scrollY' => 550,
                'scrollCollapse' => true,
                'scroller' => true,
                'columnDefs' => [
                    ['targets' => '_all', 'defaultContent' => '-']
                ]
            ]);
    }

    protected function getColumns()
    {
        return $this->columns;
    }
}
