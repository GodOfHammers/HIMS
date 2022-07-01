<?php

function displayLoginMenu()
{
	echo "<div class='topnav'>";		 
	echo "<a href='index.html' class='title_links active' style='background-color: #4CAF50;'> Login </a>" ;
	echo "<div class='dropdown'>
		<button class=\"dropbtn\" style='color:grey;'>User
			<i class=\"fa fa-caret-down\"></i>
		</button>
		<div class=\"dropdown-content\">
				<label for=\"User-Create\" style='color:grey;'> Create User </label>
				<label for=\"User-Delete\" style='color:grey;'> Delete User </label>
				<label for=\"Password-Modify\" style='color:grey;'> Change Password </label>
				<label for=\"Logout\" style='color:grey;'> Logout </label>
		</div>
	</div>
	<div class=\"dropdown\">
            <button class=\"dropbtn\" style='color:grey;'>Pharma
              <i class=\"fa fa-caret-down\"></i>
            </button>
            <div class=\"dropdown-content\">
                <label for=\"Pharma-Create\" style='color:grey;'> Create Pharma </label>
                <label for=\"Pharma-Modify\" style='color:grey;'> Modify Pharma </label>
                <label for=\"Pharma-Delete\" style='color:grey;'> Delete Pharma </label>
            </div>
				</div>
				<div class=\"dropdown\">
				<button class=\"dropbtn\" style='color:grey;'>Item
					<i class=\"fa fa-caret-down\"></i>
				</button>
				<div class=\"dropdown-content\">
						<label for=\"Item-Create\" style='color:grey;'> Create Item </label>
						<label for=\"Item-Modify\" style='color:grey;'> Modify Item </label>
						<label for=\"Item-Delete\" style='color:grey;'> Delete Item </label>
				</div>
		</div>

		<label for=\"Sale-of-Items\" style='color:grey;'> Sale of Items </label>

		<div class=\"dropdown\">
				<button class=\"dropbtn\" style='color:grey;'>Indent
					<i class=\"fa fa-caret-down\"></i>
				</button>
				<div class=\"dropdown-content\">
						<label for=\"Indent-Create\" style='color:grey;'> Create Indent </label>
						<label for=\"Indent-Approve\" style='color:grey;'> Approve Indent </label>
				</div>
		</div>
</div>
";

}

function displayLoginScreen()
{
	echo "<center>" ;
        echo "<h3> Login </h3>";

        echo "<label for='name' class='required'> Username: </label>";
        echo "<input type='text' id='name' name='name' placeholder='Enter username' style='margin-left: 4px;' required><br/>";

        echo "<label for='password' class='required'> Password: </label>";
        echo "<input type='password' id='password' name='password' placeholder='Enter password' required><br/>";

        echo "<button type='reset' id='reset_1'> Cancel </button>";
        echo "<button type='submit' id='submit_1'> Submit </button><br/><br/>";
        echo "<a href='index.html' id='forgotpwd'> Forgot Password? </a>";
	echo "</center>";
}

function displayAdminMenu ($loginId)
{
	echo "<div class='topnav'>";		 
	//echo "<a href='index.html' class='title_links active' style='background-color: #4CAF50;'> Login </a>" ;
	echo "<div class='dropdown'>
						<button class='dropbtn'>User
							<i class='fa fa-caret-down'></i>
						</button>
						<div class='dropdown-content'>
							<a href='User-Create.php?name=$loginId' class='title_links' style='color:green;'> Create User </a>
							<a href='User-Delete.php?name=$loginId' class='title_links' style='color:green;'> Delete User </a> 
							<a href='Password-Modify.php?name=$loginId' class='title_links' style='color:green;'> Change Password </a> 
							<a href='index.html' class='title_links' style='color:green;'> logout </a> 
						</div>
				</div>

				<div class='dropdown'>
          	<button class='dropbtn'>Pharma
            	<i class='fa fa-caret-down'></i>
          	</button>
          	<div class='dropdown-content'>
						<a href='Pharma-Create.php?name=$loginId' class='title_links' style='color:green;'> Create Pharma </a>
						<a href='Pharma-Modify.php?name=$loginId' class='title_links' style='color:green;'> Modify Pharma </a>
						<a href='Pharma-Delete.php?name=$loginId' class='title_links' style='color:green;'> Delete Pharma </a>
          	</div>	
				</div>

				<div class='dropdown'>
						<button class='dropbtn'>Item
							<i class='fa fa-caret-down'></i>
						</button>
						<div class='dropdown-content'>
							<a href='Item-Create.php?name=$loginId' class='title_links' style='color:green;'> Create Item </a>
							<a href='Item-Modify.php?name=$loginId' class='title_links' style='color:green;'> Modify Item </a>
							<a href='Item-Delete.php?name=$loginId' class='title_links' style='color:green;'> Delete Item </a>
						</div>
				</div>

		<label for='Sale-of-Items' style='color:grey;'> Sale of Items </label>

		<div class='dropdown'>
				<button class='dropbtn' style='color:grey;'>Indent
					<i class='fa fa-caret-down'></i>
				</button>
				<div class='dropdown-content'>
						<label for='Indent-Create' style='color:grey;'> Create Indent </label>
						<label for='Indent-Approve' style='color:grey;'> Approve Indent </label>
				</div>
		</div>
		<div class='rname'> Welcome Admin </div>
</div>
";
}

