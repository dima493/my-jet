<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">

    <title>Materials</title>
</head>

<body>

    <header>
        <nav class="navbar">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="materials.php">Materials</a></li>
                <li><a href="login.php">Login</a></li>
                <li><a href="signup.php">Signup</a></li>
            </ul>
        </nav>
    </header>

    <input type="text" id="u_path" placeholder="Предмет (напр. Фізика)">
    <input type="file" id="u_file" multiple>

    <caption align="right">
        <button onclick="addRow()">+</button>
    </caption>

    <table id="source">
        <tr>
            <th>Предмет</th>
            <th>Файл</th>
            <th>Дія</th>
        </tr>
    </table>

    <script>
        function addRow() {
            let table = document.getElementById("source");
            let pathInput = document.getElementById("u_path");
            let fileInput = document.getElementById("u_file");

            if (pathInput.value !== "" && fileInput.files.length > 0) {
                let f_name = fileInput.files[0].name;
                let p_name = pathInput.value;

                let row = table.insertRow(-1);
                let cell1 = row.insertCell(0);
                let cell2 = row.insertCell(1);
                let cell3 = row.insertCell(2);

                let link = document.createElement('a');
                link.href = `../databases/JetIQ/${p_name}/${f_name}`;
                link.textContent = f_name;
                link.target = "_blank";

                cell1.innerHTML = p_name;
                cell2.appendChild(link);

                let btn = document.createElement('button');
                btn.innerHTML = "X";
                btn.onclick = function () {
                    deleteFromServer(p_name, f_name, row);
                };
                cell3.appendChild(btn);

                function saveToServer(p_name, f_name) {
                    fetch('save_data.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ subject: p_name, file: f_name })
                    })
                        .then(response => response.text())
                        .then(data => console.log("Saved to server:", data));
                }

                saveToServer(p_name, f_name);

                pathInput.value = "";
                fileInput.value = "";

            } else {
                alert("Введіть предмет та виберіть файли!");
            }
        }

        window.onload = function () {
            fetch('save_data.php')
                .then(response => response.text())
                .then(data => {
                    if (data.trim() !== "") {
                        let lines = data.trim().split("\n");
                        lines.forEach(line => {
                            let parts = line.split("|");
                            renderRow(parts[0], parts[1]);
                        });
                    }
                });
        };

        function renderRow(p_name, f_name) {
            let table = document.getElementById("source");

            let row = table.insertRow(-1);
            let cell1 = row.insertCell(0);
            let cell2 = row.insertCell(1);
            let cell3 = row.insertCell(2);

            let link = document.createElement('a');
            link.href = `../databases/JetIQ/${p_name}/${f_name}`;
            link.textContent = f_name;
            link.target = "_blank";

            cell1.innerHTML = p_name;
            cell2.appendChild(link);

            let btn = document.createElement('button');
            btn.innerHTML = "X";
            btn.onclick = function () {
                deleteFromServer(p_name, f_name, row);
            };
            cell3.appendChild(btn);
        }

        function deleteFromServer(p_name, f_name, row) {
            fetch('save_data.php', {
                method: 'DELETE',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ subject: p_name, file: f_name })
            })
                .then(response => response.text())
                .then(data => {
                    if (data.trim() === "Deleted") {
                        row.remove();
                    }
                });
        }

    </script>
</body>

</html>