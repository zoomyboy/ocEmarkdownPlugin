<?php namespace Zoomyboy\Emarkdown;

use Backend;
use System\Classes\PluginBase;
use Event;
use October\Rain\Support\Facades\Twig;

/**
 * emarkdown Plugin Information File
 */
class Plugin extends PluginBase
{

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'emarkdown',
            'description' => 'No description provided yet...',
            'author'      => 'zoomyboy',
            'icon'        => 'icon-leaf'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {
		Event::listen('markdown.beforeParse', function ($data) {
			$data->text = preg_replace_callback('/<.+@.+>/', function($mail) {
				$mail = trim($mail[0], '<>');
				$mailParsed = Twig::parse('{{ html_email("'.$mail.'") }}');
				return '<a href="mailto:'.$mailParsed.'">'.$mailParsed.'</a>';
			}, $data->text);
		});
    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return []; // Remove this line to activate

        return [
            'Zoomyboy\Emarkdown\Components\MyComponent' => 'myComponent',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return []; // Remove this line to activate

        return [
            'zoomyboy.emarkdown.some_permission' => [
                'tab' => 'emarkdown',
                'label' => 'Some permission'
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return []; // Remove this line to activate

        return [
            'emarkdown' => [
                'label'       => 'emarkdown',
                'url'         => Backend::url('zoomyboy/emarkdown/mycontroller'),
                'icon'        => 'icon-leaf',
                'permissions' => ['zoomyboy.emarkdown.*'],
                'order'       => 500,
            ],
        ];
    }

}
