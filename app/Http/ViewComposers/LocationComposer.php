<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Models\Location;

class LocationComposer
{
    protected $locations;
    /**
     * Create a movie composer.
     *
     * @param  Location $locations
     * @return void
     */
    public function __construct(Location $locations)
    {
        $this->locations = $locations;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $locations = $this->locations::where('active', true)
            ->orderBy('title', 'asc')
            ->get();
        $view->with('locations', $locations);
    }
}