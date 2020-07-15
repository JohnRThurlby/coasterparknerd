<?php 
        //getting the database connection
	//require_once ("Includes/DBConnect.php");

	$servername = "localhost";
    $username = "root";
    $password = "";
    $database = "coasterparknerd";

	$conn = new mysqli($servername, $username, $password, $database);
	
	//an array to display response
	$response = array();
	
	//if it is an api call 
	//that means a get parameter named api call is set in the URL 
	//and with this parameter we are concluding that it is an api call 
	if(isset($_GET['apicall'])){
		
		switch($_GET['apicall']){
			
			case 'signup':
				
				//checking the parameters required are available or not 
				if(isTheseParametersAvailable(array('name', 'email', 'password', 'zipcode'))){
					
					//getting the values 
					$name         = $_POST['name']; 
					$email        = $_POST['email']; 
					$password     = md5($_POST['password']);
					$zipcode      = $_POST['zipcode']; 
					$deleteflag   = 'N';
					$temppassword = 'N';
					
					//checking if the user is already exist with this username or email
					//as the email and username should be unique for every user 
					$stmt = $conn->prepare("SELECT id FROM user WHERE email = ?");
					$stmt->bind_param("s", $email);
					$stmt->execute();
					$stmt->store_result();
					
					//if the user already exist in the database 
					if ($stmt->num_rows > 0) {
						$response['error'] = true;
						$response['message'] = 'User already registered';
						$stmt->close();

					} else {
						
						//if user is new creating an insert query 
						$stmt = $conn->prepare("INSERT INTO user (name, email, password, zipcode, deleteflag, temppassword) VALUES (?, ?, ?, ?, ?, ?)");
						$stmt->bind_param("sssss", $name, $email, $password, $zipcode, $deleteflag, $temppassword );
						
						//if the user is successfully added to the database 
						if ($stmt->execute()) {
							
							//fetching the user back 
							$stmt = $conn->prepare("SELECT id, name, email, password, zipcode, deleteflag, temppassword FROM user WHERE email = ?"); 
							$stmt->bind_param("s",$email);
							$stmt->execute();
							$stmt->bind_result($id, $name, $email, $password, $zipcode, $deleteflag, $temppassword);
							$stmt->fetch();
							
							$userinfo = array(
								'id'=>$id, 
								'name'=>$name,
								'email'=>$email,		
								'password'=>$password,
								'zipcode'=>$zipcode,
								'deleteflag'=>$deleteflag,
								'temppassword'=>$temppassword
							);
							
							$stmt->close();
							
							//adding the user data in response 
							$response['error'] = false; 
							$response['message'] = 'User registered successfully'; 
							$response['userinfo'] = $userinfo; 
						}

					}
					
				} else {

					$response['error'] = true; 
					$response['message'] = 'required parameters are not available'; 

				}
				
			break; 

			case 'profile':
				
				//checking the parameters required are available or not 
				if(isTheseParametersAvailable(array('email'))){
					
					//getting the values 
					$email = $_POST['email']; 
										
					//checking if the user is already exist with this email
					//as the email and username should be unique for every user 
					$stmt = $conn->prepare("SELECT id FROM user WHERE email = ?");
					$stmt->bind_param("s", $email);
					$stmt->execute();
					$stmt->store_result();
					
					//if the user already exist in the database 
					if ($stmt->num_rows < 1) {
						$response['error'] = true;
						$response['message'] = 'User does not exist';
						$stmt->close();

					} else {
												
							//fetching the user  
							$stmt = $conn->prepare("SELECT id, name, email, zipcode FROM user WHERE email = ?"); 
							$stmt->bind_param("s",$email);
							$stmt->execute();
							$stmt->bind_result($id, $name, $email, $zipcode);
							$stmt->fetch();
							
							$userinfo = array(
								'id'=>$id, 
								'name'=>$name,
								'email'=>$email,
								'zipcode'=>$zipcode								
							);
							
							$stmt->close();
							
							//adding the user data in response 
							$response['error'] = false; 
							$response['message'] = 'User returned successfully'; 
							$response['userinfo'] = $userinfo;
						
					}
					
				}else{
					$response['error'] = true; 
					$response['message'] = 'required parameters are not available'; 
				}
				
			break; 
			
			case 'login':
				
				if (isTheseParametersAvailable(array('email', 'password'))){

					//getting values 
					$email = $_POST['email']; 
					$password = md5($_POST['password']); 
										
					//creating the query 
					$stmt = $conn->prepare("SELECT id, name, email, password, zipcode, deleteflag, temppassword FROM user WHERE email = ? AND password = ?");

					$stmt->bind_param("ss",$email, $password);
					
					$stmt->execute();
					
					$stmt->store_result();
					
					//if the user exist with given credentials 
					if($stmt->num_rows > 0){
						
						$stmt->bind_result($id, $name, $email, $password, $zipcode, $deleteflag, $temppassword);
						$stmt->fetch();
						
						$userinfo = array(
							'id'=>$id, 
							'name'=>$name,
							'email'=>$email,	
							'password'=>$password,
							'zipcode'=>$zipcode,
							'deleteflag'=>$deleteflag,
							'temppassword'=>$temppassword

						);
						
						$response['error'] = false; 
						$response['message'] = 'Login successfull'; 
						$response['userinfo'] = $userinfo;
						
					} else {

						//if the user not found 
						$response['error'] = true; 
						$response['message'] = 'Invalid useremail or password';

					}

				} else {

					$response['error'] = true; 
					$response['message'] = 'required parameters are not available'; 

				}

			break; 

			case 'updatepass':

			//checking the parameters required are available or not 
				if(isTheseParametersAvailable(array('email', 'password', 'temppassword'))){

				//creating an array for storing the data 
										
					//getting the values 
					$email        = $_POST['email']; 
					$password     = md5($_POST['password']);
					$temppassword = $_POST['temppassword']; 
					
					//checking if the user is already exist with this email
					
					$stmt = $conn->prepare("SELECT id FROM user WHERE email = ?");
					$stmt->bind_param("s", $email);
					$stmt->execute();
					$stmt->store_result();
					
					//if the user already exist in the database 
					if ($stmt->num_rows > 0) {

						//if user is new creating an update query 
						$stmt = $conn->prepare("UPDATE user SET `password` = ?, `temppassword` = ? WHERE email = ?");
						$stmt->bind_param("sss",  $password, $temppassword,  $email);
						
						//if the user is successfully updated in the database 
						if ($stmt->execute()) {
							
							//fetching the user back 
							$stmt = $conn->prepare("SELECT id, name, email, password, zipcode, deleteflag, temppassword FROM user WHERE email = ?"); 
							$stmt->bind_param("s",$email);
							$stmt->execute();
							$stmt->bind_result($id, $name, $email, $password, $zipcode, $deleteflag, $temppassword);
							$stmt->fetch();
							
							$userinfo = array(
								'id'=>$id, 
								'name'=>$name,
								'email'=>$email,	
								'password'=>$password,
								'zipcode'=>$zipcode,
								'deleteflag'=>$deleteflag,
								'temppassword'=>$temppassword
							);
							
							//adding the user data in response 
							$response['error'] = false; 
							$response['message'] = 'User updated successfully'; 
							$response['userinfo'] = $userinfo; 

						}else {
						
					 		$response['error'] = false; 
							$response['message'] = 'Update error available'; 
					    }
					    
					} else {

						//if the user not found 
						$response['error'] = false; 
						$response['message'] = 'User not registered';

					}
					
				} else {

					$response['error'] = true; 
					$response['message'] = 'required parameters are not available'; 

				}

			break; 

			case 'userexists';
				
				if (isTheseParametersAvailable(array('email'))){

					//getting values 
					$email = $_POST['email']; 
										
					//creating the query 
					$stmt = $conn->prepare("SELECT id, name, email, password, zipcode, deleteflag, temppassword FROM user WHERE email = ?");

					$stmt->bind_param("s",$email);
					
					$stmt->execute();
					
					$stmt->store_result();
					
					//if the user exist with given credentials 
					if($stmt->num_rows > 0){
						
						$stmt->bind_result($id, $name, $email, $password, $zipcode, $deleteflag, $temppassword);
						$stmt->fetch();
						
						$userinfo = array(
							'id'=>$id, 
							'name'=>$name,
							'email'=>$email,
							'password'=>$password,
							'zipcode'=>$zipcode,
							'deleteflag'=>$deleteflag,
							'temppassword'=>$temppassword

						);
						
						$response['error'] = false; 
						$response['message'] = 'User exists'; 
						$response['userinfo'] = $userinfo;
						
					} else {

						//if the user not found 
						$response['error'] = false; 
						$response['message'] = 'User not registered';

					}

				} else {

					$response['error'] = true; 
					$response['message'] = 'required parameters are not available'; 

				}

			break; 
			

			case 'parklist':

				if (isTheseParametersAvailable(array('datacomplete'))){

					//getting values 
					$datacomplete = $_POST['datacomplete'];

					//creating an array for storing the data 
					$parklist = array(); 
													
					//creating the query 
					$stmt = $conn->prepare("SELECT id, parkname FROM parks WHERE datacomplete = ? ORDER BY parkname");

					$stmt->bind_param("s", $datacomplete);
									
					$stmt->execute();
					
					$stmt->store_result();
					
					//if the user exist with given credentials 
					if($stmt->num_rows > 0){
						
						$stmt->bind_result($id, $parkname);

						while($stmt->fetch()){
	
							//pushing fetched data in an array 
							$temp = [
								'id'=>$id,
								'parkname'=>$parkname
							];
	
							//pushing the array inside the parklist array 
							array_push($parklist, $temp);

						}
        			
						$response['error'] = false; 
						$response['message'] = 'Parks retrieve successfull'; 
						echo json_encode($parklist);
						$response['parklist'] = $parklist;
						
					} else {
						//if no parks found 
						$response['error'] = false; 
						$response['message'] = 'No complete park info';
					}

				} else {

					$response['error'] = true; 
					$response['message'] = 'required parameters are not available'; 
				
				}
			
			break; 

			case 'parknames':

				if (isTheseParametersAvailable(array('datacomplete'))){

					//getting values 
					$datacomplete = $_POST['datacomplete'];

					//creating an array for storing the data 
					$parknames = array(); 
													
					//creating the query 
					$stmt = $conn->prepare("SELECT parkname FROM parks WHERE datacomplete = ? ORDER BY parkname");

					$stmt->bind_param("s", $datacomplete);
									
					$stmt->execute();
					
					$stmt->store_result();
					
					//if the user exist with given credentials 
					if($stmt->num_rows > 0){
						
						$stmt->bind_result($parkname);

						while($stmt->fetch()){
	
							//pushing fetched data in an array 
							$temp = [
								'parkname'=>$parkname
							];
	
							//pushing the array inside the parklist array 
							array_push($parknames, $temp);

						}
        			
						$response['error'] = false; 
						$response['message'] = 'Parks retrieve successfull'; 
						echo json_encode($parknames);
						$response['parknames'] = $parknames;
						
					} else {
						//if no parks found 
						$response['error'] = false; 
						$response['message'] = 'No complete park info';
					}

				} else {

					$response['error'] = true; 
					$response['message'] = 'required parameters are not available'; 
				
				}
			
			break; 

			case 'ridenames':

				if (isTheseParametersAvailable(array('userid'))){

					//getting values 
					$userid = $_POST['userid'];

					//creating an array for storing the data 
					$ridenames = array(); 
													
					//creating the query 
					$stmt = $conn->prepare("SELECT ridename FROM parkrides");
															
					$stmt->execute();
					
					$stmt->store_result();
					
					//if the user exist with given credentials 
					if($stmt->num_rows > 0){
						
						$stmt->bind_result($ridename);

						while($stmt->fetch()){
	
							//pushing fetched data in an array 
							$temp = [
								'ridename'=>$ridename
							];
	
							//pushing the array inside the ridename array 
							array_push($ridenames, $temp);

						}
        			
						$response['error'] = false; 
						$response['message'] = 'Rides retrieve successfull'; 
						echo json_encode($ridenames);
						$response['ridenames'] = $ridenames;
						
					} else {
						//if no rides found 
						$response['error'] = false; 
						$response['message'] = 'No complete ride info';
					}

				} else {

					$response['error'] = true; 
					$response['message'] = 'required parameters are not available'; 
				
				}
			
			break; 

			case 'allridelist':

				if (isTheseParametersAvailable(array('userid'))){

					//getting values 
					$userid = $_POST['userid'];

					//creating an array for storing the data 
					$allridelist = array(); 
													
					//creating the query 
					$stmt = $conn->prepare("SELECT parkrides.id, parkrides.parkid, parkrides.ridename, parks.parkname FROM parkrides JOIN parks ON parkrides.parkid = parks.id ORDER BY ridename");
									
					$stmt->execute();
					
					$stmt->store_result();
					
					//if the user exist with given credentials 
					if($stmt->num_rows > 0){
						
						$stmt->bind_result($id, $parkid, $ridename, $parkname);

						while($stmt->fetch()){
	
							//pushing fetched data in an array 
							$temp = [
								'id'=>$id,
								'parkid'=>$parkid,
								'ridename'=>$ridename,
								'parkname'=>$parkname
							];
	
							//pushing the array inside the ridelist array 
							array_push($allridelist, $temp);

						}
        				
						
						$response['error'] = false; 
						$response['message'] = 'Rides retrieved successfull'; 
						echo json_encode($allridelist);
						$response['allridelist'] = $allridelist;
						
					} else {

						//if no rides found 
						$response['error'] = false; 
						$response['message'] = 'No rides found';

					}

				} else {

					$response['error'] = true; 
					$response['message'] = 'required parameters are not available'; 
				
				}
			
			break; 

			case 'ridelist':

				if (isTheseParametersAvailable(array('parkid'))){

					//getting values 
					$parkid = $_POST['parkid'];

					//creating an array for storing the data 
					$ridelist = array(); 
													
					//creating the query 
					$stmt = $conn->prepare("SELECT id, parkid, ridename FROM parkrides WHERE parkid = ? ORDER BY ridename");

					$stmt->bind_param("s", $parkid);
									
					$stmt->execute();
					
					$stmt->store_result();
					
					//if the user exist with given credentials 
					if($stmt->num_rows > 0){
						
						$stmt->bind_result($id, $parkid, $ridename);

						while($stmt->fetch()){
	
							//pushing fetched data in an array 
							$temp = [
								'id'=>$id,
								'parkid'=>$parkid,
								'ridename'=>$ridename
							];
	
							//pushing the array inside the ridelist array 
							array_push($ridelist, $temp);

						}
        				
						
						$response['error'] = false; 
						$response['message'] = 'Rides retrieved successfull'; 
						echo json_encode($ridelist);
						$response['ridelist'] = $ridelist;
						
					} else {

						//if no rides found 
						$response['error'] = false; 
						$response['message'] = 'No rides found';

					}

				} else {

					$response['error'] = true; 
					$response['message'] = 'required parameters are not available'; 
				
				}
			
			break; 
		
			case 'parkdetail':

				if (isTheseParametersAvailable(array('id'))){
						
						//getting values 
					$id = $_POST['id'];
													
					//creating the query 
					$stmt = $conn->prepare("SELECT parks.id, parks.parkname, parks.parkphone, parks.parkaddress1, parks.parkcity, parks.parkstate, parks.parkzip, parks.parkwikilink, parks.parkurl, parks.parklat, parks.parklon, parks.parkpic, parks.datacomplete, country.country FROM parks JOIN country ON parks.countryid = country.id WHERE parks.id = ?");
					$stmt->bind_param("s", $id);
	
					$stmt->execute();
					
					$stmt->store_result();
					
					//if the user exist with given credentials 
					if($stmt->num_rows > 0){
						
						$stmt->bind_result($id, $parkname, $parkphone, $parkaddress1, $parkcity, $parkstate, $parkzip, $parkwikilink, $parkurl, $parklat, $parklon, $parkpic, $datacomplete, $country);
        
						$stmt->fetch();
						
						$parks = array(

							'id'=>$id, 
							'parkname'=>$parkname, 
							'parkphone'=>$parkphone, 
							'parkaddress1'=>$parkaddress1, 
							'parkcity'=>$parkcity, 
							'parkstate'=>$parkstate, 
							'parkzip'=>$parkzip, 
							'parkwikilink'=>$parkwikilink, 
							'parkurl'=>$parkurl, 
							'parklat'=>$parklat, 
							'parklon'=>$parklon, 
							'parkpic'=>$parkpic, 
							'datacomplete'=>$datacomplete,
							'country'=>$country
						
						);
						
						$response['error'] = false; 
						$response['message'] = 'Park details retrieved successfull'; 
						$response['parks'] = $parks;
						
					} else {
						//if the park not found 
						$response['error'] = false; 
						$response['message'] = 'No park info';
					}

				}else{
					$response['error'] = true; 
					$response['message'] = 'required parameters are not available'; 
				}

			break; 

			case 'parkid':

				if (isTheseParametersAvailable(array('name'))){
						
						//getting values 
					$name = $_POST['name'];
																		
					//creating the query 
					$stmt = $conn->prepare("SELECT id FROM parks WHERE parkname = ?");
					$stmt->bind_param("s", $name);
	
					$stmt->execute();
					
					$stmt->store_result();
					
					//if the user exist with given credentials 
					if($stmt->num_rows > 0){
						
						$stmt->bind_result($id);
        
						$stmt->fetch();
						
						$parkid = array(

							'id'=>$id
						
						);
						
						$response['error'] = false; 
						$response['message'] = 'Park id retrieved successfull'; 
						$response['parkid'] = $parkid;
						
					} else {
						//if the park not found 
						$response['error'] = false; 
						$response['message'] = 'No park id';
					}

				}else{
					$response['error'] = true; 
					$response['message'] = 'required parameters are not available'; 
				}

			break; 

			case 'rideid':

				if (isTheseParametersAvailable(array('name'))){
						
						//getting values 
					$name = $_POST['name'];
																		
					//creating the query 
					$stmt = $conn->prepare("SELECT parkrides.id, parks.parkname FROM parkrides JOIN parks ON parkrides.parkid = parks.id WHERE ridename = ?");

					$stmt->bind_param("s", $name);
	
					$stmt->execute();
					
					$stmt->store_result();
					
					//if the user exist with given credentials 
					if($stmt->num_rows > 0){
						
						$stmt->bind_result($id, $parkname);
        
						$stmt->fetch();
						
						$rideid = array(

							'id'=>$id,
							'parkname'=>$parkname
						
						);
						
						$response['error'] = false; 
						$response['message'] = 'Ride id retrieved successfull'; 
						$response['rideid'] = $rideid;
						
					} else {
						//if the park not found 
						$response['error'] = false; 
						$response['message'] = 'No ride id';
					}

				}else{
					$response['error'] = true; 
					$response['message'] = 'required parameters are not available'; 
				}

			break; 

			case 'ridedetail':

				if (isTheseParametersAvailable(array('id'))){
						
						//getting values 
					$id = $_POST['id'];
													
					//creating the query 

				    $stmt = $conn->prepare("SELECT parkrides.id, parkrides.parkid, parkrides.ridename, parkrides.rideduration, parkrides.rideopened, parkrides.ridespeed, parkrides.ridelevel, parkrides.ridelength, parkrides.ridehgtreq, parkrides.ridetype, parkrides.rideurl, parkrides.ridemanu, parkareas.parkarea,  parkrides.rideoccup, parkrides.ridehgt, parkrides.ridevehtype  FROM parkrides JOIN parkareas ON parkrides.parkarea = parkareas.id WHERE parkrides.id = ?");

					$stmt->bind_param("s",$id);
	
					$stmt->execute();
					
					$stmt->store_result();
					
					//if the user exist with given credentials 
					if($stmt->num_rows > 0){
						
						$stmt->bind_result($id, $parkid,  $ridename, $rideduration, $rideopened, $ridespeed, $ridelevel, $ridelength, $ridehgtreq, $ridetype, $rideurl, $ridemanu, $parkarea, $rideoccup, $ridehgt, $ridevehtype);
        
						$stmt->fetch();
						
						$ride = array(

							'id'=>$id, 
							'parkid'=>$parkid,
							'ridename'=>$ridename,
							//'ridearea'=>$ridearea
							'rideduration'=>$rideduration,
							//'ridemaxhgt'=>$ridemaxhgt, 
							'rideopened'=>$rideopened, 
							'ridespeed'=>$ridespeed, 
							'ridelevel'=>$ridelevel, 
							'ridelength'=>$ridelength, 
							'ridehgtreq'=>$ridehgtreq, 
							'ridetype'=>$ridetype, 
							'rideurl'=>$rideurl,
							'ridemanu'=>$ridemanu,
							'parkarea'=>$parkarea,
							'rideoccup'=>$rideoccup,
							'ridehgt'=>$ridehgt,
							'ridevehtype'=>$ridevehtype
														
						);
																								
						$response['error'] = false; 
						$response['message'] = 'Ride details retrieved successfull'; 
						$response['ride'] = $ride;
						
					} else {

						//if the park not found 
						$response['error'] = false; 
						$response['message'] = 'No ride info';

					}

				}else{
					$response['error'] = true; 
					$response['message'] = 'required parameters are not available'; 
				}

			break; 

			case 'prevrating':

				if (isTheseParametersAvailable(array('userid', 'rideid'))){
						
						//getting values 
					$userid = $_POST['userid'];
					$rideid = $_POST['rideid'];

					$previousrating = array();
													
					//creating the query 

					$stmt = $conn->prepare("SELECT daterode, rating, waittime, fastpass, singlerider, comment FROM rideuserinfo WHERE userid = ? AND rideid = ? ORDER BY daterode DESC");

					$stmt->bind_param("ss",$userid, $rideid);
	
					$stmt->execute();
					
					$stmt->store_result();
					
					//if the user exist with given credentials 
					if($stmt->num_rows > 0){
						
						$stmt->bind_result($daterode, $rating,  $waittime, $fastpass, $singlerider, $comment);
        
						//$stmt->fetch();

						while($stmt->fetch()){
	
							//pushing fetched data in an array 
							$temp = [

								'daterode'=>$daterode,
								'rating'=>$rating,
								'waittime'=>$waittime,
								'fastpass'=>$fastpass, 
								'singlerider'=>$singlerider, 
								'comment'=>$comment 

							];
	
							//pushing the array inside the previousrating array 
							array_push($previousrating, $temp);

						}
						
																								
						$response['error'] = false; 
						$response['message'] = 'Previous rating data retrieved successfull'; 
						echo json_encode($previousrating);
						$response['previousrating'] = $previousrating;
						
					} else {

						//if the data not found 
						$response['error'] = false; 
						$response['message'] = 'No rating data';

					}

				} else {

					$response['error'] = true; 
					$response['message'] = 'required parameters are not available'; 

				}

			break; 

			

			case 'ratedrides':

				if (isTheseParametersAvailable(array('userid', 'parkid'))){
						
						//getting values 
					$userid = $_POST['userid'];
					$parkid = $_POST['parkid'];

					$ratedrides = array();
													
					//creating the query 

					$stmt = $conn->prepare("SELECT DISTINCT rideuserinfo.rideid, parkrides.ridename  FROM rideuserinfo JOIN parkrides ON rideuserinfo.parkid = parkrides.parkid AND rideuserinfo.rideid = parkrides.id WHERE rideuserinfo.userid = ? AND rideuserinfo.parkid = ? ORDER BY parkrides.ridename");

					$stmt->bind_param("ss",$userid, $parkid);
	
					$stmt->execute();
					
					$stmt->store_result();
					
					//if the user exist with given credentials 
					if($stmt->num_rows > 0){
						
						$stmt->bind_result($rideid, $ridename);
        
						//$stmt->fetch();

						while($stmt->fetch()){
	
							//pushing fetched data in an array 
							$temp = [

								'rideid'=>$rideid,
								'ridename'=>$ridename

							];
	
							//pushing the array inside the ratedride array 
							array_push($ratedrides, $temp);

						}
																							
						$response['error'] = false; 
						$response['message'] = 'Rated ride data retrieved successfull'; 
						echo json_encode($ratedrides);
						$response['ratedrides'] = $ratedrides;
						
					} else {

						//if the data not found 
						$response['error'] = false; 
						$response['message'] = 'No rated ride data';

					}

				} else {

					$response['error'] = true; 
					$response['message'] = 'required parameters are not available'; 

				}

			break; 

			case 'rideratedbyuser':

				if (isTheseParametersAvailable(array('userid', 'rideid'))){
						
						//getting values 
					$userid = $_POST['userid'];
					$rideid = $_POST['rideid'];
										
					$stmt = $conn->prepare("SELECT rideid FROM rideuserinfo WHERE userid = ? AND rideid = ?");

					$stmt->bind_param("ss", $userid, $rideid);
	
					$stmt->execute();
					
					$stmt->store_result();
										
					if($stmt->num_rows > 0){
						
						$stmt->bind_result($rideid);

						$rideratedbyuser = array(

							'rideid'=>$rideid
														
						);
																								
						$response['error'] = false; 
						$response['message'] = 'Ride previously rated'; 
						$response['rideratedbyuser'] = $rideratedbyuser;
						
					} else {

						//if the data not found 
						$response['error'] = false; 
						$response['message'] = 'Ride not yet rated';
						$rideid = '0';

						$rideratedbyuser = array(

							'rideid'=>$rideid
														
						);

						$response['rideratedbyuser'] = $rideratedbyuser;

					}

				} else {

					$response['error'] = true; 
					$response['message'] = 'required parameters are not available'; 

				}

			break; 

			case 'unratedrides':

				if (isTheseParametersAvailable(array('parkid'))){
						
						//getting values 
					
					$parkid = $_POST['parkid'];

					$unratedrides = array();
													
					//creating the query 

					$stmt = $conn->prepare("SELECT id, ridename FROM parkrides WHERE parkid = ?");

					$stmt->bind_param("s", $parkid);
	
					$stmt->execute();
					
					$stmt->store_result();
					
					//if the user exist with given credentials 
					if($stmt->num_rows > 0){
						
						$stmt->bind_result($id, $ridename);
        
						//$stmt->fetch();

						while($stmt->fetch()){
	
							//pushing fetched data in an array 
							$temp = [

								'id'=>$id,
								'ridename'=>$ridename

							];
	
							//pushing the array inside the unratedride array 
							array_push($unratedrides, $temp);

						}
																							
						$response['error'] = false; 
						$response['message'] = 'UnRated ride data retrieved successfull'; 
						echo json_encode($unratedrides);
						$response['unratedrides'] = $unratedrides;
						
					} else {

						//if the data not found 
						$response['error'] = false; 
						$response['message'] = 'No unrated ride data';

					}

				} else {

					$response['error'] = true; 
					$response['message'] = 'required parameters are not available'; 

				}

			break; 

			case 'rateride':

				if (isTheseParametersAvailable(array('userid', 'parkid', 'rideid', 'rating', 'waittime', 'fastpass', 'singlerider', 'comment', 'daterode' ))){
						
						//getting values 
					
					$userid      = $_POST['userid'];
					$parkid      = $_POST['parkid'];
					$rideid      = $_POST['rideid'];
					$rating      = $_POST['rating'];
					$waittime    = $_POST['waittime'];
					$fastpass    = $_POST['fastpass'];
					$singlerider = $_POST['singlerider'];
					$comment     = $_POST['comment'];
					$daterode    = $_POST['daterode'];
					$dateridden  = $_POST['daterode'];
													
					//creating the query 

					$stmt = $conn->prepare("INSERT INTO rideuserinfo (userid, parkid, rideid,  rating, waittime, fastpass, singlerider, comment, daterode ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
					$stmt->bind_param("sssssssss", $userid, $parkid, $rideid, $rating, $waittime, $fastpass, $singlerider, $comment, $daterode);
	
					//if the rating is successfully added to the database 
						if ($stmt->execute()) {
							
							//fetching the rating back 
							$stmt = $conn->prepare("SELECT id, userid, parkid, rideid , rating, waittime, fastpass, singlerider, comment, daterode FROM rideuserinfo WHERE rideid = ? AND userid = ?"); 
							$stmt->bind_param("ss",$rideid, $userid);

							$stmt->execute();
							$stmt->bind_result($id, $userid, $parkid, $rideid , $rating, $waittime, $fastpass, $singlerider, $comment, $daterode);
							$stmt->fetch();
							
							$riderating = array(
								'id'=>$id, 
								'userid'=>$userid, 
								'parkid'=>$parkid,
								'rideid'=>$rideid,
								'rating'=>$rating,
								'waittime'=>$waittime,
								'fastpass'=>$fastpass, 
								'singlerider'=>$singlerider, 
								'comment'=>$comment,
								'daterode'=>$daterode
							);
							
							$stmt->close();
							
							//adding the user data in response 
							$response['error'] = false; 
							$response['message'] = 'Rating created successfully'; 
							$response['riderating'] = $riderating; 

							$stmt = $conn->prepare("INSERT INTO userridevisits (userid, rideid,  daterode ) VALUES (?, ?, ?)");

				        	$stmt->bind_param("sss", $userid, $rideid, $dateridden);

							$stmt->execute();

							$stmt = $conn->prepare("SELECT id FROM userparkvisits WHERE userid = ? AND parkid = ? AND datevisit = ?");

							$stmt->bind_param("sss", $userid, $parkid, $dateridden);
	
							$stmt->execute();

							$stmt->store_result();

							if ($stmt->num_rows < 1) {
							  
								$stmt = $conn->prepare("INSERT INTO userparkvisits (userid, parkid, datevisit) VALUES (?, ?, ?)");

				        		$stmt->bind_param("sss", $userid, $parkid, $dateridden);

								$stmt->execute();
							
							}

						}

				} else {

					$response['error'] = true; 
					$response['message'] = 'required parameters are not available'; 

				}

			break; 

			case 'userparkcount':

				if (isTheseParametersAvailable(array('userid'))){
						
						//getting values 
					
					$userid = $_POST['userid'];

					$userparkcount = array();
													
					//creating the query 

					$stmt = $conn->prepare("SELECT userparkvisits.parkid, COUNT(*) as parkvisit, parks.parkname FROM userparkvisits JOIN parks WHERE userparkvisits.userid = ? AND userparkvisits.parkid = parks.id  GROUP BY userparkvisits.parkid ORDER BY 2 DESC");

					$stmt->bind_param("s", $userid);
	
					$stmt->execute();
					
					$stmt->store_result();
					
					//if the user exist with given credentials 
					if($stmt->num_rows > 0){
						
						$stmt->bind_result($parkid, $parkvisit, $parkname);
        
						//$stmt->fetch();

						while($stmt->fetch()){
	
							//pushing fetched data in an array 
							$temp = [

							    'parkid'=>$parkid,
								'parkvisit'=>$parkvisit,
								'parkname'=>$parkname

							];
	
							//pushing the array inside the parkcount array 
							array_push($userparkcount, $temp);

						}
																							
						$response['error'] = false; 
						$response['message'] = 'User Park count retrieved successfull'; 
					    echo json_encode($userparkcount);
						$response['userparkcount'] = $userparkcount;
						
					} else {

						//if the data not found 
						$response['error'] = false; 
						$response['message'] = 'No park count data';

					}

				} else {

					$response['error'] = true; 
					$response['message'] = 'required parameters are not available'; 

				}

			break; 

			case 'userridecount':

				if (isTheseParametersAvailable(array('userid'))){
						
						//getting values 
					
					$userid = $_POST['userid'];

					$userridecount = array();
													
					//creating the query 

					$stmt = $conn->prepare("SELECT COUNT(*) as visits, parkrides.ridename, userridevisits.rideid FROM userridevisits JOIN parkrides WHERE userridevisits.userid = ? AND userridevisits.rideid = parkrides.id  GROUP BY userridevisits.rideid ORDER BY 1 DESC LIMIT 5");

					$stmt->bind_param("s", $userid);
	
					$stmt->execute();
					
					$stmt->store_result();
					
					//if the user exist with given credentials 
					if($stmt->num_rows > 0){
						
						$stmt->bind_result($visits, $ridename, $rideid);
        
						//$stmt->fetch();

						while($stmt->fetch()){
	
							//pushing fetched data in an array 
							$temp = [

								'visits'=>$visits,
								'ridename'=>$ridename,
								'rideid'=>$rideid
								
							];
	
							//pushing the array inside the ridecount array 
							array_push($userridecount, $temp);

						}
																							
						$response['error'] = false; 
						$response['message'] = 'Ride count retrieved successfull'; 
					    echo json_encode($userridecount);
						$response['userridecount'] = $userridecount;
						
					} else {

						//if the data not found 
						$response['error'] = false; 
						$response['message'] = 'No ride count data';

					}

				} else {

					$response['error'] = true; 
					$response['message'] = 'required parameters are not available'; 

				}

			break; 

			case 'useroverparkcount':
													
				$useroverparkcount = array();
													
				//creating the query 

				$stmt = $conn->prepare("SELECT userid, COUNT(*) as visits FROM userparkvisits GROUP BY userid ORDER BY 2 DESC");
							
	    		$stmt->execute();
					
				$stmt->store_result();
					
				//if the data exist with given credentials 
				if($stmt->num_rows > 0){
						
					$stmt->bind_result($userid, $visits);
        
					//$stmt->fetch();

					while($stmt->fetch()){
	
						//pushing fetched data in an array 
						$temp = [

							'userid'=>$userid,
							'visits'=>$visits
							
						];
	
						//pushing the array inside the parkcount array 
						array_push($useroverparkcount, $temp);

					}
																							
					$response['error'] = false; 
					$response['message'] = 'Park count retrieved successfull'; 
					echo json_encode($useroverparkcount);
					$response['useroverparkcount'] = $useroverparkcount;
						
				} else {

					//if the data not found 
					$response['error'] = false; 
					$response['message'] = 'No park count data';

				}

			break; 

			case 'useroverridecount':
													
				$useroverridecount = array();
													
				//creating the query 

				$stmt = $conn->prepare("SELECT userid, COUNT(*) as visits FROM userridevisits GROUP BY userid ORDER BY 2 DESC");
							
	    		$stmt->execute();
					
				$stmt->store_result();
					
				//if the data exist with given credentials 
				if($stmt->num_rows > 0){
						
					$stmt->bind_result($userid, $visits);
        
					//$stmt->fetch();

					while($stmt->fetch()){
	
						//pushing fetched data in an array 
						$temp = [

							'userid'=>$userid,
							'visits'=>$visits
							
						];
	
						//pushing the array inside the parkcount array 
						array_push($useroverridecount, $temp);

					}
																							
					$response['error'] = false; 
					$response['message'] = 'Ride count retrieved successfull'; 
					echo json_encode($useroverridecount);
					$response['useroverridecount'] = $useroverridecount;
						
				} else {

					//if the data not found 
					$response['error'] = false; 
					$response['message'] = 'No ride count data';

				}

			break; 

			case 'userridecounttop':

				if (isTheseParametersAvailable(array('userid'))){
						
						//getting values 
					
					$userid = $_POST['userid'];

					$userridecount = array();
													
					//creating the query 

					$stmt = $conn->prepare("SELECT userridevisits.rideid, COUNT(*) AS numrides, parkrides.ridename FROM userridevisits JOIN parkrides WHERE userridevisits.userid = ? AND userridevisits.rideid = parkrides.id GROUP BY userridevisits.rideid ORDER BY 2 DESC LIMIT 5");

					$stmt->bind_param("s", $userid );
	
					$stmt->execute();
					
					$stmt->store_result();
					
					//if the user exist with given credentials 
					if($stmt->num_rows > 0){
						
						$stmt->bind_result($rideid, $numrides, $ridename);
        
						//$stmt->fetch();

						while($stmt->fetch()){
	
							//pushing fetched data in an array 
							$temp = [

								'rideid'=>$rideid,
								'numrides'=>$numrides,
								'ridename'=>$ridename

							];
	
							//pushing the array inside the parkcount array 
							array_push($userridecount, $temp);

						}
																							
						$response['error'] = false; 
						$response['message'] = 'Ride count retrieved successfull'; 
					    echo json_encode($userridecount);
						$response['userridecount'] = $userridecount;
						
					} else {

						//if the data not found 
						$response['error'] = false; 
						$response['message'] = 'No ride count data';

					}

				} else {

					$response['error'] = true; 
					$response['message'] = 'required parameters are not available'; 

				}

			break; 

			case 'toptenparks':

				if (isTheseParametersAvailable(array('userid'))){

					$userid = $_POST['userid'];
													
					$parkstat = array();
													
					//creating the query 

					$stmt = $conn->prepare("SELECT parks.id, parks.parkname, COUNT(userparkvisits.userid) AS visits FROM userparkvisits JOIN parks WHERE userparkvisits.parkid = parks.id GROUP BY userparkvisits.parkid ORDER BY 3 DESC LIMIT 10");
							
	    			$stmt->execute();
					
					$stmt->store_result();
					
					//if the data exist with given credentials 
					if($stmt->num_rows > 0){
						
						$stmt->bind_result($parkid, $parkname, $visits);
        
						//$stmt->fetch();

						while($stmt->fetch()){
	
							//pushing fetched data in an array 
							$temp = [

								'parksId'=>$parkid,
								'parksName'=>$parkname,
								'parksVisit'=>$visits
							
							];
	
							//pushing the array inside the parkcount array 
							array_push($parkstat, $temp);

						}
																							
						$response['error'] = false; 
						$response['message'] = 'Park count retrieved successfull'; 
						echo json_encode($parkstat);
						$response['parkstat'] = $parkstat;
						
					} else {

						//if the data not found 
						$response['error'] = false; 
						$response['message'] = 'No park count data';

					}

				} else {

					$response['error'] = true; 
					$response['message'] = 'required parameters are not available'; 

				}

			break; 

			case 'toptenrides':

				if (isTheseParametersAvailable(array('userid'))){

				 	$userid = $_POST['userid'];
													
					$ridestat = array();
													
					//creating the query 

					$stmt = $conn->prepare("SELECT userridevisits.rideid, parkrides.ridename, COUNT(userridevisits.userid) FROM userridevisits JOIN parkrides WHERE userridevisits.rideid = parkrides.id GROUP BY userridevisits.rideid ORDER BY 3 DESC LIMIT 10");
							
	    			$stmt->execute();
					
					$stmt->store_result();
					
					//if the data exist with given credentials 
					if($stmt->num_rows > 0){
						
						$stmt->bind_result($rideid, $ridename, $visits );
        
						//$stmt->fetch();

						while($stmt->fetch()){
	
							//pushing fetched data in an array 
							$temp = [
 
								'ridesId'=>$rideid,
								'ridesName'=>$ridename,
								'ridesVisits'=>$visits
													
							];
	
							//pushing the array inside the ridecount array 
							array_push($ridestat, $temp);

						}
																							
						$response['error'] = false; 
						$response['message'] = 'Ride count retrieved successfull'; 
						echo json_encode($ridestat);
						$response['ridestat'] = $ridestat;
						
					} else {

						//if the data not found 
						$response['error'] = false; 
						$response['message'] = 'No park count data';

					}

				} else {

					$response['error'] = true; 
					$response['message'] = 'required parameters are not available'; 

				}

			break; 

			case 'parkbyuser':

			if (isTheseParametersAvailable(array('userid'))){
						
						//getting values 
					
					$userid = $_POST['userid'];
													
					$parkbyuser = array();
													
					//creating the query 

					$stmt = $conn->prepare("SELECT COUNT(*) as parkvisits, userid FROM userparkvisits GROUP BY userid ORDER BY parkvisits DESC");

					$stmt->execute();
					
					$stmt->store_result();
					
					//if the data exist with given credentials 
					if($stmt->num_rows > 0){
						
						$stmt->bind_result($parkvisits, $userid);
        
						//$stmt->fetch();

						while($stmt->fetch()){
	
							//pushing fetched data in an array 
							$temp = [

								'parkvisits'=>$parkvisits,
								'userid'=>$userid

							
							];
	
							//pushing the array inside the parkcount array 
							array_push($parkbyuser, $temp);

						}
																							
						$response['error'] = false; 
						$response['message'] = 'Park count retrieved successfull'; 
						echo json_encode($parkbyuser);
						$response['parkbyuser'] = $parkbyuser;
						
					} else {

						//if the data not found 
						$response['error'] = false; 
						$response['message'] = 'No park count data';

					}
				
				} else {

					$response['error'] = true; 
					$response['message'] = 'required parameters are not available'; 

				}

			break; 

			case 'ridebyuser':

				if (isTheseParametersAvailable(array('userid'))){
						
						//getting values 
					
					$userid = $_POST['userid'];
													
					$ridebyuser = array();
													
					//creating the query 

					$stmt = $conn->prepare("SELECT  COUNT(*) as ridevisits, userid FROM userridevisits GROUP BY userid ORDER BY ridevisits DESC");
							
	    			$stmt->execute();
					
					$stmt->store_result();
					
					//if the data exist with given credentials 
					if($stmt->num_rows > 0){
						
						$stmt->bind_result($ridevisits, $userid);
        
						//$stmt->fetch();

						while($stmt->fetch()){
	
							//pushing fetched data in an array 
							$temp = [

								'ridevisits'=>$ridevisits,
								'userid'=>$userid

							
							];
	
							//pushing the array inside the ridecount array 
							array_push($ridebyuser, $temp);

						}
																							
						$response['error'] = false; 
						$response['message'] = 'Ride count retrieved successfull'; 
						echo json_encode($ridebyuser);
						$response['ridebyuser'] = $ridebyuser;
						
					} else {

						//if the data not found 
						$response['error'] = false; 
						$response['message'] = 'No ride count data';

					}

				} else {

					$response['error'] = true; 
					$response['message'] = 'required parameters are not available'; 

				}

			break; 

			case 'parkcount':

				if (isTheseParametersAvailable(array('userid'))){
						
						//getting values 
					
					$userid = $_POST['userid'];
													
					$parkcount = array();
													
					//creating the query 

					$stmt = $conn->prepare("SELECT parkid, userid, count(*) AS visits from userparkvisits GROUP BY userid, parkid ORDER BY parkid, visits DESC");
							
	    			$stmt->execute();
					
					$stmt->store_result();
					
					//if the data exist with given credentials 
					if($stmt->num_rows > 0){
						
						$stmt->bind_result($parkid, $userid,  $visits);
        
						//$stmt->fetch();

						while($stmt->fetch()){
	
							//pushing fetched data in an array 
							$temp = [
								
								'parkid'=>$parkid,
								'userid'=>$userid,
								'visits'=>$visits
							
							];
	
							//pushing the array inside the ridecount array 
							array_push($parkcount, $temp);

						}
																							
						$response['error'] = false; 
						$response['message'] = 'User park count retrieved successfull'; 
						echo json_encode($parkcount);
						$response['parkcount'] = $parkcount;
						
					} else {

						//if the data not found 
						$response['error'] = false; 
						$response['message'] = 'No user park count data';

					}

				} else {

					$response['error'] = true; 
					$response['message'] = 'required parameters are not available'; 

				}

			break; 

			
			case 'ridecount':

				if (isTheseParametersAvailable(array('userid'))){
						
						//getting values 
					
					$userid = $_POST['userid'];
													
					$ridecount = array();
													
					//creating the query 

					$stmt = $conn->prepare("SELECT rideid, userid, count(*) AS visits from userridevisits GROUP BY userid, rideid ORDER BY rideid, visits DESC");
							
	    			$stmt->execute();
					
					$stmt->store_result();
					
					//if the data exist with given credentials 
					if($stmt->num_rows > 0){
						
						$stmt->bind_result($rideid, $userid,  $visits);
        
						//$stmt->fetch();

						while($stmt->fetch()){
	
							//pushing fetched data in an array 
							$temp = [
								
								'rideid'=>$rideid,
								'userid'=>$userid,
								'visits'=>$visits
							
							];
	
							//pushing the array inside the ridecount array 
							array_push($ridecount, $temp);

						}
																							
						$response['error'] = false; 
						$response['message'] = 'User ride count retrieved successfull'; 
						echo json_encode($ridecount);
						$response['ridecount'] = $ridecount;
						
					} else {

						//if the data not found 
						$response['error'] = false; 
						$response['message'] = 'No user ride count data';

					}

				} else {

					$response['error'] = true; 
					$response['message'] = 'required parameters are not available'; 

				}

			break; 

			case 'parkareas':

				if (isTheseParametersAvailable(array('parkid'))){
						
						//getting values 
					
					$parkid = $_POST['parkid'];
													
					$parkareas = array();
													
					//creating the query 

					$stmt = $conn->prepare("SELECT id, parkarea from parkareas WHERE parkid = ? ORDER BY parkarea");

					$stmt->bind_param("s", $parkid );
							
	    			$stmt->execute();
					
					$stmt->store_result();
					
					//if the data exist with given credentials 
					if($stmt->num_rows > 0){
						
						$stmt->bind_result($id, $parkarea);
        
						//$stmt->fetch();

						while($stmt->fetch()){
	
							//pushing fetched data in an array 
							$temp = [
								
								'id'=>$id,
								'parkarea'=>$parkarea
							
							];
	
							//pushing the array inside the prkarea array 
							array_push($parkareas, $temp);

						}
																							
						$response['error'] = false; 
						$response['message'] = 'Park Areas retrieved successfull'; 
						echo json_encode($parkareas);
						$response['parkareas'] = $parkareas;
						
					} else {

						//if the data not found 
						$response['error'] = false; 
						$response['message'] = 'No park area data';

					}

				} else {

					$response['error'] = true; 
					$response['message'] = 'required parameters are not available'; 

				}

			break; 
			
			default: 
				$response['error'] = true; 
				$response['message'] = 'Invalid Operation Called';
		}
		
	}else{
		//if it is not api call 
		//pushing appropriate values to response array 
		$response['error'] = true; 
		$response['message'] = 'Invalid API Call';
	}
	
	//displaying the response in json structure 
	echo json_encode($response);

	 //function validating all the paramters are available
	//we will pass the required parameters to this function 
	function isTheseParametersAvailable($params){
		
		//traversing through all the parameters 
		foreach($params as $param){
			//if the paramter is not available
			if(!isset($_POST[$param])){
				//return false 
				return false; 
			}
		}
		//return true if every param is available 
		return true; 
	}