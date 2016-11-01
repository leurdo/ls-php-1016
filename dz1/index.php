<?php

// Задание #1
$name = 'Катя';
$age = 39;

echo 'Меня зовут: ' . $name . '<br>';
echo 'Мне ' . $age . ' лет<br>';
echo '“!|\\/’”\\' . '<br>';

// Задание #2
$total_pic = 80;
$markers = 23;
$pensils = 40;

echo 'Всего рисунков: ' . $total_pic . '<br>';
echo 'Выполнено фломастерами: ' . $markers . '<br>';
echo 'Выполнено карандашами: ' . $pensils . '<br>';
echo 'Выполнено красками: ' . $total_pic . ' - ' . $markers . ' - ' . $pensils . ' = '
    . ($total_pic - $markers - $pensils) . '<br>';

// Задание #3
define(REVO, 1917);
if (defined('REVO')) {
    echo 'Константа REVO определена <br>';
}
echo 'Значение константы REVO: ' . REVO.'<br>';
// REVO = 2016; Попытка изменить константу дает ошибку Parse error: syntax error, unexpected '='

// Задание #4
$age = 99;

if ($age > 18 && $age <= 65) {
    echo 'Вам еще работать и работать <br>';
} elseif ($age > 65) {
    echo 'Вам пора на пенсию <br>';
} elseif ($age < 18 && $age > 0) {
    echo 'Вам еще рано работать <br>';
} else {
    echo 'Неизвестный возраст <br>';
}

// Задание #5
$day = 15;

switch ($day) {
    case ($day >=1 && $day <= 5):
        echo 'Это рабочий день <br>';
        break;
    case ($day > 5 && $day <= 7):
        echo 'Это выходной день <br>';
        break;
    default:
        echo 'Неизвестный день <br>';
}

// Задание #6
$bmw = [];
$bmw['model'] = 'X5';
$bmw['speed'] = '120';
$bmw['doors'] = '5';
$bmw['year'] = '2015';

$toyota = [];
$toyota['model'] = 'X6';
$toyota['speed'] = '130';
$toyota['doors'] = '6';
$toyota['year'] = '2016';

$opel = [];
$opel['model'] = 'X7';
$opel['speed'] = '140';
$opel['doors'] = '7';
$opel['year'] = '2017';

$all = [];
$all['bmw'] = $bmw;
$all['toyota'] = $toyota;
$all['opel'] = $opel;

//echo '<pre>';
//print_r($all);

foreach ($all as $name => $car) {
    echo 'CAR ' . $name . '<br>';
    foreach ($car as $option => $value) {
        echo $value . ' ';
    }
    echo '<br>';
}

// Задание #7
echo '<table>';
for ($row = 1; $row <= 10; $row++) {
    echo '<tr>';
    for ($col = 1; $col <= 10; $col++) {
        if ($row%2 == 0 && $col%2 == 0) {
            echo '<td>(' . $col * $row . ')</td>';
        } elseif ($row%2 == 1 && $col%2 == 1) {
            echo '<td>[' . $col * $row . ']</td>';
        } else {
            echo '<td>' . $col * $row . '</td>';
        }
    }
    echo '</tr>';
}
echo '</table>';

// Задание #8
$str = 'Настоящие программисты пробелами не пользуются';
echo $str . '<br>';

$arr = explode(' ', $str);
echo ('<pre>');
print_r($arr);
echo ('</pre>');

$i = 0;
$new_arr = [];
$number_el = count($arr);

while ($i++ < $number_el) {
    $new_arr[] = $arr[$number_el - $i];
}

$new_str = implode('_', $new_arr);
echo $new_str . '<br>';

?>