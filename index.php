<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Text Separator</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
    $separator = isset($_POST['separator']) ? $_POST['separator'] : '-';
    $textArea1 = isset($_POST['textArea1']) ? $_POST['textArea1'] : '';
    $firstItems = [];
    $lastItems = [];
    $lineNumbers = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $lines = explode("\n", $textArea1);
        foreach ($lines as $index => $line) {
            if (strpos($line, $separator) !== false) {
                $items = explode($separator, $line);
                if (count($items) > 1) {
                    $firstItems[] = trim($items[0]);
                    $lastItems[] = trim($items[1]);
                }
            } else {
                $firstItems[] = '';
                $lastItems[] = '';
            }
            $lineNumbers[] = $index + 1;
        }
    }
    ?>
    <form method="post">
        <div class="select-container">
            <label for="separator">Choose a separator:</label>
            <select id="separator" name="separator">
                <option value="-" <?php echo $separator == '-' ? 'selected' : ''; ?>>-</option>
                <option value="+" <?php echo $separator == '+' ? 'selected' : ''; ?>>+</option>
                <option value="=" <?php echo $separator == '=' ? 'selected' : ''; ?>>=</option>
            </select>
        </div>
        <div class="textareas-container">
            <div class="textarea-wrapper">
                <div class="line-numbers">
                    <?php foreach ($lineNumbers as $lineNumber) {
                        echo $lineNumber . "<br>";
                    } ?>
                </div>
                <textarea id="textArea1" name="textArea1" placeholder="Enter items separated by chosen separator"><?php echo htmlspecialchars($textArea1); ?></textarea>
            </div>
            <div class="textarea-wrapper">
                <div class="line-numbers">
                    <?php foreach ($lineNumbers as $lineNumber) {
                        echo $lineNumber . "<br>";
                    } ?>
                </div>
                <textarea id="textArea2" name="textArea2" readonly placeholder="First separated items"><?php echo htmlspecialchars(implode("\n", $firstItems)); ?></textarea>
            </div>
            <div class="textarea-wrapper">
                <div class="line-numbers">
                    <?php foreach ($lineNumbers as $lineNumber) {
                        echo $lineNumber . "<br>";
                    } ?>
                </div>
                <textarea id="textArea3" name="textArea3" readonly placeholder="Last separated items"><?php echo htmlspecialchars(implode("\n", $lastItems)); ?></textarea>
            </div>
        </div>
        <div class="button-container">
            <button type="submit">Go</button>
            <button type="button" onclick="copyToClipboard('textArea2')">Copy</button>
            <button type="button" onclick="copyToClipboard('textArea3')">Copy</button>
        </div>
    </form>

    <script>
        function copyToClipboard(id) {
            const textArea = document.getElementById(id);
            const text = textArea.value;
            navigator.clipboard.writeText(text);
        }
    </script>
</body>
</html>