<head>

    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- favicons Icons -->

    <link rel="icon" type="image/png" sizes="32x32" href="/client/images/content/favicon-32x32.png.pagespeed.ce.bpuIxdoP_r.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="/client/images/content/favicon-16x16.png.pagespeed.ce.Pt-mjAmy9c.png" />

    <meta name="description" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&amp;display=swap" rel="stylesheet">

    <!-- template styles -->
    <link rel="stylesheet" href="/client/css/design.css?v={{ time() }}" />
    <!-- Site Title -->
    <title>{{ getTranslation('Site Title') }}</title>

    @stack('seo')

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/client/images/content/favicon-16x16.png.pagespeed.ce.Pt-mjAmy9c.png">
    @stack('css')
</head>
