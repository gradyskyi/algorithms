<?php
// function for counting sort
function countingsort(&$Array, $n)
{
    $max = 0;
    $operations = 0;

    //find largest element in the Array
    for ($i = 0; $i < $n; $i++) {
        if ($max < $Array[$i]) {
            $operations++;
            $max = $Array[$i];
        }
    }

    //Create a freq array to store number of occurrences of
    //each unique elements in the given array
    for ($i = 0; $i < $max + 1; $i++) {
        $operations++;
        $freq[$i] = 0;
    }

    for ($i = 0; $i < $n; $i++) {
        $operations++;
        $freq[$Array[$i]]++;
    }

    //sort the given array using freq array
    for ($i = 0, $j = 0; $i <= $max; $i++) {
        while ($freq[$i] > 0) {
            $operations++;
            $Array[$j] = $i;
            $j++;
            $freq[$i]--;
        }
    }

    echo 'Complexity: ' . $operations . "\n";
}

// function to print array
function PrintArray($Array, $n)
{
    for ($i = 0; $i < $n; $i++)
        echo $Array[$i] . " ";
    echo "\n";
}

// test the code
$MyArray = [];
for ($i = 0; $i < 100; $i++) {
    $MyArray[] = mt_rand(1, 1);
}

$n = sizeof($MyArray);
countingsort($MyArray, $n);
?>