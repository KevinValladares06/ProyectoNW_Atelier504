<h1>Usuarios</h1>
<section class="grid">
  <div class="row">
    <form class="col-12 col-m-8" action="index.php" method="get">
      <link rel="stylesheet" href="public/css/user.css" />
      <div class="flex align-center">
        <div class="col-8 row">
          <input type="hidden" name="page" value="Users_Users" />
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
  <tr>
    <td colspan="8">
      <div style="display: flex; justify-content: flex-end;">
        <a class="btn-add" href="index.php?page=Users_User&mode=INS">
          Añadir nuevo usuario
        </a>
      </div>
    </td>
  </tr>
  <br>

  <table class="col-12 table striped hover">
    <thead>
      <tr>
        <th>Id</th>
        <th>Nombre</th>
        <th>Email</th>
        <th>Estado</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      {{foreach users}}
      <tr>
        <td>{{usercod}}</td>
        <td>{{username}}</td>
        <td>{{useremail}}</td>
        <td class="center">{{userestDsc}}</td>
        <td class="center">
          <a class="btn btn-icon" href="index.php?page=Users_User&mode=DSP&id={{usercod}}" title="Ver">👁️</a>
          <a class="btn btn-icon" href="index.php?page=Users_User&mode=UPD&id={{usercod}}" title="Editar">✏️</a>
          <a class="btn btn-icon delete" href="index.php?page=Users_User&mode=DEL&id={{usercod}}" title="Eliminar">🗑️</a>
        </td>
      </tr>
      {{endfor users}}
    </tbody>
  </table>
  {{pagination}}
</section>
