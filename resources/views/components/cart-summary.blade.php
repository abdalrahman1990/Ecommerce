<h5 class="center grey-text text-darken-1">Cart Summary</h5>
<br>
<div class="divider"></div>
<table class="centered">
    <tbody>
        <tr>
            <td>Subtotal:</td>
            <td>
                <span class="val cart-subtotal"> ${{Cart::subtotal()}} /- </span>
            </td>
        </tr>
        <tr>
            <td>Tax:</td>
            <td>
                <span class="val cart-tax"> ${{Cart::tax()}} /- </span>
            </td>
        </tr>
        <tr>
            <td>Total:</td>
            <td>
                <span class="val cart-total">${{Cart::total()}} /- </span>
            </td>
        </tr>
    </tbody>
</table>
