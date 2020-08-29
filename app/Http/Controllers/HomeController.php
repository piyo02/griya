<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\UserRole;
use App\Model\Account;
use App\Model\Cluster;
use App\Model\Customer;

class HomeController extends UserController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    
    public function __construct()
    {
        parent::__construct();
        $this->cluster_model = new Cluster();
        $this->customer_model = new Customer();
        $this->account_model = new Account();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $accounts = $this->account_model->getCurrSaldoAccount();
        
        $customer_credit = $this->customer_model->getCreditPayment();
        $customer_cash = $this->customer_model->getCashPayment();

        $customer_on_process = $this->customer_model->getCustomerOnProcess();
        $customer_approve = $this->customer_model->getCustomerApprove();
        $customer_cancel = $this->customer_model->getCustomerCancel();

        $cluster_empty = $this->cluster_model->getBlockClusterNotSoldYet();
        $cluster_full = $this->cluster_model->getBlockClusterSoldOut();

        $this->data['cluster'] = [
            'empty' => count($cluster_empty),
            'full'  => count($cluster_full),
        ];
        $this->data['method'] = [
            'credit' => count($customer_credit),
            'cash' => count($customer_cash),
        ];
        $this->data['state'] = [
            'on_process' => count($customer_on_process),
            'approve' => count($customer_approve),
            'cancel' => count($customer_cancel),
        ];
        $this->data['accounts'] = $accounts;
        return $this->render( 'uadmin.home.index' );
    }
}
