<section class="container-l">
  <section class="depth-4 mb-4">
    <h1 style="font-size: 1.8rem; font-weight: bold; padding: 1rem 0;">🧾 Mi Carrito</h1>
  </section>

  <section class="grid">
    <!-- Encabezados -->
    <div class="row border-b py-3 px-4" style="font-weight: 600; background-color: #f5f5f5;">
      <span class="col-1">No.</span>
      <span class="col-4">Item</span>
      <span class="col-2 right">Precio</span>
      <span class="col-3 center">Cantidad</span>
      <span class="col-2 right">Subtotal</span>
    </div>

    <!-- Filas de productos -->
    {{foreach carretilla}}
    <div class="row border-b py-3 px-4" style="align-items: center;">
      <span class="col-1">{{row}}</span>

      <!-- Imagen + nombre del producto -->
      <span class="col-4 d-flex align-items-center gap-2">
        <img src="{{productImgUrl}}" alt="{{productName}}" style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px; margin-right: 10px;">
        {{productName}}
      </span>

      <span class="col-2 right">{{crrprc}}</span>

      <!-- Cantidad con botones -->
      <span class="col-3 center">
        <form action="index.php?page=checkout_checkout" method="post" class="qty-form d-flex justify-center align-items-center gap-2">
          <input type="hidden" name="productId" value="{{productId}}" />
          <button type="submit" name="removeOne" class="btn-icon danger">
            <i class="fa-solid fa-minus"></i> -
          </button>
          <span class="mx-2">{{crrctd}}</span>
          <button type="submit" name="addOne" class="btn-icon success">
            <i class="fa-solid fa-plus"></i> +
          </button>
        </form>
      </span>

      <span class="col-2 right">{{subtotal}}</span>
    </div>
    {{endfor carretilla}}

    <!-- Total -->
    <div class="row py-3 px-4" style="align-items: center; font-weight: bold; font-size: 1.2rem;">
      <span class="col-3 offset-7 center">Total</span>
      <span class="col-2 right">{{total}}</span>
    </div>

    <!-- Botón ordenar -->
    <div class="row px-4 py-4 justify-end">
      <form action="index.php?page=checkout_checkout" method="post">
        <button type="submit" class="btn-order">🛒 Ordenar</button>
      </form>
    </div>
  </section>
</section>

<style>
  .btn-order {
    background-color: #333;
    color: white;
    padding: 0.75rem 1.5rem;
    border: none;
    font-weight: bold;
    border-radius: 6px;
    transition: background 0.3s ease;
  }

  .btn-order:hover {
    background-color: #555;
  }

  .btn-icon {
    border: none;
    padding: 0.4rem 0.6rem;
    font-size: 0.85rem;
    display: flex;
    align-items: center;
    gap: 0.4rem;
    border-radius: 5px;
    font-weight: 500;
    cursor: pointer;
  }

  .btn-icon.success {
    background-color: #4CAF50;
    color: white;
  }

  .btn-icon.danger {
    background-color: #F44336;
    color: white;
  }

  .btn-icon:hover {
    opacity: 0.85;
  }

  .d-flex {
    display: flex;
  }

  .align-items-center {
    align-items: center;
  }

  .justify-center {
    justify-content: center;
  }

  .gap-2 {
    gap: 0.5rem;
  }

  @media (max-width: 768px) {
    .row span {
      font-size: 0.9rem;
    }

    img {
      display: none;
    }

    .btn-icon i {
      font-size: 0.9rem;
    }

    .btn-order {
      width: 100%;
    }
  }
</style>
