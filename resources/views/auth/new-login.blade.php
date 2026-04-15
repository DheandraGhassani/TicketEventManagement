<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
  <style>
      body {
          background: #f4f6f9;
          height: 100vh;
      }
      .login-container {
          height: 100vh;
      }
      .toggle-password {
          cursor: pointer;
      }
  </style>
</head>
<body>

<div class="container login-container d-flex justify-content-center align-items-center">
  <div class="col-md-4">
    <div class="card login-card p-4">
      <div class="text-center mb-4">
        <h4 class="login-title">Login Form</h4>
      </div>
      <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input id="email" name="email" type="email" class="form-control" placeholder="Input email" required autofocus value="{{ old('email') }}">
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <div class="input-group">
            <input type="password" id="password" name="password" class="form-control" placeholder="Input password" required>
            <span class="input-group-text toggle-password" onclick="togglePassword()"><i class="bi bi-eye" id="icon"></i></span>
          </div>
        </div>
        <div class="d-grid">
          <button type="submit" class="btn btn-primary">Login</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  function togglePassword() {
    const password = document.getElementById("password");
    const icon = document.getElementById("icon");

    if (password.type === "password") {
      password.type = "text";
      icon.classList.remove("bi-eye");
      icon.classList.add("bi-eye-slash");
    } else {
      password.type = "password";
      icon.classList.remove("bi-eye-slash");
      icon.classList.add("bi-eye");
    }
  }
</script>

</body>
</html>