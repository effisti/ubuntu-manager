<?php
// Zorg ervoor dat SystemManager beschikbaar is
require_once 'SystemManager.php';

use UbuntuManager\SystemManager;

// Haal systeeminformatie op
$systemInfo = SystemManager::getSystemInfo();

// Handle terminal commando's
$terminalOutput = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['command'])) {
    $command = escapeshellcmd($_POST['command']);
    $terminalOutput = shell_exec($command);
}
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubuntu Manager</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-800 text-white font-sans">

    <!-- Navigatie -->
    <nav class="bg-gray-900 p-4">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <a href="#" class="text-2xl font-semibold">Ubuntu Manager</a>
            <div>
                <a href="#" class="text-gray-300 hover:text-white px-4 py-2">Home</a>
                <a href="#system-info" class="text-gray-300 hover:text-white px-4 py-2">Systeeminfo</a>
                <a href="#terminal" class="text-gray-300 hover:text-white px-4 py-2">Terminal</a>
            </div>
        </div>
    </nav>

    <!-- Systeeminformatie -->
    <section id="system-info" class="py-12 bg-gray-900">
        <div class="max-w-7xl mx-auto px-6">
            <h2 class="text-3xl font-semibold mb-6">Systeeminformatie</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Uptime -->
                <div class="bg-gray-700 p-6 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold mb-4">Uptime</h3>
                    <p class="text-lg"><?php echo $systemInfo['uptime']; ?></p>
                </div>
                <!-- Schijfgebruik -->
                <div class="bg-gray-700 p-6 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold mb-4">Schijfgebruik</h3>
                    <pre class="text-lg"><?php echo $systemInfo['diskUsage']; ?></pre>
                </div>
                <!-- Geheugengebruik -->
                <div class="bg-gray-700 p-6 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold mb-4">Geheugengebruik</h3>
                    <pre class="text-lg"><?php echo $systemInfo['memoryUsage']; ?></pre>
                </div>
            </div>
        </div>
    </section>

    <!-- Terminal -->
    <section id="terminal" class="py-12 bg-gray-800">
        <div class="max-w-7xl mx-auto px-6">
            <h2 class="text-3xl font-semibold mb-6">Terminal Commando</h2>
            <form method="POST" class="bg-gray-700 p-6 rounded-lg shadow-md mb-6">
                <label for="command" class="block text-lg font-semibold mb-2">Voer een commando uit:</label>
                <input type="text" name="command" id="command" class="w-full p-3 bg-gray-800 text-white border border-gray-600 rounded-md focus:outline-none" placeholder="Bijv. 'ls -l'">
                <button type="submit" class="mt-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md focus:outline-none">Uitvoeren</button>
            </form>

            <?php if ($terminalOutput): ?>
                <div class="bg-gray-700 p-6 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold mb-4">Terminal Output</h3>
                    <pre class="text-lg whitespace-pre-wrap"><?php echo $terminalOutput; ?></pre>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 py-6">
        <div class="text-center text-gray-400">
            <p>&copy; 2025 Ubuntu Manager - Alle rechten voorbehouden</p>
        </div>
    </footer>

</body>

</html>