function displayManagerMenu ($loginId)
{
	echo "<div class='topnav'>";		 
	//echo "<a href='index.html' class='title_links active' style='background-color: #4CAF50;'> Login </a>" ;
	echo "<div class='dropdown'>
						<button class='dropbtn'>User
							<i class='fa fa-caret-down'></i>
						</button>
						<div class='dropdown-content'>
							<label for='User-Create' style='color:grey;'> Create User </label>
							<label for='User-Delete' style='color:grey;'> Delete User </label>
							<a href='Password-Modify.php?name=$loginId' class='title_links' style='color:green;'> Change Password </a> 
							<a href='index.html' class='title_links' style='color:green;'> logout </a> 
						</div>
				</div>

				<div class='dropdown'>
          	<button class='dropbtn' style='color:grey;'>Pharma
            	<i class='fa fa-caret-down'></i>
          	</button>
          	<div class='dropdown-content'>
							<label for='Pharma-Create' style='color:grey;'> Create Pharma </label>
							<label for='Pharma-Modify' style='color:grey;'> Modify Pharma </label>
							<label for='Pharma-Delete' style='color:grey;'> Delete Pharma </label>
          	</div>	
				</div>

				<div class='dropdown'>
						<button class='dropbtn' style='color:grey;'>Item
							<i class='fa fa-caret-down'></i>
						</button>
						<div class='dropdown-content'>
							<label for='Item-Create' style='color:grey;'> Create Item </label>
							<label for='Item-Modify' style='color:grey;'> Modify Item </label>
							<label for='Item-Delete' style='color:grey;'> Delete Item </label>
						</div>
				</div>

		<label for='Sale-of-Items' style='color:grey;'> Sale of Items </label>

		<div class='dropdown'>
				<button class='dropbtn'>Indent
					<i class='fa fa-caret-down'></i>
				</button>
				<div class='dropdown-content'>
						<label for='Indent-Create' style='color:grey;'> Create Indent </label>
						<a href='Indent-Approve.php?name=$loginId' class='title_links' style='color:green;'> Approve Indent </a>
				</div>
		</div>
		<div class='rname'> Welcome Manager </div>
</div>
";
	
}

function displaySalesMenu ($loginId)
{
	echo "<div class='topnav'>";		 
	//echo "<a href='index.html' class='title_links active' style='background-color: #4CAF50;'> Login </a>" ;
	echo "<div class='dropdown'>
						<button class='dropbtn'>User
							<i class='fa fa-caret-down'></i>
						</button>
						<div class='dropdown-content'>
							<label for='User-Create' style='color:grey;'> Create User </label>
							<label for='User-Delete' style='color:grey;'> Delete User </label>
							<a href='Password-Modify.php?name=$loginId' class='title_links' style='color:green;'> Change Password </a> 
							<a href='index.html' class='title_links' style='color:green;'> logout </a> 
						</div>
				</div>

				<div class='dropdown'>
          	<button class='dropbtn' style='color:grey;'>Pharma
            	<i class='fa fa-caret-down'></i>
          	</button>
          	<div class='dropdown-content'>
							<label for='Pharma-Create' style='color:grey;'> Create Pharma </label>
							<label for='Pharma-Modify' style='color:grey;'> Modify Pharma </label>
							<label for='Pharma-Delete' style='color:grey;'> Delete Pharma </label>
          	</div>	
				</div>

				<div class='dropdown'>
          	<button class='dropbtn' style='color:grey;'>Item
            	<i class='fa fa-caret-down'></i>
          	</button>
          	<div class='dropdown-content'>
							<label for='Item-Create' style='color:grey;'> Create Item </label>
							<label for='Item-Modify' style='color:grey;'> Modify Item </label>
							<label for='Item-Delete' style='color:grey;'> Delete Item </label>
						</div>
				</div>

				<a href='Sale-of-Items.html?name=$loginId' class='title_links'> Sale of Items </a>

				<div class='dropdown'>
						<button class='dropbtn'>Indent
							<i class='fa fa-caret-down'></i>
						</button>
						<div class='dropdown-content'>
							<a href='Indent-Create.html?name=$loginId' class='title_links' style='color:green;'> Create Indent </a>
							<label for='Indent-Approve' style='color:grey;'> Approve Indent </label>
						</div>
				</div>
				<div class='rname'> Welcome Sales </div>
  </div>
";

}

?>