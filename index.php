<?php
// Përpunimi i formularit
$error = '';
$result = '';
$rateInfo = '';
$showResult = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['reset'])) {
        // Reset - thjesht mos bëjmë asgjë, do pastrohen fushat
    } else {
        $euroValue = filter_input(INPUT_POST, 'euro', FILTER_VALIDATE_FLOAT);
        $rateValue = filter_input(INPUT_POST, 'koeficienti', FILTER_VALIDATE_FLOAT);

        if ($euroValue === false || $rateValue === false || $euroValue < 0 || $rateValue <= 0) {
            $error = 'Ju lutem shkruani vlera valide (pozitive).';
        } else {
            $lekValue = $euroValue * $rateValue;
            $formattedLek = number_format($lekValue, 2, ',', ' ');
            $formattedRate = number_format($rateValue, 2, ',', ' ');
            $result = $formattedLek . ' ALL';
            $rateInfo = "Kursi i këmbimit: 1 EUR = $formattedRate ALL";
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
    <title>Kalkulator Modern i Këmbimit Valutor</title>
    <style>
        /* Reset bazik */
        *, *::before, *::after {
            box-sizing: border-box;
        }
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
            max-width: 420px;
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
        .flags {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 1.2rem;
            margin-bottom: 2rem;
            font-size: 3rem;
        }
        .arrow {
            font-size: 2rem;
            color: #5a4fcf;
            user-select: none;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }
        label {
            font-weight: 600;
            color: #444;
            text-align: left;
            display: block;
            margin-bottom: 0.4rem;
            font-size: 0.95rem;
        }
        input[type="number"] {
            width: 100%;
            padding: 0.75rem 1rem;
            border-radius: 12px;
            border: 2px solid #ddd;
            font-size: 1rem;
            transition: border-color 0.3s ease;
            font-weight: 500;
            color: #333;
        }
        input[type="number"]:focus {
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
        button:active {
            transform: scale(0.97);
        }
        .convert-btn {
            background: #5a4fcf;
        }
        .convert-btn:hover {
            background: #4a3eb8;
        }
        .reset-btn {
            background: #e0e0e0;
            color: #555;
            box-shadow: none;
        }
        .reset-btn:hover {
            background: #cfcfcf;
        }
        .result {
            margin-top: 2rem;
            background: #f3f4ff;
            border-left: 6px solid #5a4fcf;
            border-radius: 12px;
            padding: 1.5rem 1.8rem;
            text-align: left;
            animation: fadeInUp 0.4s ease forwards;
            color: #2c2c54;
        }
        .result-title {
            font-weight: 700;
            font-size: 1.3rem;
            margin-bottom: 0.4rem;
        }
        .conversion-value {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 0.3rem;
            color: #3b3b98;
        }
        .rate-info {
            font-size: 0.95rem;
            color: #6b6b9c;
            font-weight: 600;
        }
        .error {
            margin-top: 1rem;
            background: #ffe3e3;
            border-left: 6px solid #e74c3c;
            padding: 1rem 1.2rem;
            border-radius: 12px;
            color: #b83227;
            font-weight: 600;
            animation: fadeInUp 0.4s ease forwards;
        }
        .disclaimer {
            margin-top: 2.5rem;
            font-size: 0.8rem;
            color: #999;
            font-style: italic;
        }
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(15px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        @media (max-width: 480px) {
            .container {
                padding: 2rem 1.5rem;
            }
            .flags {
                font-size: 2.5rem;
            }
            .conversion-value {
                font-size: 1.6rem;
            }
        }
    </style>
</head>
<body>
    <main class="container" role="main" aria-label="Kalkulatori i këmbimit valutor Euro në Lek">
        <h1>Kalkulator Valutash</h1>
        <p class="subtitle">Konvertoni Euro në Lek Shqiptar me lehtësi</p>
        <div class="flags" aria-hidden="true">
            <div>🇪🇺</div>
            <div class="arrow">→</div>
            <div>🇦🇱</div>
        </div>

        <?php if ($error): ?>
            <div class="error" role="alert"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST" novalidate>
            <label for="euro">Shuma në Euro (€):</label>
            <input 
                type="number" 
                id="euro" 
                name="euro" 
                step="0.01" 
                min="0" 
                placeholder="0.00" 
                value="<?php echo isset($_POST['euro']) ? htmlspecialchars($_POST['euro']) : ''; ?>" 
                required 
                aria-required="true"
                aria-describedby="euroHelp"
            />
            <small id="euroHelp" style="color:#666; font-size:0.8rem; margin-top:-1rem; margin-bottom:1rem; display:block;">Shkruaj shumën që dëshiron të konvertohet</small>

            <label for="koeficienti">Kursi i këmbimit (1 EUR = ? ALL):</label>
            <input 
                type="number" 
                id="koeficienti" 
                name="koeficienti" 
                step="0.01" 
                min="0.01" 
                placeholder="120.50" 
                value="<?php echo isset($_POST['koeficienti']) ? htmlspecialchars($_POST['koeficienti']) : ''; ?>" 
                required 
                aria-required="true"
                aria-describedby="rateHelp"
            />
            <small id="rateHelp" style="color:#666; font-size:0.8rem; margin-top:-1rem; margin-bottom:1rem; display:block;">Shkruaj kursin aktual të këmbimit</small>

            <div class="buttons">
                <button type="submit" name="submit" class="convert-btn" aria-label="Konverto valutat">Konverto</button>
                <button type="submit" name="reset" class="reset-btn" aria-label="Pastro fushat">Pastro</button>
            </div>
        </form>

        <?php if ($showResult): ?>
            <section class="result" aria-live="polite" aria-atomic="true">
                <div class="result-title">Rezultati:</div>
                <div class="conversion-value"><?php echo htmlspecialchars($result); ?></div>
                <div class="rate-info"><?php echo htmlspecialchars($rateInfo); ?></div>
            </section>
        <?php endif; ?>

        <p class="disclaimer">
            Ky kalkulator është për qëllime informative. Kontrolloni gjithmonë kurset aktuale të këmbimit.
        </p>
    </main>
</body>
</html>
