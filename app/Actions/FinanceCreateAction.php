<?php

namespace App\Actions;

use App\Models\Finance;

class FinanceCreateAction
{
    public function handle($operation, $target)
    {
        $data['user_id'] = $operation['user_id'];
        $data['sum'] = $operation['money'];
        if($target === 2 || $target === 3){
            $data['sum'] = -$data['sum'];
        }
        if($target === 1 || $target === 2){
            $data['order_id'] = $operation['id'];
        } elseif ($target === 3) {
            $data['receipt_id'] = $operation['id'];
        } elseif ($target === 4) {
            $data['expense_id'] = $operation['id'];
        }

        $data['target'] = $target;
        $financeLast = Finance::where('user_id', $operation['user_id'])->orderBy('id', 'desc')->first();
        if($financeLast === null){
            $data['total'] = $data['sum'];
        } else {
            $data['total'] = $financeLast['total'] + $data['sum'];
        }
        Finance::create($data);
    }
}
