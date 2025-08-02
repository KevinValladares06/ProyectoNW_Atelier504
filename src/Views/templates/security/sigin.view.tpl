<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Crear Cuenta</title>
  <link rel="stylesheet" href="public/css/login.css">
  <link rel="stylesheet" href="{{BASE_DIR}}/public/css/appstyle.css" />
</head>
<body>
  <section class="login-container">
    <div class="login-wrapper">
      
      <div class="login-image-section">
        <div class="overlay"></div>
      </div>

      <div class="login-form-section">
        <form method="post" action="index.php?page=sec_register">
          <h2 class="login-title">Crear Cuenta</h2>

          <div class="input-group">
            <label for="txtEmail" class="sr-only">Correo Electrónico</label>
            <input type="email" id="txtEmail" name="txtEmail" placeholder="Correo electrónico" value="{{txtEmail}}" required />
            {{if errorEmail}}<div class="error-msg">{{errorEmail}}</div>{{endif errorEmail}}
          </div>

          <div class="input-group">
            <label for="txtPswd" class="sr-only">Contraseña</label>
            <input type="password" id="txtPswd" name="txtPswd" placeholder="Contraseña" value="{{txtPswd}}" required />
            {{if errorPswd}}<div class="error-msg">{{errorPswd}}</div>{{endif errorPswd}}
          </div>

          {{if generalError}}<div class="error-msg general">{{generalError}}</div>{{endif generalError}}

          <div class="form-footer">
            <button type="submit" id="btnSignin" class="login-btn">REGISTRARSE →</button>
          </div>

          <p class="signup-msg">¿Ya tienes una cuenta? Inicia sesión <a href="index.php?page=Sec_Login">¡Aquí!</a></p>
        </form>
      </div>
    </div>
  </section>
</body>
</html>