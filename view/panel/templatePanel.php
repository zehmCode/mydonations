<!doctype html>
<html lang="en">
  <head>
  	<title><?= $title ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
		<link rel="stylesheet" href="<?php echo (count($url) > 1) ? "../": "";?>public/css/panel.css">
  
    
  </head>
  <body>
    
    <?= $content ?>
    
    <script src="<?php echo (count($url) > 1) ? "../": "";?>public/js/script.js"></script>
  </body>
</html>