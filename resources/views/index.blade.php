<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>App</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('main/main.css') }}">
    <script type="text/javascript" src="{{ asset('plupload/js/plupload.full.min.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
</head>
<body>

<ul id="filelist"></ul>
<br />

<div id="container">
    <a id="browse" href="javascript:;">[Browse...]</a>
    <a id="start-upload" href="javascript:;">[Start Upload]</a>
</div>

<br />
<pre id="console"></pre>

<script type="text/javascript">
    let token = $('meta[name="csrf-token"]').attr('content');
    let uploader = new plupload.Uploader({
        browse_button: 'browse',
        url: '{{ route('upload') }}' + '?_token=' + token,
        chunk_size: '1mb',
    });

    uploader.init();

    uploader.bind('FilesAdded', function(up, files) {
        let html = '';
        plupload.each(files, function(file) {
            html += '<li id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></li>';
        });
        document.getElementById('filelist').innerHTML += html;
    });

    uploader.bind('UploadProgress', function(up, file) {
        document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
    });

    uploader.bind('Error', function(up, err) {
        document.getElementById('console').innerHTML += "\nError #" + err.code + ": " + err.message;
    });

    document.getElementById('start-upload').onclick = function() {
        uploader.start();
    };
</script>


{{--Start variant two--}}
{{--<div id="app"></div>--}}
{{--<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>--}}
{{--End variant two--}}

</body>
</html>
