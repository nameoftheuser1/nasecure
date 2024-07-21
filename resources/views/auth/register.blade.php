<style>
    /* Updated styles for the login form container */
    body {
        display: flex;
        justify-content: center;

        height: 100vh;
        margin: 0;
        border-top: 50px solid blue;
        border-bottom: 50px solid blue;
    }

    .login-container {
        display: flex;
        background-color: #eeeeee;
        /* Light gray background */
        border-radius: 10px;
        overflow: hidden;
        width: 1000px;
        /* Adjust width as needed */
        margin-top: -1%
    }

    .login-image {
        flex: 1;
        /* Take up remaining space */
        background-image: url('{{ asset('images/NASECURE.png') }}');
        /* Adjust the path to your image */
        background-size: cover;
        background-position: center;
        border-radius: 10px 0 0 10px;
        /* Rounded corners on the left side */
    }

    .form-container {
        padding: 10px;
        /* Padding inside the form */
        width: 90%;
        /* Take up remaining width */
        max-width: 400px;
        /* Limit maximum width of the form */
    }

    label {
        display: block;
        text-align: center;
        margin-bottom: 8px;
        color: #000000;
        font-weight: bold;
    }

    input {
        width: 100%;
        padding: 5px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    button {
        width: 100%;
        padding: 5px;
        border: none;
        border-radius: 4px;
        background-color: #0352f1;
        /* Blue background color */
        color: #ffffff;
        /* White text color */
        cursor: pointer;
        margin-bottom: 10px;
    }

    button:hover {
        background-color: #0056b3;
        /* Darker blue on hover */
    }

    .login-link {
        text-align: center;
        color: #000000;
        text-decoration: none;
        display: block;
        font-size: 14px;
        margin-top: 10px;
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

            <form action="{{ route('register') }}" method="post">
                @csrf
                <label for="last_name">Last Name:</label>
                <input type="text" placeholder="Enter Last Name" id="last_name" name="last_name" value="{{ old('last_name') }}">
                @error('last_name')
                    <p class="error-message">{{ $message }}</p>
                @enderror

                <label for="first_name">First Name:</label>
                <input type="text" placeholder="Enter First Name" id="first_name" name="first_name" value="{{ old('first_name') }}">
                @error('first_name')
                    <p class="error-message">{{ $message }}</p>
                @enderror

                <label for="email">Email: (@my.cspc.edu.ph)</label>
                <input type="text" placeholder="Enter Email" id="email" name="email" value="{{ old('email') }}">
                @error('email')
                    <p class="error-message">{{ $message }}</p>
                @enderror

                <label for="contact">Contact Number:</label>
                <input type="text" placeholder="Enter Contact " id="contact" name="contact" value="{{ old('contact') }}">
                @error('contact')
                    <p class="error-message">{{ $message }}</p>
                @enderror

                <label for="password">Password:</label>
                <input type="password" placeholder="Enter Password" id="password" name="password">
                @error('password')
                    <p class="error-message">{{ $message }}</p>
                @enderror

                <label for="password_confirmation">Confirm Password:</label>
                <input type="password" placeholder="Enter Password" id="password_confirmation" name="password_confirmation">

                <button type="submit">Register</button>
                <a href="{{ route('login')}}" class="login-link">Already have an account? Login here.</a>
            </form>
        </div>
    </div>
</x-layout>

