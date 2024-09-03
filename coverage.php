<?php

$outputPath = __DIR__ . "/cov/json/";
$markdownPath = __DIR__ . "/cov/markdown/";

if (!file_exists($outputPath)) {
    mkdir($outputPath, 0777, true);
}

if (!file_exists($markdownPath)) {
    mkdir($markdownPath, 0777, true);
}

$contents = file_get_contents(__DIR__ . "/cov/xml/clover.xml");
$xml = simplexml_load_string($contents);
$arr = json_decode(json_encode($xml), true);

// Calculate total coverage
$elements = (int)$arr["project"]["metrics"]["@attributes"]["elements"];
$covered = (int)$arr["project"]["metrics"]["@attributes"]["coveredelements"];
$percentage = ($covered / $elements) * 100;

// Generate JSON report
$map = [
    "total" => [
        "statements" => ["pct" => $percentage],
    ]
];
file_put_contents($outputPath . "index.json", json_encode($map));

// Generate Markdown report
$markdown = "# Code Coverage Report\n\n";
$markdown .= "## Overall Coverage\n\n";
$markdown .= "| Lines  | Covered | Coverage |\n";
$markdown .= "|--------|---------|----------|\n";
$markdown .= sprintf(
    "| %d | %d | %.2f%% |\n",
    $elements,
    $covered,
    $percentage
);

$markdown .= "\n<details>\n";
$markdown .= "<summary>Files Coverage</summary>\n\n";
$markdown .= "| File | Methods | Statements | Total Coverage |\n";
$markdown .= "|------|-------------------|------------------------|----------------|\n";

foreach ($arr["project"]["file"] as $file) {
    $filePath = 'src/' . explode('src/', $file["@attributes"]['name'])[1];
    $fileMetrics = $file["metrics"]["@attributes"];

    $methodsPct = $fileMetrics["methods"] > 0 ? ($fileMetrics["coveredmethods"] / $fileMetrics["methods"]) * 100 : 0;
    $statementsPct = $fileMetrics["statements"] > 0 ? ($fileMetrics["coveredstatements"] / $fileMetrics["statements"]) * 100 : 0;

    $fileElements = (int)$fileMetrics["elements"];
    $fileCoveredElements = (int)$fileMetrics["coveredelements"];
    $totalCoveragePct = $fileElements > 0 ? ($fileCoveredElements / $fileElements) * 100 : 0;

    $markdown .= sprintf(
        "| %s | %.2f%% | %.2f%% | %.2f%% |\n",
        $filePath,
        $methodsPct,
        $statementsPct,
        $totalCoveragePct
    );
}

$markdown .= "\n</details>\n";

file_put_contents($markdownPath . "coverage_report.md", $markdown);