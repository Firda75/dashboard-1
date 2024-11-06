<div class="flex flex-col col-span-full sm:col-span-6 bg-indigo-400 dark:bg-gray-800 shadow-sm rounded-xl">
    <header class="px-5 py-4 border-b border-gray-100 dark:border-gray-700/60">
        <h2 class="font-semibold text-white dark:text-gray-100">MQTT STATUS</h2>
    </header>
    <div class="flex flex-col space-x-4 px-5 py-6"> 
    <div id="messages" class="flex shadow-lg shadow-indigo-800 text-3xl justify-center items-center rounded-md h-32 w-64 p-4 text-white font-bold bg-white"></div>
    <div id="status" class="flex-row p-2 font-bold mb-4"></div>
   
    
</div>
    <div class="grow">
        <canvas id="dashboard-card-04" width="595" height="75 "></canvas>
    </div>
</div>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/mqtt/dist/mqtt.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
  </head>
    <title></title>
</head>
<body class="flex h-screen bg-gray-400">


    <!-- MQTT Script -->
    <script>
    // Broker configuration
    const mqttServer = 'wss://mqtt-dashboard.com:8884/mqtt'; // WebSocket URL
    const mqttUser = 'bejo'; // MQTT Username
    const mqttPassword = 'bejokun'; // MQTT Password
    const topic = 'topik/bebas'; // MQTT Topic

    // Create a client instance
    const client = mqtt.connect(mqttServer, {
        username: mqttUser,
        password: mqttPassword,
        reconnectPeriod: 1000,
    });

    // Update status indicator
    function updateStatus(message, color) {
        const statusElement = document.getElementById('status');
        statusElement.innerHTML = message;
        statusElement.className = `mt-4 p-2 text-left font-bold ${color}`;
    }

    // Connect event
    client.on('connect', () => {
        console.log('Connected to MQTT broker');
        updateStatus('Connected to MQTT broker', 'text-green-500');
        client.subscribe(topic, (err) => {
            if (!err) {
                console.log(`Subscribed to topic ${topic}`);
            } else {
                console.error('Subscription error:', err);
            }
        });
    });

    // Message event
    client.on('message', (topic, message) => {
        const msg = message.toString();
        console.log(`Received message: ${msg}`);
        // Show only the latest message
        const messagesDiv = document.getElementById('messages');
        messagesDiv.innerHTML = `<p>${msg}</p>`; // Replace previous message with the latest one
    });

    // Error event
    client.on('error', (err) => {
        console.error('Connection error:', err);
        updateStatus('Not connected to MQTT broker', 'text-red-500');
    });

    // Offline event (when client loses connection)
    client.on('offline', () => {
        console.log('MQTT client is offline');
        updateStatus('Not connected to MQTT broker', 'text-red-500');
    });

    // End event (when client is disconnected)
    client.on('close', () => {
        console.log('MQTT client connection closed');
        updateStatus('Not connected to MQTT broker', 'text-red-500');
    });

    

</script>

</body>
</html>

