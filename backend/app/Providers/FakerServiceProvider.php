<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Bezhanov\Faker\ProviderCollectionHelper;

class FakerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Faker', function ($app) {
            $faker = \Faker\Factory::create();
            // $newClass = new class($faker) extends \Faker\Provider\Base
            // {
            //     public function title($nbWords = 5)
            //     {
            //         $sentence = $this->generator->sentence($nbWords);
            //         return substr($sentence, 0, strlen($sentence) - 1);
            //     }
            // };

            // $faker->addProvider($newClass);
            ProviderCollectionHelper::addAllProvidersTo($faker);
            return $faker;
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
