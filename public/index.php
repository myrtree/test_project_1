<?php

require '../vendor/autoload.php';

use Simple\DepsInjection;
use Simple\Storage;

DepsInjection::run();
Storage::get('app')->run();
