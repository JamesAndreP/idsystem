<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Scanner Gate</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #111827;
            color: white;
            min-height: 100vh;
            font-family: Arial;
            margin: 0;
        }

        /* HEADER BAR */
        .topbar {
            width: 100%;
            padding: 15px 25px;
            display: flex;
            align-items: center;
            background: #0f172a;
            box-shadow: 0 2px 10px rgba(0,0,0,0.3);
        }

        .topbar .logo-container {
            display: flex;
            align-items: center;
            flex: 1;
        }

        .topbar .logout-container {
            margin-left: auto;
        }

        .logo {
            height: 60px;
            width: 60px;
            object-fit: contain;
            margin-right: 12px;
        }

        .title {
            font-size: 18px;
            font-weight: bold;
        }

        .topbar .btn-danger {
            padding: 8px 16px;
            border-radius: 8px;
            background: #ef4444;
            border: none;
            color: white;
        }

        .topbar .btn-danger:hover {
            background: #dc2626;
        }

        .back-button {
            font-size: 32px;
            color: white;
            text-decoration: none;
            margin-right: 15px;
            cursor: pointer;
            transition: color 0.2s;
            line-height: 1;
            font-weight: bold;
        }

        .back-button:hover {
            color: #4f46e5;
        }

        /* CENTER BOX */
        .wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            height: calc(50vh - 70px);
        }

        .box {
            width: 500px;
            background: #1f2937;
            padding: 30px;
            border-radius: 15px;
            text-align: center;
        }

        .student-card {
            margin-top: 20px;
            padding: 20px;
            background: #111827;
            border-radius: 10px;
            display: none;
        }

        .found { border-left: 5px solid #22c55e; }
        .not-found { border-left: 5px solid #ef4444; }
    </style>
</head>
<body>

<!-- TOP BAR -->
<div class="topbar">
    <div class="logo-container">
        <a href="{{ route('dashboard') }}" class="back-button">←</a>
        <img src="{{ asset('images/stec-logo.png') }}" class="logo" alt="Logo">
        <div class="title">RMDSF-STEC Scanner System</div>
    </div>
    <div class="logout-container">
        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="btn btn-danger btn-sm">Logout</button>
        </form>
    </div>
</div>

<!-- CENTER CONTENT -->
<div class="wrapper">
    <div class="box">

        <h2>🎓 Stecians</h2>

        <input type="text" id="scannerInput"
               autocomplete="off"
               style="opacity:0; position:absolute; left:-9999px;">

        <div id="result" class="student-card"></div>

    </div>
</div>

<script>
let input = document.getElementById('scannerInput');
let result = document.getElementById('result');

// store timeout globally
let resetTimer = null;

// always focus (scanner-friendly)
setInterval(() => input.focus(), 500);

input.addEventListener('keydown', function(e) {
    if (e.key === 'Enter') {

        let code = input.value;
        input.value = '';

        fetch("{{ route('students.lookup') }}", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            body: JSON.stringify({ code: code })
        })
        .then(res => res.json())
        .then(data => {

            result.style.display = 'block';

            if (data.status === 'found') {
                let s = data.student;

                result.className = "student-card found";
                result.innerHTML = `
                    <h3>Welcome!</h3>
                    <hr>
                    <p><strong>Name:</strong> ${s.first_name} ${s.middle_name ?? ''} ${s.last_name}</p>
                    <p><strong>Section:</strong> ${s.current_grade_and_section[0].grade_level} - ${s.current_grade_and_section[0].section}</p>
                    <p><strong>LRN:</strong> ${s.lrn}</p>
                `;
            } else {
                result.className = "student-card not-found";
                result.innerHTML = `
                    <h3>❌ Not Found</h3>
                    <p>No student matched the scanned code.</p>
                `;
            }

            // ✅ CLEAR OLD TIMER FIRST
            if (resetTimer) {
                clearTimeout(resetTimer);
            }

            // ✅ START NEW 5s TIMER
            resetTimer = setTimeout(() => {
                result.style.display = 'none';
                result.innerHTML = '';
                result.className = 'student-card';
                input.focus();
            }, 5000);

        });
    }
});
</script>

</body>
</html>