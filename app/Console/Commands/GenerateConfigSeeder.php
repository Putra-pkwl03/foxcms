<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class GenerateConfigSeeder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:seeder-snapshot';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export current database configuration to a production seeder file';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Generating ProductionSeeder from current database state...');

        $content = "<?php\n\n";
        $content .= "namespace Database\Seeders;\n\n";
        $content .= "use Illuminate\Database\Seeder;\n";
        $content .= "use Illuminate\Support\Facades\DB;\n\n";
        $content .= "class ProductionSeeder extends Seeder\n";
        $content .= "{\n";
        $content .= "    public function run()\n";
        $content .= "    {\n";
        
        // 1. Global Settings
        $this->info('Exporting Global Settings...');
        $settings = \App\Models\GlobalSetting::all()->makeHidden(['created_at', 'updated_at'])->toArray();
        $content .= "        // 1. Global Settings\n";
        foreach ($settings as $setting) {
            $content .= "        \App\Models\GlobalSetting::updateOrCreate(\n";
            $content .= "            ['setting_key' => '" . addslashes($setting['setting_key']) . "'],\n";
            $content .= "            ['setting_value' => '" . addslashes($setting['setting_value']) . "']\n";
            $content .= "        );\n\n";
        }

        // 2. System Marquee
        $this->info('Exporting Marquee...');
        $marquees = \App\Models\SystemMarquee::all()->makeHidden(['created_at', 'updated_at'])->toArray();
        $content .= "        // 2. System Marquee\n";
        foreach ($marquees as $mq) {
            $content .= "        \App\Models\SystemMarquee::updateOrCreate(\n";
            $content .= "            ['id' => 1],\n";
            $content .= "            [\n";
            $content .= "                'content' => '" . addslashes($mq['content']) . "',\n";
            $content .= "                'is_active' => " . ($mq['is_active'] ? 'true' : 'false') . "\n";
            $content .= "            ]\n";
            $content .= "        );\n\n";
        }

        // 3. System Apps
        $this->info('Exporting System Apps...');
        $apps = \App\Models\SystemApp::all()->makeHidden(['created_at', 'updated_at'])->toArray();
        $content .= "        // 3. System Apps\n";
        foreach ($apps as $app) {
            $appExport = var_export($app, true);
            $content .= "        \App\Models\SystemApp::updateOrCreate(\n";
            $content .= "            ['app_key' => '" . $app['app_key'] . "'],\n";
            $content .= "            " . $appExport . "\n";
            $content .= "        );\n\n";
        }

        // 4. Home Menus
        $this->info('Exporting Home Menus...');
        $menus = \App\Models\HomeMenu::all()->makeHidden(['created_at', 'updated_at'])->toArray();
        $content .= "        // 4. Home Menus\n";
        foreach ($menus as $menu) {
            $menuExport = var_export($menu, true);
            $content .= "        \App\Models\HomeMenu::updateOrCreate(\n";
            $content .= "            ['menu_key' => '" . $menu['menu_key'] . "'],\n";
            $content .= "            " . $menuExport . "\n";
            $content .= "        );\n\n";
        }

        $content .= "    }\n";
        $content .= "}\n";

        // Write File
        $path = database_path('seeders/ProductionSeeder.php');
        File::put($path, $content);

        $this->info("Seeder generated successfully at: $path");
        $this->info("Run it using: php artisan db:seed --class=ProductionSeeder");

        return 0;
    }
}
