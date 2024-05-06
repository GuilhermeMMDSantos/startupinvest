<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    protected $table = "transactions";
    protected $fillable = [
        "item_number",
        "item_name",
        "item_price", 
        "order_id", 
        "fk_payer",
        "payment_source",
        "payment_source_card_last_digits",
        "payment_source_card_expiry",
        "payment_source_card_brand",
        "payment_status"
    ];
}
