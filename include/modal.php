<?php if($success_modal!='' || $info_modal!='' || $warning_modal!='' || $danger_modal!=''){ ?>
<div class="modal_master" style=" z-index:999; padding:1em;  top: 0; left: 0; right: 0; margin: auto; display:none;">

<?php if($success_modal!=''){ ?>
<div class="alert alert-success" role="alert">

              <button type="button" class="close" data-dismiss="alert" aria-label="Close">

                <span aria-hidden="true">×</span>

              </button>

              <div class="d-flex align-items-center justify-content-start">

                <i class="icon ion-ios-checkmark alert-icon tx-24 mg-t-5 mg-xs-t-0"></i>

                <span><strong>Well done!</strong> <?php echo $success_modal;?></span>

              </div><!-- d-flex -->

</div><!-- alert -->
<?php } ?>

<?php if($info_modal!=''){ ?>

            <div class="alert alert-info" role="alert">

              <button type="button" class="close" data-dismiss="alert" aria-label="Close">

                <span aria-hidden="true">×</span>

              </button>

              <div class="d-flex align-items-center justify-content-start">

                <i class="icon ion-ios-information alert-icon tx-24 mg-t-5 mg-xs-t-0"></i>

                <span><strong>Heads up!</strong> <?php echo $info_modal;?></span>

              </div><!-- d-flex -->

            </div>

<?php } ?>

<?php if($warning_modal!=''){ ?>

            <div class="alert alert-warning" role="alert">

              <button type="button" class="close" data-dismiss="alert" aria-label="Close">

                <span aria-hidden="true">×</span>

              </button>

              <div class="d-flex align-items-center justify-content-start">

                <i class="icon ion-alert-circled alert-icon tx-24 mg-t-5 mg-xs-t-0"></i>

                <span><strong>Warning!</strong> <?php echo $warning_modal;?></span>

              </div><!-- d-flex -->

            </div>

 <?php } ?>

<?php if($danger_modal!=''){ ?>

            <div class="alert alert-danger mg-b-0" role="alert">

              <button type="button" class="close" data-dismiss="alert" aria-label="Close">

                <span aria-hidden="true">×</span>

              </button>

              <div class="d-flex align-items-center justify-content-start">

                <i class="icon ion-ios-close alert-icon tx-24"></i>

                <span><strong>Oh snap!</strong> <?php echo $danger_modal;?></span>

              </div><!-- d-flex -->

            </div><!-- alert -->
   <?php } ?>

</div>

<?php } ?>