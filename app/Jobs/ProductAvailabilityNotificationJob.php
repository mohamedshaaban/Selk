<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Product;
use App\Models\ProductAvailabilityNotification as PAN;
use Illuminate\Support\Facades\Mail;
use App\Mail\ProductAvailabilityNotificationMail;

class ProductAvailabilityNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $product;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $customers = PAN::where('product_id', $this->product->id)->where('status', 0)->get();
        foreach ($customers as $customer) {
            try {
                Mail::to($customer->email)->send(new ProductAvailabilityNotificationMail($this->product, $customer));
                $customer->status = 1;
                $customer->save();
            } catch (\Exception $e) {
                echo $e->getMessage();
            }
        }
    }
}
