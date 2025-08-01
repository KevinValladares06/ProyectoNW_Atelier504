<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{SITE_TITLE}}</title>
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{BASE_DIR}}/public/css/appstyle.css" />
  <script src="https://kit.fontawesome.com/{{FONT_AWESOME_KIT}}.js" crossorigin="anonymous"></script>
  {{foreach SiteLinks}}
    <link rel="stylesheet" href="{{~BASE_DIR}}/{{this}}" />
  {{endfor SiteLinks}}
  {{foreach BeginScripts}}
    <script src="{{~BASE_DIR}}/{{this}}"></script>
  {{endfor BeginScripts}}
</head>
<body>
  <header>
    <input type="checkbox" class="menu_toggle" id="menu_toggle" />
    <label for="menu_toggle" class="menu_toggle_icon" >
      <div class="hmb dgn pt-1"></div>
      <div class="hmb hrz"></div>
      <div class="hmb dgn pt-2"></div>
    </label>
    
      <div class="brand">
        <h1>{{SITE_TITLE}}</h1>
        <div class="logo">
        <img src="{{BASE_DIR}}/public/imgs/logoatelier1.png" alt="Atelier 504 Logo">
        </div>
        
    </div>


    <nav id="menu">
      <ul>
        <li><a href="index.php?page={{PUBLIC_DEFAULT_CONTROLLER}}"><i class="fas fa-home"></i>&nbsp;Inicio</a></li>
        {{foreach PUBLIC_NAVIGATION}}
            <li><a href="{{nav_url}}">{{nav_label}}</a></li>
        {{endfor PUBLIC_NAVIGATION}}
      </ul>
    </nav>
    <a href="index.php?page=checkout_checkout" class="cart-button">
      <i class="fas fa-shopping-cart"></i>
      <span class="cart-count">{{CART_ITEMS}}</span>
    </a>
    <!--<span>{{if ~CART_ITEMS}}{{~CART_ITEMS}}{{endif ~CART_ITEMS}}</span>-->
  </header>
  <main>
  {{{page_content}}}
  </main>
  <footer>
    <div class="footer-content">
        <p>Todos los Derechos Reservados 2025</p>
        <a href="index.php?page=AcercaDeNosotros">Acerca de Nosotros</a>
        <a href="index.php?page=Contactanos">Contáctanos</a>
    </div>
</footer>
  {{foreach EndScripts}}
    <script src="{{~BASE_DIR}}/{{this}}"></script>
  {{endfor EndScripts}}
</body>
</html>