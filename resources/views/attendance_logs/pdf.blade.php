<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Logs</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            position: relative;
        }

        h1 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 20px;
        }

        .info-box {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            padding: 10px;
            margin-bottom: 20px;
        }

        .info-flex {
            display: flex;
            justify-content: space-between;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #dee2e6;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #e9ecef;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 0.9em;
            color: #6c757d;
        }
    </style>
</head>

<body>
    <h1>ATTENDANCE LOGS {{ $section->section_name }} </h1>
    <p><strong>Total Students:</strong> {{ $section->student_count }}</p>
    <p><strong>Instructor:</strong> {{ Auth::user()->last_name }}, {{ Auth::user()->first_name }}</p>
    <div class="info-box">
        <div class="info-flex">
            <p><strong>Date:</strong> {{ $date }}</p>
            <p><strong>Time:</strong>
                {{ date('h:i a', strtotime($section->time_in)) . ' - ' . date('h:i a', strtotime($section->time_out)) }}
            </p>
        </div>
    </div>
    <table>
        <thead>
            <tr>
                <th>Student Name</th>
                <th>Time In</th>
                <th>Time Out</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($attendanceLogs as $log)
                <tr>
                    <td>{{ $log->student ? $log->student->name : 'N/A' }}</td>
                    <td>{{ date('h:i a', strtotime($log->time_in)) }}</td>
                    <td>
                        {{ $log->time_in ? date('h:i a', strtotime($log->time_out)) : 'Time In Not Registered' }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="footer">
        NASECURE {{ date('Y') }}
    </div>
    <div class="blue-line bottom-line"></div>
</body>

</html>
