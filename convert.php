<?php
$handle = fopen($_FILES['markerfile']['tmp_name'], 'r');
$chapters = array();

while ($data = fgetcsv($handle, 1000, "\t")) {
    $chapters[] = $data;
}
fclose($handle);

array_shift($chapters);

header('Content-type: text/csv');
header('Content-Disposition: attachment; filename="chapters.txt"');

foreach($chapters as $chapter) {
    $startTime = $chapter[1];
    $chapterName = $chapter[0];

    $matches = array();

    $timeFragments = explode(':', $startTime);
    $hasHours = sizeof($timeFragments) === 3;
    
    if ($hasHours) {
        $hours = sprintf('%02d', $timeFragments[0]);
        $minutes = sprintf('%02d', $timeFragments[1]);
        $seconds = $timeFragments[2];
    } else {
        $hours = '00';
        $minutes = sprintf('%02d', $timeFragments[0]);
        $seconds = $timeFragments[1];
    }

    $combined = "$hours:$minutes:$seconds";
    print("$combined $chapterName\n");
}