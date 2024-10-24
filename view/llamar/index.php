<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Issabel Call</title>
</head>

<body>
    <form id="callForm">
        <label for="number">Número de teléfono:</label>
        <input type="text" id="number" name="number" required>
        <button type="submit">Llamar</button>
        <button type="button" onclick="hangupCall()">Colgar</button>
    </form>

    <script>
        document.getElementById('callForm').addEventListener('submit', function(e) {
            e.preventDefault();
            var number = document.getElementById('number').value;
            fetch('make_call.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'number=' + encodeURIComponent(number)
            }).then(response => response.text()).then(data => {
                console.log(data);
            });
        });

        function hangupCall() {
            fetch('hangup_call.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            }).then(response => response.text()).then(data => {
                console.log(data);
            });
        }
    </script>
</body>

</html>