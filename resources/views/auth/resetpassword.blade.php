<x-layout>
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-gray-100 p-8 rounded shadow-md w-full max-w-md">
            <h2 class="text-2xl font-bold mb-6 text-center">Password Reset Guide</h2>
            <p class="mb-4">If you need to reset your password, please follow these steps:</p>
            <ol class="list-decimal list-inside mb-4 space-y-2">
                <li>Contact your administrator and request a password reset URL.</li>
                <li>Once you receive the URL, click on it to open the password reset page.</li>
                <li>Follow the instructions on the password reset page to create a new password.</li>
                <li>After successfully resetting your password, you can log in with your new credentials.</li>
            </ol>
            <p class="text-sm text-gray-600 mb-4">For security reasons, the password reset URL can only be provided by an
                admin. Please ensure you keep your new password secure and do not share it with anyone.</p>
            <div class="flex justify-center">
                <a href="/login" class="text-indigo-600 hover:text-indigo-800 font-medium">Back to Login</a>
            </div>
        </div>
    </div>
</x-layout>
