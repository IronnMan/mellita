<?php

namespace Mellita\SaaS\Http\Controllers;

use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Show;
use Mellita\SaaS\Actions\Grid\CreateTenantAction;
use Mellita\SaaS\Actions\Grid\DeleteTenantAction;
use Mellita\SaaS\Repositories\Domain;

class DomainController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Domain(), function (Grid $grid) {
            $grid->column('id');
            $grid->column('domain');
            $grid->column('tenant_id');
            $grid->column('created_at');
            $grid->column('updated_at');

            $grid->disableCreateButton();
            $grid->disableViewButton();
            $grid->disableEditButton();
            $grid->disableDeleteButton();

            $grid->tools([
                new CreateTenantAction()
            ]);

            $grid->actions(function (Grid\Displayers\DropdownActions $rowAction) {
                $rowAction->append(new DeleteTenantAction());
            });

            $grid->toolsWithOutline(false);
        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new Domain(), function (Show $show) {
            $show->field('id');
            $show->field('domain');
            $show->field('tenant_id');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Domain(), function (Form $form) {
            $form->display('id');
            $form->text('domain');
            $form->text('tenant_id');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
