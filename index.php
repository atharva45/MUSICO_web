<?php

    session_start();
	if(!isset($_SESSION["email"])){
		header("Location: login.php");

	}

	$songno=1;

?>

<?php 
$time = time();
	setcookie('Roshan', 'user', $time)
?>

<?php 
	include_once('music.php');
?>

<?php
	$conn = new mysqli('localhost', 'root', '', 'msc');
    mysqli_select_db( $conn, 'signup');

	$uname = "SELECT uname from signup where email = '".$_SESSION["email"]."'";

	$res = mysqli_query($conn, $uname);
?>

<?php 

	function save_playlist($name){
		$conn = new mysqli('localhost', 'root', '', 'msc');
			mysqli_select_db( $conn, 'signup');
			$sql = "INSERT INTO media_playlist(name) VALUES (?)";
			$query = $conn->prepare($sql);
			$query->execute([$name]);
	}

	function get_music() {
		$rs = [];
			$conn = new mysqli('localhost', 'root', '', 'msc');
			mysqli_select_db( $conn, 'signup');
			$rs = $conn->query("SELECT * FROM music");
			return $rs;
	}

	function get_playlists() {
		$r = [];
			$conn = new mysqli('localhost', 'root', '', 'msc');
			mysqli_select_db( $conn, 'signup');
			$r = $conn->query("SELECT * FROM media_playlist");
			return $r;
	}

	function get_albums() {
		$r = [];
			$conn = new mysqli('localhost', 'root', '', 'msc');
			mysqli_select_db( $conn, 'signup');
			$r = $conn->query("SELECT * FROM album");
			return $r;
	}

	function get_artists() {
		$r = [];
			$conn = new mysqli('localhost', 'root', '', 'msc');
			mysqli_select_db( $conn, 'signup');
			$r = $conn->query("SELECT * FROM artist");
			return $r;
	}

	if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save-playlist'])){
		$playlist = isset($_POST['playlist']) ? $_POST['playlist'] : null;
		if($playlist){
			save_playlist($playlist);
			header("location:index.php");
		}
	} 
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="index.css" type="text/css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" 
	integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" 
	crossorigin="anonymous"/>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <title>Online music streaming website</title>
 	</head>
