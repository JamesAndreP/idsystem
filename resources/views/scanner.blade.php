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
            justify-content: flex-start;
            background: #0f172a;
            box-shadow: 0 2px 10px rgba(0,0,0,0.3);
        }

        .logo {
            height: 200px;
            width: 200px;
            object-fit: contain;
            margin-right: 12px;
        }

        .title {
            font-size: 18px;
            font-weight: bold;
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
    <img src="{{ asset('images/stec-logo.png') }}" class="logo" alt="Logo">
    <div class="title">RMDSF-STEC Scanner System</div>

    <form action="{{ route('logout') }}" method="POST" class="ms-auto">
        @csrf
        <button type="submit" class="btn btn-sm btn-outline-light">
            Log Out
        </button>
    </form>
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
                    <p><strong>Section:</strong> ${s.section}</p>
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