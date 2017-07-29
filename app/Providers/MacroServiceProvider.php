<?php

namespace App\Providers;

use App\Helpers\Macros\Macros;
use Collective\Html\HtmlServiceProvider;
use Form;

/**
 * Class MacroServiceProvider.
 */
class MacroServiceProvider extends HtmlServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        parent::register();

        $this->app->singleton('form', function ($app) {
            $form = new Macros($app['html'], $app['url'], $app['view'], $app['session.store']->token());

            return $form->setSessionStore($app['session.store']);
        });

        // https://gist.github.com/marekmurawski/8855132
        if ($this->app->bound('form')) {
            $this->app['form']->macro('selectOpt', function(\ArrayAccess $collection, $name, $groupBy, $labelBy = 'name', $valueBy = 'id', $value = null, $attributes = array()) {
                $select_optgroup_arr = [];
                foreach ($collection as $item)
                {
                    $select_optgroup_arr[$item[$groupBy]][$item[$valueBy]] = $item[$labelBy];
                }
                return Form::select($name, $select_optgroup_arr, $value, $attributes);
            });
        }
    }
}
