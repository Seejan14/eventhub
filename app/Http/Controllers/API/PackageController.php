<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Amenities;
use App\Models\Country;
use App\Models\EssentialItem;
use App\Models\Package;
use Illuminate\Http\Request;
use App\Traits\RespondTrait;

class PackageController extends Controller
{
    use RespondTrait;

    public function index(Request $request)
    {

        $search = $request->query('search');
        $region = $request->query('region');
        $destination = $request->query('destination');
        $activity = $request->query('activity');

        $allPackages = Package::with(['country', 'region', 'category', 'schedules'])
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhereHas('country', function ($subQ) use ($search) {
                            $subQ->where('name', 'like', "%{$search}%");
                        })
                        ->orWhereHas('region', function ($subQ) use ($search) {
                            $subQ->where('name', 'like', "%{$search}%");
                        });
                });
            })
            ->when($region, function ($query) use ($region) {
                $query->whereHas('region', function ($subQ) use ($region) {
                    $subQ->where('slug', "$region");
                });
            })
            ->when($destination, function ($query) use ($destination) {
                $query->whereHas('country', function ($subQ) use ($destination) {
                    $subQ->where('slug', "$destination");
                });
            })
            ->when($activity, function ($query) use ($activity) {
                $query->whereHas('category', function ($subQ) use ($activity) {
                    $subQ->where('slug', $activity);
                });
            })
            ->where('status', 1)
            ->paginate(20);

        return $this->successResponse($allPackages);
    }

    public function show(Request $request, $slug)
    {
        $package = Package::where('status', 1)
            ->where('slug', $slug)
            ->with('category', 'region', 'country', 'itineraries', 'schedules')
            ->firstOrFail();

        $package['guides'] = $package->guides();
        $package['essential_items'] = $package->essential_items();

        $package->itineraries->each(function ($itinerary) {
            if (!empty($itinerary->amenity_ids)) {
                $amenityIds = explode(',', $itinerary->amenity_ids);
                $itinerary->amenities = Amenities::whereIn('id', $amenityIds)->get();
            } else {
                $itinerary->amenities = [];
            }
        });

        return $this->successResponse($package);
    }

    public function getFixDepartures(Request $request)
    {
        $departures = Package::where('status', 1)
            ->with(['schedules' => function ($query) {
                $query->select('id', 'package_id', 'start_date', 'end_date', 'price', 'total_space');
            }])
            ->select('id', 'title', 'image_url', 'duration', 'slug', 'description', 'accommodation', 'best_season', 'difficulty')
            ->get();

        return $this->successResponse($departures);
    }


    public function getUpcomingPackages(Request $request)
    {
        $search = $request->query('search');
        $region = $request->query('region');
        $destination = $request->query('destination');
        $activity = $request->query('activity');

        $upcomingPackages = Package::with(['country', 'region', 'category', 'schedules'])
            ->where('status', 1)
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhereHas('country', function ($subQ) use ($search) {
                            $subQ->where('name', 'like', "%{$search}%");
                        })
                        ->orWhereHas('region', function ($subQ) use ($search) {
                            $subQ->where('name', 'like', "%{$search}%");
                        });
                });
            })
            ->when($region, function ($query) use ($region) {
                $query->whereHas('region', function ($subQ) use ($region) {
                    $subQ->where('slug', $region);
                });
            })
            ->when($destination, function ($query) use ($destination) {
                $query->whereHas('country', function ($subQ) use ($destination) {
                    $subQ->where('slug', $destination);
                });
            })
            ->when($activity, function ($query) use ($activity) {
                $query->whereHas('category', function ($subQ) use ($activity) {
                    $subQ->where('slug', $activity);
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return $this->successResponse($upcomingPackages, 'Upcoming Packages retrieved successfully');
    }


    public function getAllEssentialItems()
    {
        $essentialItems = EssentialItem::all();

        return $this->successResponse($essentialItems);
    }

    public function getPackageByDestination($id)
    {
        $packages = Package::where('country_id', $id)->get();

        return $this->successResponse($packages);
    }
}
