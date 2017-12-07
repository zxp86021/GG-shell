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

    $total_work = count($test_data);

    while (true) {
        if (count($test_data) <= 0) {
            break;
        }

        if ($test_data[0]['arrival_time'] > $clock) {
            $clock++;
        } else {
            $process_priority = $test_data[0]['priority'];

            $process = $test_data[0];

            $process_item = 0;

            for ($num = 0; $num < count($test_data); $num++) {
                if ($test_data[$num]['arrival_time'] > $clock) {
                    break;
                }

                if ($test_data[$num]['priority'] < $process_priority) {
                    $process = $test_data[$num];

                    $process_item = $num;

                    $process_priority = $test_data[$num]['priority'];
                }
            }

            array_splice($test_data, $process_item, 1);

            $completion_time = $clock + $process['cpu_burst'];

            $total_wait_time += $clock - $process['arrival_time'];

            $result[] = [
                'p_no' => $process['p_no'],
                'arrival_time' => $process['arrival_time'],
                'cpu_burst' => $process['cpu_burst'],
                'priority' => $process['priority'],
                'completion_time' => $completion_time,
                'clock' => $clock
            ];

            $clock += $process['cpu_burst'];
        }
    }

    $avg_wait_time = $total_wait_time / $total_work;

    $result[] = ['avg_wait_time' => $avg_wait_time];

    $num = $i + 1;

    echo 'test case ' . $num . ':' . PHP_EOL;

    print_r($result);

    echo PHP_EOL . PHP_EOL;
}