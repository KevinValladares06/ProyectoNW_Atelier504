<style>
h1 {
  font-size: 2rem;
  margin-bottom: 1rem;
  text-align: center;
}

.WWList {
  max-width: 900px;
  margin: 0 auto;
  padding: 1rem;
  font-family: Arial, sans-serif;
}

.WWList table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 1rem;
}

.WWList th,
.WWList td {
  padding: 0.75rem;
  border: 1px solid #ccc;
  text-align: left;
}

.WWList th {
  background-color: #e9ecef;
  font-weight: bold;
  color: #222;
}

.WWList td a.link {
  color: #007bff;
  text-decoration: none;
}

.WWList td a.link:hover {
  text-decoration: underline;
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
  background-color: #dc3545;
}

.WWList td a[href*="mode=UPD"] {
  background-color: #dc3545;
  color: white !important;
}

.WWList td a[href*="mode=UPD"]:hover {
  background-color: #dc3545;
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

<h1>Roles</h1>

<section class="WWList">
  <div style="display: flex; justify-content: right; margin-bottom: 1rem;">
    <a class="btn-add" href="index.php?page=Roles-Rol&mode=INS">Añadir nuevo rol</a>
  </div>

  <table>
    <thead>
      <tr>
        <th>Código</th>
        <th>Descripción</th>
        <th class="center">Estado</th>
        <th class="center">Acciones</th>
      </tr>
    </thead>
    <tbody>
      {{foreach roles}}
      <tr>
        <td><a>{{rolescod}}</a></td>
        <td>{{rolesdsc}}</td>
        <td class="center">{{rolesest}}</td>
        <td class="center">
          <div style="display: flex; justify-content: center;">
            <a class="btn btn-icon" href="index.php?page=Roles-Rol&mode=DSP&id={{rolescod}}" title="Ver">👁️</a>
            <a class="btn btn-icon" href="index.php?page=Roles-Rol&mode=UPD&id={{rolescod}}" title="Editar">✏️</a>
            <a class="btn btn-icon delete" href="index.php?page=Roles-Rol&mode=DEL&id={{rolescod}}" title="Eliminar">🗑️</a>
          </div>
        </td>
      </tr>
      {{endfor roles}}
    </tbody>
  </table>

  {{pagination}}
</section>
