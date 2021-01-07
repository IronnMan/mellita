<?php

namespace Mellita\SaaS\Actions\Grid;

use Mellita\SaaS\Forms\CreateTenantForm;
use Dcat\Admin\Grid\Tools\AbstractTool;
use Dcat\Admin\Widgets\Modal;

class CreateTenantAction extends AbstractTool
{
    protected $title = '创建租户实例';

    /**
     * 渲染模态框
     * @return Modal|string
     */
    public function render()
    {
        return Modal::make()
            ->lg()
            ->body(new CreateTenantForm())
            ->button("<a class='btn btn-success' style='color: white;'><i class='feather icon-package'></i>&nbsp;$this->title</a>");
    }
}
