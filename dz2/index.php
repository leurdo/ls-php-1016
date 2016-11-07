<?php

mb_internal_encoding("UTF-8");

// Задание 1

function StringArrayOutput($string_array, $resultType = false) {

    $result = '';
    foreach ($string_array as $string) {
        if ($resultType) {
            $result .= $string;
        } else {
            $result .= '<p>' . $string . '</p>';
        }
    }

    if ($resultType) {
        $result = '<p>' . $result . '</p>';
    }

    return $result;
}

$testArray = array('У', 'Попа', 'Была', 'Собака');
echo StringArrayOutput($testArray);
echo StringArrayOutput($testArray, true);

// Задание 2

function ArrayMath ($num_array, $operator) {

    $result = '';
    foreach ($num_array as $num) {
        if (is_numeric($num)) {
            if ($result === '') {
                $result = $num;
            } else {
                if ($operator == '+') {
                    $result = $result + $num;
                } elseif ($operator == '-') {
                    $result = $result - $num;
                    //echo ' Промежуточный результат ' . $result . ' ';
                } elseif ($operator == '*') {
                    $result = $result * $num;
                } elseif ($operator == '/') {
                    if ($num == 0) {
                        return 'На ноль делить нельзя';
                    } else {
                        $result = $result / $num;
                    }
                } else {
                    return 'Оператор какой-то не оператор';
                }
            }
        } else {
            return 'В массиве есть не-число.';
        }
    }

    return $result;
}

$testArray = array (5, 0, 1);
$operator = '*';
echo '<br>Массив: ';
print_r ($testArray);
echo '<br>Оператор: ' . $operator;
echo '<br>Результат операции: ' . ArrayMath($testArray, $operator);

// Задание 3

function CulcEverything() {
    if (func_get_args()) {
        for ($i = 1; $i < func_num_args(); $i++) {
            if (!is_numeric(func_get_arg($i))) {
                return 'Все аргументы, кроме первого, должны быть числами.';
            }
        }
        $result = func_get_arg(1);
        switch (func_get_arg(0)) {
            case ('+'):
                for ($i = 2; $i < func_num_args(); $i++) {
                    $result = $result + func_get_arg($i);
                }
                break;
            case ('-'):
                for ($i = 2; $i < func_num_args(); $i++) {
                    $result = $result - func_get_arg($i);
                }
                break;
            case ('*'):
                for ($i = 2; $i < func_num_args(); $i++) {
                    $result = $result * func_get_arg($i);
                }
                break;
            case ('/'):
                for ($i = 2; $i < func_num_args(); $i++) {
                    if (func_get_arg($i) == 0) {
                        return 'На ноль делить нельзя';
                    } else {
                        $result = $result / func_get_arg($i);
                    }
                }
                break;
            default:
                return 'Первым параметром должен быть оператор +, -, * или /';
        }
    } else {
        return 'Передайте в функцию оператор и числа';
    }

    return 'Результат операции: ' . $result;
}

echo '<br>' . CulcEverything('+', 1, 2, 3, 5.2);

// Задание 4

function MultiplicationTable($cols, $rows) {
    if (is_integer($cols) && (is_integer($rows))) {
        echo '<table>';
        for ($row = 1; $row <= $rows; $row++) {
            echo '<tr>';
            for ($col = 1; $col <= $cols; $col++) {
                echo '<td>' . $col * $row . '</td>';
            }
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo "Вы должны передать 2 целых числа";
    }
}

echo '<br>';
MultiplicationTable(20, 1.7);

// Задание 5

function IsPalindrom($string) {
    $string = mb_strtolower(str_replace(' ', '', $string));

    $rev_str = '';
    for ($i = 0; $i < mb_strlen($string); $i++) {
        $rev_str = mb_substr($string, $i, 1) . $rev_str;
    }

    if ($rev_str == $string) {
        return true;
    } else {
        return false;
    }
}

function CheckIfPalindrom ($string) {
    if (IsPalindrom($string)) {
        return 'Это палиндром';
    } else {
        return 'Это не палиндром';
    }
}

echo '<br>';
echo CheckIfPalindrom('А роза упала на лапу азора');

// Задание 6

echo '<br>';
echo (date('d.m.Y H:i'));
echo '<br>';
echo mktime(0, 0, 0, 2, 24, 2016);

// Задание 7

$string = 'Карл у Клары украл Кораллы';

function KarlProcessing ($string) {

    $k = mb_stripos($string, 'к');

    if ($k === false) {
        echo $string;
        return;
    }

    if ($k == 0) {
        $before_k = '';
    } else {
        $before_k = mb_substr($string, 0, $k);
    }
    if ($k == mb_strlen($string)) {
        $after_k = '';
    } else {
        $after_k = mb_substr($string, $k + 1);
    }

    $string = $before_k . $after_k;

    KarlProcessing($string);

}

echo '<br>';
KarlProcessing($string);

echo '<br>';
$string = 'Две бутылки лимонада';
$replacement = 'Три';

echo My_mb_substr_replace($string, $replacement, 0, 3);

function My_mb_substr_replace($string, $replacement, $start, $length=null){

    if ($length == null) {
        return mb_substr($string, 0, $start).$replacement;
    }
    else{
        return mb_substr($string, 0, $start). $replacement. mb_substr($string, $start + $length, mb_strlen($string));
    }

}

// Задание 8

function CheckNetwork($string) {
    preg_match("/(:\))/",$string, $matches);
    if ($matches) {
        return DrawSmile();
    } else {
        preg_match("/(?<=RX packets:)[0-9]+/", $string, $matches);
        if ($matches[0] > 1000) return 'Сеть есть';
    }
}

function DrawSmile() {
    return ('( ͡° ͜ʖ ͡°)');
}

$string = 'RX packets:950381 :) errors:0 dropped:0 overruns:0 frame:0.';
echo '<br>';
echo CheckNetwork($string);

// Задание 9

function Greeting($file_name) {
    return file_get_contents($file_name);
}

echo '<br>';
echo Greeting('test.txt');

// Задание 10

echo '<br>';

$handle = fopen("anothertest.txt", "w+b");

$mytext = "Hello again!\r\n";
$test = fwrite($handle, $mytext);
if ($test) {
    echo 'Данные в файл успешно занесены.';
} else {
    echo 'Ошибка при записи в файл.';
}

fclose($handle);

?>