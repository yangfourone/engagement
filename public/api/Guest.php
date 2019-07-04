<?php
class Guest{
	function getAll(){
		//connet db
		require 'connect.php';

		//query data by method
		$getAll_sql = "SELECT * FROM guest_engagement";
		$getAll_result = mysqli_query($con,$getAll_sql);

		$getAll_dataArray = array();

		if(mysqli_num_rows($getAll_result) == 0) {
			return 'NULL';
		}
		else {
			while ($row = mysqli_fetch_array($getAll_result,MYSQLI_ASSOC)) {
				$getAll_dataArray[] = $row;
			}
 			return $getAll_dataArray;
		}
	}
    function getById($id){
        // connet db
        require 'connect.php';

        //query data by method
        $getById_sql = "SELECT * FROM guest_engagement WHERE id = '$id'";
        $getById_result = mysqli_query($con,$getById_sql);

        if(mysqli_num_rows($getById_result) == 0) {
            return 'NULL';
        }
        else {
            $getById_dataArray = mysqli_fetch_array($getById_result,MYSQLI_ASSOC);
            return $getById_dataArray;
        }
    }
	function getByUser($input){
		// connet db
		require 'connect.php';

        $guestName = $input['guestName'];

		//query data by method
		$getById_sql = "SELECT guestName, seat, phoneNumber FROM guest_engagement WHERE guestName = '$guestName'";
		$getById_result = mysqli_query($con,$getById_sql);

		if(mysqli_num_rows($getById_result) == 0) {
			return 'NULL';
		}
		else {
			$getById_dataArray = mysqli_fetch_array($getById_result,MYSQLI_ASSOC);
			return $getById_dataArray;
		}
	}
	function getByRandom() {
        // connet db
        require 'connect.php';

        //query data by method
        $getByRandom_sql = "SELECT guestName FROM guest_engagement WHERE attend = '參加' ORDER BY RAND() LIMIT 1";
        $getByRandom_result = mysqli_query($con,$getByRandom_sql);
        $getByRandom_dataArray = mysqli_fetch_array($getByRandom_result,MYSQLI_ASSOC);
        return $getByRandom_dataArray;
    }

	function add($input){
		//connet db
		require 'connect.php';

        $guestName = $input['guestName'];
		$phoneNumber = $input['phoneNumber'];
		$invitation = $input['invitation'];
		$invitationAddress = $input['invitationAddress'];
		$attend = $input['attend'];
		$eatMeat = $input['eatMeat'];
        $eatVege = $input['eatVege'];
        $seat = $input['seat'];

		if(!isset($guestName)||empty($guestName)||empty($phoneNumber)||!isset($phoneNumber)||!isset($invitation)||!isset($invitationAddress)||!isset($attend)||!isset($seat)){
			return 'EMPTY';
		}
		else {
            $sql_insert = "INSERT INTO guest_engagement (guestName,phoneNumber,invitation,invitationAddress,attend,eatMeat,eatVege,seat) VALUES ('$guestName','$phoneNumber','$invitation','$invitationAddress','$attend','$eatMeat','$eatVege','$seat')";
            mysqli_query($con,$sql_insert);
            return 'ok';
		}
	}

	function delete($id){
		//connet db
		require 'connect.php';

		$sql_check = "SELECT * FROM guest_engagement WHERE id = '$id'";
		$check_result = mysqli_query($con,$sql_check);
		if(mysqli_num_rows($check_result) == 0) {
			return 'NULL';
		}
		else {
			$sql_delete = "DELETE FROM guest_engagement WHERE id = '$id'";
			mysqli_query($con,$sql_delete);
			return 'ok';
		}
	}
	
	function update($input){
		//connet db
		require 'connect.php';

		$id = $input['id'];
        $guestName = $input['guestName'];
        $phoneNumber = $input['phoneNumber'];
        $invitation = $input['invitation'];
        $invitationAddress = $input['invitationAddress'];
        $attend = $input['attend'];
        $eatMeat = $input['eatMeat'];
        $eatVege = $input['eatVege'];
        $seat = $input['seat'];

        if(!isset($guestName)||empty($guestName)||!isset($phoneNumber)||!isset($invitation)||!isset($invitationAddress)||!isset($attend)||!isset($seat)){
            return 'EMPTY';
        }
		else{
			$sql_update ="UPDATE guest_engagement SET guestName='$guestName', phoneNumber='$phoneNumber', invitation='$invitation', invitationAddress='$invitationAddress', attend='$attend', eatMeat='$eatMeat', eatVege='$eatVege', seat='$seat' WHERE id='$id'";
			mysqli_query($con,$sql_update);
			return 'ok';
		}
	}
}
?>