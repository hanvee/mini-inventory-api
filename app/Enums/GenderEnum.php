<?php 
namespace App\Enums;

enum GenderEnum: string
{
    case MALE = 'male';
    case FEMALE = 'female'; 

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
    
    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }
}