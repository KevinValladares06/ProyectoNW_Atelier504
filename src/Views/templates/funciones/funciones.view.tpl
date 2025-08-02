<style>

h1 {
  font-size: 2rem;
  margin-bottom: 1rem;
  text-align: center;
}

.WWList {
  max-width: 1000px;
  margin: 0 auto;
  padding: 1rem;
  font-family: Arial, sans-serif;
  overflow-x: auto;
}

.WWList table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 1rem;
  background-color: #fff;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
  table-layout: fixed;
}

.WWList th,
.WWList td {
  padding: 0.75rem;
  border: 1px solid #ddd;
  text-align: left;
  vertical-align: middle;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}

.WWList th {
  background-color: #f1f3f5;
  font-weight: bold;
  color: #222;
}

.WWList th:nth-child(1),
.WWList td:nth-child(1) {
  width: 30%;
  word-break: break-all;
}

.WWList th:nth-child(2),
.WWList td:nth-child(2) {
  width: 28%;
  word-break: break-all;
}

.WWList th:nth-child(3),
.WWList td:nth-child(3),
.WWList th:nth-child(4),
.WWList td:nth-child(4) {
  width: 10%;
  text-align: center;
}

.WWList th:nth-child(5),
.WWList td:nth-child(5) {
  width: 24%;
  text-align: center;
}

.WWList tbody tr:nth-child(even) {
  background-color: #f9f9f9;
}

.center {
  text-align: center;
}

.WWList td a {
  
  font-weight: 500;
  padding: 4px 8px;
  border-radius: 20px;
  margin: 0 2px;
  font-size: 0.9rem;
}

.WWList td a[href*="mode=DSP"] {
  background-color: #dc3545;
  color: white !important;
}

.WWList td a[href*="mode=DSP"]:hover {
  background-color: #c82333;
}

.WWList td a[href*="mode=UPD"] {
  background-color: #dc3545;
  color: white !important;
}

.WWList td a[href*="mode=UPD"]:hover {
  background-color: #c82333;
}

.WWList td a[href*="mode=DEL"] {
  background-color: #dc3545;
  color: white !important;
}

.WWList td a[href*="mode=DEL"]:hover {
  background-color: #c82333;
}

a.btn-add {
    background-color: #000000; 
    color: rgb(255, 255, 255) !important;
    padding: 0.6em 1.2em;
    font-size: 1rem;
    border-radius: 6px;
    text-decoration: none;
    display: inline-block;
    font-weight: 600;
    box-shadow: 0 2px 4px rgba(2, 101, 166, 0.15);
    transition: background 0.3s ease, transform 0.2s ease;
    text-align: right !important;
}

a.btn-add:hover{
    background-color : #0d7195c2;
    transform: scale(1.05);
    color: rgb(255, 255, 255);
}
</style>


<h1>Funciones</h1>

<section class="WWList">
  <div style="display: flex; justify-content: right; margin-bottom: 1rem;">
    <a class="btn-add" href="index.php?page=Funciones-Funcion&mode=INS">Añadir nueva función</a>
  </div>
  <table>
    <thead>
      <tr>
        <th>Código</th>
        <th>Descripción</th>
        <th class="center">Estado</th>
        <th class="center">Tipo</th>
        <th class="center">Acciones</th>
      </tr>
    </thead>
    <tbody>
      {{foreach funciones}}
      <tr>
        <td>
          <a>
            {{fncod}}
          </a>
        </td>
        <td>{{fndsc}}</td>
        <td class="center">{{fnest}}</td>
        <td class="center">{{fntyp}}</td>
        <td class="center">
          <a class="btn btn-icon" href="index.php?page=Funciones-Funcion&mode=DSP&id={{fncod}}" title="Ver">
            👁️
          </a>
          <a class="btn btn-icon" href="index.php?page=Funciones-Funcion&mode=UPD&id={{fncod}}" title="Editar">
            ✏️
          </a>
          <a class="btn btn-icon delete" href="index.php?page=Funciones-Funcion&mode=DEL&id={{fncod}}" title="Eliminar">
            🗑️
          </a>
        </td>
      </tr>
      {{endfor funciones}}
    </tbody>
  </table>
  {{pagination}}
</section>