<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Swagger UI</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/swagger-ui-dist@4.19.0/swagger-ui.css">

    <style>
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
        }
        #swagger-ui {
            height: 100%;
        }
    </style>
</head>
<body>
<div id="swagger-ui"></div>
<script src="https://cdn.jsdelivr.net/npm/swagger-ui-dist@4.19.0/swagger-ui-bundle.js"></script>
<script>
    window.onload = function() {
        SwaggerUIBundle({
            url: "/swagger.json",
            dom_id: '#swagger-ui',
            presets: [
                SwaggerUIBundle.presets.apis,
                SwaggerUIBundle.SwaggerUIStandalonePreset
            ],
            layout: "BaseLayout"
        })
    }
</script>
</body>
</html>
