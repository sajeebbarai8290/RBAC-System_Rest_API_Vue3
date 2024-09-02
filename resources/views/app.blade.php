<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RBAC System</title>
    @vite('resources/js/app.js') <!-- Ensure this line includes your JavaScript -->
    <script type="text/javascript">
        window.vueSpatiePermissions = {!! auth()->check() ? auth()->user()->getRolesPermissionsAsJson() : 0 !!}
      </script>
</head>
<body>
    <div id="app"></div>
</body>
</html>
