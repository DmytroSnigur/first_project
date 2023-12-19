<?php
declare(strict_types=1);

class PriceDeliveryProduct {
    private float $weight;
    private float $length;
    private float $width;
    private float $height;
    private ?float $sellerPrice = null;
    private string $finalPriceType;

    public function __construct(float $weight, float $length, float $width, float $height, ?float $sellerPrice = null) {
        $this->weight = $weight;
        $this->length = $length;
        $this->width = $width;
        $this->height = $height;
        $this->sellerPrice = $sellerPrice;
    }

    public function calculatePrice(): float {
        $byWeight = ($this->weight) * 50;
        $byVolume = ($this->length * $this->width * $this->height) / 1000 * 50;

        if ($this->sellerPrice !== null) {
            $finalPrice = max($byWeight, $byVolume, $this->sellerPrice);

            if ($finalPrice === $byWeight) {
                $this->finalPriceType = 'Вес';
            } else if ($finalPrice === $byVolume) {
                $this->finalPriceType = 'Объем';
            } else {
                $this->finalPriceType = 'Цена указанная продавцом';
            }
        } else {
            $finalPrice = max($byWeight, $byVolume);

            if ($finalPrice === $byWeight) {
                $this->finalPriceType = 'Вес';
            } else {
                $this->finalPriceType = 'Объем';
            }
        }

        return $finalPrice;
    }

    public function getFinalPriceType(): string {
        return $this->finalPriceType;
    }
}

$bike = new PriceDeliveryProduct(12, 90, 30, 70, 1000);
$sledge = new PriceDeliveryProduct(7, 40, 30, 20, 1300);
$crying = new PriceDeliveryProduct(24, 15, 10, 15);

var_dump("Цена: " . $bike->calculatePrice() . ", Способ: " . $bike->getFinalPriceType());
var_dump("Цена: " . $sledge->calculatePrice() . ", Способ: " . $sledge->getFinalPriceType());
var_dump("Цена: " . $crying->calculatePrice() . ", Способ: " . $crying->getFinalPriceType());
