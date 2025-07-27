<h1>Trabajar con Estudiantes</h1>

<section class="grid">
  <div class="row">
    <form class="col-12 col-m-8" action="index.php" method="get">
      <input type="hidden" name="page" value="Students_Students">
      <label for="partialName">Nombre</label>
      <input type="text" name="partialName" id="partialName" value="{{partialName}}" />
      <button type="submit">Filtrar</button>
    </form>
  </div>
</section>

<section class="WWList">
  <table>
    <thead>
      <tr>
        <th><a href="index.php?page=Students_Students&orderBy=id_estudiante&orderDescending=0">ID</a></th>
        <th><a href="index.php?page=Students_Students&orderBy=nombre&orderDescending=0">Nombre</a></th>
        <th>Apellido</th>
        <th>Edad</th>
        <th>Especialidad</th>
        <th><a href="index.php?page=Students_Student&mode=INS">Nuevo</a></th>
      </tr>
    </thead>

    <tbody>
  {{foreach students}}
  <tr>
    <td>{{id_estudiante}}</td>
    <td><a href="index.php?page=Students_Student&mode=DSP&id_estudiante={{id_estudiante}}">{{nombre}}</a></td>
    <td>{{apellido}}</td>
    <td>{{edad}}</td>
    <td>{{especialidad}}</td>
    <td>
      <a href="index.php?page=Students_Student&mode=UPD&id_estudiante={{id_estudiante}}">Editar</a>
      <a href="index.php?page=Students_Student&mode=DEL&id_estudiante={{id_estudiante}}">Eliminar</a>
    </td>
  </tr>
  {{endfor}}
</tbody>
  </table>

  {{pagination}}
</section>
