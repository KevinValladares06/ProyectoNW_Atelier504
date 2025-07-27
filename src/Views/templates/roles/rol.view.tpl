<section class="container-m row px-4 py-4">
  <h1>{{FormTitle}}</h1>
</section>

<section class="container-m row px-4 py-4">
  {{with rol}}
  <form action="index.php?page=Roles_Rol&mode={{~mode}}&id={{rolescod}}" method="POST" class="col-12 col-m-8 offset-m-2">
    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="rolescod">Código</label>
      <input class="col-12 col-m-9" {{~readonly}} type="text" name="rolescod" id="rolescod" value="{{rolescod}}" />
      <input type="hidden" name="mode" value="{{~mode}}" />
      <input type="hidden" name="id" value="{{rolescod}}" />
      <input type="hidden" name="token" value="{{~rol_xss_token}}" />
    </div>

    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="rolesdsc">Descripción</label>
      <input class="col-12 col-m-9" {{~readonly}} type="text" name="rolesdsc" id="rolesdsc" value="{{rolesdsc}}" />
      {{if rolesdsc_error}}
      <div class="col-12 col-m-9 offset-m-3 error">{{rolesdsc_error}}</div>
      {{endif rolesdsc_error}}
    </div>

    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="rolesest">Estado</label>
      <input class="col-12 col-m-9" {{~readonly}} type="text" name="rolesest" id="rolesest" value="{{rolesest}}" />
      {{if rolesest_error}}
      <div class="col-12 col-m-9 offset-m-3 error">{{rolesest_error}}</div>
      {{endif rolesest_error}}
    </div>
  {{endwith rol}}

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
    window.location.assign("index.php?page=Roles_Roles");
  });
});
</script>