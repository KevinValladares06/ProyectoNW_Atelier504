<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="/public/css/products.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

  <section class="hero">
    <div class="hero-content">
      <h1>Bienvenido a {{SITE_TITLE}}</h1>
      <p>Descubre nuestros mejores productos y ofertas especiales</p>
      <a href="#productos" class="btn-hero">Ver Productos</a>
    </div>
  </section>

  <section class="benefits">
    <div class="benefit">
      <i class="fa-solid fa-truck-fast"></i>
      <h3>Envío Rápido</h3>
      <p>Entregamos tus pedidos en tiempo récord</p>
    </div>
    <div class="benefit">
      <i class="fa-solid fa-shield-halved"></i>
      <h3>Compra Segura</h3>
      <p>Transacciones protegidas y seguras</p>
    </div>
    <div class="benefit">
      <i class="fa-solid fa-thumbs-up"></i>
      <h3>Productos de Calidad</h3>
      <p>Solo lo mejor para nuestros clientes</p>
    </div>
  </section>

  <section class="filosofia">
    <div class="filosofia-content">
      <div class="texto">
        <h2>Nuestra Filosofía</h2>
        <p>Creemos que la ropa es una extensión de tu identidad. Por eso, diseñamos cada prenda con pasión, autenticidad y propósito. Nuestro compromiso va más allá de la moda: buscamos inspirarte a expresarte libremente.</p>
        <ul>
          <li><i class="fas fa-check-circle"></i> Diseño con propósito</li>
          <li><i class="fas fa-check-circle"></i> Producción ética</li>
          <li><i class="fas fa-check-circle"></i> Comunidad y conexión</li>
        </ul>
      </div>
      <div class="imagen">
        <img src="public/imgs/imgconocenos1.png" alt="Nuestra filosofía">
      </div>
    </div>
  </section>

  <section class="pasos-compra">
    <h2>Comprar Nunca Fue Tan Fácil</h2>
    <div class="timeline">
      <div class="step">
        <div class="icon"><i class="fas fa-search"></i></div>
        <h3>Explorá</h3>
        <p>Encontrá prendas que vayan con tu estilo único.</p>
      </div>
      <div class="step">
        <div class="icon"><i class="fas fa-shopping-cart"></i></div>
        <h3>Comprá</h3>
        <p>Realizá tu pedido de forma segura y rápida.</p>
      </div>
      <div class="step">
        <div class="icon"><i class="fas fa-truck"></i></div>
        <h3>Recibilo</h3>
        <p>Disfrutá de tu compra sin moverte de casa.</p>
      </div>
    </div>
  </section>

  <section class="compra-facil">
    <div class="container-compra">
      <div class="compra-texto">
        <h2>¿Cómo comprar?</h2>
        <ol class="pasos-compra">
          <li>
            <span class="numero-paso">1</span>
            <div>
              <h4>Explora nuestros productos</h4>
              <p>Revisa las categorías y descubre lo que necesitas para tu mascota.</p>
            </div>
          </li>
          <li>
            <span class="numero-paso">2</span>
            <div>
              <h4>Agrega al carrito</h4>
              <p>Selecciona la cantidad y los productos que deseas llevar.</p>
            </div>
          </li>
          <li>
            <span class="numero-paso">3</span>
            <div>
              <h4>Confirma tu pedido</h4>
              <p>Revisa tus datos y finaliza la compra de forma rápida y segura.</p>
            </div>
          </li>
        </ol>
      </div>
      <div class="compra-img">
        <img src="public/imgs/imgcompras1.png" alt="Compra fácil en Petlove">
      </div>
    </div>
  </section>

  <h2 id="productos" class="section-products">Productos</h2>

  <div class="product-list">
    {{foreach products}}
    <div class="product" data-productId="{{productId}}">
      <img src="{{productImgUrl}}" alt="{{productName}}" class="product-image">
      <div class="product-content">
        <h2 class="product-title">{{productName}}</h2>
        <p class="product-description">{{productDescription}}</p>
        <span class="product-price">Lps. {{productPrice}}</span>
        <span class="product-stock">Disponible {{productStock}}</span>
        <form action="index.php?page=index" method="post">
          <input type="hidden" name="productId" value="{{productId}}">
          <button type="submit" name="addToCart" class="add-to-cart-btn">
            <i class="fa-solid fa-cart-plus"></i>Agregar al Carrito
          </button>
        </form>
      </div>
    </div>
    {{endfor products}}
  </div>

</body>
</html>
