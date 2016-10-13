<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="_token" content="{!! csrf_token() !!}"/>
    <title>Guest Book</title>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>

    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>

    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">

    <link href="/css/fileinput.css" rel="stylesheet">
    <script src="/js/plugins/canvas-to-blob.js"></script>
    <script src="/js/fileinput.js"></script>

    <link href="/css/animate.css" rel="stylesheet">

</head>
<body>
<div class="container-fluid" style="margin-top: 10px">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Guest book</div>
                <div class="panel-body">
                    <button class="add-message add-msg btn btn-default">
                        Add new message
                    </button>
                    <p></p>
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form role="form" class="hidden" enctype="multipart/form-data" method="POST" action="{{ url('/') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            <label>Name</label>
                                <input type="text" id="name-form" class="form-control" name="name" value="{{ old('name') }}">
                        </div>

                        <div class="form-group">
                            <label>E-Mail Address</label>
                                <input type="email" id="email-form" class="form-control" name="email" value="{{ old('email') }}">
                        </div>

                        <div class="form-group">
                            <label>Homepage</label>
                            <input type="link" id="homepage-form" class="form-control" name="homepage" value="{{ old('homepage') }}">
                        </div>

                        <div class="form-group captcha-form">
                            {!! app('captcha')->display()!!}
                        </div>

                        <div class="form-group">
                            <label>Message</label>
                                <textarea id = "text-form" name='text'>

                                </textarea>
                        </div>

                        <div class="form-group boot-file-input">
                        <input id="input-file" name="input-file" type="file" class="file-loading" accept="image/*">
                        </div>

                        <div class="form-group">
                                <button type="submit" class="btn send btn-primary">
                                    Send
                                </button>
                        </div>
                    </form>
                        <table id="example" class="display" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>E-mail</th>
                                <th>Date</th>
                                <th>Homepage</th>
                                <th>Text</th>
                                <th>IP</th>
                                <th>Browser</th>
                                <th></th>
                                <th class="hidden"></th>
                            </tr>
                            </thead>
                            <tbody class="tableBody">
                            @foreach($messages as $message)
                                <tr>
                                    <td id = "name">
                                        {!! $message->name !!}
                                    </td>
                                    <td id="email">
                                        {!! $message->email !!}
                                    </td>
                                    <td>
                                        {!! $message->created_at !!}
                                    </td>
                                    <td id="homepage">
                                        {!! $message->homepage !!}
                                    </td>
                                    <td id="text">
                                        {!! $message->text !!}
                                    </td>
                                    <td>
                                        {!! $message->IP !!}
                                    </td>
                                    <td>
                                        {!! $message->browser !!}
                                    </td>
                                    <td>
                                        <button class="btn btn-success">
                                            Preview
                                        </button>
                                    </td>
                                    <td class="hidden file-name" data-extension = "{!!pathinfo($message->file ,PATHINFO_EXTENSION)!!}" data-file="{!! $message->file !!}">
                                        {!!url('/').'/uploads/'.$message->file !!}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

<script type="text/javascript">
    $.ajaxSetup({
        headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
    });
</script>

<script>

    $(document).ready(function() {
//add new
        $(".add-message").click(function(){
            $("form").removeClass('hidden');
            $('.send').removeClass('hidden');
            $('.add-msg').addClass('hidden');
            $('form').addClass('animated slideInDown');
            $('.captcha-form').removeClass('hidden');

            $('#name-form').val('');
            $('#email-form').val('');
            $('#homepage-form').val('');

            $('.boot-file-input').empty();
            var htmlInputFile = '<input id="input-file" name="input-file" type="file" class="file-loading" accept="image/*">';
            $('.boot-file-input').html(htmlInputFile);

            tinymce.activeEditor.setContent('');

            $("#input-file").fileinput({
                allowedFileExtensions: ["jpg", "png", "gif", "txt"],
                maxImageWidth: 320,
                maxImageHeight: 240,
                resizePreference: 'width',
                maxFileCount: 1,
                resizeImage: true,
                'showUpload': false
                //      maxFileSize: 100
            }).on('filepreupload', function() {
                $('#kv-success-box').html('');
            }).on('fileuploaded', function(event, data) {
                $('#kv-success-box').append(data.response.link);
                $('#kv-success-modal').modal('show');
            });
        });

        tinymce.init({
            selector: "textarea",
            height: 100,
            plugins: [
                "link"
            ],
            toolbar1: "bold italic strikethrough link unlink",

            menubar: false,
            toolbar_items_size: 'small'
        });

        $('#example').dataTable( {
            "pageLength": 25,
            "order": [[ 2, "desc" ]],
            "bFilter": false
        } );

        //view
        $('.tableBody').on('click', '.btn-success', function (event) {
            row = $(this).closest('tr');
            $('form').addClass('animated slideInDown');
            $("form").removeClass('hidden');
            $('.add-msg').removeClass('hidden');
            $('.captcha-form').addClass('hidden');
            $('body,html').animate({scrollTop: 0}, 400);

            $('#name-form').val($.trim(row.find('#name').text()));
            $('#email-form').val($.trim(row.find('#email').text()));
            $('#homepage-form').val($.trim(row.find('#homepage').text()));
            tinymce.activeEditor.setContent($.trim(row.find('#text').text()));

            $('.send').addClass('hidden');
            $('.boot-file-input').empty();
            var htmlInputFile = '<input id="input-file" name="input-file" type="file" class="file-loading" accept="image/*">';
            $('.boot-file-input').html(htmlInputFile);

            if(row.find('.file-name').data('file'))
            {
                var extension = row.find('.file-name').data('extension');
                if (extension == 'txt') {
                    $.ajax({
                        type: "POST",
                        url: '/' + 'url',
                        data: {url: $.trim(row.find('.file-name').text())},
                        success: function (response) {
                            fileObj = "\"" + response + "\"";
                            $("#input-file").fileinput({
                                uploadAsync: false,
                                allowedFileExtensions: ["jpg", "png", "gif", "txt"],
                                overwriteInitial: false,
                                initialPreview: [
                                    fileObj
                                ],
                                initialPreviewAsData: true, // defaults markup
                                initialPreviewFileType: 'text',
                                showUpload: false,

                            });
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            console.log(JSON.stringify(jqXHR));
                            console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
                        }
                    });
                }
                else {
                    $("#input-file").fileinput({
                        uploadAsync: false,
                        allowedFileExtensions: ["jpg", "png", "gif", "txt"],
                        overwriteInitial: false,
                        initialPreview: [
                            $.trim(row.find('.file-name').text())
                        ],
                        initialPreviewAsData: true,
                        showUpload: false,

                    });
                }
            }
        });
    } );
</script>