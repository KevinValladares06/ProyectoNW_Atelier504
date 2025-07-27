<h1>Categories</h1>
<section class="WWList">
    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>Category</th>
                <th>Status</th>
                <th>
                    {{if isNewEnabled}}
                    <a href="index.php?page=Maintenance-Products-Category&mode=INS&id=" class="">New</a>
                    {{endif isNewEnabled}}
                </th>
            </tr>
        </thead>
        <tbody>
            {{foreach categories}}
            <tr>
                <td>{{id}}</td>
                <td>{{categoria}}</td>
                <td>{{estado}}</td>
                <td>
                    {{if ~isUpdateEnabled}}
                    <a href="index.php?page=Maintenance-Products-Category&mode=UPD&id={{id}}" >
                        Editar
                    </a> &nbsp;
                    {{endif ~isUpdateEnabled}}
                    <a href="index.php?page=Maintenance-Products-Category&mode=DSP&id={{id}}" >
                        Ver
                    </a> &nbsp;
                    {{if ~isDeleteEnabled}}
                    <a href="index.php?page=Maintenance-Products-Category&mode=DEL&id={{id}}" >
                        Eliminar
                    </a>
                    {{endif ~isDeleteEnabled}}
                </td>
            </tr>
            {{endfor categories}}
        </tbody>
    </table>
</section>