<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductSpec;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    private $SORT_BY_VALUES = ['price-asc', 'price-desc'];
    private $PER_PAGE_VALUES = [2, 4, 6, 8];



    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $sort_by = $request->input('sort_by', 'price-asc');
        $per_page = (int) $request->input('per_page', 6);
        $search = $request->input('search', '');


        $filters = $this->getProductSpecs();
        $applied_filters = $this->filterProductSpecs($request->all(), $filters);
        $filters = $this->checkFilters($applied_filters, $filters);


        $per_page = $this->getPerPage($per_page);
        [$order_key, $order_value] =  $this->getOrderBy($sort_by);

        $query = Product::query();

        if (!empty($search)) {
            $query->where('name', 'LIKE', '%' . $search . '%');
        }

        if (!empty($applied_filters)) {
            $query->where(function ($query) use ($applied_filters) {
                foreach ($applied_filters as $key => $values) {
                    $query->orWhereHas('specs', function ($query) use ($key, $values) {
                        $query->where(function ($query) use ($key, $values) {
                            foreach ($values as $value) {
                                $query->orWhere(function ($query) use ($key, $value) {
                                    $query->where('name', $key)->where('value', $value);
                                });
                            }
                        });
                    });
                }
            });
        }
    


        $query->orderBy($order_key, $order_value);
    
        $products = $query->paginate($per_page)->appends([
            'sort_by' => $sort_by,
            'per_page' => $per_page,
            'search' => $search,
            
        ] + $this->serializeFilters($applied_filters));

        $favourites = Auth::user()->favourites->pluck('id')->toArray();

        return view('home.index', compact(
            'products', 
            'favourites', 
            'search', 
            'sort_by', 
            'per_page',
            'filters',
            'applied_filters'
        ) + [
            'per_page_values' => $this->PER_PAGE_VALUES,
            // 'sort_by_values' => $this->SORT_BY_VALUES
        ]);
    }

    
    private function getProductSpecs() {
        // handling filter part
        $specs = ProductSpec::all();
        $filters = [];
        foreach ($specs as $spec) {
            $name = $spec->name;
            $value = $spec->value;
        
            if (!isset($filters[$name])) {
                $filters[$name] = [];
            }
        
            if (!in_array($value, $filters[$name])) {
                $filters[$name][] = $value;
            }
        }
        return $filters;
    }


    private function filterProductSpecs(array $specs, array $filters) {
        $result = [];
        foreach($specs as $key => $values) {
            if (!array_key_exists($key, $filters)) continue;
            $result[$key] = array_intersect($values, $filters[$key]);
        }
        return $result;
    }

    private function checkFilters(array $applied_filters, array $filters) {

        $checked_filters = [];
        foreach ($filters as $filterName => $filterValues) {
            $checked_filters[$filterName] = [];
            foreach ($filterValues as $value) {
                $checked_filters[$filterName][$value] =  isset($applied_filters[$filterName]) && in_array($value, (array) $applied_filters[$filterName]) ? 'checked' : '';
            }
        }

        return $checked_filters;
    }
    


    private function serializeFilters(array $filters) {
        $serialized = [];
        foreach ($filters as $key => $values) {
            $serialized[$key] = $values;
        }
        return $serialized;
    }

    
    private function getOrderBy($sort_by) {
        $sort_by = in_array($sort_by, $this->SORT_BY_VALUES) ? $sort_by : $this->SORT_BY_VALUES[0];
        return  explode('-', $sort_by);
    }

    private function getPerPage($per_page) {
        return in_array($per_page, $this->PER_PAGE_VALUES) ? $per_page : 6;
    }

}
