<?php

use Inertia\Inertia;
use App\Enums\SalaryStatus;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\TagController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ZoneController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RiderController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\PayslipController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AboutFaqController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\RiderFaqController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\AboutPageController;
use App\Http\Controllers\RiderPageController;
use App\Http\Controllers\TermsPageController;
use App\Http\Controllers\HowItWorksController;
use App\Http\Controllers\WorkWithUsController;
use App\Http\Controllers\ContactPageController;
use App\Http\Controllers\ExpenseTypeController;
use App\Http\Controllers\WhyChooseUsController;
use App\Http\Controllers\RefundRequestController;
use App\Http\Controllers\UserNotificationController;
use App\Http\Controllers\PaymentRefundsPageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth'])->group(function () {
        Route::get('/', function () {
                return Inertia::render('Dashboard');
        })->name('dashboard');

        // Customer Route
        Route::resource('customers', CustomerController::class);
        Route::post('/customers/{customer}/update-status', [CustomerController::class, 'updateStatus'])->name('customers.update-status');

        // Rider Route
        Route::resource('riders', RiderController::class);
        Route::post('/riders/{rider}/update-status', [RiderController::class, 'updateStatus'])->name('riders.update-status');
        Route::post('/riders/{rider}/verified', [RiderController::class, 'verified'])->name('riders.verified');

        // Employees Route
        Route::resource('employees', EmployeeController::class);

        // Resource Route
        Route::resource('roles', RoleController::class);
        Route::resource('users', UserController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('expenses', ExpenseController::class);
        Route::resource('loans', LoanController::class);
        Route::post('/loans/{loan}/confirmed', [LoanController::class, 'confirmed'])->name('loans.confirmed');
        Route::post('loans/confirm-multiple', [LoanController::class, 'confirmMultiple'])->name('loans.confirmMultiple');
        // Salary Routes
        Route::resource('salaries', SalaryController::class);
        Route::post('salaries/confirm', [SalaryController::class, 'confirm'])->name('salaries.confirm');
        Route::post('salaries/generate-salaries', [SalaryController::class, 'generateSalaries'])->name('salaries.generate-salaries');
        Route::get('/salaries/{salary}/payslip', [PayslipController::class, 'create'])->name('payslips.create');
        Route::post('/salaries/{salary}/payslip', [PayslipController::class, 'store'])->name('payslips.store');
        Route::get('/payslips/{payslip}', [PayslipController::class, 'show'])->name('payslips.show');
        // End Salary Routes
        Route::resource('expense-type', ExpenseTypeController::class);
        Route::resource('zones', ZoneController::class);
        Route::resource('orders', OrderController::class);
        Route::resource('refund-requests', RefundRequestController::class)->only('index', 'show', 'update');
        Route::get('/orders/{order}/invoice', [OrderController::class, 'invoice'])->name('orders.invoice');
        Route::post('orders/update-status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
        Route::post('orders/assign-rider', [OrderController::class, 'assignRider'])->name('orders.assign-rider');

        // Product Route
        Route::resource('products', ProductController::class);
        Route::post('/products/{product}/published', [ProductController::class, 'published'])->name('products.published');
        Route::post('/products/{product}/isFeatured', [ProductController::class, 'isFeatured'])->name('products.isFeatured');
        // Reviews
        Route::resource('/reviews', ReviewController::class)->only('index', 'show');
        Route::post('/reviews/{review}/approved', [ReviewController::class, 'approved'])->name('reviews.approved');
        // Contacts
        Route::resource('contacts', ContactController::class)->only('index', 'show', 'destroy');
        Route::post('/contacts/{contact}/reply', [ContactController::class, 'reply'])->name('contacts.reply');

        // Appearance Route

        // Home Page
        Route::get('/appearance/home', [HomePageController::class, 'index'])->name('appearance.home');
        Route::post('/appearance/home/hero', [HomePageController::class, 'hero'])->name('appearance.home.hero');
        Route::post('/appearance/home/apps', [HomePageController::class, 'apps'])->name('appearance.home.apps');

        // How it works
        Route::post('appearance/how-it-works', [HowItWorksController::class, 'store'])->name('how-it-works.create');
        Route::post('appearance/how-it-works/{howItWorks}', [HowItWorksController::class, 'update'])->name('how-it-works.update');
        Route::delete('appearance/how-it-works/{howItWorks}', [HowItWorksController::class, 'destroy'])->name('how-it-works.delete');

        // Rider Page
        Route::get('/appearance/rider', [RiderPageController::class, 'index'])->name('appearance.rider');
        Route::post('/appearance/rider/hero', [RiderPageController::class, 'hero'])->name('appearance.rider.hero');
        Route::post('/appearance/rider/apps', [RiderPageController::class, 'apps'])->name('appearance.rider.apps');

        // Rider Faqs
        Route::post('appearance/rider-faqs', [RiderFaqController::class, 'store'])->name('rider-faqs.create');
        Route::post('appearance/rider-faqs/{riderFaq}', [RiderFaqController::class, 'update'])->name('rider-faqs.update');
        Route::delete('appearance/rider-faqs/{riderFaq}', [RiderFaqController::class, 'destroy'])->name('rider-faqs.delete');


        // Work With Us
        Route::post('appearance/work-with-us', [WorkWithUsController::class, 'store'])->name('work-with-us.create');
        Route::post('appearance/work-with-us/{workWithUs}', [WorkWithUsController::class, 'update'])->name('work-with-us.update');
        Route::delete('appearance/work-with-us/{workWithUs}', [WorkWithUsController::class, 'destroy'])->name('work-with-us.delete');

        // Contact Page
        Route::get('/appearance/contact', [ContactPageController::class, 'index'])->name('appearance.contact');
        Route::post('/appearance/contact/hero', [ContactPageController::class, 'hero'])->name('appearance.contact.hero');

        // About Page
        Route::get('/appearance/about', [AboutPageController::class, 'index'])->name('appearance.about');
        Route::post('/appearance/about/hero', [AboutPageController::class, 'hero'])->name('appearance.about.hero');
        Route::post('/appearance/about/owner', [AboutPageController::class, 'owner'])->name('appearance.about.owner');

        //Why Choose Us
        Route::post('appearance/why-choose-us', [WhyChooseUsController::class, 'store'])->name('why-choose-us.create');
        Route::post('appearance/why-choose-us/{whyChooseUs}', [WhyChooseUsController::class, 'update'])->name('why-choose-us.update');
        Route::delete('appearance/why-choose-us/{whyChooseUs}', [WhyChooseUsController::class, 'destroy'])->name('why-choose-us.delete');

        // Rider Faqs
        Route::post('appearance/about-faqs', [AboutFaqController::class, 'store'])->name('about-faqs.create');
        Route::post('appearance/about-faqs/{aboutFaq}', [AboutFaqController::class, 'update'])->name('about-faqs.update');
        Route::delete('appearance/about-faqs/{aboutFaq}', [AboutFaqController::class, 'destroy'])->name('about-faqs.delete');

        // Terms & Conditions
        Route::get('/appearance/terms-and-conditions', [TermsPageController::class, 'index'])->name('appearance.terms');
        Route::post('/appearance/terms-and-conditions/terms', [TermsPageController::class, 'termsConditions'])->name('appearance.terms.termsConditions');

        // Payment & Refunds
        Route::get('/appearance/payment-and-refunds', [PaymentRefundsPageController::class, 'index'])->name('appearance.payments');
        Route::post('/appearance/payment-and-refunds/payments', [PaymentRefundsPageController::class, 'paymentRefunds'])->name('appearance.payments.paymentRefunds');

        // Notification routes
        Route::post('/notifications/{id}', [UserNotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
        Route::post('/notifications', [UserNotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
        Route::delete('/notifications', [UserNotificationController::class, 'clearAll'])->name('notifications.clearAll');

        // Settings Route
        Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::post('/settings/website', [SettingsController::class, 'website'])->name('settings.website');
        Route::post('/settings/currency', [SettingsController::class, 'currency'])->name('settings.currency');
        Route::resource('/settings/countries', CountryController::class)->except('index', 'create', 'show', 'edit');
        Route::resource('/settings/units', UnitController::class)->except('index', 'create', 'show', 'edit');

        // Media routes
        Route::post('media/{media}', [MediaController::class, 'download'])->name('media.download');
        Route::delete('media/{media}', [MediaController::class, 'remove'])->name('media.remove');
});
