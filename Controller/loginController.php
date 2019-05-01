<?php
	require_once "Controller/view.php";
	require_once "Controller/mysqlDB.php";
	class LoginController{
		protected $db;
		public function __construct(){
			$this->db = new mysqlDB("localhost", "root", "", "FunCoding");
		}

		public function start(){
			return View::createView1('login.php', []);
		}

		public function check(){
			$uname = $_POST['uname'];
			$pass = $_POST['pass'];
			$query="SELECT `idPosisi`,`NamaPengguna` FROM `pengguna` WHERE `Username`=";
			if(isset($uname) && $uname!=""){
				$uname = $this->db->escapeString($uname);
				$query.="'$uname' AND ";
			}
			if(isset($pass) && $pass!=""){
				$pass = $this->db->escapeString($pass);
				$hashedPassword = md5($pass);
				$query.="`Pass`='$hashedPassword'";
			}
			$res = $this->db->executeSelectQuery($query);
			if(count($res)!=0){
				if($res[0][0]==1){
					header('');
					print_r("enter");
				}
				else if($res[0][0]==2){
					header('');
					print_r("enter");
				}
				else if($res[0][0]==3){
					session_start();
					$_SESSION['userlogin'] = $res[0][1];
					session_write_close();
					header('Location: homepage');
				}
			}
			else{
			?>
				<script>
					alert("Invalid UserName or Password!");
				</script>
			<?php
			}

		}
	}
?>