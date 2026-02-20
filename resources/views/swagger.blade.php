<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="description" content="SwaggerIU"/>
    <title>SwaggerUI</title>
    <link rel="stylesheet" href="/swagger-assets/swagger.css"/>
    @if(!empty(session()->get('admin-theme')) && session()->get('admin-theme') === 'dark')
        <link rel="stylesheet" href="/swagger-assets/swagger-dark.css"/>
    @endif
</head>
<body>
<div id="swagger-ui"></div>
<script src="/swagger-assets/swagger.js" crossorigin></script>
<script>
    window.onload = () => {
        window.ui = SwaggerUIBundle({
            url: "/swagger/openapi.yaml",
            dom_id: '#swagger-ui',
        });
    };

    // if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
    //     let cssLink = document.createElement("link");
    //     cssLink.rel = "stylesheet";
    //     cssLink.href = "/swagger-assets/swagger-dark.css";
    //
    //     document.head.appendChild(cssLink);
    // }
</script>
</body>
</html>
