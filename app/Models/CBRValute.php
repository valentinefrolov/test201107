<?php

namespace App\Models;

use App\Service\Valute\ValuteModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CBRValute extends Model implements ValuteModel
{
    use HasFactory;
}
