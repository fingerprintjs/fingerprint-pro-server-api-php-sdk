<?php

$outputPath = __DIR__ . "/cov/json/";

if (!file_exists($outputPath)) {
    mkdir($outputPath);
}

$contents = file_get_contents(__DIR__ . "/cov/xml/index.xml");
$xml = simplexml_load_string($contents);
$arr = json_decode(json_encode($xml), true);
$map = [
    "total" => [
        // "lines" => ["pct" => (float)$arr["project"]["directory"]["totals"]["lines"]["@attributes"]["percent"]],
        // "methods" => ["pct" => (float)$arr["project"]["directory"]["totals"]["methods"]["@attributes"]["percent"]],
        // "functions" => ["pct" => (float)$arr["project"]["directory"]["totals"]["functions"]["@attributes"]["percent"]],
        // "classes" => ["pct" => (float)$arr["project"]["directory"]["totals"]["classes"]["@attributes"]["percent"]],
        // "traits" => ["pct" => (float)$arr["project"]["directory"]["totals"]["traits"]["@attributes"]["percent"]],
        "statements" => ["pct" => (float)$arr["project"]["directory"]["totals"]["methods"]["@attributes"]["percent"]],
    ]
];
file_put_contents(__DIR__ . "/cov/json/index.json", json_encode($map));