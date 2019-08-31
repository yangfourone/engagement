<?php
session_start();
class Admin{
	function login($input){
		//connet db
		require 'connect.php';

        $account = $_POST['account'];
        $pwd = $_POST['pwd'];

		if(!isset($account)||empty($account)||!isset($pwd)||empty($pwd)) {
			return 'EMPTY';
		}
		else {
			//query data by method
			$login_sql = "SELECT * FROM admin WHERE account = '$account' AND pwd = '$pwd'";
			$login_result = mysqli_query($con,$login_sql);

			if(mysqli_num_rows($login_result) == 0) {
				return 'NULL';
			}
			else {
				$_SESSION['account'] = $account;
				return 'loginSuccess';
			}
		}
	}
}

?>