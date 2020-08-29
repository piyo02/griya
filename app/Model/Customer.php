<?php

namespace App\Model;
use DB;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $date_from = null;
    protected $date_to = null;
    protected $sale_id = null;
    protected $state_id = null;
    protected $method_payment = null;
    protected $fee = null;
    protected $type = null;

    protected $fillable = [
        'name',
        'date',
        'phone',
        'job',
        'type',
        'method_payment',
        'sale_id',
        'fee',
        'cluster_id',
        'state_id',
        'description',
    ];

    public function getCustomers($date_from = null, $date_to = null, $sale_id = null, $state_id = null, $method_payment = null, $fee = null, $type = null) {
        $this->date_from = $date_from;
        $this->date_to = $date_to;
        $this->sale_id = $sale_id;
        $this->state_id = $state_id;
        $this->method_payment = $method_payment;
        $this->fee = $fee;
        $this->type = $type;
        return DB::table('customers')
            ->join('clusters', 'clusters.id', '=', 'customers.cluster_id')
            ->join('sales', 'sales.id', '=', 'customers.sale_id')
            ->join('states', 'states.id', '=', 'customers.state_id')
            ->select('customers.*', 'states.name as state_name', 'sales.name as sales_name', DB::raw('CONCAT(clusters.block, "", clusters.number) as block_cluster'))
            ->where(function ($query) {
                if($this->date_from) $query->whereBetween('customers.date', [$this->date_from, $this->date_to]);
                if($this->sale_id) $query->orWhere('customers.sale_id', '=', $this->sale_id);
                if($this->state_id) $query->orWhere('customers.state_id', '=', $this->state_id);
                if($this->method_payment) $query->orWhere('customers.method_payment', '=', $this->method_payment);
                if($this->fee) $query->orWhere('customers.fee', '=', $this->fee);
                if($this->type) $query->orWhere('customers.type', '=', $this->type);
            })
            ->orderBy('customers.date')
            ->get();
    }
    
    public function getDetailCustomer($id) {
        return DB::table('customers')
            ->join('clusters', 'clusters.id', '=', 'customers.cluster_id')
            ->join('sales', 'sales.id', '=', 'customers.sale_id')
            ->select('customers.*', 'sales.name as sales_name', DB::raw('CONCAT(clusters.block, "", clusters.number) as block_cluster'))
            ->where('customers.id', '=', $id)
            ->get();
    }

    public function getCreditPayment() {
        return DB::table('customers')
            ->join('clusters', 'clusters.id', '=', 'customers.cluster_id')
            ->join('sales', 'sales.id', '=', 'customers.sale_id')
            ->select('customers.*', 'sales.name as sales_name', DB::raw('CONCAT(clusters.block, "", clusters.number) as block_cluster'))
            ->where([
                ['customers.method_payment', '=', 'Kredit'],
                ['customers.state_id', '!=', 3]
            ])
            ->orderBy('customers.date')
            ->get();
    }

    public function getCashPayment() {
        return DB::table('customers')
            ->join('clusters', 'clusters.id', '=', 'customers.cluster_id')
            ->join('sales', 'sales.id', '=', 'customers.sale_id')
            ->select('customers.*', 'sales.name as sales_name', DB::raw('CONCAT(clusters.block, "", clusters.number) as block_cluster'))
            ->where([
                ['customers.method_payment', '=', 'Tunai'],
                ['customers.state_id', '!=', 3]
            ])
            ->orderBy('customers.date')
            ->get();
    }

    public function getCustomerOnProcess() {
        return DB::table('customers')
            ->join('clusters', 'clusters.id', '=', 'customers.cluster_id')
            ->join('sales', 'sales.id', '=', 'customers.sale_id')
            ->select('customers.*', 'sales.name as sales_name', DB::raw('CONCAT(clusters.block, "", clusters.number) as block_cluster'))
            ->where('customers.state_id', '=', 1)
            ->orderBy('customers.date')
            ->get();
    }

    public function getCustomerApprove() {
        return DB::table('customers')
            ->join('clusters', 'clusters.id', '=', 'customers.cluster_id')
            ->join('sales', 'sales.id', '=', 'customers.sale_id')
            ->select('customers.*', 'sales.name as sales_name', DB::raw('CONCAT(clusters.block, "", clusters.number) as block_cluster'))
            ->where('customers.state_id', '=', 2)
            ->orderBy('customers.date')
            ->get();
    }

    public function getCustomerCancel() {
        return DB::table('customers')
            ->join('clusters', 'clusters.id', '=', 'customers.cluster_id')
            ->join('sales', 'sales.id', '=', 'customers.sale_id')
            ->select('customers.*', 'sales.name as sales_name', DB::raw('CONCAT(clusters.block, "", clusters.number) as block_cluster'))
            ->where('customers.state_id', '=', 3)
            ->orderBy('customers.date')
            ->get();
    }
}
