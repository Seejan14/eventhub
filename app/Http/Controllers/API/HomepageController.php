<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\PackageCategory;
use Illuminate\Http\Request;
use App\Traits\RespondTrait;

class HomepageController extends Controller
{
    use RespondTrait;

    public function getHomepageTrips($id)
    {
        $data['popularTrips'] = $this->getPopularTrips($id);
        $data['upcomingDepartures'] = $this->getUpcomingDepartures($id);
        $data['recommendedPackages'] = $this->getRecommendedTrips($id);

        return $this->successResponse($data);
    }

    public function getPopularTrips()
    {
        $popularPackages = Package::where('status', 1)->where('popular', 1)->get();

        return $this->successResponse($popularPackages);
    }

    public function getUpcomingDepartures()
    {
        $upcomingPackages = Package::with('schedules')->where('status', 1)->orderBy('created_at')->get();

        return $this->successResponse($upcomingPackages);
    }

    public function getRecommendedPackages()
    {
        $recommendedPackages = Package::where('status', 1)
            ->where('recommended', 1)
            ->get();

        return $this->successResponse($recommendedPackages);
    }

    public function getActivities()
    {
        $activities = PackageCategory::where('status', 1)
            ->with('packages')
            ->get();

        return $this->successResponse($activities);
    }
}
