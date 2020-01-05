<?php
// Copyright 2019-2020 The Inescoin developers.
// - Mounir R'Quiba
// Licensed under the GNU Affero General Public License, version 3.
?><?php include($navStoreCagories); ?>

<div class="container">
  <h1 class="my-4">Products</h1>
  <div class="row">
  	<?php foreach ($products as $product): ?>
  		<div class="col-lg-4 col-sm-6 mb-4">
	      <div class="card h-100">
	        <a href="./?p=<?php echo $product['title'] . '._.' .  $product['sku'] ?>"><img class="card-img-top" src="<?php echo $product['image'] ?>" alt=""></a>
	        <div class="card-body">
	          <h4 class="card-title text-center">
	            <a href="./?p=<?php echo $product['title'] . '._.' .  $product['sku'] ?>"><?php echo $product['title'] ?></a>
	          </h4>
	          <div class="text-center mb-4">
	          	<span class="price"><?php echo $product['currency'] == 'usd' ? '$' : ''; ?><?php echo $product['amount']; ?> <?php echo $product['currency'] == 'eur' ? '€' : ''; ?></span>
				<span class="price-ines"><?php echo $product['amountCrypto']; ?> INES</span>

				<a title="Ajouter le produit au panier" rel="nofollow" class="btn btn-default box-shadow btn-add-cart" data-product-info='<?php echo json_encode(['title' => $product['title'], 'sku' => $product['sku'], 'amount' => $product['amount'], 'currency' => $product['currency'], 'image' => $product['image'], 'quantity' => 1], JSON_PRETTY_PRINT); ?>'>


						Ajouter
				</a>
				</div>
	          <p class="card-text"><?php echo $product['description'] ?></p>
	        </div>
	      </div>
	    </div>
  	<?php endforeach;  ?>
	</div>
</div>