<body>


	<header>
		<div class="search">
			<img src="search.png" class="mag">
			<form method="post">
			<input type="text" name="search" class="search-bar" id="live_search" onclick="showsr()"></input>
			</form>	
		</div>
		<div class="user"><?php while($rows = mysqli_fetch_assoc($res)) {
			echo $rows["uname"];}?>
		</div>
		<div class="circle"></div>
		<img src="user.png" class="user-icon">
	</header>





	<div class="NavBar">
		<logo>MUSICO</logo>
		<button class="Home" onclick="showhome()">
			<div id="btn-container">
				<img  src="home.png"/>
				<t>Home</t>
			  </div>
		</button>
		<button class="Playlist" type="button" onclick="showpl()">
			<div id="btn-container">
				<img  src="lib.png"/>
				<t>Playlist</t>
			  </div>
		</button>
		<button class="Artists" type="button" onclick="showar()">
			<div id="btn-container">
				<img  src="art.png"/>
				<t>Artists</t>
			  </div>
		</button>
		<button class="Albums" type="button" onclick="showal()">
			<div id="btn-container">
				<img  src="alb.png"/>
				<t>Albums</t>
			  </div>
		</button>
		<a href="logout.php">
			<button class="log">Log Out</button></a>
	</div>



	<div class="scr" id="s-hm">
			<p class="p5"></p>
	<div class="pop-up" id="pop" style = "display:none";>
	<div class="sap">SELECT A PLAYLIST</div>
	<div class="cancel" onclick="hidepop()">-</div>
		<div class="select-playlist">
			<?php foreach (get_playlists() as $pl): ?>
				<div class="banner-select" data-name="<?php echo $pl['name']?>" onclick="hidepop()">
				<div class="pname"><?php echo $pl["name"]; ?></div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
	
	<?php foreach (get_music() as $music): ?>
		<a class="play-audio" href="javascript:void(0);" data-file="<?php echo $music['song_audio'];?>">
			<div class="container" onclick="showpr()">
			<div class="song">
				<img src="<?php echo $music['song_img'] ?>" id="pic"/>
				<name id="name"><?php echo $music['song_name'];?></name>
				<artist id="artist"><?php echo $music['artist'];?></artist>
		</a>
				<input type="submit" value="+" name="pl_media" class="add-tpl"
				data-img="<?php echo $music['song_name'];?>" onclick="showpop()"></input>
			</div>
			</div>

	<?php endforeach; ?>
	</div>         





	<div class="screen" id="s-p" style="display: none">
		<div class="playlist" id="pl">
			<p class="p1">Welcome to your playlist</p>
			<div class="pltext">CREATE PLAYLIST</div>
			<div class="pldesc">ENDLESS LIST OF FAVORITES JAMS</div>
			<div class="playlist-songs">
				<div class="create-pl" title="create playlist"  onclick="createpl()">+</div>
				<form id="cpl-page" method="post" style="display: none">
					<h1 class="noyp">Name of your playlist:</h1> 
					<input type="text" name="playlist" class="pl-name"/>
					<h1 class="sai">Select an image:</h1>
					<button type="submit" name="save-playlist" class="save-pl">Save</button>
					<div class="cancel" onclick="hidecpl()">-</div> 
				<form>
					</div>
					<form method="get">
		<?php foreach(get_playlists() as $prow) : ?>
		<a class="playlistinside" href="javascript:void(0);" data-src="<?php echo $prow['name'];?>">		
			<div class="banner" onclick="showplsongs()">
						<img src="./pimg.png" class="pimg"/>
						<div class="plname"><?php echo $prow["name"]; ?></div>
			</div>
		<a>
			<?php endforeach; ?>
		</form>
				</div>
			</div>
		</div>





		<div class="screen" id="s-al" style="display: none">
			<div class="album" id="al">
				<p class="p2">Top Albums</p>
				<div>
					<?php foreach (get_albums() as $albums) : ?>
				<div class="album-banner" onclick="showalsongs()">
					<img src="<?php echo $albums['album_img']?>" class="album-cover"/>
					<div class="album-name"><?php echo $albums['album_name']?></div>
					<div class="album-artist"><?php echo $albums['album_artist']?></div>
				</div>
				<?php endforeach; ?>
				</div>
			</div>
					</div>





			
			<div class="screen" id="s-ar" style="display: none">
				<div class="artist" id="ar">
					<p class="p3">Top Artists</p>
					<div>
				<?php foreach (get_artists() as $artist) : ?>
					<div class="artist-banner" onclick="showarsongs()">
					<img id="artist-info" src="<?php echo $artist['artist_img']?>" class="artist-cover" id="ar-cover"/>
					<div class="artist-name"><?php echo $artist['artist_name']?></div>
				</div>
				<?php endforeach; ?>
					</div>
					</div>
				</div>






				<div class="scr" id="s-sr" style="display: none">
					<div class="srch" id="sr">
						<p class="p4">Search Results</p>
						<div id="searchresult">

						</div>
						</div>
					</div>






				<div class="screen" id="s-artist-songs" style="display: none">
					<div class="artist-s" id="ar-songs">
						<br><br><br>
						<div class="close" onclick="hidearsongs()">-</div>
						<div id="ar-s-result">
							
						</div>
						</div>
					</div>





				
				<div class="screen" id="s-album-songs" style="display: none">
					<div class="album-s" id="al-songs">
						<br><br><br>
						<div class="close" onclick="hidealsongs()">-</div>
						<div id="al-s-result">
							
						</div>
						</div>
					</div>





				<div class="scre" id="s-playlist-songs" style="display: none">
					<div class="playlist-s" id="pl-songs">
						<br><br><br><br><br><br>
						<div class="close" onclick="hideplsongs()">-</div>
						<div id="pl-s-result">
							
						</div>
						</div>
					</div>



					

	<div class="player" id="pr" style="display: none">
		<div class="control">
		  <i class="fas fa-play" id="playbtn"></i>
		</div>
		<div class="info">
			<img class="poster" id="poster"></img>
			<div class="info-song" id="song-n"></div>
		  <div class="info-ar" id="song-ar"></div>
		  <div class="bar">
			<div id="progress"></div>
		  </div>
		</div>
			<div class="line"></div>
		<div id="current">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;0:00</div>
		<div class="minus" style="left:800px;" onclick="showtl()">©</div>
		<div class="minus" onclick="hidepr()">-</div>
	  </div>
	  <div class="mini-pr" id="mpr" onclick="hidempr()" style="display: none">Player</div>




	  <div class="screen" id="s-tl" style="display: none;">
		<div class="playlist" id="pl" style="">
			<pre class="p1">English     					                 Spanish</pre>
			<p class="p1" style=""></p>	
			<div class="left-half" style=""> <pre style="    padding-top: 15vh; padding-left: 3vw; color:white;font-size: 1vw;">
            <?php 
