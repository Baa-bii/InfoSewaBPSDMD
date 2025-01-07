<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link rel="icon" href="{{ asset('assets/logo-bpsdmd.png') }}?v=2" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
    <section class="bg-red-400 bg-center backdrop-blur-md" style="background-image: url('assets/bg.png')">
        <div class="flex flex-row items-center justify-end mx-auto h-screen lg:py-0">
            <div class="bg-white p-6 h-screen w-2/6 flex flex-col justify-center">
                <div class="flex justify-center items-center">
                    <img class="w-24 h-24 mr-2 p-2" src="/assets/logo-bpsdmd.png" alt="logo">   
                </div>
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-md text-center font-medium leading-tight tracking-tight text-gray-800" >
                        Silahkan Log in terlebih dahulu
                    </h1>
                    <form class="space-y-4 md:space-y-4" action="{{ route('auth.verify') }}" method="POST">
                        @csrf
                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-black dark:text-white">Email</label>
                            <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@email.com" required>
                        </div>
                        <div>
                            <label for="password" class="block mb-2 text-sm font-medium text-black dark:text-white">Password</label>
                            <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-start">
                        </div>
                        <button type="submit" class="w-full text-white bg-blue-600 hover:bg-blue-800 ease-out duration-300 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">Log in</button> 
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>
</html>