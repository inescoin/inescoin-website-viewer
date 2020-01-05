<?php
// Copyright 2019-2020 The Inescoin developers.
// - Mounir R'Quiba
// Licensed under the GNU Affero General Public License, version 3.
?><nav class="navbar navbar-expand-lg navbar-default py-3">
  <div class="container">
    <a class="navbar-brand js-scroll-trigger" href="/"><?php echo $domain['company']['name']; ?></a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav ml-auto my-2 my-lg-0">
        <li class="nav-item">
          <a class="nav-link"  href="/store/checkout/">
            <span class="badge badge-pill badge-success float-right" id="cart-header">0</span>
            <i class="fas fa-cart-arrow-down"></i>
          </a>
        </li>
        <?php foreach ($categories as $category): ?>
      	<li class="nav-item <?php if(isset($category['children']) && !empty($category['children'])) { ?> dropdown <?php } ?>">

          <?php if(isset($category['children']) && !empty($category['children'])) { ?>
          	<a class="nav-item nav-link dropdown-toggle mr-md-2" href="#" id="bd-versions" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<?php } else { ?>
          	<a class="nav-link" href="./?c=<?php echo $category['title'] . '._.' . $category['sku']; ?>">
					<?php } ?>
          	<?php echo ucfirst($category['title']); ?>
        	</a>
					<?php if(isset($category['children']) && !empty($category['children'])): ?>
          <div class="dropdown-menu" aria-labelledby="bd-versions">
        		<a class="dropdown-item" href="./?c=<?php echo $category['title'] . '._.' . $category['sku']; ?>">All</a>
        		<?php foreach ($category['children'] as $subCategory): ?>
          		<a class="dropdown-item" href="./?c=<?php echo $subCategory['title'] . '._.' . $subCategory['sku']; ?>"><?php echo ucfirst($subCategory['title']); ?></a>
      			<?php endforeach; ?>
          </div>
        	<?php endif; ?>
        </li>
        <?php endforeach; ?>

        <?php if (count($languesMenu) > 1): ?>
        <li class="nav-item dropdown">
          <a class="nav-item nav-link dropdown-toggle mr-md-2" href="#" id="bd-versions" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?php echo $domain['label']; ?>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="bd-versions">
            <?php foreach($languesMenu as $key => $langue): ?>
              <?php if ($key !== $currentLangue): ?>
                <a class="dropdown-item" href="./?lg=<?php echo $key; ?>"><?php echo $langue; ?></a>
              <?php endif; ?>
            <?php endforeach; ?>
          </div>
        </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
