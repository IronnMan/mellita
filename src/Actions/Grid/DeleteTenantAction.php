<?php

namespace Mellita\SaaS\Actions\Grid;

use Dcat\Admin\Actions\Response;
use Dcat\Admin\Grid\RowAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mellita\SaaS\Models\Domain;
use Mellita\SaaS\Models\Tenant;

class DeleteTenantAction extends RowAction
{
    /**
     * @return string
     */
    protected $title = '🚫 删除实例';

    /**
     * Handle the action request.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function handle(Request $request): Response
    {
        $domain = Domain::where('id', $this->getKey())->first();
        if (!empty($domain)) {
            $tenant = Tenant::where('id', $domain->tenant_id)->first();
            if (!empty($tenant)) {
                DB::select('drop database ' . config('tenancy.database.prefix') . $domain->tenant_id);
                $domain->delete();
                $tenant->delete();
                return $this->response()
                    ->success('租户实例删除成功。')
                    ->refresh();
            } else {
                return $this->response()
                    ->warning('没有找到与之相关的租户记录。')
                    ->refresh();
            }
        } else {
            return $this->response()
                ->error('没有找到此记录。')
                ->refresh();
        }
    }

    /**
     * @return string|array|void
     */
    public function confirm()
    {
        return ['确认删除实例？', '删除后与之相关的用户数据将会全部清除且无法恢复。'];
    }
}
