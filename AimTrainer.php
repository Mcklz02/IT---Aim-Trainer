
<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Aim Trainer</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "leaderboard";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$userName = $_POST["userName"];
			$formPoints = $_POST["formPoints"];
			
			$selectTop10 = "SELECT Name, Score FROM top10";
			$resultTop10 = mysqli_query($conn, $selectTop10);
			if($resultTop10){
				$top10 = mysqli_fetch_all($resultTop10, MYSQLI_ASSOC);
				$isInTop10 = false;
				foreach($top10 as $entry){
					if($formPoints > $entry['Score']){
						$isInTop10 = true;
						break;
					}
				}
				if($isInTop10){
					$top10[] = array('Name'=>$userName, 'Score'=>$formPoints);
					usort($top10, function($a, $b){
						return $b['Score'] - $a['Score'];
					});
					$top10 = array_slice($top10, 0, 10);
					$i = 1;
					foreach ($top10 as $entry) {
						
						mysqli_query($conn, "UPDATE top10 SET Name='{$entry['Name']}', Score={$entry['Score']} WHERE id = $i");
						$i = $i+1;
					}
					//echo "success";
				}else{
					//echo "not in top 10";
				}
			}else{
				//echo "select error";
			}			
		}else{
			//echo "fail";
		}
?>
<style>
body {
  background-color: rgb(32, 32, 70);
  font-family: Arial, Helvetica, sans-serif;
  color: white;
 
}
#header {
  background-color: rgb(51, 51, 69);
  border-radius: 25px;
  padding: 25px;
  width: 750px;
  height: 75px;
  margin: auto;
  text-align: center;
  z-index: 1;
}
 #settings-button {
    position: relative;
    top: 250px;
    float: right;
    margin: auto;
    width: 90px;
    height: 90px;
    border-radius: 25px;
    background-color: rgb(51, 51, 69);
    text-align: center;
    z-index: 4;
	cursor: pointer;
}
 #leaderboard-button {
    position: relative;
    top: 250px;
    float: left;
    margin: auto;
    width: 90px;
    height: 90px;
    border-radius: 25px;
    background-color: rgb(51, 51, 69);
    text-align: center;
    z-index: 4;
	cursor: pointer;
}
 #settings-button:hover, #leaderboard-button:hover {
 	background-color: orange;
 }
 .button:hover{
	text-shadow: 2px 2px orange;
 }
 #settings {
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 750px;
    height: 500px;
    border-radius: 25px;
    background-color: rgb(39, 39, 72);
    text-align: center;
    z-index: 3;
}
 #leaderboard {
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 750px;
    height: 500px;
    border-radius: 25px;
    background-color: rgb(39, 39, 72);
    text-align: center;
    z-index: 3;
}
table, td, th {
  border: 3px solid white;
  font-size: 125%;
  padding: 5px
}

table {
  border-collapse: collapse;
  width: 750px;
}

th {
  height: 70px;
  font-size: 150%;
}
 .button {
    width: 150px;
    height: 75px;
    margin: 15px;
    margin-top: 30px;
    padding-bottom: 15px;
    float: left;
    border-radius: 25px;
    background-color: rgb(51, 51, 69);
    text-align: center;
    font-size:175%;
	cursor: pointer;
 }
 .setting-category {
    width: 150px;
    height: 75px;
    margin: 15px;
    margin-right: 30px;
    margin-top: 30px;
    padding-bottom: 15px;
    float: left;
    border-radius: 25px;
    background-color: rgb(51, 51, 69);
    text-align: center;
    font-size:175%;
}
  .display {
    position: absolute;
    top: 275px;
    left: 50%;
    width: 250px;
    height: 100px;
    border-radius: 25px;
    background-color: rgb(51, 51, 69);
    text-align: center;
    font-size:175%;
	line-height: 1.5;
 }
