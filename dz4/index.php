<?php

// Задание #1

if (file_exists('data.xml')) {
    $data = simplexml_load_file('data.xml');
?>

    <p>Purchase Order Number: <?php echo $data['PurchaseOrderNumber'] ?><br>
    Order Date: <?php echo $data['OrderDate'] ?><br>
    ---------------------------------------------</p>
    <?php
    $address_types = array('Shipping', 'Billing');
    $i = 0;
    foreach ($data->Address as $address) {
        echo '<h3>' . $address_types[$i++] . '</h3>';
        echo $address->Name . '<br>';
        echo $address->Street . '<br>';
        echo $address->City . '<br>';
        echo $address->State . '<br>';
        echo $address->Zip . '<br>';
        echo $address->Country . '<br>';
    } ?>
    <br>
    <b>Delivery Notes: <?php echo $data->DeliveryNotes; ?></b><br>
    <h3>Items:</h3>
    <?php
    $i = 0;
    foreach ($data->Items->Item as $item) {
        echo 'Part Number: ' . $item['PartNumber'] . '<br>';
        echo 'Product Name: ' . $item->ProductName . '<br>';
        echo 'Quantity: ' . $item->Quantity . '<br>';
        echo 'US Price: ' . $item->USPrice . '<br>';
        echo 'Ship Date: ' . $item->ShipDate . '<br>';
        echo 'Comment: ' . $item->Comment . '<br>';
        echo '<br>';
    } ?>

<?php
} else {
    echo 'Не удалось открыть файл data.xml.';
    exit;
}

// Задание #2

$movies = array(
    array(
        "title" => "Rear Window",
        "director" => "Alfred Hitchcock",
        "year" => 1954
    ),
    array(
        "title" => "Full Metal Jacket",
        "director" => "Stanley Kubrick",
        "year" => 1987
    ),
    array(
        "title" => "Mean Streets",
        "director" => "Martin Scorsese",
        "year" => 1973
    )
);

function WriteJson($movies, $filename)
{
    $handle = fopen($filename, 'w+b');
    $output = fwrite($handle, json_encode($movies));
    if (!$output) {
        echo 'Файл не записался';
        exit;
    }
    fclose($handle);
}

function ReadJson($filename)
{
    $result = json_decode(file_get_contents($filename), true);
    return ($result ? $result : 'Файл не удалось прочитать');
}

WriteJson($movies, 'output.json');
$test = ReadJson('output.json');

$change = rand(0, 1);
if ($change) {
    $movies = array(
        array(
            "title" => "Rear Window",
            "director" => "Alfred Hitchcock",
            "year" => 1954
        ),
        array(
            "title" => "Matrix",
            "director" => "The Wachowskis",
            "year" => 1999
        )

    );
}
WriteJson($movies, 'output2.json');
$test2 = ReadJson('output2.json');

function CompareArrays($test, $test2)
{
    $count_max = (count($test >= count($test2) ? count($test) : count($test2)));
    $diff = '';

    for ($i = 0; $i <= $count_max + 1; $i++) {
        if ($test[$i] && $test2[$i]) {
            $diff[$i] = array_diff_assoc($test[$i], $test2[$i]);
            if (!$diff[$i]) {
                $diff[$i] = 'Элементы одинаковые';
            }
        } else {
            $diff[$i] = 'Одного из элементов не существует';
        }

    }

    return $diff;
}

echo 'Отличия первого массива от второго:';
echo '<pre>';
print_r(CompareArrays($test, $test2));
echo '</pre>';

echo 'Отличия второго массива от первого:';
echo '<pre>';
print_r(CompareArrays($test2, $test));
echo '</pre>';

// Задание #3

$arr = array();
for ($i = 0; $i <= 50; $i++) {
    $arr[] = rand (1, 100);
}
$fp = fopen('file.csv', 'w+b');
$result = fputcsv($fp, $arr);
if (!$result) {
    echo 'Файл не записался';
    exit;
}
fclose($fp);

$content = file_get_contents('file.csv');
$new_arr = explode(',',$content);

$summ = 0;
foreach ($new_arr as $num) {
    $num = (int) $num;
    if (!($num % 2)) {
        $summ = $summ + $num;
    }
}
echo 'Сумма четных чисел массива: ' . $summ . '<br>';

// Задание #4

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://en.wikipedia.org/w/api.php?action=query&titles=Main%20Page&prop=revisions&rvprop=content&format=json");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
$data = curl_exec($ch);
curl_close($ch);
$data = json_decode($data, true);

foreach ($data['query']['pages'] as $pageid => $page) {
    echo 'Page id: ' . $pageid;
    echo '<br>';
    echo 'Page title: ' . $page['title'];
}

?>


