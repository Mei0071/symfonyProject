<?php
namespace App\Enum;

enum StatusProduct: string
{
    case Disponible = 'Disponible';
    case Rupture = 'En rupture de stock';
    case Precommande = 'En précommande';
}