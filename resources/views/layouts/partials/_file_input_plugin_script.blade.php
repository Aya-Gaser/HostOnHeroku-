{{-- File input

    <script>
        $(".file").fileinput({
            showUpload: false,
            dropZoneEnabled: false,
            //allowedFileExtensions: ['pdf', 'doc', 'docx', 'xls', 'xlsx'],
            maxFileSize: 5120000000,
            maxFileCount: 50,
        });
    </script>--}}

{{--
<script src="{{asset('assets/revolutionary-fileuploader/jquery.fileuploader.min.js')}}"
        type="text/javascript"></script>
<script src="{{asset('assets/revolutionary-fileuploader/custom.js')}}" type="text/javascript"></script>
--}}

<script src="{{asset('/assets/bootstrap-fileinput/js/plugins/piexif.js')}}" type="text/javascript"></script>
<script src="{{asset('/assets/bootstrap-fileinput/js/plugins/sortable.js')}}" type="text/javascript"></script>
<script src="{{asset('/assets/bootstrap-fileinput/js/fileinput.js')}}" type="text/javascript"></script>
<script src="{{asset('/assets/bootstrap-fileinput/themes/fas/theme.js')}}" type="text/javascript"></script>
<script src="{{asset('/assets/bootstrap-fileinput/themes/explorer-fas/theme.js')}}"
        type="text/javascript"></script>
<script>
    $(document).ready(function () {
        $(".kv-explorer").fileinput({
            'theme': 'explorer-fas',
            overwriteInitial: false,
            initialPreviewAsData: true,
            showUpload: false,
            showRemove: true,
            dropZoneEnabled: false,
            maxFileSize: 5120,
            maxFileCount: 10,
            uploadUrl: '#',
        });
    });
</script>
