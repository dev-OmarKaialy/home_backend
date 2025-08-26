<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <title>Print PDF</title>
</head>

<body>
    <iframe src="{{ route('house.print', ['file' => $filePath]) }}" style="width:100%; height:100vh;" id="pdfFrame"></iframe>

    <script>
        const iframe = document.getElementById('pdfFrame');
        iframe.onload = function() {
            iframe.contentWindow.focus();
            iframe.contentWindow.print();
        }
    </script>
</body>

</html>