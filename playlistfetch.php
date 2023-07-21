<?php
    include("config.php");

    $nfd = "Playlist data not filled";
    $input = "";
    $name = "";

    if(isset($_POST['input'])){

        $input = $_POST['input'];

        $query = "SELECT media, COUNT(media) from playlist_files WHERE playlist = '$input' 
        GROUP BY 
        media
        HAVING 
        COUNT(media) > 0;";

        $result = mysqli_query($conn,$query);
         
        if(mysqli_num_rows($result) > 0){?>
       
        <?php 
        while($rows = mysqli_fetch_assoc($result)){

            $song_n = $rows['media'];

            $sql = "SELECT * FROM music WHERE song_name = '$song_n'";

            $res = mysqli_query($conn,$sql);  
            
            while($row = mysqli_fetch_assoc($res)){
                $name = $row['song_name'];
                $artist = $row['artist'];
                $image = $row['song_img'];
                $audio = $row['song_audio'];
            
            ?>

            <p class="p10"><?php echo $input; ?></p>

            <div class="cont" onclick="showpr()">
            <a class="play-audio" data-file="<?php echo $audio;?>">
			<div class="songp">
				<img src="<?php echo $image;?>" id="plblock-img"/>
				<name id="plblock-name"><?php echo $name;?></name>
				<artist id="plblock-artist"><?php echo $artist;?></artist>
        <form method="post">
        <input type="submit" value="/" name="remove" class="remove" style="position: relative;
    display: inline-block;
    width: 30px;
    height: 30px;
    left: 330px;
    top: -80px;
    color:#1FD082;
    font-family: 'Outfit';
    font-weight: 200;
    font-style: normal;

    font-size: 40px;
    line-height: 0px;
    text-align: center;
    gap: 100px;
    border: 0px;
    font-display: block;
    
    border-radius: 100%;
    background: #000000;
    cursor: pointer;"></input></form>
			</div>
            </div>
            </a>

        <?php

            }}

        }else{
          if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['remove'])){
            $remove = "DELETE FROM playlist_files WHERE media = '$name'";
            $r = mysqli_query($conn, $remove);
          }else{?>
            <div class="NRF"><?php echo $nfd;?></div>

        <?php
          }
        }     
    }
?>



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