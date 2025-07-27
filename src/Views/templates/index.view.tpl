<h1>{{SITE_TITLE}}</h1>


<div class="product-list">
  {{foreach products}}
  <div class="product" data-productId="{{productId}}">
    <img src="{{productImgUrl}}" alt="{{productName}}">
    <h2>{{productName}}</h2>
    <p>{{productDescription}}</p>
    <span class="price">{{productPrice}}</span>
    <span class="stock">Disponible {{productStock}}</span>
    <form action="index.php?page=index" method="post">
        <input type="hidden" name="productId" value="{{productId}}">
        <button type="submit" name="addToCart" class="add-to-cart">
          <i class="fa-solid fa-cart-plus"></i>Agregar al Carrito
        </button>
    </form>
  </div>
  {{endfor products}}
</div>