$allmyfrnd="
All my friends are watching, I can hear them talking
All my friends are watching, I can hear them talking
All my friends are watching, I can hear them talking
All my friends are watching, I can hear them talking
Tell me what's going on
Can you take me there
Before the morning comes?
Can you make me care?
Tell me what's going on
Help me fade into flashing lights
Yeah, I've been working overtime
'Cause all my friends, they know
Been making messes out of silence
If we're the same, let me let go
Somebody save me from the madness
Come watch us rise again
Out of the fever
Life will never be the same
I'm a believer
Don't call us another name
We were born to the same sunrise
It's getting brighter all the time
'Cause all my friends, they know
Been making messes out of silence
If we're the same, let me let go
Somebody save me from the madness (right)
(Yeah, yeah, yeah)
(Oh)
'Cause all my friends, they know
Been making messes out of silence
If we're the same, let me let go
Somebody save me from the madness (madness, madness)
(Mad, mad, mad)
All my friends are watching, I can hear them talking
All my friends are watching, I can hear them talking";

$lorem="Lorem ipsum dolor sit
Lorem ipsum dolor sit.
Lorem ipsum dolor sit
Lorem, ipsum dolor sit 
amet consectetur adipisicing elit.
Fugit dolores adipisci dolorem,
necessitatibus inventore praesentium
totam excepturi tempora fuga esse ad
a sequi corrupti dolore reprehenderit,
est, beatae unde deleniti atque aspernatur
distinctio iste incidunt! Nostrum, quod 
quae.Alias molestiae ex quaerat iure 
expedita labore laudantium, omnis 
dignissimos quia dolorum sapiente 
in laborum eum, esse sint beatae unde 
dolorem earum illum reiciendis. Delectus 
a, voluptatem numquam assumenda blanditiis 
ducimus veritatis corrupti nobis autem laudantium 
possimus vel voluptates voluptatibus nostrum, rem 
inventore quas iste odio maxime consequuntur non| 
quae. Velit placeat, eum veritatis animi ducimus 
temporibus rerum esse beatae tempore repellat.
in laborum eum, esse sint beatae unde 
dolorem earum illum reiciendis. Delectus 
a, voluptatem numquam assumenda blanditiis 
ducimus veritatis corrupti nobis autem laudantium 
possimus vel voluptates voluptatibus nostrum, rem 
inventore quas iste odio maxime consequuntur non|
";
if($songno==1)
{
    echo $allmyfrnd;

    $songno=2;
}
else
{
    echo $lorem;
}
?>
				
			</pre></div>
			<!-- <div class="right-half"><pre style="    padding-top: 15vh; padding-left: 3vw; color:white;font-size: 1vw;">
Todos mis amigos están mirando, puedo oírlos hablar
Todos mis amigos están mirando, puedo oírlos hablar
Todos mis amigos están mirando, puedo oírlos hablar
Todos mis amigos están mirando, puedo oírlos hablar

Dime qué está pasando
¿Puedes llevarme allí
Antes de que llegue la mañana?
¿Puedes hacer que me importe?
Dime qué está pasando

Ayúdame a desvanecerme en las luces parpadeantes
Sí, he estado trabajando para escribir esta canción
Estoy parada sola, la gente está quedándose sola
Estoy tratando de salir, pero tú estás aquí

¿Vendrás a buscarme?
No puedo seguir adelante, necesito tu ayuda
Dime qué está pasando
Déjame desvanecerme en las luces parpadeantes

Sí, he estado trabajando para escribir esta canción
Este no fue mi final, quería más

Todo el mundo está mirando, puedo oírlos hablar
Este no fue mi final, quería más

Todo el mundo está mirando, puedo oírlos hablar

</pre></div> -->
		</div>
			
			<!-- <div class="pldesc">ENDLESS LIST OF FAVORITES JAMS</div> -->	
	  </div>

	  



	<script>
