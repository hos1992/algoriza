<!DOCTYPE html>
{{-- <html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl"> --}}
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl" class="sc-theme-a">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    <link rel="apple-touch-icon" sizes="180x180" href="/dashboard/assets/img/fav/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/dashboard/assets/img/fav/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/dashboard/assets/img/fav/favicon-16x16.png">
    <link rel="mask-icon" href="/dashboard/assets/img/fav/safari-pinned-tab.svg" color="#5bbad5">

    <link rel="manifest" href="/dashboard/manifest.json">
    <meta name="theme-color" content="#00838f">
    <link href="https://fonts.googleapis.com/css2?family=Almarai" rel="stylesheet">

    <style>
        * {
            font-family: "Almarai", sans-serif !important;
        }
    </style>

    <!-- polyfills -->
    <script src="/dashboard/assets/js/vendor/polyfills.min.js" defer></script>

    <!-- UIKit js -->
    <script src="/dashboard/assets/js/uikit.min.js" defer></script>

    <!-- async assets-->
    <script src="/dashboard/assets/js/vendor/loadjs.min.js" defer></script>
    <script>
        window.onload = (event) => {
            var html = document.getElementsByTagName('html')[0];
            // ----------- CSS
            // md icons
            loadjs('/dashboard/assets/css/materialdesignicons.min.css', {
                preload: true
            });
            // UIkit
            loadjs('/dashboard/node_modules/uikit/dist/css/uikit-rtl.min.css', {
                preload: true
            });

            @if (url()->current() == route('admin.login'))
                loadjs(['/dashboard/assets/css/login_page.min.css'], function() {});
            @endif
            // themes
            loadjs('/dashboard/assets/css/themes/themes_combined.min.css', {
                preload: true
            });
            // mdi icons (base64) & google fonts (base64)
            loadjs([
                '/dashboard/assets/css/fonts/mdi_fonts.css',
                '/dashboard/assets/css/fonts/roboto_base64.css',
                '/dashboard/assets/css/fonts/sourceCodePro_base64.css'
            ], {
                preload: true
            });
            // main stylesheet
            loadjs(['/dashboard/assets/css/main-rtl.min.css'], function() {});
            // vendor
            loadjs('/dashboard/assets/js/vendor.min.js', function() {
                // scutum common functions/helpers
                loadjs('/dashboard/assets/js/scutum_common.min.js', function() {
                    scutum.init();
                    loadjs('/dashboard/assets/js/views/dashboard/dashboard_v1.min.js', {
                        success: function() {
                            $(function() {
                                scutum.dashboard.init()
                            });
                        }
                    });
                    loadjs('/dashboard/assets/js/views/forms/forms-regular.min.js', {
                        success: function() {
                            $(function() {
                                scutum.forms.regular.init()
                            });
                        }
                    });
                    // loadjs('/dashboard/assets/js/views/forms/forms.js', {
                    //     success: function () {
                    //         $(function () {
                    //             scutum.forms.controls.init()
                    //         });
                    //     }
                    // });
                    // modals
                    loadjs('/dashboard/assets/js/views/components/modals_dialogs.min.js', {
                        success: function() {
                            $(function() {
                                scutum.components.modalsDialogs.init()
                            });
                        }
                    });
                    // style switcher
                    // loadjs([
                    //     '/dashboard/assets/js/style_switcher.min.js',
                    //     '/dashboard/assets/css/plugins/style_switcher.min.css'
                    // ], {
                    //     success: function () {
                    //         $(function () {
                    //             scutum.styleSwitcher();
                    //         });
                    //     }
                    // });
                    // show page
                    setTimeout(function() {
                        // clear styles (FOUC)
                        $(html).css({
                            'backgroundColor': '',
                        });
                        $('body').css({
                            'visibility': '',
                            'overflow': '',
                            'apacity': '',
                            'maxHeight': ''
                        });

                        document.getElementById('main-loader').style.display = 'none';

                    }, 100);


                });
            });

        };
    </script>


    <!-- Scripts -->
    @routes
    @vite('resources/js/app.js')
    @inertiaHead
</head>

<body class="font-sans antialiased">
    <div id="main-loader" style="text-align: center; margin-top: 50px">
        جارى التحميل...
    </div>
    <script>
        // prevent FOUC
        var html = document.getElementsByTagName('html')[0];
        html.style.backgroundColor = '#f5f5f5';
        document.body.style.visibility = 'hidden';
        document.body.style.overflow = 'hidden';
        document.body.style.apacity = '0';
        document.body.style.maxHeight = "100%";

        document.getElementById('main-loader').style.visibility = 'visible';
    </script>

    @inertia


</body>

</html>
