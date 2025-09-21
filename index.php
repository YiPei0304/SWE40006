<?php
// PHP Calculator Project - Index/Landing Page
// Redirect to calculator or show project info
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Calculator Project - Task 3.3</title>
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
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .landing-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 50px;
            max-width: 600px;
            text-align: center;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            animation: fadeInUp 1s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .logo {
            font-size: 4em;
            margin-bottom: 20px;
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-10px);
            }
            60% {
                transform: translateY(-5px);
            }
        }

        .title {
            color: #2c3e50;
            font-size: 2.5em;
            margin-bottom: 15px;
            font-weight: 300;
        }

        .subtitle {
            color: #7f8c8d;
            font-size: 1.3em;
            margin-bottom: 30px;
        }

        .description {
            color: #34495e;
            font-size: 1.1em;
            line-height: 1.6;
            margin-bottom: 40px;
        }

        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .feature {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            border-left: 4px solid #3498db;
            transition: transform 0.3s ease;
        }

        .feature:hover {
            transform: translateY(-5px);
        }

        .feature-icon {
            font-size: 2em;
            margin-bottom: 10px;
        }

        .feature-title {
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .feature-desc {
            color: #7f8c8d;
            font-size: 0.9em;
        }

        .btn {
            display: inline-block;
            padding: 15px 30px;
            font-size: 1.2em;
            font-weight: bold;
            text-decoration: none;
            border-radius: 10px;
            transition: all 0.3s ease;
            margin: 0 10px;
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

        .btn-secondary {
            background: linear-gradient(145deg, #95a5a6, #7f8c8d);
            color: white;
            box-shadow: 0 4px 15px rgba(149, 165, 166, 0.3);
        }

        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(149, 165, 166, 0.4);
        }

        .info-box {
            background: #e8f4f8;
            border: 1px solid #3498db;
            border-radius: 10px;
            padding: 20px;
            margin-top: 30px;
            text-align: left;
        }

        .info-title {
            color: #2980b9;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .tech-stack {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        .tech-item {
            background: #3498db;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.9em;
            font-weight: bold;
        }

        @media (max-width: 600px) {
            .landing-container {
                padding: 30px 20px;
            }
            
            .logo {
                font-size: 3em;
            }
            
            .title {
                font-size: 2em;
            }
            
            .btn {
                display: block;
                margin: 10px 0;
            }
        }
    </style>
</head>
<body>
    <div class="landing-container">
        <div class="logo">🧮</div>
        <h1 class="title">PHP Calculator Project</h1>
        <p class="subtitle">Task 3.3 HD - Advanced Web Application</p>
        
        <p class="description">
            Welcome to the PHP Calculator project! A comprehensive server-side calculator 
            built with pure PHP for Task 3.3 HD.
        </p>

        <div>
            <a href="calculator.php" class="btn btn-primary">🚀 Launch Calculator</a>
        </div>
    </div>

    <script>
        // Simple script for any future enhancements
        document.addEventListener('DOMContentLoaded', function() {
            // Add click effect to the button
            const launchBtn = document.querySelector('.btn-primary');
            launchBtn.addEventListener('click', function(e) {
                this.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    this.style.transform = 'translateY(-2px)';
                }, 100);
            });
        });
    </script>
</body>
</html>