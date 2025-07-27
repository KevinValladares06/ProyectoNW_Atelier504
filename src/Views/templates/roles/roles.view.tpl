<h1>Roles</h1>

<section class="WWList">
  <table>
    <thead>
      <tr>
        <th>Código</th>
        <th>Descripción</th>
        <th class="center">Estado</th>
        <th class="center">
          <a href="index.php?page=Roles-Rol&mode=INS">Nuevo</a>
        </th>
      </tr>
    </thead>
    <tbody>
      {{foreach roles}}
      <tr>
        <td>
          <a class="link" href="index.php?page=Roles-Rol&mode=DSP&id={{rolescod}}">
            {{rolescod}}
          </a>
        </td>
        <td>{{rolesdsc}}</td>
        <td class="center">{{rolesest}}</td>
        <td class="center">
          <a href="index.php?page=Roles-Rol&mode=UPD&id={{rolescod}}">Editar</a>
          &nbsp;
          <a href="index.php?page=Roles-Rol&mode=DEL&id={{rolescod}}">Eliminar</a>
        </td>
      </tr>
      {{endfor roles}}
    </tbody>
  </table>
  {{pagination}}
</section>