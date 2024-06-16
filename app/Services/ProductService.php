<?php

namespace App\Services;
use App\Models\Product;
use App\Models\ProductSpec;

class ProductService {
    
    
    public $SORT_BY_VALUES = ['price-asc', 'price-desc'];
    public $PER_PAGE_VALUES = [2, 4, 6, 8];

    public function getProductSpecs() {
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


    public function filterProductSpecs(array $specs, array $filters) {
        $result = [];
        foreach($specs as $key => $values) {
            if (!array_key_exists($key, $filters)) continue;
            $result[$key] = array_intersect($values, $filters[$key]);
        }
        return $result;
    }

    public function checkFilters(array $applied_filters, array $filters) {

        $checked_filters = [];
        foreach ($filters as $filterName => $filterValues) {
            $checked_filters[$filterName] = [];
            foreach ($filterValues as $value) {
                $checked_filters[$filterName][$value] =  isset($applied_filters[$filterName]) && in_array($value, (array) $applied_filters[$filterName]) ? 'checked' : '';
            }
        }

        return $checked_filters;
    }
    


    public function serializeFilters(array $filters) {
        $serialized = [];
        foreach ($filters as $key => $values) {
            $serialized[$key] = $values;
        }
        return $serialized;
    }

    
    public function getOrderBy($sort_by) {
        $sort_by = in_array($sort_by, $this->SORT_BY_VALUES) ? $sort_by : $this->SORT_BY_VALUES[0];
        return  explode('-', $sort_by);
    }

    public function getPerPage($per_page) {
        return in_array($per_page, $this->PER_PAGE_VALUES) ? $per_page : 6;
    }




    public function getAllFilters($selected_filters) {
        $filters = $this->getProductSpecs();
        $applied_filters = $this->filterProductSpecs($selected_filters, $filters);
        $filters = $this->checkFilters($applied_filters, $filters);

        return [$filters, $applied_filters];
    }


    public function getProducts($sort_by, $applied_filters) {
        
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
        return $query;
    }

}
