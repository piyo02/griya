<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class Account extends Model
{
    protected $fillable = ['name', 'number', 'saldo'];

    public function getAccount( $condition = [] ) {
        if($condition != [])
            return DB::table('accounts')
                ->select('accounts.*')
                ->where([$condition])
                ->get();
        else
            return DB::table('accounts')
                ->select('accounts.*')
                ->get();
    }

    public function getCurrSaldoAccount($where = []) {
        $condition[] = ['transactions.type_id', '!=', 1];
        if($where != [])
            $condition[] = $where;
        
        $accounts = $this->getAccount($where);
        $expense_accounts = $this->getExpenseAccount($condition);
        $income_accounts = $this->getIncomeAccount($condition);
        $i = 0;
        $j = 0;
        foreach ($accounts as $key => $account) {
            $income = (isset($income_accounts[$i]->total_income) && $account->id == $income_accounts[$i]->id) ? $income_accounts[$i]->total_income : 0;
            $expense = (isset($expense_accounts[$j]->total_expense) && $account->id == $expense_accounts[$j]->id) ? $expense_accounts[$j]->total_expense : 0;
            $getCurrSaldoAccount[$account->id] = (object) [
                'id' => $account->id,
                'name' => $account->name,
                'number' => $account->number,
                'saldo' => $account->saldo + ($income - $expense)
            ];
            if(isset($income_accounts[$i]->total_income) && $account->id == $income_accounts[$i]->id) { $i++; }
            if(isset($expense_accounts[$j]->total_expense) && $account->id == $expense_accounts[$j]->id) { $j++; }
        }
        
        return $getCurrSaldoAccount;
    }

    public function getExpenseAccount( $condition = [] ) {
        return DB::table('accounts')
            ->select('accounts.id', DB::raw('SUM(transactions.total) as total_expense'))
            ->join('transactions', 'transactions.source_acc_id', '=', 'accounts.id')
            ->where($condition)
            ->groupBy('accounts.id')
            ->orderBy('accounts.id')
            ->get();
    }

    public function getIncomeAccount( $condition = [] ) {
        return DB::table('accounts')
            ->select('accounts.id', DB::raw('SUM(transactions.total) as total_income'))
            ->join('transactions', 'transactions.destination_acc_id', '=', 'accounts.id')
            ->where($condition)
            ->groupBy('accounts.id')
            ->orderBy('accounts.id')
            ->get();
    }
}
