<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class Transaction extends Model
{
    protected $fillable = [
        'customer_id',
        'source_acc_id',
        'destination_acc_id',
        'type_id',
        'date',
        'total',
        'description',
    ];

    public function getCashIn($condition = [['transactions.type_id', '<=', 2]]){
        return DB::table('transactions')
            ->join('customers', 'customers.id', '=', 'transactions.customer_id')
            ->join('accounts as destination_account', 'destination_account.id', '=', 'transactions.destination_acc_id')
            ->select('transactions.*', 'transactions.date as datetime', 'customers.name as customer_name', 'destination_account.name as destination_acc_name')
            ->where($condition)
            ->orderBy('transactions.date')
            ->get();
    }

    public function getCashOut($condition = [['transactions.type_id', '>', 3]]){
        return DB::table('transactions')
            ->join('accounts as source_account', 'source_account.id', '=', 'transactions.source_acc_id')
            ->join('types', 'types.id', '=', 'transactions.type_id')
            ->select('transactions.*', 'transactions.date as datetime', 'source_account.name as source_acc_name', 'types.name as type_name')
            ->where($condition)
            ->orderBy('transactions.date')
            ->get();
    }

    public function getCashTransfer(){
        return DB::table('transactions')
            ->join('accounts as source_account', 'source_account.id', '=', 'transactions.source_acc_id')
            ->join('accounts as destination_account', 'destination_account.id', '=', 'transactions.destination_acc_id')
            ->select('transactions.*', 'transactions.date as datetime', 'source_account.name as source_acc_name', 'destination_account.name as destination_acc_name')
            ->where('transactions.type_id', '=', 3)
            ->orderBy('transactions.date')
            ->get();
    }

    public function getCashFlow($id = null){
        if($id)
            return DB::table('transactions')
                ->leftJoin('customers', 'customers.id', '=', 'transactions.customer_id')
                ->join('types', 'types.id', '=', 'transactions.type_id')
                ->leftJoin('accounts as account_expense', 'account_expense.id', '=', 'transactions.source_acc_id')
                ->leftJoin('accounts as account_income', 'account_income.id', '=', 'transactions.destination_acc_id')
                ->select('transactions.*', 'account_income.name as account_income', 'account_expense.name as account_expense', 'types.name as type_name', 'transactions.date as datetime', 'customers.name as customer_name')
                ->orderBy('transactions.date')
                ->where('transactions.source_acc_id', '=', $id)
                ->orWhere('transactions.destination_acc_id', '=', $id)
                ->get();
        else
            return DB::table('transactions')
            ->leftJoin('customers', 'customers.id', '=', 'transactions.customer_id')
            ->join('types', 'types.id', '=', 'transactions.type_id')
            ->leftJoin('accounts as account_expense', 'account_expense.id', '=', 'transactions.source_acc_id')
            ->leftJoin('accounts as account_income', 'account_income.id', '=', 'transactions.destination_acc_id')
            ->select('transactions.*', 'account_income.name as account_income', 'account_expense.name as account_expense', 'types.name as type_name', 'transactions.date as datetime', 'customers.name as customer_name')
            ->orderBy('transactions.date')
            ->get();
    }
    
    public function checkTransaction($id) {
        return DB::table('transactions')
            ->where([
                ['source_acc_id', '=', $id],
                ['type_id', '!=', 1]
            ])
            ->orWhere([
                ['destination_acc_id', '=', $id],
                ['type_id', '!=', 1]
            ])
            ->get();
    }
}
