<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Internunity | Home</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
    />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Angkor&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/style.css">
    <script src="https://kit.fontawesome.com/3a7e8b6e65.js" crossorigin="anonymous"></script>


    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'base': '#053440',
                        'shade': 'white',
                        'base-alt': '#F1B434',
                        'grey': '#e9f0ea'
                    }
                }
            }
        }
     </script>

     @vite('resources/css/app.css')
</head>
<body>


    <div id="app"></div>
    @vite('resources/js/app.js')

</body>
</html>

