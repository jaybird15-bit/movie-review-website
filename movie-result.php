<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Movie</title>
    <link rel="stylesheet" href="theme.css" />
  </head>
  <body>
    <header>
      <nav>
        <a href="index.html">Homepage</a>
        <a href="add-movie.html">Add a Movie</a>
        <a href="signup.html">Signup</a>
        <a href="login.html">Login</a>
      </nav>
    </header>
    <main>
	<div class="movie-info">
	<h1>Search Results</h1>
	<span>
	<input type = "text" name = "title" size = "30" maxlength="30" />
	<input type = "submit" value="Search" />
	</input>
	</span>
	<div class="movie-info">
	<?php
       	$movieTitle = $_POST["title"];

  		if($movieTitle = 'Star Wars'){
			
			print(
			"
			<img src='StarWarsMoviePoster.jpg' alt='Movie Poster' />
			<label><h1><a href='movie.html'>Star Wars</a></h1></label>
			<p>
            The Imperial Forces -- under orders from cruel Darth Vader (David
            Prowse) -- hold Princess Leia (Carrie Fisher) hostage, in their
            efforts to quell the rebellion against the Galactic Empire. Luke
            Skywalker (Mark Hamill) and Han Solo (Harrison Ford), captain of the
            Millennium Falcon, work together with the companionable droid duo
            R2-D2 (Kenny Baker) and C-3PO (Anthony Daniels) to rescue the
            beautiful princess, help the Rebel Alliance, and restore freedom and
            justice to the Galaxy.
        </p>"
		);
		}
		else{
			
		}
       ?>
	 </div>
	</main>
	<footer></footer>
  </body>
</html>