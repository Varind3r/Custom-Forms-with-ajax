<div class="cart-icon">
    <a href="<?php echo wc_get_cart_url(); ?>" class="cart-icon-link">
        <span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
        <i class="fa fa-shopping-cart"></i>
    </a>
</div>

.cart-icon {
    position: relative;
}

.cart-icon-link {
    display: flex;
    align-items: center;
    text-decoration: none;
    color: #000; /* Change this to your desired color */
}

.cart-count {
    background-color: #ff0000; /* Change this to your desired background color */
    color: #fff; /* Change this to your desired text color */
    border-radius: 50%;
    padding: 4px 8px;
    font-size: 12px;
    position: absolute;
    top: 0;
    right: 0;
}