#points {
	transform: translate(-475px, 0);
}
#combo {
	transform: translate(-125px, 0);
}
#reac-speed {
	transform: translate(+225px, 0);
}
 #game-container {
	display: block;
    position: relative;
    top: 250px;
    margin: auto;
    width: 975px;
    height: 500px;
    border-radius: 25px;
    background-color: rgb(51, 51, 69);
    z-index: 1;
}
.circle {
    position: absolute;
    width: 50px;
    height: 50px;
    background-color: DodgerBlue;
    border-radius: 50%;
    cursor: pointer;
    z-index: 2;
}
#endGameForm{
	display: none;
	position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
	border-radius: 25px;
	background-color: rgb(32, 32, 70);
	padding: 20px;
	z-index: 3;
	font-size:125%;
}
input[type=text], select {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
  font-size:125%;
}
input[type=submit] {
  width: 100%;
  background-color: rgb(51, 51, 69);
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size:125%;
}
input[type=submit]:hover {
  background-color: orange;
}
#message {
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    border-radius: 25px;
    background-color: rgb(39, 39, 72);
    text-align: center;
	padding: 25px;
	font-size:175%;
    z-index: 3;
}
#instruction {
  position: fixed;
  bottom: 0;
  right: 0;
  width: 300px;
  border: 3px solid orange;
  z-index: 3;
}


</style>
</head>
<body>
<div id="header">
	<h1>Aim Trainer</h1>
</div>
<div id="settings-button" onclick="ShowSettings()">
	<br>
	<i class="material-icons", style="font-size:50px;">settings</i>
</div>
<div id="leaderboard-button" onclick="ShowLeaderboard()">
	<br>
	<i class="material-icons", style="font-size:50px;">grade</i>
</div>
<div id="settings">
	<h1>Settings</h1>
    <div class="setting-category">
    	<p> <b>Frequency</b> </p>
    </div>
    <div class="button", id="speed-fast">
    	<p> High </p>
    </div>
    <div class="button", id="speed-normal", style="background-color: orange">
    	<p> Normal </p>
    </div>
    <div class="button", id="speed-slow">
    	<p> Low </p>
    </div>
    <div class="setting-category">
    	<p> <b>Max time</b> </p>
    </div>
    <div class="button", id="disap-fast">
    	<p> Short </p>
    </div>
    <div class="button", id="disap-normal", style="background-color: orange">
    	<p> Normal </p>
    </div>
    <div class="button", id="disap-slow">
    	<p> Long </p>
    </div>
    <div class="setting-category">
    	<p> <b>Size</b> </p>
    </div>
    <div class="button", id="size-small">
    	<p> Small </p>
    </div>    
    <div class="button", id="size-normal", style="background-color: orange">
    	<p> Normal </p>
    </div>
	<div class="button", id="size-big">
    	<p> Big </p>
    </div>
</div>
<div id="leaderboard">
	<table>
    	<tr>
        	<th>Name</th>
            <th>Score</th>
        </tr>
		<?php
		$x = 1;
		$sql = "SELECT * FROM top10";
		$result = mysqli_query($conn, $sql);

		if (mysqli_num_rows($result) > 0) {
			while($row = mysqli_fetch_assoc($result)) {
				echo "<tr><td>". $row["Name"]."</td><td id=score".$x.">".$row["Score"]."</td></tr>";
				$x++;
			}
		} else {
			echo "0 results";
		}
		?>
	</table>
</div>
<div class="display", id="points"> Points: <br> 0</div> 
<div class="display", id="combo"> Combo: <br> 0</div> 
<div class="display", id="reac-speed"> Reaction Speed: <br> - </div> 
<div id="game-container"> </div>
<div id="endGameForm"> 
	<form action="AimTrainer.php" method="post", autocomplete="off">
		<p> Congratulations! </p> 
		<p> Your score will now be entered into the leaderboard </p>
        <label for="userName">Your Name:</label>
        <input type="text" id="userName" name="userName">

        <input type="hidden" id="formPoints" name="formPoints" value="0">

        <input type="submit" value="Submit">
    </form>
