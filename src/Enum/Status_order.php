<?php

namespace App\Enum;

enum StatusOrder: string
{
    case Preparation = 'En préparation';
    case Expedier = 'Expédiée';
    case Livrer = 'Livrée';
    case Annuler = 'Annulée';

}