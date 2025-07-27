<h1>Funciones</h1>

<section class="WWList">
  <table>
    <thead>
      <tr>
        <th>Código</th>
        <th>Descripción</th>
        <th class="center">Estado</th>
        <th class="center">Tipo</th>
        <th class="center">
          <a href="index.php?page=Funciones-Funcion&mode=INS">Nuevo</a>
        </th>
      </tr>
    </thead>
    <tbody>
      {{foreach funciones}}
      <tr>
        <td>
          <a class="link" href="index.php?page=Funciones-Funcion&mode=DSP&id={{fncod}}">
            {{fncod}}
          </a>
        </td>
        <td>{{fndsc}}</td>
        <td class="center">{{fnest}}</td>
        <td class="center">{{fntyp}}</td>
        <td class="center">
          <a href="index.php?page=Funciones-Funcion&mode=UPD&id={{fncod}}">Editar</a>
          &nbsp;
          <a href="index.php?page=Funciones-Funcion&mode=DEL&id={{fncod}}">Eliminar</a>
        </td>
      </tr>
      {{endfor funciones}}
    </tbody>
  </table>
  {{pagination}}
</section>