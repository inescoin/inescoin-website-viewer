<?php
// Copyright 2019-2020 The Inescoin developers.
// - Mounir R'Quiba
// Licensed under the GNU Affero General Public License, version 3.

?>  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-light fixed-top py-3" id="mainNav">
    <div class="container">
      <a class="navbar-brand js-scroll-trigger" href="#page-top">
        <img width="120" height="40" class="logo" src="<?php echo $domain['company']['logo']; ?>" alt="<?php echo $domain['company']['name']; ?>"></a>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto my-2 my-lg-0">
          <?php foreach ($domain['pages'] as $page): ?>
            <?php if ($page['shownInMenu'] && !empty($page['menuTitle']) && !$page['isLink']) : ?>
              <li class="nav-item">
                <a class="nav-link js-scroll-trigger" href="#<?php echo $page['divId']; ?>"><?php echo $page['menuTitle']; ?></a>
              </li>
            <?php endif; ?>
            <?php if (isset($page['isLink']) && $page['isLink']) : ?>
              <li class="nav-item">
                <a class="nav-link js-scroll-trigger" target="blank" href="<?php echo $page['linkUrl']; ?>"><?php echo $page['menuTitle']; ?></a>
              </li>
            <?php endif; ?>
          <?php endforeach; ?>
          <?php if ($domain['website']['store']): ?>
          <li class="nav-item">
            <a class="nav-link" href="/store/">Store</a>
          </li>
          <?php endif; ?>
          <?php if (count($languesMenu) > 1): ?>
          <li class="nav-item dropdown">
            <a class="nav-item nav-link dropdown-toggle mr-md-2" href="#" id="bd-versions" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <?php echo $domain['label']; ?>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="bd-versions">
              <?php foreach($languesMenu as $key => $langue): ?>
                <?php if ($key !== $currentLangue): ?>
                  <a class="dropdown-item" href="/?lg=<?php echo $key; ?>"><?php echo $langue; ?></a>
                <?php endif; ?>
              <?php endforeach; ?>
            </div>
          </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>

  <?php $i=0; foreach ($domain['pages'] as $page): ?>
  <?php if ($i === 0) { ?>
    <style type="text/css">
      header.masthead {
          background: url("<?php echo $page['backgroundImage'] ?>") no-repeat;
          background-position: center;
          min-height: 750px;
      }
    </style>
    <header class="masthead">
      <?php echo $page['body']; ?>
    </header>
  <?php } else { ?>
    <section class="page-section" id="<?php echo $page['divId']; ?>">
      <?php echo $page['body']; ?>
    </section>
  <?php } ?>
  <?php $i++; endforeach; ?>
