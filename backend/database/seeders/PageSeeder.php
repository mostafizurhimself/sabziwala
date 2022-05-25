<?php

namespace Database\Seeders;

use App\Models\Appearance;
use App\Enums\AppearanceType;
use App\Enums\SettingsType;
use App\Models\Settings;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Website Settings section seeder
        DB::transaction(function () {
            $website = Settings::updateOrCreate(
                [
                    'name' => SettingsType::WEBSITE()
                ],
                [
                    'data' => [
                        'name'        => "SabziWaley",
                        'description' => "Organic Food Haven",
                        'phone'       => "85785648996",
                        'email'       => "sabziwaley@gmail.com",
                        'street'      => "12 Park street",
                        'city'        => "Lahore",
                        'zip'         => "7854",
                        'country'     => "Pakistan",
                        'facebook'    => "https://www.google.com/",
                        'twitter'     => "https://www.google.com/",
                        'instagram'     => "https://www.google.com/",
                    ]
                ]
            );

            $website->addMediaFromUrl(asset('images/logo/logo.png'))->toMediaCollection('primary');
        });

        //  Currency Settings section seeder
        DB::transaction(function () {
            Settings::updateOrCreate(
                [
                    'name' => SettingsType::CURRENCY()
                ],
                [
                    'data' => [
                        'name'        => "Pakistan",
                        'code'        => "PKR",
                        'symbol'      => "Rs.",
                    ]
                ]
            );
        });

        //  Hero section seeder
        DB::transaction(function () {
            $hero = Appearance::updateOrCreate(
                [
                    'name' => AppearanceType::HERO()
                ],
                [
                    'data' => [
                        'title'    => "Get Organic Food At Your Doorstep ",
                        'subtitle' => "With Firm Fresh Food We Offer Quick Delivery ",
                    ]
                ]
            );

            $hero->addMediaFromUrl(asset('images/appearances/home/homepage-hero.png'))->toMediaCollection('primary');
        });

        //  Home page App section seeder
        DB::transaction(function () {
            $apps = Appearance::updateOrCreate(
                [
                    'name' => AppearanceType::APP_SECTION()
                ],
                [
                    'data' => [
                        'title'    => "Get our app",
                        'subtitle' => "Keep sabziwaly in your pocket",
                        'playStore' => "https://www.google.com/",
                        'appStore' => "https://www.google.com/",
                    ]
                ]
            );

            $apps->addMediaFromUrl(asset('images/appearances/home/delivery-rider.png'))->toMediaCollection('primary');
        });

        //  Rider Hero section seeder
        DB::transaction(function () {
            $hero = Appearance::updateOrCreate(
                [
                    'name' => AppearanceType::RIDER_HERO()
                ],
                [
                    'data' => [
                        'title'    => "Become A Rider",
                        'subtitle' => "With massive opportunity our rider is our priority",
                    ]
                ]
            );

            $hero->addMediaFromUrl(asset('images/appearances/rider/rider-banner.jpg'))->toMediaCollection('primary');
        });

        // Rider page App section seeder
        DB::transaction(function () {
            $apps = Appearance::updateOrCreate(
                [
                    'name' => AppearanceType::RIDER_APPS()
                ],
                [
                    'data' => [
                        'title'    => "Get our app",
                        'subtitle' => "Keep sabziwaly in your pocket",
                        'playStore' => "https://www.google.com/",
                        'appStore' => "https://www.google.com/",
                    ]
                ]
            );

            $apps->addMediaFromUrl(asset('images/appearances/home/delivery-rider.png'))->toMediaCollection('primary');
        });

        //  About Hero section seeder
        DB::transaction(function () {
            $hero = Appearance::updateOrCreate(
                [
                    'name' => AppearanceType::ABOUT_PAGE_HERO()
                ],
                [
                    'data' => [
                        'title'    => "Learn About Sabziwaly",
                    ]
                ]
            );

            $hero->addMediaFromUrl(asset('images/appearances/about/about-us.jpg'))->toMediaCollection('primary');
        });

        //  About Owner section seeder
        DB::transaction(function () {
            $owner = Appearance::updateOrCreate(
                [
                    'name' => AppearanceType::OWNER_SECTION()
                ],
                [
                    'data' => [
                        'title'       => "Owner Say About Sabziwaly",
                        'subtitle'    => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,",

                        'description' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type.",
                    ]
                ]
            );

            $owner->addMediaFromUrl(asset('images/appearances/rider/rider-banner.jpg'))->toMediaCollection('primary');
        });

        //  Contact Hero section seeder
        DB::transaction(function () {
            $hero = Appearance::updateOrCreate(
                [
                    'name' => AppearanceType::CONTACT_PAGE_HERO()
                ],
                [
                    'data' => [
                        'title'    => "Contact With Us",
                    ]
                ]
            );

            $hero->addMediaFromUrl(asset('images/appearances/contact/contact-banner.jpg'))->toMediaCollection('primary');
        });

        //  Payment section seeder
        DB::transaction(function () {
            Appearance::updateOrCreate(
                [
                    'name' => AppearanceType::PAYMENT_REFUNDS()
                ],
                [
                    'data' => [
                        'purchase'    => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.



                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.",


                        'refunds'    => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.",
                    ]
                ]
            );
        });

        //  Terms section seeder
        DB::transaction(function () {
            Appearance::updateOrCreate(
                [
                    'name' => AppearanceType::TERMS_CONDITIONS()
                ],
                [
                    'data' => [
                        'general'    => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.",

                        'privacy'    => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.



                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.",
                    ]
                ]
            );
        });
    }
}
