<?php
// PHP Calculator - Task 3.3
// Initialize variables
$num1 = '';
$num2 = '';
$operation = '';
$result = '';
$error = '';
$history = [];

// Start session to maintain calculation history
session_start();

// Initialize history if not exists
if (!isset($_SESSION['history'])) {
    $_SESSION['history'] = [];
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get input values
    $num1 = $_POST['num1'] ?? '';
    $num2 = $_POST['num2'] ?? '';
    $operation = $_POST['operation'] ?? '';

    // Validate inputs
    if (empty($num1) || empty($num2) || empty($operation)) {
        $error = "Please fill in all fields.";
    } elseif (!is_numeric($num1) || !is_numeric($num2)) {
        $error = "Please enter valid numbers.";
    } else {
        // Convert to float for calculations
        $num1 = floatval($num1);
        $num2 = floatval($num2);

        // Perform calculation
        switch ($operation) {
            case "add":
                $result = $num1 + $num2;
                $operation_symbol = "+";
                break;
            case "subtract":
                $result = $num1 - $num2;
                $operation_symbol = "-";
                break;
            case "multiply":
                $result = $num1 * $num2;
                $operation_symbol = "×";
                break;
            case "divide":
                if ($num2 == 0) {
                    $error = "Error: Division by zero is not allowed.";
                } else {
                    $result = $num1 / $num2;
                    $operation_symbol = "÷";
                }
                break;
            case "power":
                $result = pow($num1, $num2);
                $operation_symbol = "^";
                break;
            case "modulo":
                if ($num2 == 0) {
                    $error = "Error: Modulo by zero is not allowed.";
                } else {
                    $result = $num1 % $num2;
                    $operation_symbol = "%";
                }
                break;
            default:
                $error = "Invalid operation selected.";
        }

        // Add to history if calculation was successful
        if (empty($error) && $result !== '') {
            $history_entry = [
                'num1' => $num1,
                'num2' => $num2,
                'operation' => $operation_symbol,
                'result' => $result,
                'timestamp' => date('Y-m-d H:i:s')
            ];

            // Add to session history (keep last 10 calculations)
            array_unshift($_SESSION['history'], $history_entry);
            if (count($_SESSION['history']) > 10) {
                $_SESSION['history'] = array_slice($_SESSION['history'], 0, 10);
            }
        }
    }
}

