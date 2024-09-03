<?php

$outputPath = __DIR__ . "/cov/json/";
$markdownPath = __DIR__ . "/cov/markdown/";

$contents = file_get_contents(__DIR__ . "/cov/xml/clover.xml");
$xml = simplexml_load_string($contents);
$arr = json_decode(json_encode($xml), true);

$metrics = $arr["project"]["metrics"]["@attributes"];

// Calculate coverage metrics
$statementsCovered = (int)$metrics["coveredstatements"];
$statementsTotal = (int)$metrics["statements"];
$statementsPct = $statementsTotal > 0 ? ($statementsCovered / $statementsTotal) * 100 : 0;

$functionsCovered = (int)$metrics["coveredmethods"];
$functionsTotal = (int)$metrics["methods"];
$functionsPct = $functionsTotal > 0 ? ($functionsCovered / $functionsTotal) * 100 : 0;

// Function to return color based on percentage
function getCoverageStatus($percentage) {
    if ($percentage >= 80) {
        return ":green_circle:";
    } elseif ($percentage >= 50) {
        return ":yellow_circle:";
    } else {
        return ":red_circle:";
    }
}

// Generate JSON report
$map = [
    "total" => [
        "statements" => ["pct" => $statementsPct],
    ]
];
file_put_contents($outputPath . "index.json", json_encode($map));

// Generate Markdown report
$markdown = "# Code Coverage Report\n\n";
$markdown .= "## Coverage Report\n\n";
$markdown .= "| St. | Category       | Percentage | Covered / Total |\n";
$markdown .= "|-----|----------------|------------|-----------------|\n";
$markdown .= sprintf(
    "| %s | Statements      | %.2f%%     | %d / %d          |\n",
    getCoverageStatus($statementsPct),
    $statementsPct,
    $statementsCovered,
    $statementsTotal
);
$markdown .= sprintf(
    "| %s | Functions       | %.2f%%     | %d / %d          |\n",
    getCoverageStatus($functionsPct),
    $functionsPct,
    $functionsCovered,
    $functionsTotal
);

$markdown .= "\n<details>\n";
$markdown .= "<summary>Files Coverage</summary>\n\n";
$markdown .= "| File | Methods | Statements | Total Coverage |\n";
$markdown .= "|------|---------|------------|----------------|\n";

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