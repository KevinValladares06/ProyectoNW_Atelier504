<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="public/css/login.css">
  <link rel="stylesheet" href="{{BASE_DIR}}/public/css/appstyle.css" />
</head>
<body>
  <section class="login-container">
  <div class="login-wrapper">
    <!-- Imagen lateral -->
    <div class="login-image-section">
      <div class="overlay">
        
      </div>
    </div>

    
    <div class="login-form-section">
      <form method="post" action="index.php?page=sec_login{{if redirto}}&redirto={{redirto}}{{endif redirto}}">
        <h2 class="login-title">Inicia Sesión</h2>

        <div class="input-group">
          <label for="txtEmail" class="sr-only">Correo Electrónico</label>
          <input type="email" id="txtEmail" name="txtEmail" placeholder="username" value="{{txtEmail}}" required />
          {{if errorEmail}}<div class="error-msg">{{errorEmail}}</div>{{endif errorEmail}}
        </div>

        <div class="input-group">
          <label for="txtPswd" class="sr-only">Contraseña</label>
          <input type="password" id="txtPswd" name="txtPswd" placeholder="password" value="{{txtPswd}}" required />
          {{if errorPswd}}<div class="error-msg">{{errorPswd}}</div>{{endif errorPswd}}
        </div>

        {{if generalError}}<div class="error-msg general">{{generalError}}</div>{{endif generalError}}

        <div class="form-footer">
          
          <button type="submit" id="btnLogin" class="login-btn">LOGIN →</button>
        </div>

        <p class="signup-msg">¿No tienes una cuenta?, Crea tu cuenta <a href="index.php?page=Sec_Register">¡Aquí!</a></p>
      </form>
    </div>
  </div>
</section>

</body>
</html>