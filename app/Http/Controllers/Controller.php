<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponseTrait;
use App\Traits\FormatUserTrait;

abstract class Controller
{
    use ApiResponseTrait, FormatUserTrait;
}
