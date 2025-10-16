<?php
// Përpunimi i formularit
$error = '';
$result = '';
$rateInfo = '';
$showResult = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['reset'])) {
        // Reset - nuk bën asgjë, fushat do pastrohen në HTML
    } else {
        $fromCurrency = $_POST['fromCurrency'] ?? '';
        $toCurrency = $_POST['toCurrency'] ?? '';
        $amount = filter_input(INPUT_POST, 'amount', FILTER_VALIDATE_FLOAT);
        $rate = filter_input(INPUT_POST, 'rate', FILTER_VALIDATE_FLOAT);

        if ($amount === false || $rate === false || $amount < 0 || $rate <= 0) {
            $error = 'Ju lutem shkruani vlera valide (pozitive).';
        } elseif (empty($fromCurrency) || empty($toCurrency)) {
            $error = 'Zgjidhni valutën e duhur.';
        } else {
            $converted = $amount * $rate;
            $formattedConverted = number_format($converted, 2, ',', ' ');
            $formattedRate = number_format($rate, 2, ',', ' ');
            $result = "$formattedConverted $toCurrency";
            $rateInfo = "Kursi i këmbimit: 1 $fromCurrency = $formattedRate $toCurrency";
            $showResult = true;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Kalkulator Valutash PHP</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: #333;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }
        .container {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 12px 24px rgba(0,0,0,0.15);
            max-width: 450px;
            width: 100%;
            padding: 2.5rem 2rem;
            text-align: center;
        }
        h1 {
            margin-bottom: 0.25rem;
            color: #5a4fcf;
            font-weight: 700;
            font-size: 1.9rem;
        }
        p.subtitle {
            margin-bottom: 2rem;
            color: #7a7a9d;
            font-weight: 500;
        }
        label {
            font-weight: 600;
            color: #444;
            text-align: left;
            display: block;
            margin-bottom: 0.4rem;
            font-size: 0.95rem;
        }
        select, input[type="number"] {
            width: 100%;
            padding: 0.75rem 1rem;
            border-radius: 12px;
            border: 2px solid #ddd;
            font-size: 1rem;
            transition: border-color 0.3s ease;
            font-weight: 500;
            color: #333;
        }
        select:focus, input:focus {
            border-color: #5a4fcf;
            outline: none;
            box-shadow: 0 0 8px rgba(90, 79, 207, 0.4);
        }
        .buttons {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }
        button {
            flex: 1;
            padding: 0.85rem 0;
            border-radius: 12px;
            border: none;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.1s ease;
            box-shadow: 0 4px 8px rgba(90, 79, 207, 0.3);
            color: white;
        }
        .convert-btn { background: #5a4fcf; }
        .convert-btn:hover { background: #4a3eb8; }
        .reset-btn { background: #e0e0e0; color: #555; box-shadow: none; }
        .reset-btn:hover { background: #cfcfcf; }
        .result {
            margin-top: 2rem;
            background: #f3f4ff;
            border-left: 6px solid #5a4fcf;
            border-radius: 12px;
            padding: 1.5rem 1.8rem;
            text-align: left;
            color: #2c2c54;
        }
        .result-title { font-weight: 700; font-size: 1.3rem; margin-bottom: 0.4rem; }
        .conversion-value { font-size: 2rem; font-weight: 800; margin-bottom: 0.3rem; color: #3b3b98; }
        .rate-info { font-size: 0.95rem; color: #6b6b9c; font-weight: 600; }
        .error {
            margin-top: 1rem; background: #ffe3e3;
            border-left: 6px solid #e74c3c; padding: 1rem 1.2rem;
            border-radius: 12px; color: #b83227; font-weight: 600;
        }
        .disclaimer {
            margin-top: 2.5rem; font-size: 0.8rem; color: #999; font-style: italic;
        }
    </style>
</head>
<body>
<main class="container">
    <h1>Kalkulator Valutash</h1>
    <p class="subtitle">Konvertoni lehtësisht midis valutave të ndryshme</p>

    <?php if ($error): ?>
        <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST">
        <label for="fromCurrency">Nga valuta:</label>
        <select id="fromCurrency" name="fromCurrency" required>
            <option value="">-- Zgjidh valutën --</option>
            <option value="EUR" <?= (($_POST['fromCurrency'] ?? '')=='EUR')?'selected':'' ?>>🇪🇺 EUR - Euro</option>
            <option value="USD" <?= (($_POST['fromCurrency'] ?? '')=='USD')?'selected':'' ?>>🇺🇸 USD - Dollar Amerikan</option>
            <option value="CAD" <?= (($_POST['fromCurrency'] ?? '')=='CAD')?'selected':'' ?>>🇨🇦 CAD - Dollar Kanadez</option>
            <option value="AUD" <?= (($_POST['fromCurrency'] ?? '')=='AUD')?'selected':'' ?>>🇦🇺 AUD - Dollar Australian</option>
            <option value="NZD" <?= (($_POST['fromCurrency'] ?? '')=='NZD')?'selected':'' ?>>🇳🇿 NZD - Dollar Zelanda e Re</option>
            <option value="GBP" <?= (($_POST['fromCurrency'] ?? '')=='GBP')?'selected':'' ?>>🇬🇧 GBP - Pound Britanik</option>
            <option value="CHF" <?= (($_POST['fromCurrency'] ?? '')=='CHF')?'selected':'' ?>>🇨🇭 CHF - Franga Zviceriane</option>
            <option value="SEK" <?= (($_POST['fromCurrency'] ?? '')=='SEK')?'selected':'' ?>>🇸🇪 SEK - Korona Suedeze</option>
            <option value="DKK" <?= (($_POST['fromCurrency'] ?? '')=='DKK')?'selected':'' ?>>🇩🇰 DKK - Korona Daneze</option>
            <option value="NOK" <?= (($_POST['fromCurrency'] ?? '')=='NOK')?'selected':'' ?>>🇳🇴 NOK - Korona Norvegjese</option>
            <option value="JPY" <?= (($_POST['fromCurrency'] ?? '')=='JPY')?'selected':'' ?>>🇯🇵 JPY - Jen Japonez</option>
            <option value="CNY" <?= (($_POST['fromCurrency'] ?? '')=='CNY')?'selected':'' ?>>🇨🇳 CNY - Yuan Kinez</option>
            <option value="TRY" <?= (($_POST['fromCurrency'] ?? '')=='TRY')?'selected':'' ?>>🇹🇷 TRY - Lira Turke</option>
            <option value="HUF" <?= (($_POST['fromCurrency'] ?? '')=='HUF')?'selected':'' ?>>🇭🇺 HUF - Forint Hungarez</option>
            <option value="ALL" <?= (($_POST['fromCurrency'] ?? '')=='ALL')?'selected':'' ?>>🇦🇱 ALL - Lek Shqiptar</option>
        </select>

        <label for="toCurrency">Në valutë:</label>
        <select id="toCurrency" name="toCurrency" required>
            <option value="">-- Zgjidh valutën --</option>
            <option value="ALL" <?= (($_POST['toCurrency'] ?? '')=='ALL')?'selected':'' ?>>🇦🇱 ALL - Lek Shqiptar</option>
            <option value="EUR" <?= (($_POST['toCurrency'] ?? '')=='EUR')?'selected':'' ?>>🇪🇺 EUR - Euro</option>
            <option value="USD" <?= (($_POST['toCurrency'] ?? '')=='USD')?'selected':'' ?>>🇺🇸 USD - Dollar Amerikan</option>
            <option value="GBP" <?= (($_POST['toCurrency'] ?? '')=='GBP')?'selected':'' ?>>🇬🇧 GBP - Pound Britanik</option>
        </select>

        <label for="amount">Shuma:</label>
        <input type="number" id="amount" name="amount" step="0.01" min="0" placeholder="0.00"
               value="<?php echo isset($_POST['amount']) ? htmlspecialchars($_POST['amount']) : ''; ?>" required>

        <label for="rate">Kursi (1 njësi = ?):</label>
        <input type="number" id="rate" name="rate" step="0.01" min="0.01" placeholder="120.50"
               value="<?php echo isset($_POST['rate']) ? htmlspecialchars($_POST['rate']) : ''; ?>" required>

        <div class="buttons">
            <button type="submit" name="submit" class="convert-btn">Konverto</button>
            <button type="submit" name="reset" class="reset-btn">Pastro</button>
        </div>
    </form>

    <?php if ($showResult): ?>
        <section class="result">
            <div class="result-title">Rezultati:</div>
            <div class="conversion-value"><?= htmlspecialchars($result) ?></div>
            <div class="rate-info"><?= htmlspecialchars($rateInfo) ?></div>
        </section>
    <?php endif; ?>

    <p class="disclaimer">
        Ky kalkulator është për qëllime informative. Kontrolloni gjithmonë kurset aktuale të këmbimit.
    </p>
</main>
</body>
</html>
