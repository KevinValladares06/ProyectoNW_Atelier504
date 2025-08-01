<link rel="stylesheet" href="{{BASE_DIR}}/public/css/main.css" />
<div class="contactanos-page-container">
    <div class="grid row">
        <div class="col-12 center my-4">
            <h1>Contactanos</h1>
        </div>
    </div>
    <div class="grid row align-center">
        <div class="col-l-6 col-m-8 col-12 px-3 my-2">
            <div class="formulario">
                <h2>Envianos un Mensaje</h2>
                <form action="#" method="post">
                    <div class="form-group my-3">
                        <label for="nombre">Nombre</label>
                        <input type="text" id="nombre" name="nombre" placeholder="Nombre Completo" required
                            class="width-full" />
                    </div>
                    <div class="form-group my-3">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Email Address" required
                            class="width-full" />
                    </div>
                    <div class="form-group my-3">
                        <label for="asunto">Asunto</label>
                        <input type="text" id="asunto" name="asunto" placeholder="Asunto" required class="width-full" />
                    </div>
                    <div class="form-group my-3">
                        <label for="mensaje">Mensaje</label>
                        <textarea id="mensaje" name="mensaje" placeholder="Tu Mensaje" rows="5" required
                            class="width-full"></textarea>
                    </div>
                    <button type="submit" class="btn primary my-3">Enviar Mensaje</button>
                </form>
            </div>
        </div>

        <div class="col-l-6 col-m-8 col-12 px-3 my-2">
            <div class="info-contacto">
                <h2>Ponte en contacto con nosotros</h2>
                <p>
                    Para poder tener una mejor cercanía y atender cualquier preocupación o duda, puedes comunicarte con
                    nosotros directamente <br>
                    Si experimentás problemas con la plataforma o necesitas asistencia técnica, nuestro equipo está listo para ayudarte.
                </p>
                <ul class="info-lista">
                    <li><strong>Llámanos:</strong> +504 9016-4572</li>
                    <li><strong>Email:</strong> info@ecommerce.com</li>
                    <li><strong>Dirección:</strong> Calle Principal #123<br>
                        Barrio El Centro<br>
                        Ciudad Ejemplo, Honduras<br>
                        C.P. 11101
                </ul>
            </div>
        </div>
    </div>
</div>