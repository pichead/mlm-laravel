<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Order;
use App\Models\PurchaseOrder;
use App\Models\Price;




class SendMail extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $Order = Order::where('purchase_order_id',$this->data['purchase_id'])->get();
        $Price = Order::where('purchase_order_id',$this->data['purchase_id'])->sum('price');
        $Payment = PurchaseOrder::where('id',$this->data['purchase_id'])->first();
        $priceitem = Price::where('user_id',$Payment->buyer_id)->get();
        if($this->data['subject'] == "แจ้งเตือนการชำระเงิน"){
            return $this->from('noreply@vdealers.com')
                ->subject($this->data['subject'])
                ->view('mail.payment_mail')
                ->with('data', $this->data)
                ->with('Order',$Order)
                ->with('Price',$Price)
                ->with('priceitem',$priceitem)
                ;
        }
        else{
            return $this->from('noreply@vdealers.com')
                    ->subject($this->data['subject'])
                    ->view('mail.bill_mail')
                    ->with('data', $this->data)
                    ->with('Order',$Order)
                    ->with('Price',$Price)
                    ->with('priceitem',$priceitem)
                    ;

        }
    }
}

?>