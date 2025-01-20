<?php

namespace App\Filters;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;


abstract class AbstractFilters{

    protected $request;

    protected $filters = [];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    public function filter(Builder $builder): Builder
    {
        foreach($this->request->all() as $filter => $value){
            if($this->filters[$filter] && method_exists($this,$this->filters[$filter])){
                $this->filters[$filter]($builder,$filter,$value);
            }
        }

        return $builder;
    }

    public function generic(Builder $builder,string $filter,string $value ): Builder
    {
        return $builder->where($filter,$value);
    }


}
