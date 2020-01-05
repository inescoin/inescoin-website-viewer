<?php
// Copyright 2019-2020 The Inescoin developers.
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
  <link rel="stylesheet" href="/assets/css/main.css">

   <?php if (!empty($domain['theme']['css']['value'])) {?>
  <style type="text/css">
    <?php echo $domain['theme']['css']['value']; ?>
  </style>
  <?php } ?>
</head>
<body id="page-top">

  <?php include($view); ?>

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

