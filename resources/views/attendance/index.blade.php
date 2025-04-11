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
        background-color: #f8f9fa;
        padding: 20px;
    }
    .container {
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        display: inline-block;
    }
    .time {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 15px;
    }
    button {
        width: 100%;
        padding: 12px;
        margin: 8px 0;
        font-size: 18px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
    .enabled {
        background-color: #28a745;
        color: white;
    }
    .disabled {
        background-color: gray;
        color: white;
        pointer-events: none;
    }
    .error {
        color: red;
        font-weight: bold;
        margin-bottom: 10px;
    }
    </style>

</head>
<body>
    <div class="container">


        <h1>勤怠管理</h1>
        @if ($errors->any())
            <div style="color: red; font-weight: bold; margin-bottom: 10px;">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif
        <div class="time">
            現在時刻: <span id="current-time">{{ now()->format('H:i:s') }}</span>
        </div>
        @if ($attendance)
            <div class="attendance-info">
                <p>出勤時刻: {{ $attendance->clock_in ? $attendance->clock_in->format('H:i:s') : '-' }}</p>
                <p>休憩開始: {{ $attendance->break_start ? $attendance->break_start->format('H:i:s') : '-' }}</p>
                <p>休憩終了: {{ $attendance->break_end ? $attendance->break_end->format('H:i:s') : '-' }}</p>
                <p>退勤時刻: {{ $attendance->clock_out ? $attendance->clock_out->format('H:i:s') : '-' }}</p>
            </div>
        @endif
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
