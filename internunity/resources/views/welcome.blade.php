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
    <section id="internship-modal" class="hidden bg-black/75 fixed w-full h-full flex justify-center items-center z-10">
        <div class="internship bg-white w-1/2 p-3 rounded-md relative">
            <div class="actions absolute right-5 flex gap-2 text-xs">
                <button class="bg-base-alt px-2 py-1 text-white rounded-md">
                    <i class="fa-solid fa-heart text-black"></i>
                </button>
                <button class="notify bg-red-500 text-white px-2 py-1 rounded-md">
                    <i class="fa-solid fa-flag"></i>
                </button>
            </div>
            <h1 class="font-bold text-xl">Laravel Developer Internship</h1>
            <p class="text-xs italic opacity-75">Posted 5 years ago</p>
            <p class="text-sm mt-3 border-b border-grey pb-3">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Eum aperiam sequi hic? Tempore perferendis, maxime voluptas amet perspiciatis corporis praesentium excepturi necessitatibus enim eaque, deleniti hic? Numquam, nisi aperiam. Culpa sed autem, possimus in natus nihil eos esse! Ducimus impedit dignissimos aliquam harum. Eum nisi illo rem adipisci ea sit.</p>
            <p class="stipend text-sm">Stipend: 15,000 PKR</p>
            <p class="skills mt-3">
                <span class="tag bg-base-alt text-black text-xs rounded-full p-2">HTML</span>
                <span class="tag bg-base-alt text-black text-xs rounded-full p-2">CSS</span>
                <span class="tag bg-base-alt text-black text-xs rounded-full p-2">JAVASCRIPT</span>
            </p>
            <div class="actions">
                <button class="bg-blue-500 text-white px-3 py-1 rounded-md mt-5 text-xs">Apply</button>
                <button class="bg-red-500 text-white px-3 py-1 rounded-md mt-5 text-xs">Cancel</button>
            </div>
        </div>
    </section>
    <header class="bg-base text-white py-4">
        <div class="container mx-auto w-2/3 flex justify-between items-center">
            <div class="logo">
                <h1 class="text-3xl font-bold">Internunity</h1>
            </div>
            <nav>
                <ul class="flex items-center space-x-2">
                    <li class="bg-shade px-3 rounded py-1 text-black"><a href="/index.html">Apply</a></li>
                    <li class="hover:bg-shade hover:text-black px-3 py-1 rounded"><a href="/internships.html">Internships</a></li>
                    <li class="hover:bg-shade hover:text-black px-3 py-1 rounded"><a href="/profile.html">Profile</a></li>
                    <li class="hover:bg-shade hover:text-black px-3 py-1 rounded"><a href="#">Companies</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div id="app"></div>
    @vite('resources/js/app.js')

</body>
</html>

