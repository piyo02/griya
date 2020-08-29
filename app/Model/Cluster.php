<?php

namespace App\Model;
use DB;

use Illuminate\Database\Eloquent\Model;

class Cluster extends Model
{
    protected $fillable = ['block', 'number', 'description'];

    public function getBlockCluster() {
        $clusters = DB::table('clusters')
            ->leftJoin('customers', 'customers.cluster_id', '=', 'clusters.id')
            ->select('clusters.*', 'customers.name as customer_name', DB::raw('CONCAT(block, "", number) as cluster'), DB::raw('IF(customers.state_id != 3, "TERISI", "BELUM TERISI") as state'))
            ->get();

        return $this->setClusterToGroupBlock($clusters);
    }

    public function getCluster() {
        return DB::table('clusters')
            ->leftJoin('customers', 'customers.cluster_id', '=', 'clusters.id')
            ->select('clusters.*', 'customers.name as customer_name', DB::raw('CONCAT(block, "", number) as cluster'), DB::raw('IF(customers.state_id != 3, "TERISI", "BELUM TERISI") as state'))
            ->orderBy('cluster')
            ->get();
    }

    public function getBlockClusterNotSoldYet() {
        return DB::table('clusters')
            ->leftJoin('customers', 'customers.cluster_id', '=', 'clusters.id')
            ->select('clusters.*', DB::raw('CONCAT(block, "", number) as cluster'), DB::raw('IF(customers.state_id != 3, "TERISI", "BELUM TERISI") as state'))
            ->where('customers.id', '=', null)
            ->orWhere('customers.state_id', '=', 3)
            ->orderBy('cluster')
            ->get();
    }

    public function getBlockClusterSoldOut() {
        return DB::table('clusters')
            ->leftJoin('customers', 'customers.cluster_id', '=', 'clusters.id')
            ->select('clusters.*', 'customers.name as customer_name', DB::raw('CONCAT(block, "", number) as cluster'), DB::raw('IF(customers.state_id != 3, "TERISI", "BELUM TERISI") as state'))
            ->where('customers.state_id', '!=', 3)
            ->orderBy('cluster')
            ->get();
    }

    public function setClusterToGroupBlock($clusters) {
        $groupCluster = [];
        $currBlock = '';
        foreach ($clusters as $key => $cluster) {
            if($currBlock != $cluster->block){
                $currBlock = $cluster->block;
            }
            $groupCluster[$cluster->block][] = $cluster;
        }

        return $groupCluster;
    }
}
