<?php

return [
 
    'index' => [
        'title' => 'Invoice',
    ],

    'create' => [
        'title' => 'Invoice Create',
    ],

    'edit' => [
        'title' => 'Invoice Edit',
    ],

    'delete' => [
        'title' => 'Delete',
    ],
    
    'breadcrumb' => [
        'index' => 'Invoice',
        'create' => 'Create',
        'edit' => 'Edit',
    ],
    'form' => [
        'add-button'        => 'Add New Invoice',
    ],

    'table' => [
        'sl'                => 'SL',
        'username'          => 'User Name',
        'name'              => 'Name',
        'user_id'           => 'User Name',
        'amount'            => 'Amount',
        'tokens'            => 'Tokens',
        'income_received'   => 'Income Received',
        'package_id'        => 'Package Id',
        'roi'               => 'Roi',
        'phase_id'          => 'Phase Id',
        'timeline'          => 'Timeline',
        'added'             => 'Added',
        'pending'           => 'Pending',
        'token_type'        => 'Token Type',        
        'bonus_tokens'      => 'Bonus Tokens',
        'claimed'           => 'Claimed',        
        'usdt_release'      => 'USDT Release',
        'months'            => 'Months',
        'months_left'       => 'Months Left',
        'per_month_tokens'  => 'Per Month Tokens',
        'is_binary'         => 'Is Binary',
        'expired'           => 'Expired',
        'receiving_address' => 'Receiving Address',
        'crypto_txn_id'     => 'Crypto Txn Id',
        'hash'              => 'Hash',
        'created_at'        => 'Created At',

        'status'            => 'Status',
        'edit'              => 'Edit',
        'delete'            => 'Delete',
        'users_type'        => 'User Type',
    ],

    'message' => [

        'store' => [
            'success'   => 'Invoice added successfully!',
            'error'     => 'There is an error! Please try later!',
        ],

        'update' => [
            'success'   => 'Invoice updated successfully!',
            'error'     => 'There is an error! Please try later!',
        ],

        'destroy' => [
            'success'   => 'Invoice deleted successfully!',
            'error'     => 'There is an error! Please try later!',
            'warning_last_Invoice' => 'Last Invoice can not be deleted!',
        ],
    ]

];