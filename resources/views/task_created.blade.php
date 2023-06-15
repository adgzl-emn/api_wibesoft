<!DOCTYPE html>
<html>
<head>
    <title>Görev Oluşturuldu</title>
</head>
<body>
<h1>Görev Oluşturuldu</h1>
<p>Görev başarıyla oluşturuldu. Görev bilgileri:</p>
<p>Başlık: {{ $task->title }}</p>
<p>İçerik: {{ $task->content }}</p>
<p>Zaman: {{ $task->task_time }}</p>
<p>Durum: {{ $task->status }}</p>
<p>Olusturma tarihi: {{ $task->status }}</p>
</body>
</html>
