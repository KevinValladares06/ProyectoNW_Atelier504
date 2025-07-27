<section class="container-l">
<section class="depth-4">
  <h1>Checkout</h1>
</section>
<section class="grid">
  <div class="row border-b" style="padding: 0.5rem 1rem;align-items:center;">
    <span class="col-1">#</span>
    <span class="col-4">Item</span>
    <span class="col-2 right">Precio</span>
    <span class="col-3 center">Cantidad</span>
    <span class="col-2 right">Subtotal</span>
  </div>
{{foreach carretilla}}
  <div class="row border-b" style="padding: 0.5rem 1rem;align-items:center;">
    <span class="col-1">{{row}}</span>
    <span class="col-4">{{productName}}</span>
    <span class="col-2 right">{{crrprc}}</span>
    <span class="col-3 center">
      <form action="index.php?page=checkout_checkout" method="post">
        <input type="hidden" name="productId" value="{{productId}}" />
        <button type="submit" name="removeOne" class="circle"><i class="fa-solid fa-minus"></i></button>
        <span style="padding: 0.25rem 0.5rem;">{{crrctd}}</span>
        <button type="submit" name="addOne" class="circle"><i class="fa-solid fa-plus"></i></button>
      </form>
    </span>
    <span class="col-2 right">
      {{subtotal}}
    </span>
  </div>
{{endfor carretilla}}
 <div class="row" style="padding: 0.5rem 1rem;align-items:center;">
    <span class="col-3 offset-7 center">Total</span>
    <span class="col-2 right">{{total}}</span>
  </div>
  <div class="row">
    <form action="index.php?page=checkout_checkout" method="post" class="col-12 right">
      <button type="submit">Ordenar</button>
    </form>
  </div>
</section>

</section>