<style>
    body {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background-color: #ffffff;
        border-top: 50px solid blue;
        border-bottom: 50px solid blue;
    }

    .login-container {
        display: flex;
        background-color: #EEEEEE;
        border-radius: 10px;
        overflow: hidden;
        width: 800px;
    }

    .login-image {
        flex: 1;
        background-image: url('{{ asset('images/NASECURE.png') }}');
        background-size: cover;
        background-position: center;
    }

    .form-container {
        flex: 1;
        padding: 20px;
    }

    h2 {
        text-align: center;
        font-size: 30px;
        color: #000000;
        font-weight: bold;
    }

    label {
        display: block;
        text-align: center;
        margin-bottom: 8px;
        color: #000000;
        font-weight: bold;
    }

    input {
        width: calc(100% - 16px);
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    button {
        width: 100%;
        padding: 12px;
        border: none;
        border-radius: 4px;
        background-color: #0352f1;
        color: #ffffff;
        cursor: pointer;
        margin-bottom: 10px;
    }

    button:hover {
        background-color: #0056b3;
    }

    .login-link {
        text-align: center;
        color: #000000;
        text-decoration: none;
        display: block;
        font-size: 14px;
        margin-top: 2px;
        margin-bottom: 9px;
        font-weight: bold;
    }

    .login-link:hover {
        text-decoration: underline;
    }

    .error-message {
        color: red;
        font-size: 14px;
        margin-top: 5px;
    }
</style>
<x-layout>
    <div class="login-container">
        <div class="login-image"></div>
        <div class="form-container">
            <form action="{{ route('login') }}" method="post">
                @csrf
                @error('failed')
                    <p class="error-message"> {{ $message }}</p>
                @enderror
                <label for="email">Email (@my.cspc.edu.ph)</label>
                <input type="text" placeholder="Enter Email" value="{{ old('email') }}" id="email" name="email">
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
                <label for="password">Password</label>
                <input type="password" placeholder="Enter Password" id="password" name="password">
                @error('password')
                    <div class="error-message">{{ $message }}</div>
                @enderror
                <button type="submit">Log In</button>
                <a href="#" class="login-link">Reset Password</a>
                <a href="{{ route('register') }}" class="login-link">Don't have an account? Register here.</a>
            </form>
        </div>
    </div>
</x-layout>
