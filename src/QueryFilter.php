<?php

namespace Rondigital\QueryFilter;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

trait QueryFilter
{

    public function query($collection, Request $request)
    {

        if ($request->has('startingDate')) {
            $endingDate = $request->endingDate ?? Carbon::now();
            $collection = $collection->where('created_at', '>=', $request->startingDate)
                ->where('created_at', '<=', $endingDate);
        }
        if ($request->has('filteredBy')) {
            switch ($request->filteredBy) {
                case 'today':
                    $collection = $collection->where('created_at', '>=', Carbon::now()->format('Y-m-d'));
                    break;
                case 'last-24':
                    $collection = $collection->where('created_at', '>=', Carbon::now()->subDay());
                    break;
                case 'last-7-day':
                    $collection = $collection->where('created_at', '>=', Carbon::now()->subDays(7));
                    break;
                case 'last-30-day':
                    $collection = $collection->where('created_at', '>=', Carbon::now()->subDays(30));
                    break;
                case 'last-60-day':
                    $collection = $collection->where('created_at', '>=', Carbon::now()->subDays(60));
                    break;
                case 'last-90-day':
                    $collection = $collection->where('created_at', '>=', Carbon::now()->subDays(90));
                    break;
                case 'last-year':
                    $collection = $collection->where('created_at', '>=', Carbon::now()->subYear());
                    break;
                case 'this-month':
                    $collection = $collection->whereMonth('created_at', Carbon::now()->month)
                        ->whereYear('created_at', Carbon::now()->year);
                    break;
                case 'last-month':
                    $collection = $collection->whereMonth('created_at', Carbon::now()->subMonth()->month)
                        ->whereYear('created_at', Carbon::now()->subMonth()->year);
                    break;
                case 'this-week':
                    $startOfWeek = Carbon::now()->startOfWeek(); // Bu haftanın başlangıç tarihi
                    $endOfWeek = Carbon::now()->endOfWeek(); // Bu haftanın bitiş tarihi
                    $collection = $collection->whereBetween('created_at', [$startOfWeek, $endOfWeek]);
                    break;
                case 'last-week':
                    $startOfLastWeek = Carbon::now()->subWeek()->startOfWeek(); // Geçen haftanın başlangıç tarihi
                    $endOfLastWeek = Carbon::now()->subWeek()->endOfWeek(); // Geçen haftanın bitiş tarihi
                    $collection = $collection->whereBetween('created_at', [$startOfLastWeek, $endOfLastWeek]);
                    break;
            }
        }
        if ($request->has('search')) {
            $searchTerm = $request->search;
            if($request->searchColumn){
                $searchColumn = $request->searchColumn; // Default sütunlar
                if($searchColumn){
                    if(Schema::hasColumn($collection->first()->getTable(), $searchColumn)){
                        $collection = $collection->where($searchColumn, 'like', '%' . $searchTerm . '%');
                    }
                }
            }
        }

        $collection = $collection->orderBy($request->orderBy ?? 'id', $request->orderType ?? 'asc')->paginate($request->perPage ?? 10);
        return $collection;

    }
}
