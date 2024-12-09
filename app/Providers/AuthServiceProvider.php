<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Announcement;
use App\Models\Category;
use App\Models\City;
use App\Models\Contact;
use App\Models\Country;
use App\Models\Leave;
use App\Models\Post;
use App\Policies\AnnoucementPol;
use App\Policies\AnnouncementPol;
use App\Policies\CategoryPol;
use App\Policies\CityPol;
use App\Policies\ContactPol;
use App\Policies\CountryPol;
use App\Policies\LeavePol;
use App\Policies\PostPol;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Announcement::class => AnnouncementPol::class,
        Leave::class => LeavePol::class,
        Post::class => PostPol::class,
        Category::class => CategoryPol::class,
        City::class => CityPol::class,
        Contact::class => ContactPol::class,
        Country::class => CountryPol::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
