<?php
ob_start(); 
require_once 'engine/config.php';
require_once 'engine/init.php';

if (!($user -> LoggedIn()))
{
	header('Location: login.php');
	die();
}
if ($user -> IsBanned($odb))
{
	header('Location: logout.php');
	die();
}

////////////////////////////////////*************************** 
/*
FAQ
ADD OR CHANGE FAQs on ARRAY ABOVE
/*
/////////////////////////////////////////////////////*/

$faqs = [
  ['CAN I GET A TRIAL PLAN FOR FREE?', 'No! all plans available for purchase are shown on this page, please do not ask support for test plans / hit tests'],
  ['CAN I PAY BY PAYPAL?', 'We sometimes allow payments via paypal, please contact support'],
  ['CAN I BUY 2 PLANS AT ONCE?', 'No, if you want to upgrade your plan, contact support'],
  ['WILL I GET MY PLAN AFTER BUYING IT IMMEDIATELY?', 'Yes, when the cryptopayment is confirmed you will get your plan immediately (10-30min). If you buy by PayPal, please contact us via discord / tawk.to'],
];

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php require_once("include/head.php"); ?>
  </head>
<body>

  <?php require_once("include/header.php"); ?>

    <div class="sh-mainpanel">
      <div class="sh-breadcrumb">
        <nav class="breadcrumb">
          <a class="breadcrumb-item" href="<?php echo $my_site_url; ?>"><?php echo $my_site_name; ?></a>
          <span class="breadcrumb-item active">Plans</span>
        </nav>
      </div><!-- sh-breadcrumb -->
      <div class="sh-pagetitle">
        <div class="input-group">          
        </div><!-- input-group -->
        <div class="sh-pagetitle-left">
          <div class="sh-pagetitle-icon"><i class="icon ion-ios-cart"></i></div>
          <div class="sh-pagetitle-title">
            <span>Select your plan</span>
            <h2>Plans</h2>
          </div><!-- sh-pagetitle-left-title -->
        </div><!-- sh-pagetitle-left -->
      </div><!-- sh-pagetitle -->

      <div class="sh-pagebody">
      <?php require_once("include/modal.php"); ?>
        <!-- Put your content here -->

        <div class="row"> 
				<?php
				$packagesinfo = $odb -> query("SELECT * FROM `packages` WHERE `public` = 2 ORDER BY `id` ASC");
				while($row = $packagesinfo ->fetch())
				{
					if ($row['unit'] == 'Months'){
						$unit = 'Month(s)';
					} elseif ($row['unit'] == 'Years'){
						$unit = 'Year(s)';
					} elseif ($row['unit'] == 'Days'){
						$unit = 'Day(s)';
					}
					$methods = json_decode($row['methods'], true);
					$highlight=($row['highlight']==1)? 'style="background-color: #0e62c7"' : 'style="background-color: #6C6C6C;"';
          echo '<div class="col-sm-2">
                  <div class="card bd-primary mg-t-20">
                    <div class="card-header bg-primary tx-white"><h6 class="panel-title text-center">'.$row['name'].'<br><span class="text-center" style="font-size: 1.5em; font-weight:bolder">$ '.$row['price'].'.00</span></h6></div>
							
                    <div class="card-body pd-sm-30">
                      <p><i class="fa fa-calendar-check-o" style="margin-right: 17px; font-size: 18px;"></i>Per '.$row['length'].' '.$unit.'</p>
                      <p><i class="fa fa-clock-o" style="margin-right: 17px; font-size: 18px;"></i>'.$row['mbt'].' Seconds</p>
                      <p><i class="fa fa-unlock" style="margin-right: 17px; font-size: 18px;"></i>'.implode(", ", $packagesinfo).'Unlimited attacks</p>
                      <p><i class="fa fa-spinner" style="margin-right: 17px; font-size: 18px;"></i>'.$row['conc'].' Concurrent attacks</p>
                      <p><i class="fa fa-rocket" style="margin-right: 17px; font-size: 18px;"></i>'.$row['powermin'].' Gbps UDP</p>
                      <!--<p><i class="fa fa-clipboard" style="margin-right: 17px; font-size: 18px; "></i>'.$row['meth'].'  And more!</p> 
                    -->
								
                    <form action="https://www.coinpayments.net/index.php" method="post">
                      <input type="hidden" name="cmd" value="_pay_simple">
                      <input type="hidden" name="reset" value="1">
                      <input type="hidden" name="merchant" value="280336acb267fd75d9ece272a48ead67">
                      <input type="hidden" name="item_name" value="'.$row['name'].'">
                      <input type="hidden" name="item_desc" value="'.$row['name'].' plan">
                      <input type="hidden" name="item_number" value="1">
                      <input type="hidden" name="invoice" value="1">
                      <input type="hidden" name="currency" value="USD">
                      <input type="hidden" name="amountf" value="'.$row['price'].'">
                      <input type="hidden" name="want_shipping" value="0">
                      <input type="hidden" name="success_url" value="https://nullbooter.club/index.php">
                      <input type="hidden" name="cancel_url" value="https://nullbooter.club/packages.php">
                    
                      <button class="btn btn-primary btn-block" style="cursor:pointer" type="submit">Purchase</button>
                    
										</form>
                    </div>
									</div>
						</div>';
				}
				?>

        

                  
                  </div><!-- media-list -->
                </div><!-- card-body -->
              </div>
              </div><!-- col12 -->

        </div><!--row >
        <!-- end of your content -->
      </div><!-- sh-pagebody -->
      <?php require_once('include/footer.php'); ?>
    </div><!-- sh-mainpanel -->
    <?php require_once('include/js.php');?>
  </body>
</html>
