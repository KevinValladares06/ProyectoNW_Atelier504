<h1>Usuarios</h1>
<section class="grid">
  <div class="row">
    <form class="col-12 col-m-8" action="index.php" method="get">
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
  <table>
    <thead>
      <tr>
        <th> Id
          {{ifnot OrderByUsercod}}
          <a href="index.php?page=Users_Users&orderBy=usercod&orderDescending=0">ID <i class="fas fa-sort"></i></a>
          {{endifnot OrderByUsercod}}
          {{if OrderUsercodDesc}}
          <a href="index.php?page=Users_Users&orderBy=clear&orderDescending=0">ID <i class="fas fa-sort-down"></i></a>
          {{endif OrderUsercodDesc}}
          {{if OrderUsercod}}
          <a href="index.php?page=Users_Users&orderBy=usercod&orderDescending=1">ID <i class="fas fa-sort-up"></i></a>
          {{endif OrderUsercod}}
        </th>
        
        <th class="left"> Nombre
          {{ifnot OrderByUsername}}
          <a href="index.php?page=Users_Users&orderBy=username&orderDescending=0">Nombre <i class="fas fa-sort"></i></a>
          {{endifnot OrderByUsername}}
          {{if OrderUsernameDesc}}
          <a href="index.php?page=Users_Users&orderBy=clear&orderDescending=0">Nombre <i class="fas fa-sort-down"></i></a>
          {{endif OrderUsernameDesc}}
          {{if OrderUsername}}
          <a href="index.php?page=Users_Users&orderBy=username&orderDescending=1">Nombre <i class="fas fa-sort-up"></i></a>
          {{endif OrderUsername}}
        </th>

        
        <th class="left"> Email
          {{ifnot OrderByUseremail}}
          <a href="index.php?page=Users_Users&orderBy=useremail&orderDescending=0">Email <i class="fas fa-sort"></i></a>
          {{endifnot OrderByUseremail}}
          {{if OrderUseremailDesc}}
          <a href="index.php?page=Users_Users&orderBy=clear&orderDescending=0">Email <i class="fas fa-sort-down"></i></a>
          {{endif OrderUseremailDesc}}
          {{if OrderUseremail}}
          <a href="index.php?page=Users_Users&orderBy=useremail&orderDescending=1">Email <i class="fas fa-sort-up"></i></a>
          {{endif OrderUseremail}}
        </th>
        
        <th>Estado</th>
        <th><a href="index.php?page=Users_User&mode=INS">Nuevo</a></th>
      </tr>
    </thead>
   <tbody>
  {{foreach users}}
  <tr>
    <td>{{usercod}}</td>
    <td>
      <a class="link" href="index.php?page=Users_User&mode=DSP&id={{usercod}}">{{username}}</a>
    </td>
    <td>{{useremail}}</td>
    <td class="center">{{userestDsc}}</td>
    <td class="center">
      <a href="index.php?page=Users_User&mode=UPD&id={{usercod}}">Editar</a> &nbsp;
      <a href="index.php?page=Users_User&mode=DEL&id={{usercod}}">Eliminar</a>
    </td>
  </tr>
  {{endfor users}}
</tbody>
  </table>
  {{pagination}}
</section>
