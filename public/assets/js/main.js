(function() {
	var cartProducts;

	function updateCart() {
		console.log($('#cart-header').html(Object.keys(cartProducts).length));
	}

	try {
		cartProducts = JSON.parse(localStorage.getItem('inescoin-cart'));
	} catch(e) {}

	cartProducts = cartProducts || {};

	if ($('.btn-add-cart').length) {
		$('.btn-add-cart').click(function() {
			var product = $(this).data('product-info');

			if (cartProducts[product.sku]) {
				cartProducts[product.sku].quantity++;
			} else {
				console.log('Added --> ' + product.sku);
				cartProducts[product.sku] = product;
			}

			console.log(product, cartProducts);

			localStorage.setItem('inescoin-cart', JSON.stringify(cartProducts));

			updateCart();
		});
	}

	updateCart();
	// console.log($('#cart-header').html(Object.keys(cartProducts).length));
})();

