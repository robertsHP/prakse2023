
<?php
    include 'apiFunctions.php';

    refreshDBInfoFor(
        'clients', 
        'clients',
        [
            'id' => 'client_id',
            'name' => 'name',
            'email' => 'email',
            'phone_number' => 'phone_number',
            'address' => 'adress'
        ]
    );
    refreshDBInfoFor(
        'categories', 
        'product_categories',
        [
            'id' => 'category_id',
            'name' => 'name'
        ]
    );
    refreshDBInfoFor(
        'order_states', 
        'order_states',
        [
            'id' => 'state_id',
            'name' => 'name'
        ]
    );
    refreshDBInfoFor(
        'orders', 
        'orders',
        [
            'id' => 'order_id',
            'number' => 'number',
            'client_id' => 'client_id',
            'date' => 'date',
            'total_sum' => 'total_price',
            'state_id' => 'state_id'
        ]
    );
    refreshDBInfoFor(
        'products', 
        'products',
        [
            'id' => 'product_id',
            'name' => 'name',
            'description' => 'description',
            'image_path' => 'photo_file_loc',
            'price' => 'price',
            'count_left' => 'available_amount',
            'category_id' => 'category_id',
        ]
    );
    refreshDBInfoFor(
        'order_products',
        'purchased_goods',
        [
            'id' => 'purch_goods_id',
            'order_id' => 'order_id',
            'product_id' => 'product_id',
            'count' => 'amount',
            'total_sum' => 'total_price'
        ]
    );
?>