<?php

namespace App\Configurations;

use Bow\View\View;
use Bow\Configuration\Loader;
use Bow\Configuration\Configuration;
use League\CommonMark\CommonMarkConverter;

class ApplicationConfiguration extends Configuration
{
    /**
     * Launch configuration
     *
     * @param  Loader $config
     * @return void
     */
    public function create(Loader $config): void
    {
        //
    }

    /**
     * Start the configured package
     *
     * @return void
     */
    public function run(): void
    {
        View::getInstance()->getEngine()->directive("markdown", function ($expression, $allow_unsafe_links = true) {
            $converter = new CommonMarkConverter([
                'html_input' => 'strip',
                'allow_unsafe_links' => $allow_unsafe_links,
            ]);
            return $converter->convert($expression);
        });
    }
}
