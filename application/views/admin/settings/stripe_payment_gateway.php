<style>
.outerDivFull {  float: right; margin-top: -40px; } 

.switchToggle input[type=checkbox]{height: 0; width: 0; visibility: hidden; position: absolute; }
.switchToggle label {cursor: pointer; text-indent: -9999px; width: 70px; max-width: 70px; height: 30px; background: #d1d1d1; display: block; border-radius: 100px; position: relative; }
.switchToggle label:after {content: ''; position: absolute; top: 2px; left: 2px; width: 26px; height: 26px; background: #fff; border-radius: 90px; transition: 0.3s; }
.switchToggle input:checked + label, .switchToggle input:checked + input + label  {background: #3e98d3; }
.switchToggle input + label:before, .switchToggle input + input + label:before {content: 'Off'; position: absolute; top: 5px; left: 35px; width: 26px; height: 26px; border-radius: 90px; transition: 0.3s; text-indent: 0; color: #fff; }
.switchToggle input:checked + label:before, .switchToggle input:checked + input + label:before {content: 'On'; position: absolute; top: 5px; left: 10px; width: 26px; height: 26px; border-radius: 90px; transition: 0.3s; text-indent: 0; color: #fff; }
.switchToggle input:checked + label:after, .switchToggle input:checked + input + label:after {left: calc(100% - 2px); transform: translateX(-100%); }
.switchToggle label:active:after {width: 60px; } 
.toggle-switchArea { margin: 10px 0 10px 0; }
</style>
<div class="page-wrapper">
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col">
                    <h3 class="page-title">Stripe Gateway</h3>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <ul class="nav nav-tabs menu-tabs">
            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url() . 'admin/settings'; ?>">General Settings</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url() . 'admin/emailsettings'; ?>">Email Settings</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="<?php echo base_url() . 'admin/stripe_payment_gateway'; ?>">Payment Gateway</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url() . 'admin/sms-settings'; ?>">SMS Gateway</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url() . 'admin/theme-color'; ?>">Theme Color Change</a>
            </li>
        </ul>



        <div class="row">
            <div class="col-lg-8">
                <div class="card">
				
                    <div class="card-body">
					
							<ul class="nav nav-tabs menu-tabs">
								<li class="nav-item active">
									<a class="nav-link" href="<?php echo base_url() . 'admin/stripe_payment_gateway'; ?>">Stripe</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" href="<?php echo base_url() . 'admin/razorpay_payment_gateway'; ?>">Razorpay </a>
								</li>
								<li class="nav-item ">
									<a class="nav-link" href="<?php echo base_url() . 'admin/paypal_payment_gateway'; ?>">PayPal</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" href="<?php echo base_url() . 'admin/cod_payment_gateway'; ?>">COD</a>
								</li>
							</ul>
							
							
                        <form action="<?php echo base_url() . 'admin/settings/edit/' . $list['id']; ?>" method="post">
                            <h4 class="text-primary">Stripe</h4>
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
							<div class="outerDivFull" >
							<div class="switchToggle">
								<input name="stripe_show" type="checkbox"  value="1" id="switch" <?php if($list['status']== 1) { ?>checked <?php } ?>>
								<label for="switch">Toggle</label>
							</div>
							</div>

                            <div class="form-group">
                                <label>Stripe Option</label>

                                <div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input class="custom-control-input stripe_payment" id="sandbox" name="gateway_type" value="sandbox" type="radio" <?= ($list['gateway_type'] == "sandbox") ? 'checked' : '' ?> >
                                        <label class="custom-control-label" for="sandbox">Sandbox</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input class="custom-control-input stripe_payment" id="livepaypal" name="gateway_type" value="live" type="radio"  <?= ($list['gateway_type'] == "live") ? 'checked' : '' ?> >
                                        <label class="custom-control-label" for="livepaypal">Live</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Gateway Name</label>
                                <input  type="text" id="gateway_name" name="gateway_name"  value="<?php if (!empty($list['gateway_name'])) {
    echo $list['gateway_name'];
} ?>" required class="form-control" placeholder="Gateway Name">
                            </div>
                            <div class="form-group">
                                <label>API Key</label>
                                <input type="text" id="api_key" name="api_key" value="<?php if (!empty($list['api_key'])) {
    echo $list['api_key'];
} ?>" required class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Rest Key</label>
                                <input type="text" id="value" name="value" value="<?php if (!empty($list['value'])) {
    echo $list['value'];
} ?>" required class="form-control">
                            </div>
                            <div class="mt-4">
<?php if ($user_role == 1) { ?>
                                    <button class="btn btn-primary" name="form_submit" value="submit" type="submit">Submit</button>
<?php } ?>

                                <a href="<?php echo base_url() . 'admin/stripe_payment_gateway' ?>" class="btn btn-link m-l-5">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
