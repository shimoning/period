#!/usr/bin/env php
<?php

namespace Shimoning\Period;

require_once __DIR__ . '/vendor/autoload.php';

echo __NAMESPACE__ . " shell\n";
echo "-----\nexample:\n";
echo "var_dump(Period::monthly(2020, 2, 30));\n-----\n\n";

$sh = new \Psy\Shell();

$sh->addCode(sprintf("namespace %s;", __NAMESPACE__));

$sh->run();

echo "\n-----\nBye.\n";
