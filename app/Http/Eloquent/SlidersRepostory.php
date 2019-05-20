<?php
/**
 * Created by PhpStorm.
 * User: shaban
 * Date: 18/11/18
 * Time: 10:17
 */
namespace  App\Http\Eloquent;

use App\Http\Interfaces\SlidersRepostoryInterface;
use App\Http\Models\Sliders;

class SlidersRepostory implements  SlidersRepostoryInterface
{
    protected $slisders;
    public function __construct(Sliders $sliders)
    {
        $this->slisders = $sliders;
    }

    public function getallactivesliders()
    {
        return $this->slisders->whereStatus(Sliders::SLIDER_ENABLED)->get();
    }
}