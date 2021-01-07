<?php

namespace Mellita\SaaS\Console;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'mellita:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the Mellita SaaS package';

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
        $saas_domain = $this->ask('您的根域名地址？（请以 saas.com 为例。）');

        $this->call('tenancy:install');
        $this->call('migrate');
        $this->call('admin:publish');
        $this->call('admin:install');
        $this->call('key:generate');

        try {
            $tenancy_config_file = base_path() . '/config/tenancy.php';
            $string = file_get_contents($tenancy_config_file);
            $string = str_replace("'localhost',", "'$saas_domain',", $string);
            file_put_contents($tenancy_config_file, $string);
            $this->info('租户配置文件设置完成。');
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
        }

        $this->call('mellita:menu');
        $this->call('optimize:clear');

        $this->warn('完成！');
    }
}
