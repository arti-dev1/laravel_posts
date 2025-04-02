<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="card shadow" style="width: 400px;">
            <div class="card-body">
                <h3 class="text-center mb-4">Login</h3>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">Remember Me</label>
                    </div>
                    <button id="loginButton" type="button" class="btn btn-primary w-100">Login</button>
                </form>
               
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="b crossorigin="anonymous"></script>
    <script>
        $(document).ready(function(){
            $("#loginButton").on('click',function(){
                var email = $("#email").val();  
                var password = $("#password").val(); 
                $.ajax({
                    url : '/api/login',
                    type : 'POST',
                    contentType : 'application/json',
                    data: JSON.stringify({
                        email : email,
                        password : password
                    }),
                    success: function(response){
                        console.log(response);
                        localStorage.setItem('api_token',response.token);
                        window.location.href="/allposts";
                    },
                    error: function(xhr, status, error){
                        alert('Error:' + error);
                    }
                });
            })
        });
    </script>
</body>
</html>