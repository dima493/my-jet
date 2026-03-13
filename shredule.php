<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Розклад</title>
</head>
<body>
    <header>
        <nav class="navbar">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="materials.php">Materials</a></li>
                <li><a href="shredule.php">Shredule</a></li>
                <li><a href='logout.php'>Sign Out</a></li>
            </ul>
        </nav>
    </header>

    <h2 align="center">Розклад занять</h2>
    
    <div class="controls" style="text-align: center; margin-bottom: 20px;">
        <select id="u_week_num">
            <option value="1">1 Week (Чисельник)</option>
            <option value="2">2 Week (Знаменник)</option>
        </select>

        <select id="u_lesson_num">
            <option value="1">1 lesson</option>
            <option value="2">2 lesson</option>
            <option value="3">3 lesson</option>
            <option value="4">4 lesson</option>
            <option value="5">5 lesson</option>
            <option value="6">6 lesson</option>
            <option value="7">7 lesson</option>
        </select>

        <select id="u_day">
            <option value="1">Monday</option>
            <option value="2">Tuesday</option>
            <option value="3">Wednesday</option>
            <option value="4">Thursday</option>
            <option value="5">Friday</option>
        </select>

        <input type="text" id="u_sub" placeholder="Subject">
        <input type="text" id="u_kab" placeholder="Audience">
        <button onclick="addRow()">+</button>
    </div>

    <h3 align="center">1 Тиждень</h3>
<table id="table_week_1" class="schedule-table">
    <thead>
        <tr>
            <th>№</th>
            <th>Monday</th>
            <th>Tuesday</th>
            <th>Wednesday</th>
            <th>Thursday</th>
            <th>Friday</th>
            <th>Act</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>

<br>

<h3 align="center">2 Тиждень</h3>
<table id="table_week_2" class="schedule-table">
    <thead>
        <tr>
            <th>№</th>
            <th>Monday</th>
            <th>Tuesday</th>
            <th>Wednesday</th>
            <th>Thursday</th>
            <th>Friday</th>
            </tr>
    </thead>
    <tbody></tbody>
</table>

    <script>
        function addRow() {
            let weekNum = document.getElementById("u_week_num").value;
            let lessonNum = document.getElementById("u_lesson_num").value;
            let dayIndex = parseInt(document.getElementById("u_day").value);
            let sub = document.getElementById("u_sub").value;
            let kab = document.getElementById("u_kab").value;

            if (sub && kab) {
                fetch('shredule_save.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        week_num: weekNum,
                        lesson_num: lessonNum, 
                        day_index: dayIndex, 
                        subject: sub, 
                        cabinet: kab 
                    })
                }).then(() => {
                    location.reload(); 
                });
            } else {
                alert("Заповніть предмет та кабінет!");
            }
        }

        function renderRow(weekNum, lessonNum, dayIndex, subject, cabinet) {
            let tableId = (weekNum == 1) ? "table_week_1" : "table_week_2";
            let tbody = document.querySelector(`#${tableId} tbody`);
            
            if (!tbody) return;

            let row = Array.from(tbody.rows).find(r => r.cells[0].innerText == lessonNum);

            if (!row) {
                row = tbody.insertRow(-1);
                for (let i = 0; i <= 6; i++) row.insertCell(i).innerHTML = "";
                row.cells[0].innerText = lessonNum;

                row.cells[dayIndex].innerHTML = "";

                let lessonContainer = document.createElement('div');
                lessonContainer.className = "lesson-item";
                lessonContainer.innerHTML = `
                    <div style="color: #00FF99; border-bottom: 1px solid #333; margin-bottom: 5px;">
                        <strong>${subject}</strong><br>
                        <small>${cabinet}</small>
                    </div>
                `;

                let btn = document.createElement('button');
                btn.innerHTML = "X";
                btn.className = "x-btn";
                btn.onclick = function() { deleteFromServer(weekNum, lessonNum, dayIndex, subject, cabinet); };

                lessonContainer.appendChild(btn);
                row.cells[dayIndex].appendChild(lessonContainer);
            }            
            sortSchedule(tbody); 
        }

        function sortSchedule(tbody) {
            let rows = Array.from(tbody.rows);
            rows.sort((a, b) => parseInt(a.cells[0].innerText) - parseInt(b.cells[0].innerText));
            rows.forEach(row => tbody.appendChild(row));
        }

        function deleteFromServer(weekNum, lessonNum, dayIndex, subject, cabinet) {
            if (confirm("Видалити цю пару з розкладу?")) {
                fetch('../databases/shredule_save.php', {
                    method: 'DELETE',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ 
                        week_num: weekNum,
                        lesson_num: lessonNum, 
                        day_index: dayIndex, 
                        subject: subject, 
                        cabinet: cabinet 
                    })
                }).then(() => {
                    location.reload();
                });
            }
        }

        window.onload = function() {
            fetch('../databases/shredule_save.php')
            .then(res => res.json())
            .then(data => {
                if(data && Array.isArray(data)) {
                    data.forEach(item => {
                        renderRow(item.week_num, item.lesson_num, item.day_index, item.subject, item.cabinet);
                    });
                }
            })
            .catch(err => console.error("Помилка завантаження даних:", err));
        };
    </script>
</body>
</html>