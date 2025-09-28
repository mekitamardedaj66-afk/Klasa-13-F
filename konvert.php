<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Marrim te dhenat dhe pastrojmë inputin
    $euro = filter_input(INPUT_POST, 'euro', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $kursi = filter_input(INPUT_POST, 'kursi', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

    // Validimi – mos lejo bosh
    if ($euro === null || $kursi === null || $euro === '' || $kursi === '') {
        echo "Ju lutem plotësoni të gjitha fushat!";
        exit;
    }

    // Kalkulimi
    $shumaLek = $euro * $kursi;
    $shumaFormatuar = number_format($shumaLek, 2, ',', '.');

    echo "<h2>Rezultati</h2>";
    echo "<p>Shuma e konvertuar në Lek (ALL): <strong>{$shumaFormatuar} ALL</strong></p>";
    echo '<br><a href="index.html">Kthehu mbrapa</a>';
} else {
    echo "Metodë e pasaktë!";
}
?>