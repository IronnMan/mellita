<?php

namespace Mellita\SaaS\Forms;

use Dcat\Admin\Http\JsonResponse;
use Dcat\Admin\Widgets\Form;
use Mellita\SaaS\Models\SaaSTenant;

class CreateTenantForm extends Form
{

    /**
     * 处理
     * @param array $input
     * @return JsonResponse
     */
    public function handle(array $input): JsonResponse
    {
        $name = $input['name'] ?? null;

        $tenant = SaaSTenant::create(['id' => $name]);
        $tenant->domains()->create(['domain' => $name . '.' . config('tenancy.central_domains')[0]]);

        return $this->response()
            ->success('成功创建租户实例。')
            ->refresh();
    }

    /**
     * 构造表单
     */
    public function form()
    {
        $this->text('name', '组织名称')
            ->required();
    }
}
