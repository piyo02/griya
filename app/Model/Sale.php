<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class Sale extends Model
{
    protected $fillable = ['name', 'phone', 'street'];

    public function getDetailSales() {
        return DB::table('sales')
            ->select('sales.*', 
                        DB::raw('SUM(CASE WHEN customers.fee = "half" AND customers.state_id != 3 THEN 1 ELSE 0 END) as half_fee'),
                        DB::raw('SUM(CASE WHEN customers.fee = "full" AND customers.state_id != 3 THEN 1 ELSE 0 END) as full_fee'),
                        DB::raw('SUM(CASE WHEN customers.id  > 0 AND customers.state_id != 3 THEN 1 ELSE 0 END) as total_customer')
                    )
            ->leftJoin('customers', 'customers.sale_id', '=', 'sales.id')
            ->groupBy('sales.id')
            ->get();
    }

    public function getFeeMarketing() {
        // return DB::table('customers')
        //     ->join('clusters', 'clusters.id', '=', 'customers.cluster_id')
        //     ->rightJoin('sales', 'sales.id', '=', 'customers.sale_id')
        //     ->join('states', 'states.id', '=', 'customers.state_id')
        //     ->select('customers.*', 'states.name as state_name', 'sales.name as sales_name', DB::raw('CONCAT(clusters.block, "", clusters.number) as cluster'))
        //     ->where('state_id' ,'!=', 3)
        //     ->orWhere('state_id' ,'=', null)
        //     ->orderBy('customers.date')
        //     ->get();

        return DB::table('sales')
            ->leftJoin(DB::raw('(
                customers 
                JOIN states ON states.id = customers.state_id
                JOIN clusters ON clusters.id = customers.cluster_id
            )'), 'customers.sale_id', '=', 'sales.id')
            ->select('customers.*', 'states.name as state_name', 'sales.name as sales_name', DB::raw('CONCAT(clusters.block, "", clusters.number) as cluster'))
            ->where('state_id' ,'!=', 3)
            ->orWhere('state_id' ,'=', null)
            ->orderBy('customers.date')
            ->get();
    }
}
