<?php

namespace App\Http\Controllers\Api;

use App\Models\Zone;
use App\Models\Product;
use App\Models\AboutFaq;
use App\Models\RiderFaq;
use App\Models\Settings;
use App\Models\Appearance;
use App\Models\HowItWorks;
use App\Models\WorkWithUs;
use App\Models\WhyChooseUs;
use Illuminate\Http\Request;
use App\Facades\ConfigHelper;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;

class ConfigController extends Controller
{

    /**
     * Get the appearances and settings
     */
    public function __invoke()
    {
        $data = [
            'settings'      => Settings::all(),
            'appearances'   => Appearance::all(),
            'howItWorks'    => HowItWorks::all(),
            'workWithUs'    => WorkWithUs::all(),
            'riderFaqs'     => RiderFaq::all(),
            'aboutFaqs'     => AboutFaq::all(),
            'whyChooseUs'   => WhyChooseUs::all(),
            'enums'         => ConfigHelper::getEnums(),
            'options'       => ConfigHelper::getOptions(),
            // 'featureProducts' => Product::withCount('orderItems')->orderBy('order_items_count', 'desc')->take(6)->get(),
            'cities'        => Zone::select('city')->distinct()->pluck('city')->toArray(),
        ];
        return new ApiResource($data);
    }
}
