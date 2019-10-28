<?php

include '../vendor/autoload.php';

include '../src/app/App.php';

use Blockchain\App;

echo (new App())->run();

