<?php

namespace Mellita\SaaS\Console;

use Dcat\Admin\Models;
use Illuminate\Console\Command;

class InitAdminMenuCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'mellita:menu';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Init the Mellita SaaS Console Panel Menu';

    /**
     * Install directory.
     *
     * @var string
     */
    protected $directory = '';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        Models\Menu::truncate();
        Models\Menu::insert(
            [
                [
                    "id" => 2,
                    "parent_id" => 0,
                    "order" => 3,
                    "title" => "Admin",
                    "icon" => "feather icon-settings",
                    "uri" => "",
                    "extension" => "",
                    "show" => 1,
                    "created_at" => "2021-01-07 03:20:24",
                    "updated_at" => "2021-01-07 22:24:58"
                ],
                [
                    "id" => 3,
                    "parent_id" => 2,
                    "order" => 4,
                    "title" => "Users",
                    "icon" => "",
                    "uri" => "auth/users",
                    "extension" => "",
                    "show" => 1,
                    "created_at" => "2021-01-07 03:20:24",
                    "updated_at" => "2021-01-07 22:24:58"
                ],
                [
                    "id" => 4,
                    "parent_id" => 2,
                    "order" => 5,
                    "title" => "Roles",
                    "icon" => "",
                    "uri" => "auth/roles",
                    "extension" => "",
                    "show" => 1,
                    "created_at" => "2021-01-07 03:20:24",
                    "updated_at" => "2021-01-07 22:24:58"
                ],
                [
                    "id" => 5,
                    "parent_id" => 2,
                    "order" => 6,
                    "title" => "Permission",
                    "icon" => "",
                    "uri" => "auth/permissions",
                    "extension" => "",
                    "show" => 1,
                    "created_at" => "2021-01-07 03:20:24",
                    "updated_at" => "2021-01-07 22:24:58"
                ],
                [
                    "id" => 6,
                    "parent_id" => 2,
                    "order" => 7,
                    "title" => "Menu",
                    "icon" => "",
                    "uri" => "auth/menu",
                    "extension" => "",
                    "show" => 1,
                    "created_at" => "2021-01-07 03:20:24",
                    "updated_at" => "2021-01-07 22:24:58"
                ],
                [
                    "id" => 7,
                    "parent_id" => 2,
                    "order" => 8,
                    "title" => "Extensions",
                    "icon" => "",
                    "uri" => "auth/extensions",
                    "extension" => "",
                    "show" => 1,
                    "created_at" => "2021-01-07 03:20:24",
                    "updated_at" => "2021-01-07 22:24:58"
                ],
                [
                    "id" => 9,
                    "parent_id" => 0,
                    "order" => 2,
                    "title" => "Domains",
                    "icon" => NULL,
                    "uri" => "/",
                    "extension" => "",
                    "show" => 1,
                    "created_at" => "2021-01-07 16:50:38",
                    "updated_at" => "2021-01-07 22:42:48"
                ]
            ]
        );
    }
}
