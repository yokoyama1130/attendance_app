<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>勤怠管理</title>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        function updateTime() {
            document.getElementById("current-time").innerText = new Date().toLocaleTimeString();
        }
        setInterval(updateTime, 1000);
    </script>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 20px;
        }
        .container {
            width: 300px;
            margin: auto;
        }
        .time {
            font-size: 24px;
            margin-bottom: 20px;
        }
        button {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            font-size: 18px;
        }
        .disabled {
            background-color: gray;
            color: white;
            pointer-events: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>勤怠管理</h1>
        <div class="time">
            現在時刻: <span id="current-time">{{ now()->format('H:i:s') }}</span>
        </div>
        <form method="POST" action="{{ route('attendance.store') }}">
            @csrf
            <button type="submit" name="action" value="clock_in" 
                {{ $attendance && $attendance->clock_in ? 'class=disabled' : '' }}>出勤</button>
            <button type="submit" name="action" value="break_start" 
                {{ !$attendance || !$attendance->clock_in || $attendance->break_start ? 'class=disabled' : '' }}>休憩開始</button>
            <button type="submit" name="action" value="break_end" 
                {{ !$attendance || !$attendance->break_start || $attendance->break_end ? 'class=disabled' : '' }}>休憩終了</button>
            <button type="submit" name="action" value="clock_out" 
                {{ !$attendance || !$attendance->break_end || $attendance->clock_out ? 'class=disabled' : '' }}>退勤</button>
        </form>
    </div>
</body>
</html>
