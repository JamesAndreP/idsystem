<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student QR Print</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f3f4f6;
            padding: 30px;
        }

        .card-print {
            max-width: 500px;
            margin: auto;
            background: white;
            border-radius: 15px;
            padding: 25px;
            text-align: center;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        .qr-box {
            margin: 20px 0;
        }

        .info {
            text-align: left;
            margin-top: 15px;
        }

        .info p {
            margin: 5px 0;
            font-size: 15px;
        }

        .btn-print {
            margin-top: 20px;
        }

        /* PRINT STYLES */
        @media print {
            body {
                background: white;
                padding: 0;
            }

            .btn-print {
                display: none;
            }

            .card-print {
                box-shadow: none;
                border: none;
            }
        }
    </style>
</head>
<body>

<div class="card-print">

    <h3>Student QR Code</h3>

    <div class="qr-box">
        {!! $qr !!}
    </div>

    <div class="info">
        <p><strong>First Name:</strong> {{ $student->first_name }}</p>
        <p><strong>Middle Name:</strong> {{ $student->middle_name ?: '-' }}</p>
        <p><strong>Last Name:</strong> {{ $student->last_name }}</p>
        <p><strong>Section:</strong> {{ $student->section }}</p>
        <p><strong>LRN:</strong> {{ $student->lrn }}</p>
    </div>

    <button onclick="window.print()" class="btn btn-primary btn-print">
        Print
    </button>

</div>

</body>
</html>