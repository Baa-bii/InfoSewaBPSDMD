<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create User</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <link rel="icon" href="{{ asset('assets/logo-bpsdmd.png') }}?v=2" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
</head>
<body>
    <x-header></x-header>
    <x-sidebar></x-sidebar>
    <main class="p-16 md:ml-64 h-auto pt-20">
        <form action="{{ route('sup-admin.user.store') }}" method="POST" onsubmit="return validateForm()">
            @csrf
            <div>
                <h2 class="text-xl font-bold mb-4">Tambahkan User</h2>
        
                <!-- Nama User -->
                <label for="name" class="block text-sm font-medium mb-2">Nama User</label>
                <input id="name" name="name" type="text" class="w-full p-2 border rounded-md mb-4" placeholder="Nama User" required>
                @error('name')
                    <div class="text-red-500 text-sm mb-2">{{ $message }}</div>
                @enderror
        
                <!-- Email -->
                <label for="email" class="block text-sm font-medium mb-2">Email</label>
                <input id="email" name="email" type="email" class="w-full p-2 border rounded-md mb-4" placeholder="contoh@domain.com" required>
                @error('email')
                    <div class="text-red-500 text-sm mb-2">{{ $message }}</div>
                @enderror
        
                <!-- Password -->
                <label for="password" class="block text-sm font-medium mb-2">Password</label>
                <input id="password" name="password" type="password" autocomplete="off" class="w-full p-2 border rounded-md mb-4" placeholder="Password" required>
                @error('password')
                    <div class="text-red-500 text-sm mb-2">{{ $message }}</div>
                @enderror
        
                <!-- Confirm Password -->
                <label for="confirm_password" class="block text-sm font-medium mb-2">Confirm Password</label>
                <input id="confirm_password" name="confirm_password" type="password" class="w-full p-2 border rounded-md mb-4" placeholder="Confirm password" required>
        
                <!-- Role -->
                <label for="role" class="block text-sm font-medium mb-2">Role</label>
                <select id="role" name="role" class="w-full p-2 border rounded-md mb-4" required>
                    <option value="">Pilih Role</option>
                    <option value="admin">Admin</option>
                    <option value="sup-admin">Super-Admin</option>
                </select>
                @error('role')
                    <div class="text-red-500 text-sm mb-2">{{ $message }}</div>
                @enderror
        
                <!-- Action Buttons -->
                <div class="flex justify-end gap-2">
                    <button type="button" id="closeModal" class="px-4 py-2 bg-gray-300 rounded-md hover:bg-gray-400">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-700">Simpan</button>
                </div>
            </div>
        </form>
        
        <script>
            function validateForm() {
                const password = document.getElementById('password').value;
                const confirmPassword = document.getElementById('confirm_password').value;
        
                if (password !== confirmPassword) {
                    alert('Password dan Confirm Password tidak cocok.');
                    return false; // Prevent form submission
                }
                return true; // Allow form submission
            }
        
            document.getElementById('closeModal').addEventListener('click', () => {
                window.history.back();
            });
        </script>
        
        
    </main>
</body>
</html>