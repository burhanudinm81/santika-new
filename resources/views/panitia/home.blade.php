<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SANTIKA</title>

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    @include('required-css')
    @yield('page-style')
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        @include('panitia.navbar')
        @include('panitia.sidebar')

        <div class="content-wrapper">
            @yield('content-panitia')
        </div>

        <aside class="control-sidebar control-sidebar-dark">
            <div class="p-3">
                <h5>Title</h5>
                <p>Sidebar content</p>
            </div>
        </aside>

        @include('panitia.footer')

        <!-- Modal Pop Up Sukses -->
        <div class="modal" id="modal-popup-sukses" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <i class="mr-2 fas fa-2x fa-check-circle" style="color: green"></i>
                        <h5 class="modal-title">Modal Title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Modal body text goes here!</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Pop Up Error -->
        <div class="modal" id="modal-popup-error" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <i class="mr-2 fas fa-2x fa-exclamation-circle" style="color: red"></i>
                        <h5 class="modal-title">Modal Title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="background-color: #f8d7da; color: #721c24;"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="other-modal">
            @yield('modals')
        </div>
    </div>

    <!-- REQUIRED SCRIPTS -->
    @include('required-js')
    <script src="{{ asset('/custom-assets/js/seminar-proposal.js') }}"></script>
    <script src="{{ asset('/custom-assets/js/seminar-hasil.js') }}"></script>
    <script src={{ url('/custom/js/load-content.js') }}></script>
    <script src="{{ url('/custom/js/animate-custom-file-input.js') }}"></script>
    <script src="{{ url('/custom/js/profile/change-password.js') }}"></script>

    @yield('scripts-panitia')
</body>

</html>
