<?php
namespace App\Helpers;
use Brick\Math\Exception\NumberFormatException;
use NumberFormatter;

class Currency
{
    public function __invoke(...$params)
    {
        return static::format(...$params);
    }
    public static function format($amount, $currency = null)
    {
        try {
            $formatter = new NumberFormatter(config('app.locale'), NumberFormatter::CURRENCY);

            if ($currency === null) {
                $currency = config('app.currency', 'USD');
            }

            return $formatter->formatCurrency($amount, $currency);
        } catch (NumberFormatException $e) {
            // معالجة الخطأ إذا فشل تنسيق العملة
            return 'Error formatting currency';
        }
    }
}
//class Currency
//{
//    public static function format($amount ,$currency = null)
//    {
//        $formatter = new NumberFormatter(config('app.locale'),NumberFormatter::CURRENCY);
//        if($currency === null){
//            $currency =config('app.currency','USD');
//        }
//        return $formatter->formatCurrency($amount,$currency);
//    }
//}



