<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  </head>
<body>

<?php
    require 'vendor/autoload.php';
    use GuzzleHttp\Client;

	if (isset($_POST['search'])) {
		$search = $_POST['anime'];
		$apiUrl = 'https://api.jikan.moe/v4/anime?q=' . urlencode($search);

        $client = new Client();

        $response = $client->get($apiUrl);
		
		if ($response !== false) {
			// permintaan api
			$results = json_decode($response->getBody(), true);
			$results = $results["data"];

		} else {
			return "gagal";
		}

	}

?>


<nav class="navbar navbar-expand-lg bg-dark navbar-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Sensei Anime</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <!-- <div class="collapse navbar-collapse" id="navbarNav"> -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">anime</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">mangga</a>
        </li>
        <li class="nav-item">
          <a class="nav-link">author</a>
        </li>
      </ul>
    </div>
  </div>
</nav>


<div class="container">
	<div class="row mt-4 justify-content-center">
		<div class="col-md-5">
			<h3>Search anime</h3>
			<form action="" method="POST">
			<div class="input-group mb-3">
				<input type="text" class="form-control" placeholder="Judul anime!" name="anime">
				<input type="submit" class="btn btn-outline-secondary bg-dark text-light" name="search" value="Cari" />
			</div>
			</form>
		</div>
	</div>

	
	<?php if (!empty($results)): ?>
    <div class="row justify-content-start">
        <?php foreach ($results as $result): ?>
            <div class="col-sm-auto mb-3">
                <div class="card" style="width: 10rem">
					<div class="image d-flex align-items-center"  style="height: 225px; width: 158.4px">
						<img src="<?=$result["images"]["webp"]["image_url"]?>" class="card-img-top" alt="gambarAnime" style="max-height: 250px;">
					</div>
                    <div class="card-body">
                        <h6 class="card-title"><?=$result["titles"][0]["title"]?></h6>
                        <p class="card-text">
                            status: <?=$result["status"]?>
                            <br>
                            rating: <?=$result["score"]?>
                            <br>
                            genre: 
							<?php
								$genre = $result["genres"];
								$lastIndex = count($genre) - 1;
								if (!empty($genre)) {
									foreach ($genre as $index => $g) {
										echo $g["name"];
										if ($index !== $lastIndex) {
											echo ', ';
										}
									}
								} else {
									echo "-";
								}
							?>
                        </p>
                        <a href="#" class="btn btn-primary">Detail</a>
                    </div>
                </div>
			</div>
		<?php endforeach; ?>
    </div>
	<?php else: ?>
		<p class="text-center">Tidak ada hasil yang ditemukan.</p>
	<?php endif; ?>

</div>	


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
  </body>
</html>