// BUTTON
		function showtl() {
			{
				document.getElementById('s-tl').style.display = 'block';
				document.getElementById('s-playlist-songs').style.display = 'none';
  				document.getElementById('s-al').style.display = 'none';
				document.getElementById('s-ar').style.display = 'none';
				document.getElementById('s-p').style.display = 'none';
				document.getElementById('s-sr').style.display = 'none';
				document.getElementById('s-album-songs').style.display = 'none';
				document.getElementById('s-artist-songs').style.display = 'none';
			};
		}

		function showpl() {
			{
				document.getElementById('s-tl').style.display = 'none';
  				document.getElementById('s-p').style.display = 'block';
				document.getElementById('s-al').style.display = 'none';
				document.getElementById('s-ar').style.display = 'none';
				document.getElementById('s-sr').style.display = 'none';
				document.getElementById('s-album-songs').style.display = 'none';
				document.getElementById('s-artist-songs').style.display = 'none';
			};
		}

		function showal() {
			{
				document.getElementById('s-tl').style.display = 'none';
				document.getElementById('s-playlist-songs').style.display = 'none';
  				document.getElementById('s-al').style.display = 'block';
				document.getElementById('s-ar').style.display = 'none';
				document.getElementById('s-p').style.display = 'none';
				document.getElementById('s-sr').style.display = 'none';
				document.getElementById('s-album-songs').style.display = 'none';
				document.getElementById('s-artist-songs').style.display = 'none';
			};
		}

		function showar() {
			{
				document.getElementById('s-tl').style.display = 'none';
				document.getElementById('s-playlist-songs').style.display = 'none';
				document.getElementById('s-ar').style.display = 'block';
				document.getElementById('s-p').style.display = 'none';
				document.getElementById('s-al').style.display = 'none';
				document.getElementById('s-sr').style.display = 'none';
				document.getElementById('s-album-songs').style.display = 'none';
				document.getElementById('s-artist-songs').style.display = 'none';
			};
		}

		function showsr() {
			{
				document.getElementById('s-tl').style.display = 'none';
				document.getElementById('s-sr').style.display = 'block';
				document.getElementById('srchsub').style.display = 'block';
			};
		}

		function showpr() {
			{
				document.getElementById('s-tl').style.display = 'none';
				document.getElementById('pr').style.display = 'block';
				document.getElementById('mpr').style.display = 'none';
			};
		}

		function hidepr() {
			{
				document.getElementById('s-tl').style.display = 'none';
					document.getElementById('pr').style.display = 'none';
					document.getElementById('mpr').style.display = 'block';
			};
		}

		function hidempr() {
			{
				document.getElementById('s-tl').style.display = 'none';
					document.getElementById('pr').style.display = 'block';
					document.getElementById('mpr').style.display = 'none';
			};
		}


		function showhome() {
			document.getElementById('s-tl').style.display = 'none';
				document.getElementById('s-artist-songs').style.display = 'none';
				document.getElementById('s-album-songs').style.display = 'none';
				document.getElementById('s-playlist-songs').style.display = 'none';
  				document.getElementById('s-p').style.display = 'none';
				document.getElementById('s-al').style.display = 'none';
				document.getElementById('s-ar').style.display = 'none';
				document.getElementById('s-sr').style.display = 'none';
				document.getElementById('srchsub').style.display = 'none';
				
		}

		function createpl(){
				document.getElementById('cpl-page').style.display = 'block';
		}

		function hidecpl(){
				document.getElementById('cpl-page').style.display = 'none';
		}

		function showarsongs(){
				document.getElementById('s-artist-songs').style.display = 'block';
		}

		function hidearsongs(){
				document.getElementById('s-artist-songs').style.display = 'none';
		}

		function showalsongs(){
				document.getElementById('s-album-songs').style.display = 'block';
		}

		function hidealsongs(){
				document.getElementById('s-album-songs').style.display = 'none';
		}

		function showplsongs(){
				document.getElementById('s-playlist-songs').style.display = 'block';
		}

		function hideplsongs(){
				document.getElementById('s-playlist-songs').style.display = 'none';
		}

		function showpop(){
				document.getElementById('pop').style.display = 'block';
		}

		function hidepop(){
				document.getElementById('pop').style.display = 'none';
		}
				
	</script>

	<script>
		var audio = null;
		var currentfile = null;

		$(document).ready(function(){

			$('.play-audio').on('click', function(){
				var el = $(this);
				var filename = el.attr('data-file');
			if(audio && currentfile === filename){
					audio.currentTime=0;
					audio.play();
				}
			else{
				if(audio){
						audio.pause();
					}
					audio = new Audio(filename);
					currentfile = filename;
					audio.play();
				}

				const str = filename;
				const newstr = str.replace(/[/.$@&]|[-]|(?<=-).*/g,'');
				let progress = document.getElementById("progress");
				let playbtn = document.getElementById("playbtn");
				let name = document.getElementById("song-n");
				name.innerHTML = newstr;
				const newstr2 = str.replace(/.*(?=-)|[!]|(?<=!).*/g,'');
				const art = newstr2.replace(/-/g,'')
				let artist = document.getElementById("song-ar");
				artist.innerHTML = art;
				
				const newstr3 = str.replace(/.*(?=!)|.mp3/g,'');
				const newstr4 ="./$@&/" + newstr3.replace(/!/g,'');
				const img = document.createElement("img"); 
				img.src = newstr4;
				let pstr = document.getElementById("poster");
				pstr.src = img.src;




				var playpause = function () {
  if (audio.paused) {
    audio.play();
  } else {
    audio.pause();
  }
}

playbtn.addEventListener("click", playpause);

audio.onplay = function () {
  playbtn.classList.remove("fa-play");
  playbtn.classList.add("fa-pause");
}

audio.onpause = function () {
  playbtn.classList.add("fa-play");
  playbtn.classList.remove("fa-pause");
}

audio.ontimeupdate = function () {
  let ct = audio.currentTime;
  current.innerHTML = timeFormat(ct);
  //progress
  let duration = audio.duration;
  prog = Math.floor((ct * 100) / duration);
  progress.style.setProperty("--progress", prog + "%");
}

function timeFormat(ct) {
  minutes = Math.floor(ct / 60);
  seconds = Math.floor(ct % 60);
  let duration = audio.duration;
  min = Math.floor(duration / 60);
  sec = Math.floor(duration % 60);

  if (seconds < 10) {
    seconds = "0"+seconds;
  }

  return (minutes + ":" + seconds + "/" + min + ":" + sec);
}
			});
		});
	</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

	<script>
		$(document).ready(function() {

			$("#live_search").keyup(function(){
				var input = $(this).val();
				// alert(input);

				if(input !=""){
					$.ajax({

						url:"livesearch.php",
						method:"POST",
						data:{input:input},

						success:function(data){
							$("#searchresult").html(data);
						}
					});
				}else{
					document.getElementById("searchresult").innerHTML = "";
				}
			});
		});
            

	</script>

	<script>
		var input = null;

		$(document).ready(function() {
			$(".artist-cover").on("click",function(){
				var el = $(this);
				input = el.attr('src');

				console.log(input);
				if(input !=""){
					$.ajax({

						url:"artistfetch.php",
						method:"POST",
						data:{input:input},

						success:function(data){
							$("#ar-s-result").html(data);
						}
					});
				}else{
					document.getElementById("ar-s-result").innerHTML = "";
				}
			});
		});
	</script>

