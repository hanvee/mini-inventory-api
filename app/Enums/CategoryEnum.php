<?php 
namespace App\Enums;

enum CategoryEnum: string
{
    case FOOD = 'food';
    case CLOTHING = 'clothing'; 
    case ELECTRONIC = 'electronic'; 

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
    
    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }
}