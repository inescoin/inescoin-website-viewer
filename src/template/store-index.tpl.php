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
	            <a href="/store/?p=<?php echo $product['title'] . '._.' .  $product['sku'] ?>"><?php echo $product['title'] ?></a>
	          </h4>
	          <div class="text-center mb-4">
	          	<span class="price"><?php echo $product['currency'] == 'usd' ? '$' : ''; ?><?php echo $product['amount']; ?> <?php echo $product['currency'] == 'eur' ? '€' : ''; ?></span>
				<span class="price-ines"><?php echo $product['amountCrypto']; ?> INES</span>

				<a title="Ajouter le produit au panier" rel="nofollow" class="btn btn-default box-shadow btn-add-cart" data-product-info='<?php echo json_encode(['title' => htmlspecialchars($product['title'], ENT_QUOTES), 'sku' => htmlspecialchars($product['sku'], ENT_QUOTES), 'amount' => htmlspecialchars($product['amount'], ENT_QUOTES), 'currency' => htmlspecialchars($product['currency'], ENT_QUOTES), 'image' => htmlspecialchars($product['image'], ENT_QUOTES), 'quantity' => 1], JSON_PRETTY_PRINT); ?>'>


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
