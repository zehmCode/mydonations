<div class="wrapper d-flex align-items-stretch">
			<nav id="sidebar">
				<div class="custom-menu">
					<button type="button" id="sidebarCollapse" class="btn btn-primary">
	          <i class="fa fa-bars"></i>
	          <span class="sr-only">Toggle Menu</span>
	        </button>
        </div>
	  		<h1><a href="index.html" class="logo">MyDonations panel</a></h1>
        <ul class="list-unstyled components mb-5">
          <li class="<?php echo (count($url) == 1) ? "active": "";?>">
              <a href="<?php echo (count($url) > 1) ? "../panel": "";?>"><i class="fa-solid fa-chart-line"></i> Dashboard</a>
          </li> 
          <li class="<?php echo ((count($url) > 1) && ($url[1] == "membres")) ? "active": "";?>">
            <a href="<?php echo ((count($url) > 1)) ? "../panel/membres": "panel/membres";?>"><i class="fa-solid fa-users"></i> Membres</a>
          </li>
          <li class="<?php echo ((count($url) > 1) && ($url[1] == "paiement")) ? "active": "";?>">
            <a href="<?php echo ((count($url) > 1)) ? "../panel/paiement": "panel/paiement";?>"><i class="fa-solid fa-credit-card"></i> Paiements</a>
          </li>
        </ul>

    	</nav>