<?php
// Copyright 2019 The Inescoin developers.
// - Mounir R'Quiba
// Licensed under the GNU Affero General Public License, version 3.

if (empty($domain)) {
  echo 'Not found!';
  exit();
}
?><!DOCTYPE html>
<html lang="<?php echo $currentLangue; ?>">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-sc ale=1, shrink-to-fit=no">
  <?php if (!empty($domain['website']['meta'])) {
          foreach ($domain['website']['meta'] as $meta) { ?>
  <meta <?php echo $meta['type']; ?>="<?php echo $meta['name']; ?>" content="<?php echo $meta['content']; ?>">
  <?php   }
        }
  ?>

  <title><?php echo $domain['website']['title']; ?></title>
  <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">

  <?php if (!empty($domain['theme']['css']['links'])) {
          foreach ($domain['theme']['css']['links'] as $link) { ?>
  <link href="<?php echo $link['link']; ?>" rel="stylesheet">
  <?php   }
        }
  ?>

  <title><?php echo $domain['website']['title']; ?></title>
  <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">

   <?php if (!empty($domain['theme']['css']['value'])) {?>
  <style type="text/css">
    <?php echo $domain['theme']['css']['value']; ?>
  </style>
  <?php } ?>
</head>
<body id="page-top">

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-light fixed-top py-3" id="mainNav">
    <div class="container">
      <a class="navbar-brand js-scroll-trigger" href="#page-top"><?php echo $domain['company']['name']; ?></a>
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
          background: -webkit-gradient(linear, left top, left bottom, from(rgba(92, 77, 66, 0.8)), to(rgba(92, 77, 66, 0.8))), url("<?php echo $page['backgroundImage'] ?>");
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

  <!-- Footer -->
  <footer class="bg-light py-5">
    <div class="container">
      <div class="small text-center text-muted">Copyright &copy; <?php echo $domain['company']['year']; ?> - <?php echo $domain['company']['name']; ?></div>
      <div class="small text-center text-muted">This website is generated with <a href="https://wallet.inescoin.org/">Inescoin Offline Wallet</a> and hosted into Inescoin Blockchain: <a href="https://explorer.inescoin.org/?domain=<?php echo $websiteName; ?>"><?php echo $websiteName; ?></a></div>
    </div>
  </footer>

  <?php if (!empty($domain['theme']['js']['links'])) {
          foreach ($domain['theme']['js']['links'] as $link) { ?>
  <script src="<?php echo $link['link']; ?>"></script>
  <?php   }
        }
  ?>

  <script type="text/javascript">
    <?php echo $domain['theme']['js']['value']; ?>
  </script>
</body>
</html>

