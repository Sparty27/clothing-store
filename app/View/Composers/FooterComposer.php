<?php
 
namespace App\View\Composers;

use App\Models\Category;
use App\Models\Contact;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
 
class FooterComposer
{
    /**
     * Create a new profile composer.
     */
    public function __construct() {}
 
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $footerCategories = Cache::remember('footer-categories', 3600, function () {   
            return Category::footerVisible()->orderPriority()->get();   
        });

        $footerContacts = Cache::remember('footer-contacts', 3600, function () {   
            return Contact::active()->get();   
        });


        $view->with('footerCategories', $footerCategories);
        $view->with('footerContacts', $footerContacts);
    }
}