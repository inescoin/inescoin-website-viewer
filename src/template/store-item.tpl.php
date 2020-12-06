<?php
// Copyright 2019-2020 The Inescoin developers.
// - Mounir R'Quiba
// Licensed under the GNU Affero General Public License, version 3.
?><?php include($navStoreCagories); ?>

<div class="container">
	<?php foreach ($products as $product): ?>
	<div class="product-preview">
		<div class="row product-wrapper">
			<div class="col-md-6 no-padding product-thumb-wrapper">
				<img src="<?php echo $product['image']; ?>" alt="<?php echo $product['title']; ?>" class="product-thumb full-width">

			</div>
			<div class="col-md-6 product-buy-block">
				<ol class="breadcrumb text-uppercase hide-xs">
					<?php if (!empty($product['categories']) && is_array($product['categories'])) { ?>
						<?php foreach ($product['categories'] as $category): ?>
						<li class="breadcrumb-item"><a href="<?php echo $category['link']; ?>" title="<?php echo $category['label']; ?>"><?php echo $category['label']; ?></a></li>
						<?php endforeach; ?>
					<?php } ?>
				</ol>
				<h1 class="title-default product-name hide-xs"><?php echo $product['title']; ?></h1>
				<div class="product-content">
					<div class="row">
						<div class="col-md-12 product-price text-center unless_nbre_piece"></div>
						<div class="col-md-12 product-cta">
							<a title="Ajouter le produit au panier" rel="nofollow" class="btn btn-default box-shadow btn-add-cart" data-product-info='<?php echo json_encode(['title' => htmlspecialchars($product['title'], ENT_QUOTES), 'sku' => htmlspecialchars($product['sku'], ENT_QUOTES), 'amount' => htmlspecialchars($product['amount'], ENT_QUOTES), 'currency' => htmlspecialchars($product['currency'], ENT_QUOTES), 'image' => htmlspecialchars($product['image'], ENT_QUOTES), 'quantity' => 1], JSON_PRETTY_PRINT); ?>'>
									<span class="price"><?php echo $product['currency'] == 'usd' ? '$' : ''; ?><?php echo $product['amount']; ?> <?php echo $product['currency'] == 'eur' ? '€' : ''; ?></span>
									Ajouter
							</a>
						</div>
					</div>
				</div>
				<p class="text-primary product-description_short"><?php echo $product['description']; ?>&nbsp;</span></p>

				<?php if (!empty($product['composition']) && is_array($product['composition'])) { ?>
				<p class="title-default small hide-before">Composition</p>
				<p class="text-primary product-description">
					<?php foreach ($product['composition'] as $composition): ?>
						<?php echo $composition; ?><br />
					<?php endforeach; ?>
				</p>
				<?php } ?>
				<?php if (!empty($product['tags']) && is_array($product['tags'])) { ?>
				<ul class="tags">
						<?php foreach ($product['tags'] as $tag): ?>
						<li><a class="tag" href="./?t=<?php echo $tag; ?>" title="<?php echo $tag; ?>"><?php echo $tag; ?></a></li>
						<?php endforeach; ?>
				</ul>
				<?php } ?>
			</div>
			<div class="clearfix"></div>
		</div>

	</div>
	<div class="clearfix"></div>
	<?php endforeach;  ?>
</div>
