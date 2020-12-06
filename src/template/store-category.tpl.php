<?php
// Copyright 2019-2020 The Inescoin developers.
// - Mounir R'Quiba
// Licensed under the GNU Affero General Public License, version 3.
?><?php include($navStoreCagories); ?>

<div class="container">
  <h1 class="my-4"><?php echo $categoryName; ?></h1>
  <div class="row">
  	<?php foreach ($products as $product): ?>
  		<div class="col-lg-4 col-sm-6 mb-4">
	      <div class="card h-100">
	        <a href="./?p=<?php echo $product['title'] . '._.' .  $product['sku'] ?>"><img class="card-img-top" src="<?php echo $product['image'] ?>" alt=""></a>
	        <div class="card-body">
	          <h4 class="card-title">
	            <a href="/store/?p=<?php echo $product['title'] . '._.' .  $product['sku'] ?>"><?php echo $product['title'] ?></a>
	          </h4>
	          <p class="card-text"><?php echo $product['description'] ?></p>
	        </div>
	      </div>
	    </div>
  	<?php endforeach;  ?>
	</div>
</div>