// Handle clear history
if (isset($_POST['clear_history'])) {
    $_SESSION['history'] = [];
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Get history
$history = $_SESSION['history'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Calculator - Task 3.3</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            color: white;
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }

        .header p {
            font-size: 1.2em;
            opacity: 0.9;
        }

        .main-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }

        .calculator-section {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .section-title {
            color: #2c3e50;
            font-size: 1.8em;
            margin-bottom: 20px;
            text-align: center;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
        }

        .form-container {
            background: #2c3e50;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            color: #ecf0f1;
            font-weight: bold;
            margin-bottom: 8px;
            font-size: 1.1em;
        }

        .form-input, .form-select {
            width: 100%;
            height: 50px;
            font-size: 1.1em;
            padding: 0 15px;
            border-radius: 8px;
            border: 2px solid #34495e;
            background: #ecf0f1;
            color: #2c3e50;
            transition: all 0.3s ease;
        }

        .form-input:focus, .form-select:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 10px rgba(52, 152, 219, 0.3);
            transform: scale(1.02);
        }

        .input-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .btn {
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            font-size: 1.1em;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .btn-primary {
            background: linear-gradient(145deg, #3498db, #2980b9);
            color: white;
            box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(52, 152, 219, 0.4);
        }

        .btn-success {
            background: linear-gradient(145deg, #27ae60, #2ecc71);
            color: white;
            box-shadow: 0 4px 15px rgba(39, 174, 96, 0.3);
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(39, 174, 96, 0.4);
        }

        .btn-warning {
            background: linear-gradient(145deg, #f39c12, #e67e22);
            color: white;
            box-shadow: 0 4px 15px rgba(243, 156, 18, 0.3);
        }

        .btn-warning:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(243, 156, 18, 0.4);
        }

        .btn-danger {
            background: linear-gradient(145deg, #e74c3c, #c0392b);
            color: white;
            box-shadow: 0 4px 15px rgba(231, 76, 60, 0.3);
        }

        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(231, 76, 60, 0.4);
        }

        .button-row {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 15px;
            align-items: end;
            margin-top: 10px;
        }

        .result-display {
            margin-top: 20px;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            font-size: 1.3em;
            font-weight: bold;
        }

        .result-success {
            background: linear-gradient(145deg, #27ae60, #2ecc71);
            color: white;
            box-shadow: 0 4px 15px rgba(39, 174, 96, 0.3);
        }

        .result-error {
            background: linear-gradient(145deg, #e74c3c, #c0392b);
            color: white;
            box-shadow: 0 4px 15px rgba(231, 76, 60, 0.3);
        }

        .history-section {
            background: #2c3e50;
            border-radius: 15px;
            padding: 20px;
            max-height: 400px;
            overflow-y: auto;
        }

        .history-item {
            background: #34495e;
            margin-bottom: 10px;
            padding: 15px;
            border-radius: 8px;
            color: #ecf0f1;
            transition: transform 0.2s ease;
        }

        .history-item:hover {
            transform: scale(1.02);
            background: #3a536b;
        }

        .history-calculation {
            font-size: 1.2em;
            font-weight: bold;
            color: #3498db;
        }

        .history-time {
            font-size: 0.9em;
            color: #bdc3c7;
            margin-top: 5px;
        }

        .no-history {
            text-align: center;
            color: #95a5a6;
            font-style: italic;
            padding: 20px;
        }

        .footer {
            text-align: center;
            color: white;
            margin-top: 30px;
            padding: 20px;
            background: rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .main-content {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            
            .input-row {
                grid-template-columns: 1fr;
            }
            
            .button-row {
                grid-template-columns: 1fr;
            }
            
            .calculator-section {
                padding: 20px;
            }
            
            .header h1 {
                font-size: 2em;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>🧮 PHP Calculator</h1>
            <p>Advanced Server-Side Calculator - Task 3.3 HD</p>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Calculator Section -->
            <div class="calculator-section">
                <h2 class="section-title">Calculator</h2>
                
                <div class="form-container">
                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="input-row">
                            <div class="form-group">
                                <label class="form-label" for="num1">First Number</label>
                                <input type="number" 
                                       id="num1" 
                                       name="num1" 
                                       class="form-input" 
                                       step="any" 
                                       required 
                                       placeholder="Enter first number"
                                       value="<?php echo htmlspecialchars($num1); ?>" />
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label" for="num2">Second Number</label>
                                <input type="number" 
                                       id="num2" 
                                       name="num2" 
                                       class="form-input" 
                                       step="any" 
                                       required 
                                       placeholder="Enter second number"
                                       value="<?php echo htmlspecialchars($num2); ?>" />
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="operation">Operation</label>
                            <select id="operation" name="operation" class="form-select" required>
                                <option value="">Select Operation</option>
                                <option value="add" <?php echo ($operation == 'add') ? 'selected' : ''; ?>>➕ Addition</option>
                                <option value="subtract" <?php echo ($operation == 'subtract') ? 'selected' : ''; ?>>➖ Subtraction</option>
                                <option value="multiply" <?php echo ($operation == 'multiply') ? 'selected' : ''; ?>>✖️ Multiplication</option>
                                <option value="divide" <?php echo ($operation == 'divide') ? 'selected' : ''; ?>>➗ Division</option>
                                <option value="power" <?php echo ($operation == 'power') ? 'selected' : ''; ?>>🔢 Power</option>
                                <option value="modulo" <?php echo ($operation == 'modulo') ? 'selected' : ''; ?>>🔄 Modulo</option>
                            </select>
                        </div>
                        
                        <div class="button-row">
                            <button type="submit" class="btn btn-success">🧮 Calculate</button>
                            <button type="button" class="btn btn-warning" onclick="clearForm()">🗑️ Clear</button>
                        </div>
                    </form>
                    
                    <!-- Result Display -->
                    <?php if (!empty($error)): ?>
                        <div class="result-display result-error">
                            ❌ <?php echo htmlspecialchars($error); ?>
                        </div>
                    <?php elseif ($result !== ''): ?>
                        <div class="result-display result-success">
                            ✅ <?php echo htmlspecialchars($num1 . ' ' . $operation_symbol . ' ' . $num2 . ' = ' . $result); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- History Section -->
            <div class="calculator-section">
                <h2 class="section-title">Calculation History</h2>
                
                <div class="history-section">
                    <?php if (empty($history)): ?>
                        <div class="no-history">
                            📝 No calculations yet. Start calculating to see your history!
                        </div>
                    <?php else: ?>
                        <?php foreach ($history as $index => $calc): ?>
                            <div class="history-item">
                                <div class="history-calculation">
                                    <?php echo htmlspecialchars($calc['num1'] . ' ' . $calc['operation'] . ' ' . $calc['num2'] . ' = ' . $calc['result']); ?>
                                </div>
                                <div class="history-time">
                                    🕒 <?php echo htmlspecialchars($calc['timestamp']); ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        
                        <form method="POST" style="margin-top: 15px;">
                            <button type="submit" name="clear_history" class="btn btn-danger" style="width: 100%;">
                                🗑️ Clear History
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>PHP Calculator</strong> - Task 3.3 HD Implementation</p>
            <p>Built with PHP <?php echo phpversion(); ?> | Session-based History | Advanced Error Handling</p>
        </div>
    </div>

    <script>
        function clearForm() {
            document.getElementById('num1').value = '';
            document.getElementById('num2').value = '';
            document.getElementById('operation').selectedIndex = 0;
            
            // Remove result display
            const resultDisplay = document.querySelector('.result-display');
            if (resultDisplay) {
                resultDisplay.style.display = 'none';
            }
        }
        
        // Add some interactive effects
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('.form-input, .form-select');
            
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.style.transform = 'scale(1.02)';
                });
                
                input.addEventListener('blur', function() {
                    this.style.transform = 'scale(1)';
                });
            });
            
            // Auto-focus first input
            document.getElementById('num1').focus();
        });
    </script>
</body>
</html>