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
  ['ARE THE PAYMENTS AUTOMATIC?', 'Yes, payments are automatic, after sending the money wait for confirmation from blockchain, usually it takes 30 minutes.'],
  ['WHAT ARE THE PAYMENT METHODS?', 'You can only pay for your plans through bitcoin, we do not accept any other form of payment in this meaning.'],
  ['WHAT ARE THE DIFFERENCES BETWEEN STANDARD AND VIP PLANS?', 'VIP plans offer 100Gbps amplification power, standard plans offers only 20Gbps.'],
  ['ARE MY DATA SAFE?', 'Yes, the only form of contact between the user and the admin is tickets, the only form of payment is bitcoin, our attacks are spoofed, we do not log your IP, we allow the use of all forms of PROXY or VPN.'],
  ['WHAT IS THE GUARANTEED POWER?', 'Guaranteed UDP power for free trial plan is 5Gbps, for Standard plans - 20Gbps and for VIP plans - 100Gbps.'],
  ['WHY DONT YOU OFFER LAYER7 METHODS?', 'All layer7 attacks can be traced back, we dont offer and never will because of the safety of our users and us.'],
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
          <span class="breadcrumb-item active">FAQ</span>
        </nav>
      </div><!-- sh-breadcrumb -->
      <div class="sh-pagetitle">
        <div class="input-group">          
        </div><!-- input-group -->
        <div class="sh-pagetitle-left">
          <div class="sh-pagetitle-icon"><i class="icon ion-ios-help"></i></div>
          <div class="sh-pagetitle-title">
            <span>Questions and answers</span>
            <h2>FAQ</h2>
          </div><!-- sh-pagetitle-left-title -->
        </div><!-- sh-pagetitle-left -->
      </div><!-- sh-pagetitle -->

      <div class="sh-pagebody">
      <?php require_once("include/modal.php"); ?>
        <!-- Put your content here -->
        <div class="row row-sm">
          <div class="col-lg-12">
        <div class="card bd-primary mg-t-20">
              <div class="card-header bg-primary tx-white">FAQ</div>
              <div class="card-body">
                <div class="media-list">

                <?php foreach($faqs as list($title, $content)){ ?>
                  <div class="media">
                  <div class="sh-pagetitle-icon"><i class="icon ion-ios-help"></i></div>
                    <div class="media-body mg-l-20">
                      <h6 class="tx-15 mg-b-5"><a href=""><?php echo $title; ?></a></h6>
                      <p class="mg-b-20">by: <a href=""><?php echo $my_site_name; ?></a></p>
                      <p><?php echo $content; ?></p>
                    </div><!-- media-body -->
                  </div><!-- media -->
                  <hr class="mg-y-20">
                <?php } ?>                  

                
                </div><!-- media-list -->
              </div><!-- card-body -->
            </div>
            </div><!-- col12 -->
            </div><!-- row -->
        <!-- end of your content -->
      </div><!-- sh-pagebody -->
      <?php require_once('include/footer.php'); ?>
    </div><!-- sh-mainpanel -->
    <?php require_once('include/js.php');?>
  </body>
</html>
