<?php
$data = [
    [ // test case 1
        ['p_no' => 1, 'arrival_time' => 0, 'cpu_burst' => 10, 'priority' => 1, 'completion_time' => -1],
        ['p_no' => 2, 'arrival_time' => 0, 'cpu_burst' => 29, 'priority' => 2, 'completion_time' => -1],
        ['p_no' => 3, 'arrival_time' => 0, 'cpu_burst' => 3, 'priority' => 3, 'completion_time' => -1],
        ['p_no' => 4, 'arrival_time' => 0, 'cpu_burst' => 7, 'priority' => 4, 'completion_time' => -1],
        ['p_no' => 5, 'arrival_time' => 0, 'cpu_burst' => 12, 'priority' => 4, 'completion_time' => -1]
    ],
    [ // test case 2
        ['p_no' => 1, 'arrival_time' => 5, 'cpu_burst' => 10, 'priority' => 2, 'completion_time' => -1],
        ['p_no' => 2, 'arrival_time' => 5, 'cpu_burst' => 3, 'priority' => 1, 'completion_time' => -1],
        ['p_no' => 3, 'arrival_time' => 8, 'cpu_burst' => 3, 'priority' => 1, 'completion_time' => -1],
        ['p_no' => 4, 'arrival_time' => 10, 'cpu_burst' => 10, 'priority' => 2, 'completion_time' => -1],
        ['p_no' => 5, 'arrival_time' => 300, 'cpu_burst' => 4, 'priority' => 1, 'completion_time' => -1]
    ],
    [ // test case 3
        ['p_no' => 1, 'arrival_time' => 0, 'cpu_burst' => 7, 'priority' => 1, 'completion_time' => -1],
        ['p_no' => 2, 'arrival_time' => 2, 'cpu_burst' => 4, 'priority' => 2, 'completion_time' => -1],
        ['p_no' => 3, 'arrival_time' => 4, 'cpu_burst' => 1, 'priority' => 3, 'completion_time' => -1],
        ['p_no' => 4, 'arrival_time' => 5, 'cpu_burst' => 4, 'priority' => 4, 'completion_time' => -1],
        ['p_no' => 5, 'arrival_time' => 0, 'cpu_burst' => 12, 'priority' => 4, 'completion_time' => -1]
    ]
];

for ($i = 0; $i < 3; $i++) {
    $clock = 0;

    $count = 0;

    $result = [];

    $total_wait_time = 0;

    for ($j = count($data[$i]) - 1; $j > 0; --$j) {
        for ($k = 0; $k <= $j - 1; ++$k) {
            if ($data[$i][$k]['arrival_time'] > $data[$i][$k + 1]['arrival_time']) {
                $tmp = $data[$i][$k];

                $data[$i][$k] = $data[$i][$k + 1];

                $data[$i][$k + 1] = $tmp;
            }
        }
    }

    $test_data = $data[$i];

    while (true) {
        if ($count == count($test_data)) {
            break;
        }

        if ($test_data[$count]['arrival_time'] > $clock) {
            $clock++;
        } else {
            $completion_time = $clock + $test_data[$count]['cpu_burst'];

            $total_wait_time += $clock - $test_data[$count]['arrival_time'];

            $result[] = [
                'p_no' => $test_data[$count]['p_no'],
                'arrival_time' => $test_data[$count]['arrival_time'],
                'cpu_burst' => $test_data[$count]['cpu_burst'],
                'priority' => $test_data[$count]['priority'],
                'completion_time' => $completion_time,
                'clock' => $clock
            ];

            $clock += $test_data[$count]['cpu_burst'];

            $count++;
        }
    }

    $avg_wait_time = $total_wait_time / count($test_data);

    $result[] = ['avg_wait_time' => $avg_wait_time];

    $num = $i + 1;

    echo 'test case ' . $num . ':' . PHP_EOL;

    print_r($result);

    echo PHP_EOL . PHP_EOL;
}