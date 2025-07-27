<section class="container-m row px-4 py-4">
  <h1>{{FormTitle}}</h1>
</section>

<section class="container-m row px-4 py-4">
  {{with student}}
  <form action="index.php?page=Students_Student&mode={{~mode}}&id={{id_estudiante}}" method="POST" class="col-12 col-m-8 offset-m-2">
    
    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="id_estudiante">ID</label>
      <input class="col-12 col-m-9" readonly disabled type="text" name="id_estudianteD" id="id_estudianteD" placeholder="ID" value="{{id_estudiante}}" />
      <input type="hidden" name="id_estudiante" value="{{id_estudiante}}" />
      <input type="hidden" name="mode" value="{{~mode}}" />
      <input type="hidden" name="token" value="{{~student_xss_token}}" />
    </div>

    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="nombre">Nombre</label>
      <input class="col-12 col-m-9" {{~readonly}} type="text" name="nombre" id="nombre" placeholder="Nombre" value="{{nombre}}" />
      {{if nombre_error}}
      <div class="col-12 col-m-9 offset-m-3 error">
        {{nombre_error}}
      </div>
      {{endif nombre_error}}
    </div>

    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="apellido">Apellido</label>
      <input class="col-12 col-m-9" {{~readonly}} type="text" name="apellido" id="apellido" placeholder="Apellido" value="{{apellido}}" />
      {{if apellido_error}}
      <div class="col-12 col-m-9 offset-m-3 error">
        {{apellido_error}}
      </div>
      {{endif apellido_error}}
    </div>

    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="edad">Edad</label>
      <input class="col-12 col-m-9" {{~readonly}} type="number" name="edad" id="edad" placeholder="Edad" value="{{edad}}" />
      {{if edad_error}}
      <div class="col-12 col-m-9 offset-m-3 error">
        {{edad_error}}
      </div>
      {{endif edad_error}}
    </div>

    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="especialidad">Especialidad</label>
      <input class="col-12 col-m-9" {{~readonly}} type="text" name="especialidad" id="especialidad" placeholder="Especialidad" value="{{especialidad}}" />
      {{if especialidad_error}}
      <div class="col-12 col-m-9 offset-m-3 error">
        {{especialidad_error}}
      </div>
      {{endif especialidad_error}}
    </div>

    {{endwith student}}

    <div class="row my-4 align-center flex-end">
      {{if showCommitBtn}}
      <button class="primary col-12 col-m-2" type="submit" name="btnConfirmar">Confirmar</button>
      &nbsp;
      {{endif showCommitBtn}}
      <button class="col-12 col-m-2" type="button" id="btnCancelar">
        {{if showCommitBtn}}Cancelar{{endif showCommitBtn}}
        {{ifnot showCommitBtn}}Regresar{{endifnot showCommitBtn}}
      </button>
    </div>
  </form>
</section>

<script>
  document.addEventListener("DOMContentLoaded", () => {
    const btnCancelar = document.getElementById("btnCancelar");
    btnCancelar.addEventListener("click", (e) => {
      e.preventDefault();
      e.stopPropagation();
      window.location.assign("index.php?page=Students_Students");
    });
  });
</script>
