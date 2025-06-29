<section class="depth-2 px-4 py-5">
    <h2>{{modeDsc}}</h2>
</section>
<section class="depth-2 px-4 py-4 my-4 grid row">
   <form 
        method="POST"
        action="index.php?page=Maintenance-Products-Category&mode={{mode}}&id={{id}}"
        class="grid col-12 col-m-8 offset-m-2 col-l-6 offset-l-3"
    >
        <div class="row my-2">
            <label for="id" class="col-12 col-m-4 col-l-3">Id:</label>
            <input 
                type="text"
                name="id"
                id="id"
                value="{{id}}"
                placeholder="Catégory Id"
                class="col-12 col-m-8 col-l-9"
                readonly
             />
             <input type="hidden" name="xsrtoken" value="{{xsrtoken}}" />
        </div>
        <div class="row my-2">
            <label for="category" class="col-12 col-m-4 col-l-3">Category:</label>
            <input 
                type="text"
                name="categoria"
                id="category"
                value="{{categoria}}"
                placeholder="Name of Category"
                class="col-12 col-m-8 col-l-9"
                {{readonly}}
             />
             {{foreach errors_categoria}}
                <div class="error col-12">{{this}}</div>
             {{endfor errors_categoria}}
        </div>
        <div class="row my-2">
            <label for="status" class="col-12 col-m-4 col-l-3">Status:</label>
            <select {{if readonly}} readonly disabled {{endif readonly}} id="status" name="estado" >
                <option value="ACT" {{selectedACT}}>Active</option>
                <option value="INA" {{selectedINA}}>Disabled</option>
                <option value="RTR" {{selectedRTR}}>Retired</option>
            </select>
            {{foreach errors_estado}}
                <div class="error col-12">{{this}}</div>
             {{endfor errors_estado}}
        </div>
        <div class="row">
            <div class="col-12 right">
                <button class="" id="btnCancel" type="button">{{cancelLabel}}</button>
                &nbsp;
                {{if showConfirm}}
                    <button class="primary" type="submit">Confirm</button>
                {{endif showConfirm}}
           </div>
        </div>
        {{if errors_global}}
            <div class="row">
                <ul class="col-12">
                {{foreach errors_global}}
                    <li class="error">{{this}}</li>
                {{endfor errors_global}}
                </ul>
            </div>
        {{endif errors_global}}
    </form>
</section>
<script>
    document.addEventListener("DOMContentLoaded", ()=>{
        document.getElementById("btnCancel")
            .addEventListener("click", (e)=>{
                e.preventDefault();
                e.stopPropagation();
                window.location.assign("index.php?page=Maintenance-Products-Categories");
            });
    });
</script>