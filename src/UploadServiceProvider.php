<?php

namespace Itstructure\MFU;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Itstructure\MFU\Facades\Uploader as UploaderFacade;
use Itstructure\MFU\Services\Uploader as UploaderService;
use Itstructure\MFU\Facades\Previewer as PreviewerFacade;
use Itstructure\MFU\Services\Previewer as PreviewerService;

/**
 * Class UploadServiceProvider
 * @package Itstructure\MFU
 * @author Andrey Girnik <girnikandrey@gmail.com>
 */
class UploadServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     * @return void
     */
    public function register()
    {
        $this->app->bind('uploader', function ($app) {
            return UploaderService::getInstance($app['config']['uploader']['processor']);
        });
        AliasLoader::getInstance()->alias('Uploader', UploaderFacade::class);

        $this->app->bind('previewer', function ($app) {
            return PreviewerService::getInstance($app['config']['uploader']['preview']);
        });
        AliasLoader::getInstance()->alias('Previewer', PreviewerFacade::class);

        // Directives
        require_once __DIR__ . '/functions.php';

        Blade::directive('fileSetter', function ($config) {
            return "<?php echo file_setter($config); ?>";
        });

        $this->app->register(UploadRouteServiceProvider::class);

        $this->registerCommands();
    }

    /**
     * Bootstrap any application services.
     * @return void
     */
    public function boot()
    {
        // Loading settings
        $this->loadViews();
        $this->loadTranslations();
        $this->loadMigrations();


        // Publish settings
        $this->publishAssets();
        $this->publishConfig();
        $this->publishViews();
        $this->publishTranslations();
        $this->publishMigrations();
    }


    /*
    |--------------------------------------------------------------------------
    | COMMAND SETTINGS
    |--------------------------------------------------------------------------
    */

    /**
     * Register commands.
     * @return void
     */
    private function registerCommands(): void
    {
        $this->commands(Commands\PublishCommand::class);
    }


    /*
    |--------------------------------------------------------------------------
    | LOADING SETTINGS
    |--------------------------------------------------------------------------
    */

    /**
     * Set directory to load views.
     * @return void
     */
    private function loadViews(): void
    {
        $this->loadViewsFrom($this->packagePath('resources/views'), 'uploader');
    }

    /**
     * Set directory to load translations.
     * @return void
     */
    private function loadTranslations(): void
    {
        $this->loadTranslationsFrom($this->packagePath('resources/lang'), 'uploader');
    }

    /**
     * Set directory to load migrations.
     * @return void
     */
    private function loadMigrations(): void
    {
        $this->loadMigrationsFrom($this->packagePath('database/migrations'));
    }


    /*
    |--------------------------------------------------------------------------
    | PUBLISH SETTINGS
    |--------------------------------------------------------------------------
    */

    private function publishAssets(): void
    {
        $this->publishes([
            $this->packagePath('resources/assets') => public_path('vendor/uploader'),
        ], 'assets');
    }

    /**
     * Publish config.
     * @return void
     */
    private function publishConfig(): void
    {
        $configPath = $this->packagePath('config/uploader.php');

        $this->publishes([
            $configPath => config_path('uploader.php'),
        ], 'config');

        $this->mergeConfigFrom($configPath, 'uploader');
    }

    /**
     * Publish views.
     * @return void
     */
    private function publishViews(): void
    {
        $this->publishes([
            $this->packagePath('resources/views') => resource_path('views/vendor/uploader'),
        ], 'views');
    }

    /**
     * Publish translations.
     * @return void
     */
    private function publishTranslations(): void
    {
        $this->publishes([
            $this->packagePath('resources/lang') => resource_path('lang/vendor/uploader'),
        ], 'lang');
    }

    /**
     * Publish migrations.
     * @return void
     */
    private function publishMigrations(): void
    {
        $this->publishes([
            $this->packagePath('database/migrations') => database_path('migrations'),
        ], 'migrations');
    }


    /*
    |--------------------------------------------------------------------------
    | OTHER SETTINGS
    |--------------------------------------------------------------------------
    */

    /**
     * Get package path.
     * @param $path
     * @return string
     */
    private function packagePath($path): string
    {
        return __DIR__ . '/../' . $path;
    }
}
