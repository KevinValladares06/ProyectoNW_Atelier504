<?php

namespace Controllers\Checkout;

use Controllers\PublicController;

class Error extends PublicController
{
    public function run(): void
    {
        echo '
        <!DOCTYPE html>
        <html>
        <head>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        </head>
        <body>
            <script>
                Swal.fire({
                    icon: "error",
                    title: "¡Error!",
                    text: "No se pudo realizar la compra.",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didClose: () => {
                        window.location.href = "http://localhost:8080/NW/ProyectoNW_Atelier504/index.php?page=Checkout_Checkout";
                    }
                });
            </script>
        </body>
        </html>
        ';
        die();
    }
}