</div>
<div id="message"> Lorem ipsum </div>
<div id="instruction"> Press 'Space' to stop the game and record your score </div>

<script>
let mult = 1;
let acc;
let tmax = 1500;
let t;
let freq = 1250;
let maxN = Math.ceil(tmax/freq)+1;
let size = 100;
function ShowSettings() {
	if(document.getElementById("settings").style.display == "block"){
		document.getElementById("settings").style.display = "none";
    } else {
    	document.getElementById("settings").style.display = "block";
		document.getElementById("leaderboard").style.display = "none";
	}
}
function ShowLeaderboard() {
	if(document.getElementById("leaderboard").style.display == "block"){
		document.getElementById("leaderboard").style.display = "none";
    } else {
    	document.getElementById("leaderboard").style.display = "block";
		document.getElementById("settings").style.display = "none";
	}
}
document.getElementById('settings').addEventListener('click', Menu);
function Menu() {
	switch(event.target.id){
		case "speed-fast":
			clearInterval(Speed);
			freq = 750;
			Speed = setInterval(createCircle, freq);
			document.getElementById("speed-normal").style.backgroundColor = "rgb(51, 51, 69)";
			document.getElementById("speed-slow").style.backgroundColor = "rgb(51, 51, 69)";
			event.target.style.backgroundColor = "orange";
			break;
		case "speed-normal":
			clearInterval(Speed);
			freq = 1250;
			Speed = setInterval(createCircle, freq);
			document.getElementById("speed-fast").style.backgroundColor = "rgb(51, 51, 69)";
			document.getElementById("speed-slow").style.backgroundColor = "rgb(51, 51, 69)";
			event.target.style.backgroundColor = "orange";
			break;
		case "speed-slow":
			clearInterval(Speed);
			freq = 1750;
			Speed = setInterval(createCircle, freq);
			document.getElementById("speed-normal").style.backgroundColor = "rgb(51, 51, 69)";
			document.getElementById("speed-fast").style.backgroundColor = "rgb(51, 51, 69)";
			event.target.style.backgroundColor = "orange";
			break;
		case "disap-fast":
			tmax = 1000;
			document.getElementById("disap-normal").style.backgroundColor = "rgb(51, 51, 69)";
			document.getElementById("disap-slow").style.backgroundColor = "rgb(51, 51, 69)";
			event.target.style.backgroundColor = "orange";
			break;
		case "disap-normal":
			tmax = 1500;
			document.getElementById("disap-fast").style.backgroundColor = "rgb(51, 51, 69)";
			document.getElementById("disap-slow").style.backgroundColor = "rgb(51, 51, 69)";
			event.target.style.backgroundColor = "orange";			
			break;
		case "disap-slow":
			tmax = 2500;
			document.getElementById("disap-normal").style.backgroundColor = "rgb(51, 51, 69)";
			document.getElementById("disap-fast").style.backgroundColor = "rgb(51, 51, 69)";
			event.target.style.backgroundColor = "orange";
			break;		
		case "size-big":
			size = 150;
			document.getElementById("size-normal").style.backgroundColor = "rgb(51, 51, 69)";
			document.getElementById("size-small").style.backgroundColor = "rgb(51, 51, 69)";
			event.target.style.backgroundColor = "orange";
			break;
		case "size-normal":
			size = 100;
			document.getElementById("size-big").style.backgroundColor = "rgb(51, 51, 69)";
			document.getElementById("size-small").style.backgroundColor = "rgb(51, 51, 69)";
			event.target.style.backgroundColor = "orange";
			break;
		case "size-small":
			size = 50;
			document.getElementById("size-big").style.backgroundColor = "rgb(51, 51, 69)";
			document.getElementById("size-normal").style.backgroundColor = "rgb(51, 51, 69)";
			event.target.style.backgroundColor = "orange";
			break;		
	}
}
const pointsElement = document.getElementById('points');
const comboElement = document.getElementById('combo');
const reacElement = document.getElementById('reac-speed');
const gameContainer = document.getElementById('game-container');
let Points = 0;
function calcPoints(m, a, tm, t1){
	Points += m * (50 * a + 50 * ((tm - t1) / tm));
	Points = Math.ceil(Points);
	pointsElement.innerHTML = 'Points: <br>' + Points;
}
function circleClick(){

	if(event.target.classList.contains('circle')){
		let endTime = new Date();
		t = endTime - event.target.dataset.startTime;
		reacElement.innerHTML = 'Reaction Speed: <br>' + t + 'ms';
		event.target.dataset.flag = 1;
		mult++;
		comboElement.innerHTML = 'Combo: <br>' + mult;
	}

	if (event.target.id == 'circle1') {
		acc = 0.33;
		event.target.nextSibling.nextSibling.remove();
		event.target.nextSibling.remove();
		event.target.remove();
		calcPoints(mult, acc, tmax, t);
	}
	if (event.target.id == 'circle2') {
		acc = 0.66;
		event.target.previousSibling.remove();
		event.target.nextSibling.remove();
		event.target.remove();
		calcPoints(mult, acc, tmax, t);
	}
	if (event.target.id == 'circle3') {
		acc = 1;
		event.target.previousSibling.previousSibling.remove();
		event.target.previousSibling.remove();
		event.target.remove();
		calcPoints(mult, acc, tmax, t);
	}
	
}
gameContainer.addEventListener('click', circleClick);
function gameEnd(){
	if(event.key == " "){
		clearInterval(Speed);
		if(Points > Number(document.getElementById('score10').innerHTML)){
			document.getElementById("endGameForm").style.display = "block";
			document.getElementById("formPoints").value = Points;
		}else{
			document.getElementById('message').innerHTML = "Your score wasn't high enough to get to the top 10. Better luck next time!";
			document.getElementById('message').style.display = "block";
		}
	}
}
document.addEventListener('keypress', gameEnd);
function createCircle() {
            const circle = document.createElement('div');
            const circle2 = document.createElement('div');
            const circle3 = document.createElement('div');
			let sT = new Date();
            circle.classList.add('circle');
			circle.id = 'circle1';
			circle.dataset.startTime = Number(sT);
			circle.dataset.flag = 0;
            circle2.classList.add('circle');
			circle2.id = 'circle2';
			circle2.dataset.startTime = Number(sT);
			circle2.dataset.flag = 0;
            circle3.classList.add('circle');
			circle3.id = 'circle3';
			circle3.dataset.startTime = Number(sT);
			circle3.dataset.flag = 0;

            const maxX = gameContainer.clientWidth - size;
            const maxY = gameContainer.clientHeight - size;

            const x = Math.random() * maxX;
            const y = Math.random() * maxY;

            circle.style.width = `${size}px`;
            circle.style.height = `${size}px`;
            circle.style.left = `${x}px`;
            circle.style.top = `${y}px`;
            
            circle2.style.width = `${2*size/3}px`;
            circle2.style.height = `${2*size/3}px`;
            circle2.style.left = `${x+0.173*size}px`;
            circle2.style.top = `${y+0.173*size}px`;
            circle2.style.backgroundColor = "Tomato";
            
            circle3.style.width = `${size/3}px`;
            circle3.style.height = `${size/3}px`;
            circle3.style.left = `${x+0.345*size}px`;
            circle3.style.top = `${y+0.345*size}px`;
			circle3.style.backgroundColor = "yellow";
            
            gameContainer.appendChild(circle);
            gameContainer.appendChild(circle2);
            gameContainer.appendChild(circle3);
			
            setTimeout(() => {
                circle.remove();
                circle2.remove();
                circle3.remove();
				if(circle.dataset.flag==0&&circle2.dataset.flag==0&&circle3.dataset.flag==0){
					mult=1;comboElement.innerHTML='Combo: <br> 0';reacElement.innerHTML='Reaction Speed: <br> -';};
            }, tmax);
        }
Speed = setInterval(createCircle, freq);

</script>
	<?php
		$conn->close();
	?>
</body>
</html>