<script>
		var input = null;

		$(document).ready(function() {
			$(".album-cover").on("click",function(){
				var e = $(this);
				input = e.attr('src');

				console.log(input);
				if(input !=""){
					$.ajax({

						url:"albumfetch.php",
						method:"POST",
						data:{input:input},

						success:function(data){
							$("#al-s-result").html(data);
						}
					});
				}else{
					document.getElementById("al-s-result").innerHTML = "";
				}
			});
		});
	</script>

	<script>
		var input = null;
		$(document).ready(function() {
			$(".add-tpl").on("click",function(){
				var el = $(this);
				input = el.attr('data-img');
				$.ajax({

				url:"addtoplaylist.php",
				method:"POST",
				data:{input:input},
			});
		});
	});
	</script>

	<script>
		var input = null;
		$(document).ready(function() {
			$(".banner-select").on("click",function(){
				var el = $(this);
				input = el.attr('data-name');
				$.ajax({

				url:"addtoplaylist2.php",
				method:"POST",
				data:{input:input},
			});
		});
	});
	</script>

	<script>
		var input = null;
		$(document).ready(function() {
			$(".playlistinside").on("click",function(){
				var el = $(this);
				input = el.attr('data-src');
				console.log(input);
				if(input !=""){
				$.ajax({

				url:"playlistfetch.php",
				method:"POST",
				data:{input:input},
				success:function(data){
					$("#pl-s-result").html(data);
				}
			});
		}else{
			document.getElementById("pl-s-result").innerHTML = "";
		}
		});
	});
	</script>

</body>
</html>