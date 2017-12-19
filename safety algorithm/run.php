<?php
$available_resource = [10, 5, 7];

$allocation_resource = [
    [0, 1, 0],
    [2, 0, 0],
    [3, 0, 2],
    [2, 1, 1],
    [0, 0, 2]
];

$max_resource = [
    [7, 5, 3],
    [3, 2, 2],
    [9, 0, 2],
    [2, 2, 2],
    [4, 3, 3]
];

$need = [];

$process_no = -1;

$request_resource = [];

for ($i = 0; $i < count($allocation_resource); $i++) {
    $tmp = [];

    for ($j = 0; $j < count($allocation_resource[$i]); $j++) {
        $tmp[] = $max_resource[$i][$j] - $allocation_resource[$i][$j];

        $available_resource[$j] -= $allocation_resource[$i][$j];
    }

    $need[] = $tmp;
}

while(true) {
    $init = safety($available_resource, $allocation_resource, $max_resource, $need);

    if (count($init) != count($need)) {
        echo '不能做 QQ' . PHP_EOL;
        continue;
    }

    $process_no = readline('Enter Process No: ');

    if ($process_no > count($allocation_resource)) {
        echo '太多了' . PHP_EOL;
        continue;
    }

    for ($k = 0; $k < count($available_resource); $k++) {
        $request_resource[] = readline('Enter Request Resource: ');
    }

    for ($l = 0; $l < count($available_resource); $l++) {
        if ($request_resource[$l] > $available_resource[$l]) {
            echo 'Request > Available, Process must wait!' . PHP_EOL;
            break;
        } else if ($request_resource[$l] > $need[$process_no][$l]) {
            echo 'Request > Need, error' . PHP_EOL;
            break;
        }
        continue;
    }
}

function safety($available_resource, $allocation_resource, $max_resource, $need)
{
    $run_time = 0;

    $result = [];

    while (true) {
        if ($run_time >= count($allocation_resource)) {
            break;
        }

        for ($m = 0; $m < count($max_resource); $m++) {
            $can_exec = true;

            for ($i = 0; $i < count($max_resource[$m]); $i++) {
                if ($available_resource[$i] >= $need[$m][$i] && $need[$m][$i] >= 0) {
                    continue;
                } else {
                    $can_exec = false;

                    break;
                }
            }

            if ($can_exec) {
                $result[] = $m;

                for ($j = 0; $j < count($max_resource[$m]); $j++) {
                    $available_resource[$j] += $allocation_resource[$m][$j];

                    $need[$m][$j] = -1;
                }
            }
        }

        $run_time++;
    }

    return $result;
}