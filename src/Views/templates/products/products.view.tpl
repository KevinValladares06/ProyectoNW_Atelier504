<h1>Productos</h1>
<section class="grid">
  <div class="row">
    <form class="col-12 col-m-8" action="index.php" method="get">
      <link rel="stylesheet" href="public/css/product.css" />
      <div class="flex align-center">
        <div class="col-8 row">
          <input type="hidden" name="page" value="Products_Products">
          <label class="col-3" for="partialName">Nombre</label>
          <input class="col-9" type="text" name="partialName" id="partialName" value="{{partialName}}" />
          <label class="col-3" for="status">Estado</label>
          <select class="col-9" name="status" id="status">
              <option value="EMP" {{status_EMP}}>Todos</option>
              <option value="ACT" {{status_ACT}}>Activo</option>
              <option value="INA" {{status_INA}}>Inactivo</option>
          </select>
        </div>
        <div class="col-4 align-end">
          <button type="submit">Filtrar</button>
        </div>
      </div>
    </form>
  </div>
</section>
<section class="WWList">
  <table class="col-12 table striped hover">
    <thead>
      <tr>
        <th>Imagen</th>
        <th>Id</th>
        <th>Producto</th>
        <th>Descripción</th>
        <th class="right">Precio</th>
        <th>Stock</th>
        <th>Estado</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      {{foreach products}}
      <tr>
        <td><img src="{{productImgUrl}}" alt="img de {{productName}}" style="width:60px;height:auto;border-radius:4px;" /></td>
        <td>{{productId}}</td>
        <td>{{productName}}</td>
        <td>{{productDescription}}</td>
        <td class="right">L. {{productPrice}}</td>
        <td class="center">{{productStock}}</td>
        <td class="center">{{productStatusDsc}}</td>
        <td class="center">
          <a class="btn btn-icon" href="index.php?page=Products-Product&mode=DSP&id={{productId}}" title="Ver">
            👁️
          </a>
          <a class="btn btn-icon" href="index.php?page=Products-Product&mode=UPD&id={{productId}}" title="Editar">
            ✏️
          </a>
          <a class="btn btn-icon delete" href="index.php?page=Products-Product&mode=DEL&id={{productId}}" title="Eliminar">
            🗑️
          </a>
        </td>
      </tr>
      {{endfor products}}

      <!-- Fila para agregar nuevo -->
      <tr>
        <td colspan="8" class="center">
          <a class="btn-add" href="index.php?page=Products-Product&mode=INS">
            Añadir nuevo producto
          </a>
        </td>
      </tr>
    </tbody>
  </table>
  {{pagination}}
</section>