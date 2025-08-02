<?php

namespace Controllers\Checkout;

use Controllers\PublicController;
use Dao\Cart\Cart;
use Utilities\Security;

class Checkout extends PublicController
{
    public function run(): void
    {
        $viewData = array();

        // Obtener carrito del usuario autenticado
        $carretilla = Cart::getAuthCart(Security::getUserId());

        if ($this->isPostBack()) {
            $processPayment = true;

            // ✅ Manejar eliminación total de un producto del carrito

            // Incrementar o disminuir cantidad
            if (isset($_POST["removeOne"]) || isset($_POST["addOne"])) {
                $productId = intval($_POST["productId"]);
                $productoDisp = Cart::getProductoDisponible($productId);
                $amount = isset($_POST["removeOne"]) ? -1 : 1;

                if ($amount == 1) {
                    if ($productoDisp["productStock"] - $amount >= 0) {
                        Cart::addToAuthCart(
                            $productId,
                            Security::getUserId(),
                            $amount,
                            $productoDisp["productPrice"]
                        );
                    }
                } else {
                    Cart::addToAuthCart(
                        $productId,
                        Security::getUserId(),
                        $amount,
                        $productoDisp["productPrice"]
                    );
                }
                $carretilla = Cart::getAuthCart(Security::getUserId());
                $processPayment = false;
            }

            // Crear orden de pago (si no se estaba actualizando el carrito)
            if ($processPayment) {
                $PayPalOrder = new \Utilities\Paypal\PayPalOrder(
                    "test" . (time() - 10000000),
                    "http://localhost:8080/NW/CopiaProyectoNW/index.php?page=Checkout_Error",
                    "http://localhost:8080/NW/CopiaProyectoNW/index.php?page=Checkout_Accept"
                );

                foreach ((array)$carretilla as $producto) {
                    $PayPalOrder->addItem(
                        $producto["productName"],
                        $producto["productDescription"],
                        $producto["productId"],
                        $producto["crrprc"],
                        0,
                        $producto["crrctd"],
                        "DIGITAL_GOODS"
                    );
                }

                $PayPalRestApi = new \Utilities\PayPal\PayPalRestApi(
                    \Utilities\Context::getContextByKey("PAYPAL_CLIENT_ID"),
                    \Utilities\Context::getContextByKey("PAYPAL_CLIENT_SECRET")
                );
                $PayPalRestApi->getAccessToken();
                $response = $PayPalRestApi->createOrder($PayPalOrder);

                $_SESSION["orderid"] = $response->id;
                foreach ($response->links as $link) {
                    if ($link->rel == "approve") {
                        \Utilities\Site::redirectTo($link->href);
                    }
                }
                die();
            }
        }

        // Construir vista del carrito
        $finalCarretilla = [];
        $counter = 1;
        $total = 0;
        foreach ($carretilla as $prod) {
            $prod["row"] = $counter;
            $prod["subtotal"] = number_format($prod["crrprc"] * $prod["crrctd"], 2);
            $total += $prod["crrprc"] * $prod["crrctd"];
            $prod["crrprc"] = number_format($prod["crrprc"], 2);
            $finalCarretilla[] = $prod;
            $counter++;
        }

        $viewData["carretilla"] = $finalCarretilla;
        $viewData["total"] = number_format($total, 2);
        \Views\Renderer::render("paypal/checkout", $viewData);
    }
}
